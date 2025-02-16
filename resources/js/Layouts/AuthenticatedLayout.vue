<script setup>
import { ref, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Home, Users, Package, BarChart2, MessageCircle, Settings, ChevronDown, ChevronRight, Bell, Moon, Sun, LogOut } from 'lucide-vue-next';

// Obtener datos del usuario desde Inertia.js
const page = usePage();
const user = computed(() => page.props.auth.user);

// Estado de secciones expandibles
const expandedSections = ref({
    inventory: false,
    reports: false
});

// Estado de modo oscuro
const isDarkMode = ref(false);

// Alternar modo oscuro
const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    document.documentElement.classList.toggle('dark', isDarkMode.value);
};

// Expande/cierra secciones del Sidebar
const toggleSection = (section) => {
    expandedSections.value[section] = !expandedSections.value[section];
};
</script>

<template>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-900 text-gray-900 dark:text-white p-4 border-r border-gray-200 dark:border-gray-700 min-h-screen">
            <div class="flex items-center space-x-2 p-4">
                <ApplicationLogo class="w-10 h-10" />
                <span class="text-xl font-bold">BMS</span>
            </div>

            <nav class="flex flex-col gap-2 mt-4">
                <!-- Dashboard -->
                <router-link to="/dashboard" class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <Home class="w-5 h-5" /> Dashboard
                </router-link>

                <!-- Usuarios -->
                <router-link to="/users" class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <Users class="w-5 h-5" /> Gestión de Usuarios
                </router-link>


                <!-- Inventario -->
                <div @click="toggleSection('inventory')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Package class="w-5 h-5" /> Inventario
                    </div>
                    <ChevronDown v-if="expandedSections.inventory" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.inventory" class="ml-6 flex flex-col gap-2">
                    <router-link to="/inventario/caja">🏦 Caja</router-link>
                    <router-link to="/inventario/categorias">🏷 Categorías</router-link>
                    <router-link to="/inventario/clientes">👥 Clientes</router-link>
                    <router-link to="/inventario/compras">🛒 Compras</router-link>
                    <router-link to="/inventario/cotizaciones">📄 Cotizaciones</router-link>
                    <router-link to="/inventario/devoluciones">🔄 Devoluciones</router-link>
                    <router-link to="/inventario/productos">📦 Productos</router-link>
                    <router-link to="/inventario/proveedor">🚚 Proveedores</router-link>
                    <router-link to="/inventario/usuarios">👤 Usuarios</router-link>
                    <router-link to="/inventario/ventas">💰 Ventas</router-link>
                </div>

                <!-- Reportes -->
                <div @click="toggleSection('reports')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <BarChart2 class="w-5 h-5" /> Reportes
                    </div>
                    <ChevronDown v-if="expandedSections.reports" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.reports" class="ml-6 flex flex-col gap-2">
                    <router-link to="/reportes/ventas">📈 Ventas</router-link>
                    <router-link to="/reportes/compras">🛒 Compras</router-link>
                </div>

                <!-- Mensajería -->
                <router-link to="/mensajeria">📩 Mensajería</router-link>

                <!-- Configuración -->
                <router-link to="/configuracion">⚙️ Configuración</router-link>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <div class="flex-1 flex flex-col">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 p-4 flex justify-between items-center">
                <div class="text-lg font-bold">Bienvenido, {{ user?.name }}</div>
                <div class="flex items-center gap-4">
                    <!-- Modo Oscuro -->
                    <button @click="toggleDarkMode" class="p-2 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        <Moon v-if="!isDarkMode" class="w-5 h-5" />
                        <Sun v-else class="w-5 h-5 text-yellow-400" />
                    </button>
                    <!-- Notificaciones -->
                    <button class="p-2 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        <Bell />
                    </button>
                    <!-- Usuario Dropdown -->
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition">
                                {{ user?.name }}
                                <ChevronDown class="w-4 h-4 ml-2" />
                            </button>
                        </template>
                        <template #content>
                            <router-link to="/profile">Perfil</router-link>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                <LogOut class="w-5 h-5 mr-2" /> Cerrar sesión
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </nav>

            <main class="flex-1 p-8">
                <router-view />
            </main>
        </div>
    </div>
</template>
