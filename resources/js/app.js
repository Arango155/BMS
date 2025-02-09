import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import '@fortawesome/fontawesome-free/css/all.min.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap-icons/font/bootstrap-icons.css';
import Footer from './components/Footer.vue';
import { useDark } from '@vueuse/core';
import DarkModeToggle from './components/DarkModeToggle.vue';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

const appName = import.meta.env.VITE_APP_NAME || 'BMS';

// Detecta el modo oscuro
const isDark = useDark();
if (isDark.value) document.documentElement.classList.add('dark');
else document.documentElement.classList.remove('dark');

// Crea la aplicación Inertia
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Toast, { // 📌 🔥 Agregamos configuración para Toast
                position: "top-right",
                timeout: 3000,
                closeOnClick: true,
                pauseOnHover: true,
                draggable: true,
                showCloseButtonOnHover: false,
            })
            .component('Footer', Footer)
            .component('DarkModeToggle', DarkModeToggle)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
