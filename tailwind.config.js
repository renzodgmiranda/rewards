import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            colors:{
                orange: {
                    950: '#f67d50'
                },
                tier: '#58595b',
                mainbg: '#faf1ef',
                blue_cus1: '#4c6784',
                gray_cus1: '#93a3b5',
                gold: '#FFD700',
                silver: '#C0C0C0',
                bronze: '#CD7F32',
                platinum: '#e5e4e2',
                yellow_cus1: '#f9a61c',
                orange_cus1: '#ef4d25'
            },

            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans]
            },

            fontSize: {
                regular: '1.3331rem',
                pts20: '1.67rem',
                pts30: '2.5rem',
                pts30woRem: ['40px', '1px'],
                pts45: ['60px', '1px'],
                pts55: ['73.33px', '1px'],
                bold: ['33.33px', '1'],
                pts25: ['33.33px', '1px'],
                semiLarge: ['60px', '1'],
                large: ['72.5px', '1'],
                exe: ['34.666666666666664px', '1']

            }
        },
    },

    plugins: [
        forms, typography,
        require('flowbite/plugin'),
        require('@tailwindcss/forms')
    ],
};
