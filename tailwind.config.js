import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                // heading: ['"Archivo Black"', 'sans-serif']
            },
            colors: {
                'aalapak-orange': '#F28E2B',
                'aalapak-blue': '#4E9FCA',
                'aalapak-sky': '#76C6E6',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.5s ease-out',
                'scale-in': 'scaleIn 0.3s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { transform: 'translateY(20px)', opacity: '0' },
                    '100%': { transform: 'translateY(0)', opacity: '1' },
                },
                scaleIn: {
                    '0%': { transform: 'scale(0.9)', opacity: '0' },
                    '100%': { transform: 'scale(1)', opacity: '1' },
                },
            },
            backdropBlur: {
                xs: '2px',
            },
        },
    },

    plugins: [
        forms,
        function({ addUtilities }) {
            const newUtilities = {
                '.line-clamp-2': {
                    overflow: 'hidden',
                    display: '-webkit-box',
                    '-webkit-box-orient': 'vertical',
                    '-webkit-line-clamp': '2',
                },
            }
            addUtilities(newUtilities)
        }
    ],
};