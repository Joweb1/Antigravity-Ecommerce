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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                orbitron: ['Orbitron', 'sans-serif'],
            },
            colors: {
                'theme-bg': '#05010d',
                'theme-text': '#fafafa',
                'theme-accent': '#9333ea',
                'theme-border': 'rgba(255, 255, 255, 0.1)',
            },
        },
    },

    plugins: [forms],
};
