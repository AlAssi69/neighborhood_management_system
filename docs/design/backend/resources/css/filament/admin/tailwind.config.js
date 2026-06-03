import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './app/Livewire/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            borderRadius: {
                sm: '0.125rem',
                DEFAULT: '0.25rem',
                md: '0.375rem',
                lg: '0.5rem',
                xl: '0.75rem',
            },
            maxWidth: {
                content: '1440px',
            },
            colors: {
                sy: {
                    primary: 'var(--sy-primary)',
                    'on-primary': 'var(--sy-on-primary)',
                    cream: 'var(--sy-cream)',
                    paper: 'var(--sy-paper)',
                    white: 'var(--sy-white)',
                    green: 'var(--sy-green)',
                    'green-deep': 'var(--sy-green-deep)',
                    'green-mid': 'var(--sy-green-mid)',
                    'green-soft': 'var(--sy-green-soft)',
                    'green-pale': 'var(--sy-green-pale)',
                    'green-zebra': 'var(--sy-green-zebra)',
                    gold: 'var(--sy-gold)',
                    'gold-soft': 'var(--sy-gold-soft)',
                    'gold-muted': 'var(--sy-gold-muted)',
                    bronze: 'var(--sy-bronze)',
                    'bronze-soft': 'var(--sy-bronze-soft)',
                    ink: 'var(--sy-ink)',
                    gray: 'var(--sy-gray)',
                    muted: 'var(--sy-muted)',
                    accent: 'var(--sy-accent)',
                    forest: 'var(--sy-forest)',
                    charcoal: 'var(--sy-charcoal)',
                    umber: 'var(--sy-umber)',
                    'border-subtle': 'var(--sy-border-subtle)',
                    'border-strong': 'var(--sy-border-strong)',
                    'border-input': 'var(--sy-border-input)',
                    'border-gold': 'var(--sy-border-gold)',
                    'border-bronze': 'var(--sy-border-bronze)',
                    'border-green': 'var(--sy-border-green)',
                    'border-card': 'var(--sy-border-card)',
                },
            },
            fontFamily: {
                qomra: ['"itf Qomra Arabic"', 'Cairo', 'sans-serif'],
                sans: ['"IBM Plex Sans"', 'Cairo', 'system-ui', 'sans-serif'],
                mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
            },
        },
    },
}
