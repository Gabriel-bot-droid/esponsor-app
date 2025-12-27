import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Georgia', 'Cambria', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                'brand-cream': '#FFFBF0', 
                'brand-orange': '#F59E0B', 
                'brand-orange-hover': '#D97706',
                'brand-text': '#1F2937', 
            }
        },
    },

    plugins: [forms],
};
