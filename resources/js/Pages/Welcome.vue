<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, watchEffect } from 'vue';
import { useDarkMode } from '@/utils/theme'; // Importa la función para manejar el modo oscuro
import Footer from "@/components/Footer.vue";
import { Moon, Sun, Bell } from 'lucide-vue-next';

const { isDarkMode, toggleDarkMode } = useDarkMode();

// Estado reactivo para el menú y la pestaña activa
const isMenuOpen = ref(false);
const activeTab = ref('modules'); // Activa la pestaña de Modules por defecto

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

// 📌 ERP Modules
const modules = [
    { icon: '🛒', title: 'Procurement', description: 'Manages purchasing processes, supplier relationships, and procurement workflows.' },
    { icon: '💰', title: 'Finance & Accounting', description: 'Handles financial transactions, reporting, budgeting, and compliance.' },
    { icon: '👥', title: 'Human Capital Management', description: 'Manages employee records, payroll, recruitment, and performance tracking.' },
    { icon: '🏭', title: 'Manufacturing', description: 'Oversees production planning, scheduling, and shop floor management.' },
    { icon: '📦', title: 'Inventory Management', description: 'Tracks stock levels, movements, and replenishment strategies.' },
    { icon: '🚚', title: 'Logistics & Supply Chain', description: 'Optimizes transportation, vendor management, and delivery tracking.' },
    { icon: '🛍️', title: 'Sales & Order Management', description: 'Handles sales orders, invoicing, and customer tracking.' },
    { icon: '🤝', title: 'CRM (Customer Relationship Management)', description: 'Manages customer relationships, sales pipelines, and marketing campaigns.' },
    { icon: '🌐', title: 'E-commerce Integration', description: 'Connects online sales platforms with inventory and order management.' },
    { icon: '🏦', title: 'Banking & Treasury', description: 'Integrates financial transactions, bank reconciliations, and cash flow management.' },
    { icon: '📊', title: 'Business Intelligence (BI)', description: 'Provides analytics, dashboards, and data-driven decision-making tools.' },
    { icon: '🔒', title: 'Security & Compliance', description: 'Ensures regulatory compliance, role-based access, and encryption measures.' },
];

// 📌 ERP Features
const features = [
    { icon: '📡', title: 'Cloud-Based Access', description: 'Work from anywhere with real-time data updates in the cloud.' },
    { icon: '🤖', title: 'AI & Automation', description: 'Automates repetitive tasks, predictive analytics, and smart workflows.' },
    { icon: '⚙️', title: 'Customizable Workflows', description: 'Adapt the ERP to fit your business processes and rules.' },
    { icon: '📊', title: 'Real-Time Reporting', description: 'Generate instant financial reports, sales forecasts, and KPI dashboards.' },
    { icon: '🔄', title: 'Automated Updates', description: 'Keep your system up to date with the latest features and security patches.' },
];

const currentSkills = ref(modules);

// 📌 Funciones para cambiar entre Modules y Features
const showModules = () => {
    activeTab.value = 'modules';
    currentSkills.value = modules;
};
const showFeatures = () => {
    activeTab.value = 'features';
    currentSkills.value = features;
};
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-[#1a1c2c]">
        <!-- Navbar -->
        <nav class="bg-white dark:bg-[#1a1c2c] shadow p-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="https://cdn-icons-png.flaticon.com/256/4951/4951200.png" alt="Logo" class="w-8 h-8" />
                <span class="text-gray-800 dark:text-white font-bold text-xl">BMS</span>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Dark Mode Toggle -->
                <button
                    @click="toggleDarkMode"
                    class="p-2 rounded-full transition-all duration-300 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600"
                >
                    <Moon v-if="!isDarkMode" class="w-5 h-5 text-gray-700" />
                    <Sun v-else class="w-5 h-5 text-yellow-400" />
                </button>

                <!-- Login / Register Buttons -->
                <template v-if="props.canLogin">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="text-gray-800 dark:text-white font-bold hover:text-blue-500 dark:hover:text-blue-400 text-xl"
                    >
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="text-gray-800 dark:text-white font-bold hover:text-blue-500 dark:hover:text-blue-400 text-xl"
                        >
                            Log in
                        </Link>
                        <Link
                            v-if="props.canRegister"
                            :href="route('register')"
                            class="text-white bg-blue-500 dark:bg-blue-700 hover:bg-blue-600 dark:hover:bg-blue-500 font-bold text-xl py-3 px-6 rounded-md"
                        >
                            Get started with BMS
                        </Link>
                    </template>
                </template>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="p-6">
            <div class="text-center mt-6">
                <button @click="showModules" :class="['btn', activeTab === 'modules' ? 'btn-primary' : 'btn-light']">Modules</button>
                <button @click="showFeatures" :class="['btn', 'ml-4', activeTab === 'features' ? 'btn-primary' : 'btn-light']">Features</button>
            </div>

            <div id="codingskills" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-6">
                <div class="card dark:bg-[#22243a] dark:border-gray-700" v-for="skill in currentSkills" :key="skill.title">
                    <span>{{ skill.icon }}</span>
                    <span class="font-bold">{{ skill.title }}</span>
                    <p>{{ skill.description }}</p>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>

<style scoped>
button.bg-blue-500 {
    transition: all 0.3s ease-in-out !important;
}

.card {
    transition: transform 0.2s !important;
}
.card:hover {
    transform: translateY(-5px) scale(1.05) !important;
}

nav {
    background-color: #ffffff !important;
    transition: background-color 0.3s ease-in-out !important;
}

.dark nav {
    background-color: #1E1E2E !important;
    color: white !important;
}
</style>
