import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createRouter, createWebHistory } from 'vue-router';

import '@fortawesome/fontawesome-free/css/all.min.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'vue-toastification/dist/index.css';
import 'floating-vue/dist/style.css';

import Footer from './components/Footer.vue';
import DarkModeToggle from './components/DarkModeToggle.vue';
import Toast from 'vue-toastification';
import { Plus, Users } from 'lucide-vue-next';
import { VueDraggableNext } from 'vue-draggable-next';
import TiptapEditor from '@/Components/TiptapEditor.vue';
import DraggableBoard from '@/Components/DraggableBoard.vue';
import CustomCard from '@/Components/CustomCard.vue';
import { Editor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import { MotionPlugin } from '@vueuse/motion';
import FloatingVue from 'floating-vue';
import { Dialog, DialogOverlay, DialogPanel, DialogTitle, DialogDescription } from '@headlessui/vue';
import { useDark, useToggle } from '@vueuse/core';

// 📌 Importar router desde `router/index.js`
import router from './router';

const appName = import.meta.env.VITE_APP_NAME || 'BMS';

// 🔥 MEJOR LÓGICA DE MODO OSCURO
const isDark = useDark({
    selector: 'html',
    attribute: 'class',
    valueDark: 'dark',
    valueLight: 'light',
    storageKey: 'darkModePreference', // Guarda la preferencia en LocalStorage
});

const toggleDarkMode = useToggle(isDark);

// 🚀 Crear la aplicación Inertia con Vue Router
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(router)  // 📌 Usa Vue Router aquí
            .use(ZiggyVue)
            .use(Toast, {
                position: "top-right",
                timeout: 3000,
                closeOnClick: true,
                pauseOnHover: true,
                draggable: true,
                showCloseButtonOnHover: false,
            })
            .use(MotionPlugin)
            .use(FloatingVue)
            .component('Footer', Footer)
            .component('DarkModeToggle', DarkModeToggle)
            .component('PlusIcon', Plus)
            .component('UsersIcon', Users)
            .component('VueDraggableNext', VueDraggableNext)
            .component('TiptapEditor', TiptapEditor)
            .component('DraggableBoard', DraggableBoard)
            .component('CustomCard', CustomCard)
            .component('Editor', Editor)
            .component('EditorContent', EditorContent)
            .component('Dialog', Dialog)
            .component('DialogOverlay', DialogOverlay)
            .component('DialogPanel', DialogPanel)
            .component('DialogTitle', DialogTitle)
            .component('DialogDescription', DialogDescription)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
