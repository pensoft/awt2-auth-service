/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'main-teal': '#00b1b2',
                'main-teal-hover': '#00999a',
                'main-dark': '#192956',
                'main-gray': '#e3e3e3',
                'error': '#e56b87',
            },
            fontSize: {
                sm: ['14px', '19px'],
                base: ['15px', '20px'],
                lg: ['16px', '22px'],
                xl: ['34px', '50px'],
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
