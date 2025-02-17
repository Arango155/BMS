
/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // 🔥 Importante: Activa el modo oscuro basado en clases

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
            },
            colors: {
                darkBg: '#1a202c', // 🔥 Color de fondo en modo oscuro
                darkText: '#ffffff', // 🔥 Color de texto en modo oscuro
                darkCard: '#2D3748', // 🔥 Color para tarjetas en modo oscuro
                darkBorder: '#4A5568', // 🔥 Bordes más visibles en modo oscuro
                darkSidebar: '#111827', // 🎨 Sidebar en modo oscuro
                darkHover: '#1f2937', // 🌙 Hover en modo oscuro
            },
        },
    },

    plugins: [forms],
};


