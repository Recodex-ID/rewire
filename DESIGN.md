# Design Direction — Rewire Starter Kit

> **Authored by the agent, not the product owner.** Per antislop R-37, agent-authored
> direction defaults toward generic AI taste unless it's grounded in something real.
> This file is grounded in the visual system already implemented in this codebase
> (`resources/css/app.css`, the landing page redesign, the dashboard UI) — it documents
> and formalizes decisions already made, rather than inventing new ones. Treat it as a
> reasonable starting point, not a final brand book: the product owner should revise
> anything that doesn't match their actual intent.

## Identity

A Laravel + Livewire starter kit for internal tools and client projects: authentication,
roles, a blog, and a back office, ready on day one. The audience is developers and small
agencies who need to look credible and competent to a client fast, not a consumer product
chasing attention. The tone is **capable and unpretentious** — a well-run engineering
team's internal tool, not a startup's pitch deck.

## Personality

- Confident, direct, technical. Copy states facts about the codebase (real package counts,
  real test counts) rather than marketing claims.
- Calm, not flashy. No hero animation theatrics; the interesting part is the product being
  real and working, shown via actual code and actual features.
- Light theme by default across the public site (landing, blog) — reserves `brand-navy`
  as a strong dark accent (hero code panels, CTA blocks, stats strips) rather than a
  full-page dark background.

## Palette

Source of truth: `resources/css/app.css`. Do not introduce new colors outside this set.

| Token | Value | Role |
|---|---|---|
| `--color-brand-navy` | `#1a2a4b` | Primary text, dark surfaces, primary buttons |
| `--color-brand-navy-light` | `#2a3a5b` | Hover state for navy surfaces |
| `--color-brand-accent` | `#4da3ff` | The one deliberate accent — links, highlights, active states |
| `--color-brand-accent-dark` | `#2e7dd8` | Accent on light backgrounds (better contrast) |
| `--color-brand-snow` | `#fefefe` | Page background, text on dark surfaces |
| `--color-brand-silver` | `#bcbfc4` | Muted text on dark surfaces |

This is 2 core colors (navy, snow) + 1 accent (blue), matching R-29's cap. Zinc/gray
neutrals (already used throughout the authenticated app's System panel) are not part of
the core palette and don't count against it.

## Typography

- **Display / headings**: Space Grotesk (`--font-display`) — used for all `h1`/`h2` on the
  public site. Chosen because it's already the established display face across the app,
  not an AI default; it reads technical without being a monospace cliché.
  Fallback: `ui-sans-serif, system-ui, sans-serif`.
- **Body**: Instrument Sans (`--font-sans`). Fallback: same sans-serif stack.
- **Monospace**: JetBrains Mono (`--font-mono`) — used narrowly, for actual code (the
  landing page's code showcase, route names, file paths), never as a decorative "tech"
  typeface for body copy or labels.

## Motif

The one repeated, specific gesture: **real code as proof**. The landing page's code
showcase (tabbed `routes/app.php` / `User::booted()` / `Post` model / a real Pest test)
is the identity motif — this product shows its own source instead of illustrating with
stock graphics or invented screenshots. Extend this motif rather than introducing a new
one (e.g. a new feature page should show its actual route/model snippet, not a generic
icon grid).

## Dials

`Dial: ENERGY 2 / RHYTHM 2 / MOTION 2`

- **ENERGY 2** (Stripe/Vercel range): confident and clean, not sterile (GOV.UK) and not
  loud (agency portfolio). Matches "capable, unpretentious."
- **RHYTHM 2**: sections are consistent but not identical — hero, code tabs, checklist,
  card grid, stats strip, and CTA each use a different internal composition, not the same
  centered-title-plus-grid pattern repeated six times.
- **MOTION 2**: Alpine-driven tab switching and hover/focus states only. No scroll
  parallax, no pinning, no choreography — this is a tool, not a showcase site.

## What NOT to do here

- Don't add a dark-mode toggle to the public site without a stated reason (R-21) — the
  authenticated app already has its own theme via Flux; the landing page's light theme is
  a deliberate identity choice, not an oversight.
- Don't add gradients, glassmorphism, or glow beyond what's already in `app.css`
  (`landing-grid-bg-dark`, `landing-dot-pattern`) — those two background treatments are
  the full decorative budget for this product.
- Don't invent statistics, testimonials, or logos. Every number on the landing page must
  trace to something checkable in this repo (package count, test count, role count).
