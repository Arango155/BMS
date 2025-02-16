<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Home, Users, Package, ShoppingCart, DollarSign, FileText, Briefcase, Clipboard, Settings, ChevronDown, ChevronRight, Bell, Moon, Sun, LogOut } from 'lucide-vue-next';

const page = usePage();
const user = computed(() => page.props.auth?.user || {});
const profile = computed(() => page.props.profile || {});

// Estado de secciones expandibles
const expandedSections = ref({
    inventory: false,
    sales: false,
    purchases: false,
    accounting: false,
    hr: false,
    users: false
});

// Alternar modo oscuro
const isDarkMode = ref(false);
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
                <span class="text-xl font-bold">BMS ERP</span>
            </div>

            <nav class="flex flex-col gap-2 mt-4">
                <router-link to="/dashboard" class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <Home class="w-5 h-5" /> Dashboard
                </router-link>

                <!-- Gestión de Usuarios -->
                <div @click="toggleSection('users')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Users class="w-5 h-5" /> Gestión de Usuarios
                    </div>
                    <ChevronDown v-if="expandedSections.users" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.users" class="ml-6 flex flex-col gap-2">
                    <router-link to="/usuarios/clientes">👥 Clientes</router-link>
                    <router-link to="/usuarios/empleados">👤 Usuarios</router-link>
                    <router-link to="/users">📝 Usuarios Registrados</router-link>
                    <router-link to="/usuarios/roles">🔑 Roles y Permisos</router-link>
                </div>

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



                <!-- Ventas -->
                <div @click="toggleSection('sales')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <DollarSign class="w-5 h-5" /> Ventas
                    </div>
                    <ChevronDown v-if="expandedSections.sales" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.sales" class="ml-6 flex flex-col gap-2">
                    <router-link to="/ventas/facturacion">🧾 Facturación</router-link>
                    <router-link to="/ventas/clientes">👥 Clientes</router-link>
                    <router-link to="/ventas/pedidos">📑 Pedidos</router-link>
                    <router-link to="/ventas/cotizaciones">📄 Cotizaciones</router-link>
                </div>

                <!-- Compras -->
                <div @click="toggleSection('purchases')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <ShoppingCart class="w-5 h-5" /> Compras
                    </div>
                    <ChevronDown v-if="expandedSections.purchases" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.purchases" class="ml-6 flex flex-col gap-2">
                    <router-link to="/compras/ordenes">🛒 Ordenes de Compra</router-link>
                    <router-link to="/compras/proveedores">🚚 Proveedores</router-link>
                    <router-link to="/compras/pagos">💳 Pagos</router-link>
                </div>

                <!-- Configuración -->
                <router-link to="/configuracion">⚙️ Configuración</router-link>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <div class="flex-1 flex flex-col">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 p-4 flex justify-between items-center">
                <div class="text-lg font-bold">{{ profile.dashboard_name || 'Sistema de Gestión BMS' }}</div>

                <div class="flex items-center gap-4">
                    <button @click="toggleDarkMode" class="p-2 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        <Moon v-if="!isDarkMode" class="w-5 h-5" />
                        <Sun v-else class="w-5 h-5 text-yellow-400" />
                    </button>
                    <button class="p-2 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        <Bell />
                    </button>
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition">
                                {{ user?.name || 'Usuario' }}
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
