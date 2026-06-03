---
name: Levantine Executive
colors:
  surface: '#f8f9fa'
  surface-dim: '#d9dadb'
  surface-bright: '#f8f9fa'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f3f4f5'
  surface-container: '#edeeef'
  surface-container-high: '#e7e8e9'
  surface-container-highest: '#e1e3e4'
  on-surface: '#191c1d'
  on-surface-variant: '#3f493f'
  inverse-surface: '#2e3132'
  inverse-on-surface: '#f0f1f2'
  outline: '#6f7a6f'
  outline-variant: '#becabc'
  surface-tint: '#006d36'
  primary: '#005f2e'
  on-primary: '#ffffff'
  primary-container: '#007a3d'
  on-primary-container: '#a1ffb7'
  inverse-primary: '#78db92'
  secondary: '#6b5d35'
  on-secondary: '#ffffff'
  secondary-container: '#f2deac'
  on-secondary-container: '#706139'
  tertiary: '#525151'
  on-tertiary: '#ffffff'
  tertiary-container: '#6a6969'
  on-tertiary-container: '#ece9e9'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#94f8ad'
  primary-fixed-dim: '#78db92'
  on-primary-fixed: '#00210c'
  on-primary-fixed-variant: '#005227'
  secondary-fixed: '#f5e1af'
  secondary-fixed-dim: '#d8c595'
  on-secondary-fixed: '#241a00'
  on-secondary-fixed-variant: '#524520'
  tertiary-fixed: '#e5e2e1'
  tertiary-fixed-dim: '#c8c6c5'
  on-tertiary-fixed: '#1c1b1b'
  on-tertiary-fixed-variant: '#474746'
  background: '#f8f9fa'
  on-background: '#191c1d'
  surface-variant: '#e1e3e4'
typography:
  headline-lg:
    fontFamily: itfQomraArabic-Black
    fontSize: 32px
    fontWeight: '900'
    lineHeight: '1.2'
  headline-md:
    fontFamily: itfQomraArabic-Black
    fontSize: 24px
    fontWeight: '900'
    lineHeight: '1.3'
  headline-sm:
    fontFamily: itfQomraArabic-Black
    fontSize: 20px
    fontWeight: '900'
    lineHeight: '1.4'
  body-lg:
    fontFamily: IBM Plex Sans
    fontSize: 18px
    fontWeight: '400'
    lineHeight: '1.6'
  body-md:
    fontFamily: IBM Plex Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.5'
  body-sm:
    fontFamily: IBM Plex Sans
    fontSize: 14px
    fontWeight: '400'
    lineHeight: '1.5'
  label-md:
    fontFamily: IBM Plex Sans
    fontSize: 14px
    fontWeight: '600'
    lineHeight: '1'
    letterSpacing: 0.02em
  label-sm:
    fontFamily: IBM Plex Sans
    fontSize: 12px
    fontWeight: '600'
    lineHeight: '1'
    letterSpacing: 0.05em
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  margin-page: 2rem
  gutter-grid: 1.5rem
  padding-container: 1.5rem
  stack-sm: 0.5rem
  stack-md: 1rem
  stack-lg: 2rem
---

## Brand & Style
The design system establishes an authoritative, institutional presence tailored for high-stakes ERP environments. It balances the dignity of the Syrian visual identity with a modern, professional SaaS aesthetic.

The style is **Corporate / Modern** with a focus on high-clarity information architecture. It utilizes a spacious, light-themed canvas to ensure that data-heavy tasks remain readable and cognitively manageable. The visual narrative is one of stability, precision, and institutional trust, utilizing sharp typography and a refined color palette to differentiate between administrative levels and functional modules.

## Colors
The palette is rooted in the "Levantine Green" as the primary action and success color, symbolizing growth and officiality. "Golden Wheat" serves as a sophisticated accent for secondary actions, dividers, and status highlights.

- **Primary (#007a3d):** Used for primary buttons, active navigation states, and success indicators.
- **Secondary (#b9a779):** Applied to subtle borders, focus rings, and decorative accents that require distinction without high contrast.
- **Backgrounds:** A clean white base (`#ffffff`) is complemented by a "Paper" neutral (`#fcfbf7`) for container backgrounds to reduce eye strain during long working sessions.
- **Text:** Deep charcoal (`#1a1a1a`) is used for maximum legibility on light backgrounds, with a secondary gray (`#5f6368`) for metadata.

## Typography
This design system employs a bilingual-first typographic strategy. **itfQomraArabic-Black** is reserved for headings to provide a strong, unmistakable Syrian identity and visual weight. 

For data density and multi-language support (Arabic/English), **IBM Plex Sans** is used for all body and UI elements. Its systematic, technical nature ensures that numbers and labels remain clear even in complex data tables. 

**Hierarchy Rules:**
- Headings should always be RTL-aligned when in Arabic mode.
- Use `headline-lg` exclusively for page titles.
- Use `label-md` for table headers and form labels to ensure they stand out from data values.

## Layout & Spacing
The layout follows a **Fixed Grid** model for desktop to ensure data forms don't become overly wide and unreadable. The content is centered within a 1440px max-width container.

- **Grid:** A 12-column grid with 24px (1.5rem) gutters.
- **Sidebar:** A fixed 280px left/right sidebar (depending on locale) for primary navigation. On desktop the user may fully collapse it; a hamburger (three-line) control in the top bar re-opens it when hidden.
- **Data Density:** While the overall UI is "spacious," data tables use a "compact" vertical rhythm (8px internal padding) to allow more rows to be visible simultaneously.
- **Mobile:** On screens below 768px, the layout collapses into a single-column fluid flow with 16px side margins; navigation opens via the same sidebar toggle pattern.

## Elevation & Depth
Depth is achieved through **Tonal Layering** and **Low-contrast Outlines** rather than heavy shadows. This maintains a clean, modern "light" feel.

- **Base Layer:** The page background uses a very subtle cream/neutral (`#fcfbf7`).
- **Surface Layer:** White cards (`#ffffff`) sit on top of the base, defined by a 1px border in Golden Wheat at 20% opacity (`#b9a77933`).
- **Focus States:** Active elements utilize a soft 4px blur shadow in Levantine Green at 10% opacity to indicate interaction without breaking the flat aesthetic.
- **Interactions:** Hovering over list items or table rows triggers a subtle tint change to the neutral background color.

## Shapes
The design system uses a **Soft** shape language to appear approachable yet professional. 

- **Containers & Cards:** 0.5rem (8px) corner radius.
- **Buttons & Inputs:** 0.25rem (4px) corner radius to maintain a sense of structural precision suitable for an ERP.
- **Search Bars:** Rounded-xl (0.75rem) to differentiate them from functional data entry fields.

## Components
- **Buttons:** Primary buttons are solid Levantine Green with white text. Secondary buttons use a Golden Wheat outline with wheat-colored text. All buttons have a height of 40px for standard tasks and 48px for primary page actions.
- **Input Fields:** Use a 1px neutral border that transitions to Levantine Green on focus. Labels sit clearly above the field in `label-sm` weight.
- **Data Tables:** Headers are pinned with a slight Golden Wheat bottom border. Zebra striping is used sparingly (every other row in the neutral color).
- **Status Chips:** Use a tonal background (e.g., light green background for success) with high-contrast text. No heavy borders on chips.
- **Cards:** Used to group related data sets. Cards must have a clear title using `headline-sm` and consistent internal padding.
- **Navigation:** The sidebar uses high-contrast icons. The active state is indicated by a vertical bar in Levantine Green on the leading edge of the menu item.