# Sagiris Elementor Testimonial Slider

**A custom Elementor widget** for a testimonial/review carousel — repeater-driven content, responsive slides-per-view, autoplay, and star ratings — built directly against Elementor's `Widget_Base` API.

A [Sagiris](https://sagirisdev.com) plugin. GPLv2-or-later.

> 🚧 **Status:** in development. The v1.0 spec lives in the [`ready-for-agent` PRD issue](../../issues).

## Overview

- **Custom Elementor widget** — extends `Elementor\Widget_Base`, registered via the `elementor/widgets/register` hook.
- **Repeater-driven content** — photo, name, title/company, quote, and a 1-5 star rating per testimonial.
- **Responsive carousel** — vanilla CSS scroll-snap + a small hand-written JS controller, no bundler or build step.
- Companion piece to [Signalboard](https://github.com/SagirisWebDev/signalboard), demonstrating Elementor's developer-API surface (widgets/controls/render) alongside the Gutenberg-block portfolio pieces.

## Documentation

Architecture notes and engineering-decision rationale will live in `docs/` as the build progresses.
