# Syrian visual identity — design tokens

Reference for the Filament admin UI theme. Layout and typography follow [DESIGN.md](DESIGN.md) / [DESIGN-dark.md](DESIGN-dark.md); **colors** are the national brand palette below (not the Levantine MD3 greens in DESIGN.md). CSS: [`backend/resources/css/filament/admin/syrian-tokens.css`](../../backend/resources/css/filament/admin/syrian-tokens.css).

## Shape language

Soft corners in both themes: `sm` 2px, default 4px, `lg` 8px, `xl` 12px.

## Core palette (light)

| Token | Hex | National name | Usage |
|-------|-----|---------------|--------|
| `sy-green` / `sy-green-deep` | `#042623` | Orontes Green | Filament `primary`, headings, active nav |
| `sy-green-mid` | `#0a4a42` | — | Hover / pressed |
| `sy-gold` | `#b9a779` | Qasioun Gold | Topbar rule, icons, accents |
| `sy-cream` | `#edebe0` | Palmyra Sand | Page background, text on green |
| `sy-white` | `#ffffff` | — | Cards, inputs |
| `sy-ink` | `#161616` | Basalt Black | Body text |
| `sy-gray` | `#3d3a3b` | — | Muted text (Filament `gray`) |
| `sy-bronze` | `#988561` | Ebla Bronze | Projects, warnings |

### Tint scale (light)

| Token | Hex | Usage |
|-------|-----|--------|
| `sy-green-soft` | `#d4e8e2` | Table headers, hovers |
| `sy-green-pale` | `#ecf4f1` | Sidebar, toolbars |
| `sy-green-zebra` | `#e8f2ef` | Alternating rows |
| `sy-gold-soft` | `#f3ede0` | Finance hub, totals |
| `sy-bronze-soft` | `#f0ebe3` | Projects hub |

## Dark theme (high contrast)

Same brand hues; surfaces shift to Basalt / elevated gray. Foreground text uses near-white tones for strong contrast on dark surfaces.

| Token | Hex | Usage |
|-------|-----|--------|
| `sy-cream` | `#131313` | Page background (Basalt) |
| `sy-green-pale` | `#201f1f` | Section cards |
| `sy-white` | `#353534` | Elevated inputs/cards |
| `sy-green-deep` | `#042623` | Topbar, sidebar, primary buttons |
| `sy-green` | `#eef8f5` | Links, accents on dark |
| `sy-ink` | `#fafaf9` | Body text |
| `sy-accent` | `#ffffff` | Headings, emphasis |
| `sy-gray` | `#f2f1ef` | UI / nav / secondary copy |
| `sy-muted` | `#e4e3e1` | Tertiary / helper text |
| `sy-gold` | `#b9a779` | Borders, icons, active indicators |

## Borders

| Token | Role |
|-------|------|
| `sy-border-strong` | Cards, sections |
| `sy-border-subtle` | Row dividers |
| `sy-border-card` | Gold-tint card edge |
| `sy-border-gold` / `sy-border-bronze` / `sy-border-green` | Themed edges |

## Filament semantic colors

- **primary:** `#042623` (Orontes Green)
- **success:** `#0d5c4a`
- **warning:** `#988561` (Ebla Bronze)
- **gray:** `#3d3a3b`

## Typography

| Role | Font |
|------|------|
| Headings | itf Qomra Arabic |
| Body / UI | IBM Plex Sans |
| Dark labels (optional) | JetBrains Mono (`.sy-label-mono`) |
| Fallback | Cairo |

## Logos

| Asset | Path | When |
|-------|------|------|
| Horizontal wordmark (light) | `backend/public/images/brand/syrian-horizontal-dark-green.svg` | Light mode (`brandLogo`) |
| Horizontal wordmark (dark) | `backend/public/images/brand/syrian-horizontal-white.svg` | Dark mode (`darkModeBrandLogo`) |
| Favicon | `backend/public/images/brand/syrian-icon-gold.svg` | Browser tab |

Source files for the horizontal logos live in the repo-root `assets/` folder (gitignored).

Standardize gold at **`#b9a779`** (not `#b9a77a`).

## Build

```bash
cd backend && npm run build
```
