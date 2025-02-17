<template>
    <footer
        class="w-full p-6 mt-6 bg-gray-50 text-black dark:bg-gray-900 dark:text-white transition-all duration-300 !important">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 !important">
            <!-- Logo y enlaces principales -->
            <div class="flex flex-col items-start !important">
                <div class="flex items-center gap-2 !important">
                    <img src="https://cdn-icons-png.flaticon.com/256/4951/4951200.png" alt="BMS Logo"
                         class="h-8 dark:brightness-90 !important">
                    <span class="text-lg font-semibold !important">BMS</span>
                </div>
                <ul class="mt-2 space-y-1 !important">
                    <li v-for="link in mainLinks" :key="link.text">
                        <a :href="link.href"
                           class="hover:text-gray-600 dark:hover:text-gray-400 transition !important">
                            {{ link.text }}
                        </a>
                    </li>
                </ul>
                <!-- Redes Sociales -->
                <div class="flex gap-4 mt-3 text-lg !important">
                    <a v-for="social in socialLinks" :key="social.icon" :href="social.href"
                       class="hover:text-gray-600 dark:hover:text-gray-400 transition !important">
                        {{ social.icon }}
                    </a>
                </div>
            </div>

            <!-- Secciones Dinámicas -->
            <div v-for="section in sections" :key="section.title">
                <h3 class="text-lg font-semibold !important">{{ section.title }}</h3>
                <ul class="mt-2 space-y-1 !important">
                    <li v-for="link in section.links" :key="link.text">
                        <a :href="link.href"
                           class="hover:text-gray-600 dark:hover:text-gray-400 transition !important">
                            {{ link.text }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Parte inferior -->
        <div class="mt-6 text-center text-sm border-t pt-4 border-gray-300 dark:border-gray-700 !important">
            <p>© {{ year }} BMS. All rights reserved.</p>
            <p class="mt-1">
                <a href="#" class="hover:text-gray-600 dark:hover:text-gray-400 transition !important">
                    Do Not Sell My Info
                </a>
                |
                <a href="#" class="hover:text-gray-600 dark:hover:text-gray-400 transition !important">
                    Cookie Settings
                </a>
            </p>
        </div>
    </footer>
</template>

<script setup>
import { ref } from "vue";

// Año dinámico
const year = ref(new Date().getFullYear());

// Links principales
const mainLinks = ref([
    { text: "Home", href: "#" },
    { text: "Services", href: "#" },
    { text: "About Us", href: "#" },
    { text: "Open Source", href: "#" },
]);

// Redes sociales
const socialLinks = ref([
    { icon: "📘", href: "#" }, // Facebook
    { icon: "🐦", href: "#" }, // Twitter
    { icon: "🔗", href: "#" }, // LinkedIn
    { icon: "📸", href: "#" }, // Instagram
]);

// Secciones dinámicas
const sections = ref([
    {
        title: "🏢 Company",
        links: [
            { text: "About us", href: "#" },
            { text: "Careers", href: "#" },
            { text: "Security", href: "#" },
            { text: "Status", href: "#" },
            { text: "Terms & Privacy", href: "#" },
        ],
    },
    {
        title: "📚 Resources",
        links: [
            { text: "Help center", href: "#" },
            { text: "Pricing", href: "#" },
            { text: "Blog", href: "#" },
            { text: "Community", href: "#" },
            { text: "Integrations", href: "#" },
            { text: "Templates", href: "#" },
            { text: "Affiliates", href: "#" },
        ],
    },
]);
</script>
