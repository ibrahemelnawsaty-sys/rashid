/** رشيد — ربط Tailwind برموز التصميم (§10.2.5). darkMode=class. */
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                primary: 'var(--color-primary)',
                'primary-light': 'var(--color-primary-light)',
                'primary-dark': 'var(--color-primary-dark)',
                secondary: 'var(--color-secondary)',
                accent: 'var(--color-accent)',
                'accent-soft': 'var(--color-accent-soft)',
                success: 'var(--color-success)',
                warning: 'var(--color-warning)',
                danger: 'var(--color-danger)',
                info: 'var(--color-info)',
                ink: 'var(--color-ink)',
                'ink-muted': 'var(--color-ink-muted)',
                surface: 'var(--color-surface)',
                'surface-alt': 'var(--color-surface-alt)',
                background: 'var(--color-background)',
                border: 'var(--color-border)',
            },
            borderRadius: {
                sm: 'var(--radius-sm)',
                md: 'var(--radius-md)',
                lg: 'var(--radius-lg)',
                xl: 'var(--radius-xl)',
            },
            boxShadow: {
                sm: 'var(--shadow-sm)',
                md: 'var(--shadow-md)',
                lg: 'var(--shadow-lg)',
            },
            fontFamily: {
                sans: ['IBM Plex Sans Arabic', 'Tajawal', 'Segoe UI', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [forms],
};
