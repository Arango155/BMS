<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Footer from "@/components/Footer.vue";

// Definir propiedades recibidas
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

// Estado reactivo para controlar la visibilidad del menú
const isMenuOpen = ref(false);
</script>

<template>
    <div class="bg-white shadow-lg p-4 relative">
        <nav class="flex justify-between items-center flex-wrap">
            <!-- Logo y nombre -->
            <div class="flex items-center space-x-2">
                <img src="https://cdn-icons-png.flaticon.com/256/4951/4951200.png" alt="Logo" class="w-8 h-8"/>
                <span class="text-gray-800 font-bold text-xl">BMS</span>
            </div>

            <!-- Botón del menú hamburguesa -->
            <button @click="isMenuOpen = !isMenuOpen" class="sm:hidden text-gray-800 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Links de navegación -->
            <div class="hidden sm:flex flex-1 justify-center space-x-8">
                <Link v-for="link in ['features', 'solutions', 'plans', 'pricing', 'download', 'modules', 'community', 'other']"
                      :key="link" :href="`#${link}`"
                      class="text-gray-600 hover:text-blue-500 transition-colors duration-300 capitalize">
                    {{ link }}
                </Link>
            </div>

            <!-- Botones de login/register -->
            <div class="hidden sm:flex items-center space-x-4">
                <template v-if="props.canLogin">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-gray-800 font-bold hover:text-blue-500 text-xl">Dashboard</Link>
                    <template v-else>
                        <Link :href="route('login')" class="text-gray-800 font-bold hover:text-blue-500 text-xl">Log in</Link>
                        <Link v-if="props.canRegister" :href="route('register')" class="text-white bg-blue-500 hover:bg-blue-600 font-bold text-xl py-3 px-6 rounded-md">
                            Get started with BMS
                        </Link>
                    </template>
                </template>
            </div>
        </nav>

        <!-- Menú desplegable para móviles -->
        <div v-if="isMenuOpen" class="fixed inset-0 bg-white bg-opacity-90 z-50 flex flex-col items-center pt-16 space-y-6" @click.self="isMenuOpen = false">
            <Link v-for="link in ['features', 'solutions', 'plans', 'pricing', 'download', 'modules', 'community', 'other']"
                  :key="link" :href="`#${link}`"
                  class="text-gray-800 font-bold text-3xl hover:text-blue-500 transition-colors duration-300 capitalize">
                {{ link }}
            </Link>

            <hr class="w-3/4 border-gray-500 mt-6"/>

            <template v-if="props.canLogin">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-gray-800 font-bold hover:text-blue-500 text-xl">Dashboard</Link>
                <template v-else>
                    <Link :href="route('login')" class="text-gray-800 font-bold hover:text-blue-500 text-xl">Log in</Link>
                    <Link v-if="props.canRegister" :href="route('register')" class="bg-blue-500 text-white font-bold text-xl py-3 px-6 rounded-md hover:bg-blue-600">
                        Get started with BMS
                    </Link>
                </template>
            </template>
        </div>
    </div>

<main>
    <div class="text-center mt-6">
        <button onclick="showCodeSkills()" class="btn btn-primary">Modules</button>
        <button onclick="showSoftSkills()" class="btn btn-light ml-4">Features</button>
    </div>

    <div id="codingskills" class="margin grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
        <div class="card" v-for="skill in skills" :key="skill.title">
            <i :class="skill.icon"></i>
            <span class="font-bold">{{ skill.title }}</span>
            <p>{{ skill.description }}</p>
        </div>
    </div>

</main>
    <Footer />
</template>
<style>


</style>
<script>
export default {
    data() {
        return {
            skills: [
                { icon: 'bi bi-cart', title: 'Procurement', description: 'Manages purchasing processes, supplier relationships, and procurement workflows.' },
                { icon: 'bi bi-cash-stack', title: 'Finance and Accounting', description: 'Handles financial transactions, reporting, budgeting, and compliance.' },
                { icon: 'bi bi-people', title: 'Human Capital Management', description: 'Manages employee records, payroll, recruitment, and performance tracking.' },
                { icon: 'bi bi-gear-wide', title: 'Manufacturing', description: 'Oversees production planning, scheduling, and shop floor management.' },
                { icon: 'bi bi-box', title: 'Order Management', description: 'Tracks customer orders from order entry to fulfillment and invoicing.' },
                { icon: 'bi bi-truck', title: 'Supply Chain Management', description: 'Optimizes logistics, vendor management, and procurement strategies.' },
                { icon: 'bi bi-box-seam', title: 'ERP Distribution', description: 'Streamlines distribution processes, inventory control, and order processing.' },
                { icon: 'bi bi-person-lines-fill', title: 'CRM', description: 'Manages customer relationships, sales pipelines, and marketing campaigns.' },
                { icon: 'bi bi-cart-plus', title: 'E-commerce', description: 'Integrates online sales platforms with inventory and order management.' },
                { icon: 'bi bi-archive', title: 'Inventory Management', description: 'Tracks stock levels, movements, and replenishment strategies.' },
                { icon: 'bi bi-house-door', title: 'Warehouse Management', description: 'Manages storage, picking, packing, and warehouse automation.' },
                { icon: 'bi bi-bar-chart-line', title: 'Business Intelligence', description: 'Provides analytics, reporting, and data visualization for decision-making.' },
            ]

        };
    }
};
</script>


