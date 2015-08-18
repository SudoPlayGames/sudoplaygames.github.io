---
title: Finding Interesting Areas in a Cave
author: Jason Taylor
forumuser: codetaylor
layout: post
---

Procedurally generated caves present a problem when trying to find interesting spawn areas.

In a hand crafted map, the loot can be hidden in an obscure corner, mobs and bosses can be placed in large-enough areas, and quest-giving NPCs can be placed in an open area where they will not be missed. In order to create the feel of a hand-crafed map in a procedural world, the program needs a way to identify the types of areas that each map contains in order to place content in the proper places.

## The Problem

To generate area masks for our cave areas, we use a layered, diffusion limited aggregation approach. What we end up with is pretty organic, as you can see below, and serves our purpose very well.

![image]( {{ site.url }}/assets/blog/medium-cave-1.png )

Now that we have these, how can we identify areas of interest in the mask? Let's say we wanted to place some items in small room-like areas and place hordes of combatants in the large areas; how can we identify the different sized areas in the mask?

## Our Solution

The solution that we came up with involves tracing rings around the edges of the mask (picture wood grain or a topographical map) and assigning an incremental number to each ring. Imagine a 3d printer using the area mask as a base and each layer that it prints on top of that base is slightly smaller than the last, until the last point is printed. You would have something that resembled a grouping of stalagmites. Now with this printed model, you could measure the length of each stalagmite to determine the room size and it's a pretty good bet that the tip of each stalagmite represents the center of a room-like area.

This is the process that we mimic with the algorithm described below.

### Definitions

* The Mask represents a 2d grid of ints using one dimensional array
* A Tile is simply a vector(x,y) that identifies a location in the Mask
* A TileBag is an array of Tiles
* FloodGet is a flood fill algorithm that returns a TileBag of Tiles that would be filled
* A GroupedTileBag is an array of TileBags

#### getGroupedTileBag()

1. Fill a TileBag(0) by looping through the Mask and selecting any Tile that has a floor value.
2. Fill a TileBag(1) by taking a Tile from TileBag(0) and performing a FloodGet with the Tile's coordinates.
3. Save TileBag(1) in a list of TileBags to return.
4. Remove all tiles in TileBag(1) from TileBag(0).
5. If TileBag(0) has any Tiles left, go to step 2.
6. Return list of TileBags.

#### createZoneMap()

1. Fill a GroupedTileBag(0) by calling getGroupedTileBag
2. For each TileBag(n) in GroupedTileBag(0)
   1. Select all tiles directly adjacent to wall tiles and replace them with an index with encoded depth
   2. GetBag: Get a GroupedTileBag(1) full of floor tiles
   3. If the GroupedTileBag(1) is empty, we're done
   4. For each TileBag(m) in GroupedTileBag(1)
      * If the TileBag(m) size is less than the group size threshold
         * Select all tiles in the TileBag(m) and replace the with an index with encoded depth
      * Else
         * Select all tiles directly adjacent to the previous index and replace them with a new encoded index
   5. ++depth
   6. Goto GetBag

## Results

The visualized result of the algorithm:

![image]( {{ site.url }}/assets/blog/medium-cave-spawn-1.png )

The green areas are the concentric rings, drawn darker with each new ring. The clusters of Tiles that lie somewhere in the spectrum of red to blue are the interesting areas. The more red the cluster, the smaller the area it resides in, and the more blue the cluster, the larger the area it resides in.

We can then use this information to solve our problem above, placing our items in small red areas and our hordes of combatants in the large blue areas.

Here are some more visualizations:

{% include image-row-sm.md left="medium-cave-2.png" right="medium-cave-spawn-2.png" %}
{% include image-row-sm.md left="large-cave-1.png" right="large-cave-spawn-1.png" %}

## Edit

* (July 29, 2015): fixed typo and fixed placement of depth increment