import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Enable dark mode with class strategy
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
            animation: {
                'fade-in-up': 'fade-in-up 0.8s ease-out forwards',
                'gradient': 'gradient 3s ease infinite',
                'spin-slow': 'spin-slow 3s linear infinite',
                'pulse': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'ping': 'ping 1s cubic-bezier(0, 0, 0.2, 1) infinite',
                'bounce': 'bounce 1s infinite',
            },
            keyframes: {
                'fade-in-up': {
                    'from': {
                        opacity: '0',
                        transform: 'translateY(20px)'
                    },
                    'to': {
                        opacity: '1',
                        transform: 'translateY(0)'
                    }
                },
                'gradient': {
                    '0%, 100%': {
                        'background-position': '0% 50%'
                    },
                    '50%': {
                        'background-position': '100% 50%'
                    }
                },
                'spin-slow': {
                    'from': {
                        transform: 'rotate(0deg)'
                    },
                    'to': {
                        transform: 'rotate(360deg)'
                    }
                }
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
            },
        },
    },

    plugins: [forms],
};