import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.tsx',
    ],

    theme: {
        extend: {
            textshadow:{
                'lg' : '2px 1px 2px rgba(0,0,0,0.3)'
            },
            screens: {
                'xl': '1440px',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                english: ['Poppins', 'Roboto', ...defaultTheme.fontFamily.sans],
                arabic: ['"Cairo"', '"Readex Pro"', '"Noto Sans"', 'sans-serif'],

            },
            colors: {
                'primary-color': 'rgb(40, 40, 41)'
            },
            animation: {
                'fadeup': 'fadeup 1s 0s both',
                'fadeleft': 'fadeleft 2s 1s both',
                'faderight': 'faderight 2s 1s both',
                'scaleup': 'scaleUp  0.8s ease-in-out infinite alternate',
            },
            keyframes: {
                fadeup: {
                    '0%': {
                        opacity: '0',
                        transform: 'translate3d(0, 100%, 0)',
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateZ(0)',
                    },
                },
                fadeleft: {
                    '0%': {
                        opacity: '0',
                        transform: 'translate3d(-100% , 0 , 0)'
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateZ(0)',
                    }
                },
                faderight: {
                    '0%': {
                        opacity: '0',
                        transform: 'translate3d(100%, 0, 0)',
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateZ(0)',
                    },
                },
                scaleUp: {
                    '0%': { transform: 'scale(1)' },
                    '100%': { transform: 'scale(1.25)' },
                },
            },
        },
    },

    plugins: [forms],
};
