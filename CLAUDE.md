# Sagiris Elementor Testimonial Slider

Custom Elementor widget: a testimonial/review carousel. A Sagiris plugin. GPLv2-or-later.

- **Code structure:** plain OOP PHP classes, manually `require_once`'d — no Composer/PSR-4 autoloading.
- **Text domain / prefix:** `sagiris-elementor-testimonial-slider`
- **Frontend:** vanilla CSS scroll-snap + hand-written JS — no bundler, no JS build step.
- **Dependency:** requires Elementor (free tier) active, declared via the `Requires Plugins` plugin header.
- **Scope:** deliberately lighter-weight than sibling portfolio pieces (e.g. Signalboard) — no CI, no PHPUnit, no branch-protection ruleset. Portfolio value here is demonstrating Elementor's `Widget_Base`/controls/render API, not engineering process rigor.

## Agent skills

### Issue tracker

Issues and PRDs live in this repo's GitHub Issues (`SagirisWebDev/sagiris-elementor-testimonial-slider`), via the `gh` CLI. See `docs/agents/issue-tracker.md`.

### Triage labels

The five canonical triage roles map to identically-named labels (`needs-triage`, `needs-info`, `ready-for-agent`, `ready-for-human`, `wontfix`). See `docs/agents/triage-labels.md`.

### Domain docs

Single-context: one `CONTEXT.md` + `docs/adr/` at the repo root (created lazily as terms/decisions get resolved). See `docs/agents/domain.md`.
