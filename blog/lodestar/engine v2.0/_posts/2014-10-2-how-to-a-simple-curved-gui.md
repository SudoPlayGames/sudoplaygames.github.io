---
title: A Simple Curved GUI
author: Jason Taylor
forumuser: codetaylor
layout: post
---

This post details my implementation of a curved GUI. The technique aims to distort the GUI to look like it is projected onto the inside of a curved cylinder using OpenGL and GLSL.

## Preamble

Yesterday I set out to dabble with a simple curved GUI. Not knowing exactly where to start, I began the same way I begin many new tasks, by doing some research. It all began by slinging some search terms at Google: curved gui, glsl curved shader, non-planar projection, rounded gui, opengl cylindrical projection - the list goes on to no avail. Switching to searching images yielded results, but not the results I was looking for. Thinking that there must be some information somewhere on this I ended up spending far too long looking. Eventually I came to the conclusion that this is either not a widely used effect, or it is just so damn simple that it doesn't even warrant an explanation.

I was about to give up and retire for the evening when I ran across this vague tidbit from [a four year old youtube video](1):

> i just simply transform every pixel on screen by quadric function in fragment shader

Suddenly, I felt dumb; of course it's going to involve a parabola!

## TL;DR

~~~ glsl
in vec2 xTexCoord;

uniform sampler2D tech_Texture0;
uniform float tech_DistortionFactor;

out vec4 out_FragColor;

void main(void) {
  vec2 uv = xTexCoord;
  uv.y += tech_DistortionFactor * (-2.0 * uv.y + 1.0) * uv.x * (uv.x - 1.0);
  out_FragColor = texture(tech_Texture0, uv);
}
~~~

## Prerequisite

The GUI in Lodestar is rendered first to an offscreen texture, then sampled from that texture and written to the final output framebuffer. This allows for various post processing effects to be slipped in during the final write.

If you want to follow along and implement this effect then rendering your GUI first to an offscreen texture is a must for this to work properly, as we'll be transforming the texture lookup coordinates to achieve the distortion.

## Parabola

The OpenGL texture coordinate system dictates that the bottom left is \\( (0,0) \\) and the top right is \\( (1,1) \\); the x-coordinate increases from left to right and the y-coordinate increases from bottom to top.

Let's use this information and think about how we want our effect to behave. As the x-coordinate increases, we want to translate the y-coordinate away from the original y-coordinate, until the x-coordinate reaches the halfway point. When the x-coordinate reaches the threshold of halfway across the screen, we want the y-coordinate to begin decreasing back to the original y-coordinate.

This can be achieved with a parabola. We know that we want our parabola to begin at \\( (0,0) \\) and end at \\( (1,0) \\). We also know that halfway between the OpenGL x-coordinate \\( 0 \\) and \\( 1 \\), is \\( 0.5 \\). Now we know our parabola's x-intercepts and the x-coordinate of its vertex.

Simply working backward from our zeros will yeild a general parabola that fits our needs.

\\[ x=0, x=1 \\]

\\[ x=0, x-1=0 \\]

\\[ y=x(x-1) \\]

\\[ y=x^{2}-x \\]

{% include image-row-lg.md image="ht-curved-3.png" %}

We can apply this parabola in the GLSL shader like so:

~~~ glsl
uv.y += uv.x * (uv.x - 1.0);
~~~

Now, when the shader samples from the offscreen GUI texture, it will sample farther down on the y-axis as the x-coordinate approaches the center of the screen. At the bottom of the screen, this essentially samples non-existant pixels and draws nothing because we're sampling outside of the texture. This gives the appearance that the GUI is bending up.

{% include image-row-lg.md image="ht-curved-5.png" %}

As you can see above, it's starting to look like the effect we're after, but there's no variance along the y-axis. We need the y-value of the parabola's vertex to be influenced by the y-coordinate on the screen. As the y-coordinate approaches the middle of the screen, we need the parabola to become flatter and flatter until it approximates a horizontal line at the center of the screen, then reverse direction.

{% include image-row-lg.md image="ht-curved-4.png" %}

We know that our vertex is at point \\( (h,k) \\) and that \\( h=0.5 \\). Now we just have to parameterize \\( k \\).

The general form of a parabola is \\( ax^{2}+bx+c \\), so we just need to know how \\( k \\) is affected by \\( a \\), \\( b \\), and \\( c \\).

So, what is \\( k \\)?

\\[ k=\frac{4ac-b^{2}}{4a} \\]

Let's see if we can define \\( b \\) in terms of \\( a \\):

\\[ h=\frac{-b}{2a} \\]

We know \\( h=0.5 \\) so:

\\[ 0.5=\frac{-b}{2a} \\]

Multiply by \\( 2a \\)

\\[ a=-b \\]

So, we know that:

\\[ b=-a \\]

Now, let's replace the \\( b \\) in the equation for \\( k \\) above:

\\[ k=\frac{4ac-(-a)^{2}}{4a} \\]

Next, simplify:

\\[ k=\frac{4ac-a^{2}}{4a} \\]

\\[ k=\frac{a(4c-a)}{4a} \\]

\\[ k=\frac{4c-a}{4} \\]

We also know that there is no \\( c \\) in the equation for our parabola, or more accurately, \\( c=0 \\), therefore:

\\[ k=\frac{4(0)-a}{4} \\]

\\[ k=\frac{-a}{4} \\]

Now we know that \\( k=\frac{-a}{4} \\) and \\( b=-a \\). This means that we can simply introduce a scalar value \\( s \\) like so:

\\[ y=sx^{2}-sx \\]

Changing the value of \\( s \\) will move our vertex up and down, while keeping the x-intercepts stationary. This is what we'll influence with our y-coordinate to move the vertex.

We know that our y-coordinate starts at \\( 0 \\), reaches \\( 0.5 \\) at the middle of the screen, and ends at the top of the screen at \\( 1 \\). We also know that we want the parabola to open up when the y-coordinate is at the bottom of the screen \\( (0) \\), flat when it is at the middle \\( (0.5) \\), and open down when it is at the top \\( (1) \\). So, as our function input travels from \\( 0 \\) to \\( 1 \\) we need our output to go from \\( 1 \\) to \\( -1\\).

This sounds like a linear function:

\\[ y=mx+b \\]

We know our y-intercept is \\( 1 \\):

\\[ y=mx+1 \\]

And we know that our x-intercept is \\( 0.5 \\) making our slope:

\\[ \frac{1-0}{0-0.5}=-2 \\]

Slap it all together:

\\[ y=-2x+1 \\]

Now, we want the input to our linear function to be the y-coordinate of the texture lookup. We can express this in GLSL like so:

~~~
uv.y += (-2.0 * uv.y + 1.0) * uv.x * (uv.x - 1.0);
~~~

It's probably a good idea to multiply by another scalar sent into the shader as a uniform so you can control the amount of distortion from outside the shader:

~~~
uv.y += tech_DistortionFactor * (-2.0 * uv.y + 1.0) * uv.x * (uv.x - 1.0);
~~~

{% include image-row-sm.md left="ht-curved-1.png" right="ht-curved-2.png" %}

Finally, our shader is done and the GUI is being drawn with style, but our mouse input is now mismatched.

## Mouse Input

The mouse input is pretty easy to align to the display now that we've got all the math down. If your in-game GUI coordinate system is the same as OpenGL's coordinate system, then all you have to do is take the same math that you added to `uv.y` in the shader, scale it to match your screen height, and subtract that value from your GUI input y-value.

If your GUI coordinate system uses an inverted y-axis, simply add the scaled math to the y-value before subtracting it from your screen height, such as:

~~~ java
y = screenHeight - adjust(y);
~~~

---

If you find this useful, let me know in the comments below!

[1]:http://www.youtube.com/watch?v=Vlj1l17ltqk
