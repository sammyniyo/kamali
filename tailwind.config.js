import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                gold: '#c9a84c',
                dark: '#1a1a18',
                cream: '#f5f0e8',
                mid: '#2e2e2a',
                gray: '#8a8880',
            },
            fontFamily: {
                sans: ['"DM Sans"', ...defaultTheme.fontFamily.sans],
                display: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
            },
            letterSpacing: {
                label: '0.4em',
            },
        },
    },
    plugins: [],
};
