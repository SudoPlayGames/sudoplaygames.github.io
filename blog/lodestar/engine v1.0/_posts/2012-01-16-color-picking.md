---
title: Color Picking
author: Jason Taylor
forumuser: codetaylor
layout: post
---
The picking is done!  These screenshots were taken before I found the green bug.

{% include image-row-sm.md left="color-picking-1.png" right="color-picking-2.png" %}

Yes, I switched it around.  I use the order BGR instead of RGB.  Red burned far to deeply into my head while debugging, silently mocking me with it’s seemingly infinite, yet frustratingly discreet shades of anger and whispered queries: “You haven’t figured it out yet?”  I found that blue’s soothing, self-confident “You know you’ll get there” to be much more effective.

What is the green bug you ask?  Notice the green hue?  My first algorithm was skipping three colors for every face color assigned, essentially burning through the available 2^24 colors at an accelerated rate, causing the green hue to increment faster.  That has all been fixed, however, and if I really need to have 16.7 million pickable surfaces, I can sleep at night.