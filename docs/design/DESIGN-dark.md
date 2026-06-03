---
name: Imperial Heritage
colors:
  surface: '#131313'
  surface-dim: '#131313'
  surface-bright: '#393939'
  surface-container-lowest: '#0e0e0e'
  surface-container-low: '#1c1b1b'
  surface-container: '#201f1f'
  surface-container-high: '#2a2a2a'
  surface-container-highest: '#353534'
  on-surface: '#e5e2e1'
  on-surface-variant: '#c1c8c6'
  inverse-surface: '#e5e2e1'
  inverse-on-surface: '#313030'
  outline: '#8b9291'
  outline-variant: '#414847'
  surface-tint: '#a9cec9'
  primary: '#a9cec9'
  on-primary: '#123633'
  primary-container: '#002623'
  on-primary-container: '#6c8f8a'
  inverse-primary: '#426561'
  secondary: '#d8c595'
  on-secondary: '#3b2f0c'
  secondary-container: '#554822'
  on-secondary-container: '#cab788'
  tertiary: '#f0b8bf'
  on-tertiary: '#4a262b'
  tertiary-container: '#38171d'
  on-tertiary-container: '#ad7c82'
  error: '#ffb4ab'
  on-error: '#690005'
  error-container: '#93000a'
  on-error-container: '#ffdad6'
  primary-fixed: '#c5eae5'
  primary-fixed-dim: '#a9cec9'
  on-primary-fixed: '#00201d'
  on-primary-fixed-variant: '#2b4d49'
  secondary-fixed: '#f5e1af'
  secondary-fixed-dim: '#d8c595'
  on-secondary-fixed: '#241a00'
  on-secondary-fixed-variant: '#524520'
  tertiary-fixed: '#ffd9dd'
  tertiary-fixed-dim: '#f0b8bf'
  on-tertiary-fixed: '#311117'
  on-tertiary-fixed-variant: '#643b41'
  background: '#131313'
  on-background: '#e5e2e1'
  surface-variant: '#353534'
typography:
  headline-xl:
    fontFamily: itfQomraArabic-Black
    fontSize: 48px
    fontWeight: '900'
    lineHeight: '1.1'
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: itfQomraArabic-Black
    fontSize: 32px
    fontWeight: '900'
    lineHeight: '1.2'
  headline-lg-mobile:
    fontFamily: itfQomraArabic-Black
    fontSize: 24px
    fontWeight: '900'
    lineHeight: '1.2'
  body-md:
    fontFamily: IBM Plex Sans
    fontSize: 16px
    fontWeight: '400'
    lineHeight: '1.6'
  label-sm:
    fontFamily: JetBrains Mono
    fontSize: 12px
    fontWeight: '500'
    lineHeight: '1.0'
    letterSpacing: 0.08em
spacing:
  unit: 8px
  gutter: 24px
  margin-desktop: 64px
  margin-mobile: 20px
  stack-sm: 8px
  stack-md: 24px
  stack-lg: 48px
---

## Brand & Style

This design system is built upon a foundation of institutional authority and national permanence. It is designed for high-stakes civic environments, demanding a UI that feels both ancient and indestructible. The aesthetic is a fusion of **Corporate Modernism** and **Levantine Brutalism**, utilizing heavy architectural weights, sharp geometric precision, and a high-contrast color strategy that reflects the stony resilience of Syrian heritage.

The emotional response should be one of profound trust, gravity, and cultural continuity. By utilizing large, unyielding typographic blocks and a palette drawn from the landscape and historic architecture, the interface establishes itself as an official, immutable record.

## Colors

The palette is rooted in the "Forest" primary (#002623), a deep, emerald-black that serves as the primary surface and brand signifier. "Golden Wheat" (#b9a779) is used strictly for high-priority interactive elements, borders, and iconography, providing a regal contrast against the dark base.

"Deep Umber" (#280A10) acts as a specialized tertiary tone for alerts, semantic warnings, or secondary highlighting, while "Charcoal" (#161616) provides the structural depth for background layering. Text predominantly utilizes "Accent Light" (#edebe0) to ensure maximum legibility and an "ink-on-stone" feel, avoiding pure white to maintain the historical, weathered warmth of the source imagery.

## Typography

The typographic system is led by **itfQomraArabic-Black**, a font that carries immense visual weight and structural authority. It must be used for all primary headings to anchor the page. Headlines should be set with tight leading and slightly negative tracking to emphasize the monolithic nature of the brand.

For body content, **IBM Plex Sans** provides a technical, clean, and international balance to the expressive headers. **JetBrains Mono** is reserved for labels, metadata, and systemic values, reinforcing the "logic" aspect of the system with a disciplined, monospaced rhythm that suggests data integrity and archival precision.

## Layout & Spacing

The design system employs a **Fixed Grid** philosophy for desktop, centering content within a 1280px container to create a sense of focused stability. On mobile, the system transitions to a fluid 4-column layout. 

Spacing is governed by an 8px incremental scale, but the "rhythm" leans toward generous internal padding within components and significant vertical "stacks" between sections. This creates an editorial, spacious feel that prevents the dark palette from feeling cramped. Elements should be aligned to a strict baseline grid to ensure the architectural rigor is maintained across all screen sizes.

## Elevation & Depth

Depth is conveyed through **Tonal Layering** and **High-Contrast Outlines** rather than soft shadows. In this system, "elevation" is represented by shifting from "Charcoal" (#161616) backgrounds to "Forest" (#002623) containers. 

To separate interactive elements, use crisp 1px or 2px borders in "Golden Wheat" or "Deep Umber." When a shadow is absolutely necessary for floating elements (like modals), use a "Hard Shadow": 4px offset, 0px blur, colored #000000 at 50% opacity, mimicking the sharp shadows cast by the Levantine sun on stone walls.

## Shapes

The shape language is strictly **Sharp (0px)**. To reflect the stonework and monumental architecture of the Syrian Directorate, all containers, buttons, and input fields must feature 90-degree angles. Any deviation toward rounded corners would undermine the institutional authority and "built-to-last" narrative of the design system. 

Diagonal cuts (45-degree chamfers) are permitted on specific decorative corners or high-priority tags to echo traditional geometric motifs found in the reference mosaics.

## Components

### Buttons
Primary buttons are solid "Golden Wheat" with "Forest" text, set in all-caps itfQomraArabic. Secondary buttons are "Forest" with a 2px "Golden Wheat" border. All buttons feature a "Press" state where the background shifts to "Deep Umber."

### Input Fields
Inputs are "Charcoal" backgrounds with a bottom-only border of 2px in "Accent Light." On focus, the border transitions to "Golden Wheat." Labels always sit above the input in JetBrains Mono.

### Cards
Cards are defined by their borders rather than their backgrounds. A card should be a "Forest" container with a "Golden Wheat" 1px border. For "featured" content, use a double-border effect or a top-weighted "Deep Umber" accent bar.

### Navigation
The navigation bar should be a monolithic block of "Forest," using "Accent Light" for links. Active states are indicated by a 4px "Golden Wheat" underline that spans the full width of the menu item.

### Chips/Tags
Small, rectangular blocks with "Deep Umber" backgrounds and "Accent Light" text. No rounded corners. Used for categorization and status indicators.