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
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                'xs': '475px',
            },
            spacing: {
                'safe-bottom': 'env(safe-area-inset-bottom)',
                'safe-top': 'env(safe-area-inset-top)',
            },
            minHeight: {
                'touch': '44px',
            },
            minWidth: {
                'touch': '44px',
            },
        },
    },

    plugins: [
        forms,
        function({ addUtilities }) {
            const newUtilities = {
                '.touch-target': {
                    minHeight: '44px',
                    minWidth: '44px',
                },
                '.mobile-container': {
                    paddingLeft: '1rem',
                    paddingRight: '1rem',
                    '@screen sm': {
                        paddingLeft: '1.5rem',
                        paddingRight: '1.5rem',
                    },
                    '@screen lg': {
                        paddingLeft: '2rem',
                        paddingRight: '2rem',
                    },
                },
            }
            addUtilities(newUtilities)
        }
    ],
};
