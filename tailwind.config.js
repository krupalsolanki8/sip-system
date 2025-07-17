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
            },
            colors: {
                blue: {
                  700: '#1240d4',
                  800: '#0F33A6',
                  900: '#2242aa',
                },
                primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
            },
            width: {
                '8' : '2rem',
                '12': '3rem',
                '16': '4rem',
                '20': '5rem',
                '24': '6rem',
                '28': '7rem',
                '32': '8rem',
                '36': '9rem',
                '40': '10rem',
                '44': '11rem',
                '48': '12rem',
                '52': '13rem',
                '56': '14rem',
                '60': '15rem',
                '64': '16rem',
            },
            height: {
                '8' : '2rem',
                '12': '3rem',
                '16': '4rem',
                '20': '5rem',
                '24': '6rem',
                '28': '7rem',
                '32': '8rem',
                '36': '9rem',
                '40': '10rem',
                '44': '11rem',
                '48': '12rem',
                '52': '13rem',
                '56': '14rem',
                '60': '15rem',
                '64': '16rem',
            },
        },
    },

    plugins: [forms],
};
