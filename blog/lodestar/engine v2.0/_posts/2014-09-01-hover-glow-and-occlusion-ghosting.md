---
title: Hover Glow and Occlusion Ghosting
author: Jason Taylor
forumuser: codetaylor
layout: post
---

It's been a while since I've posted anything really technical about Lodestar, so I decided to write about some of the challenges that I recently faced while implementing two new features into the deferred rendering pipeline: hover glow and occlusion ghosting.

## Hover Glow

The need to indicate to the player that an object in the 3D game world is interact-able has been brewing for quite some time. There's the obvious method of changing the cursor when the mouse hovers over something usable, but I wanted more than that. I wanted the object to light up with some kind of outline, something that would not only catch the players attention, but also provide additional information through color.

### Options

Some research into this problem turned up three promising solutions: the stencil / line-width / wireframe solution, the hardware determined feature edge solution, and the outline glow solution.

#### The Stencil / Line-Width / Wireframe Solution

This method is outlined as follows:

 * Draw the object and write into the stencil buffer
 * Set the line-width to a visibly wide value
 * Draw the object again with color of choice using the stencil mask

Here is [some additional information](1) about the process.

The results of this method look vibrant and the line is of a uniform width all around the object. Unfortunately we couldn't use this method because Lodestar's rendering pipeline is locked into *OpenGL 3.2 Core* and *glLineWidth()* was deprecated in 3.1 and removed in 3.2 Core.

#### The Hardware Determined Feature Edge Solution

As I understand it, this method is as follows:

 * Create an edge list CPU-side by comparing face normals and view direction
 * Pass custom vertex info to GPU
 * Use shader to draw line segments as view-facing quads

That's a very basic, high-level overview of [this paper](2) by Morgan McGuire and John F. Hughes.

This solution feels like it would provide us with what we need and would be challenging and fun to implement. However, it also feels like overkill for this particular problem, like it would be better suited for an artistic, stylized rendering. We decided to try to find a simpler method.

#### The Outline Glow Solution

This final method is as follows:

 * Draw each mesh to an offscreen glow texture with color of choice
 * Use a separable gaussian blur on the glow texture
 * Draw each mesh to the stencil buffer of target frame buffer
 * Additively blend the glow texture with the target using the stencil mask

I originally got the idea from [this question on StackExchange](3).

This is the solution that we ended up implementing because it works and it's fairly simple. Additionally, we can leverage the existing frame buffer stack used for the bloom blur and don't need to create any additional frame buffers.

### Implementation

At this point the pipeline looked something like this:

{% include image-row-lg.md image="rendering_pipeline.png" %}

Before the outline could be implemented, I had to do some refactoring.

#### Decouple the Blur Stack From the Bloom Filter

The first step was to refactor what I call the *blur stack* to decouple it from the bloom filter and make it easily reusable. The blur stack is a series of texture spaces partitioned starting at half the size of the current resolution. For example if you're running the game in 800x600, the blur stack would look like this:

![Blur Stack Table](/assets/blog/blur-stack-table.png)

The blur process simply:

 * Downsamples the texture at *(pass0, 0)* down through the textures to the level specified
 * Performs a separable gaussian blur in one of three directions (*HORIZONTAL*, *VERTICAL*, *BOTH*), ping-ponging between passes at the specified level for the number of passes specified
 * Upscales the texture back up the stack, ending at *(pass0, 0)*

During the refactor, I noticed that I had a separate shader that sampled the light accumulation buffer (LA), performed the bloom threshold calculations and tone mapping, and wrote the output to a frame buffer of screen resolution. That frame buffer was then downsampled to the *(pass0, 0)* texture before the blur process began.

This was a huge waste of fill-rate. Combining the bloom threshold and downsampling shaders into a single shader that samples from the LA buffer, performs the calculations and downsamples directly into the *(pass0, 0)* eliminated an entire screen sized frame buffer from the pipeline with no visible difference.

Decoupling the blur stack was a big win because not only did the blur filter become usable for something other than bloom, I was also able to correct a design flaw and potential future performance issue.

#### Create the Outline Processor

With the blur stack decoupled from the bloom filter, I moved on to creating the outline processor; the class responsible for drawing the outlines. This was pretty vanilla. The steps that the processor goes through read pretty much like the steps listed above:

  * Draw each mesh to the *(pass0, 0)* texture of the blur stack in the color specified
  * If anything was drawn:
    * Perform the blur with the given parameters
    * Draw each mesh that was previously drawn to the stencil buffer of the target
    * Draw the blurred texture to the target with the stencil mask

After the outline processor was created, the pipeline looked something like this:

{% include image-row-lg.md image="rendering_pipeline2.png" %}

#### Results

{% include image-row-lg.md image="lss-screenshot-247.png" %}

#### Improvements and Issues

If there was a way to eliminate the extra draw for the stencil buffer, that would be awesome. I thought about using the original gbuffer draw to draw to the stencil, but the gbuffer's depth/stencil is shared with the LA buffer and is wiped during the lighting phase. It would be possible to reserve an id in the stencil just for the meshes that need to glow and blit the depth/stencil to the main render target to use later, but it still conflicts with a solution implemented in the next section: we blit the depth/stencil to the main render target before any interact-able entities are rendered.

I can foresee performance issues if this were used to draw many meshes simply because of how many times it needs to draw the same mesh: once to the gbuffer and twice to create the glow effect. For our purposes, highlighting an interact-able mesh when the player hovers over it, there will only be a handful of meshes using this effect at any given time.

## Occlusion Ghosting

The main focus of this game is on the choices that the player makes during encounters. I want all of the information that a player needs to make those choices presented in a clear and concise manner. If a unit is hidden from the player's view due to the camera angle, I want the player to know there's something there.

Torchlight II does a pretty good job of this:

{% include image-row-lg.md image="occlusion-ghosting-t2example.png" %}

### Options

The option was pretty straightforward: render everything, then render stuff you want ghosted again, but with a reversed depth function.

### Implementation

The implementation of this effect felt pretty straightforward as well.

#### Depth Buffer Data in Final Render Target

Up to this point I hadn't used the depth buffer in the final/master render target for anything. The final screen was simply a composite of other textures onto a full-screen quad. I figured I could just blit the gbuffer's depth/stencil buffer to the final/master render target. The copy FBO method in my renderer gave the option to copy the depth/stencil buffer, but always copied the color buffer too. After a tiny refactor, I can now copy just the depth/stencil if so inclined.

#### Occlusion Processor

The occlusion processor simply handles the drawing of the models flagged with *USE_OCCLUSION*. It reverses the depth function and draws the flagged models to the final/master render target, testing against the newly blitted depth buffer.

#### GBuffer Sorting Tweak

After completing the steps above, the effect worked, but not well. Since the units are comprised of several meshes, parts of the unit that were behind other parts of the unit were being rendered with the ghosting effect. This looked horrible and confusing. My solution was to create a multi-parameter comparator to replace the default opaque comparator. This new sorter would first sort meshes that were flagged with *OCCLUDE_FLAG* to the top of the list, then sort by distance from camera per the norm. Now, while looping through meshes in the gbuffer drawing phase, if a mesh is not flagged, we know we've reached the end of the stuff we want to occlude and we blit the depth buffer to the final/master render target at this time, effectively creating a snapshot of the depth buffer that includes only the meshes that we want to provide occlusion.

#### Results

{% include image-row-lg.md image="lss-screenshot-244.png" %}

#### Improvements and Issues

Again, we are doubling the poly-count of any mesh set to use the occlusion effect, every frame. Also, it might be possible to eliminate the *OCCLUDE_FLAG* and have the gbuffer opaque sort use the *USE_OCCLUSION* flag on the meshes instead. Then, anything that doesn't use the occlusion effect would provide the occlusion effect. I would, however, lose the ability to have meshes that neither provide the occlusion effect or use it.

There is an issue with this method:

{% include image-row-lg.md image="lss-screenshot-246.png" %}

The feet of a unit slip through the floor just a bit when walking and trigger the occlusion effect. I've been thinking about how to solve this and haven't really landed on a solution yet. This might be one of those problems that doesn't have a neat, clever little solution, but rather a brute-force workaround like changing the unit animation a little bit so that the feet don't drop below the floor.

## Conclusion

Over time I will tweak the parameters, colors, shaders, and style of the effects, but I am quite happy with the initial outcome.

Here is what the current state of the pipeline looks like:

{% include image-row-lg.md image="rendering_pipeline3.png" %}

[1]: http://www.flipcode.com/archives/Object_Outlining.shtml
[2]: http://cs.brown.edu/~morgan/papers/(McGuireHughes04)-hardware-determined-edge-features.pdf
[3]: http://gamedev.stackexchange.com/questions/16391/how-can-i-reduce-aliasing-in-my-outline-glow-effect
