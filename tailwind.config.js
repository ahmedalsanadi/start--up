import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        "./node_modules/flowbite/**/*.js"
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                tajawal: ['Tajawal', 'sans-serif'], // Add Tajawal font
              },
        },
    },
    plugins: [
        require('flowbite/plugin'),
    ],
};
