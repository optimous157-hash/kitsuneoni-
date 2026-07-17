import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
                japanese: ['"Noto Serif JP"', 'serif'],
            },

            colors: {
                yamagata: {
                    black: '#0a0a0a',
                    dark: '#111111',
                    charcoal: '#1a1a1a',
                    graphite: '#2a2a2a',
                    steel: '#3a3a3a',
                    silver: '#8a8a8a',
                    mist: '#b5b5b5',
                    pearl: '#e5e5e5',
                    snow: '#f5f5f5',
                    white: '#fafafa',
                    red: '#c41e3a',
                    'red-dark': '#9b1830',
                    'red-light': '#e63950',
                    gold: '#c9a84c',
                    'gold-dark': '#b8933d',
                },
            },

            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },

            borderRadius: {
                '4xl': '2rem',
            },

            animation: {
                'fade-in': 'fadeIn 0.6s ease-out forwards',
                'slide-up': 'slideUp 0.6s ease-out forwards',
                'slide-down': 'slideDown 0.3s ease-out forwards',
                'scale-in': 'scaleIn 0.4s ease-out forwards',
                'float': 'float 6s ease-in-out infinite',
                'glow': 'glow 2s ease-in-out infinite alternate',
                'shimmer': 'shimmer 2s linear infinite',
            },

            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideDown: {
                    '0%': { opacity: '0', transform: 'translateY(-10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                scaleIn: {
                    '0%': { opacity: '0', transform: 'scale(0.95)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                glow: {
                    '0%': { boxShadow: '0 0 20px rgba(196, 30, 58, 0.1)' },
                    '100%': { boxShadow: '0 0 40px rgba(196, 30, 58, 0.3)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
            },

            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'noise': "url(\"data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E\")",
            },

            boxShadow: {
                'premium': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                'premium-lg': '0 35px 60px -15px rgba(0, 0, 0, 0.3)',
                'glow-red': '0 0 30px rgba(196, 30, 58, 0.15)',
                'inner-glow': 'inset 0 1px 0 0 rgba(255, 255, 255, 0.05)',
            },

            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        color: theme('colors.yamagata.mist'),
                        a: {
                            color: theme('colors.yamagata.red'),
                            '&:hover': {
                                color: theme('colors.yamagata.red-light'),
                            },
                        },
                    },
                },
                invert: {
                    css: {
                        color: theme('colors.yamagata.pearl'),
                    },
                },
            }),
        },
    },

    plugins: [forms, typography],
};
