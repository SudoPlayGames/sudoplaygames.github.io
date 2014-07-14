---
title: Smooth Lighting #1
author: Jason Taylor
forumuser: codetaylor
layout: post
---
The lighting engine is mostly complete at this point.  There is a global light level, static lights, dynamic lights, pseudo-AO, and calculated realtime shadows.

{% include image-row-lg.md image="smooth-lighting-3.png" %}
{% include image-row-sm.md left="smooth-lighting-1.png" right="smooth-lighting-2.png" %}

I’m thinking about adding anti-lights in a pass four calculation. They will work the same way as the dynamic light sources, but instead of adding light, the anti-lights will subtract light. This could be useful for concealment and spell effects.