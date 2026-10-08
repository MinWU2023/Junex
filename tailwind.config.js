const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand-red': '#D92B28',
                'brand-navy': '#1A202C',
                'brand-dark': '#0b1220',
                'brand-gray-light': '#F3F4F6',
                'brand-black': '#000000',
                'sample-red': '#D92B28',
                'sample-red-light': '#FFF5F5',
                'sample-lead': '#585858',
            },
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
    },

    plugins: [require('@tailwindcss/ui')],
};
