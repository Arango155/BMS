<script setup>
import { ref, defineAsyncComponent } from 'vue';
import Footer from "@/Components/Footer.vue";
import { Link } from '@inertiajs/vue3';
import { Package, Users, ShoppingCart, Tag, ClipboardList, Box, DollarSign, FileText, RefreshCw } from 'lucide-vue-next';

// Estado para la visibilidad del menú en móviles
const isMenuOpen = ref(false);

// Estado para manejar qué módulo se está mostrando
const selectedModule = ref(null);

// Importar dinámicamente los componentes según el módulo seleccionado
const modules = [
    { name: "Cajas", icon: Box, component: defineAsyncComponent(() => import('@/Pages/Inventario/Caja.vue')) },
    { name: "Proveedores", icon: Users, component: defineAsyncComponent(() => import('@/Pages/Inventario/Proveedor.vue')) },
    { name: "Categorías", icon: Tag, component: defineAsyncComponent(() => import('@/Pages/Inventario/Categorias.vue')) },
    { name: "Usuarios", icon: Users, component: defineAsyncComponent(() => import('@/Pages/Inventario/Usuarios.vue')) },
    { name: "Productos", icon: Package, component: defineAsyncComponent(() => import('@/Pages/Inventario/Productos.vue')) },
    { name: "Clientes", icon: Users, component: defineAsyncComponent(() => import('@/Pages/Inventario/Clientes.vue')) },
    { name: "Ventas", icon: DollarSign, component: defineAsyncComponent(() => import('@/Pages/Inventario/Ventas.vue')) },
    { name: "Cotizaciones", icon: FileText, component: defineAsyncComponent(() => import('@/Pages/Inventario/Cotizaciones.vue')) },
    { name: "Devoluciones", icon: RefreshCw, component: defineAsyncComponent(() => import('@/Pages/Inventario/Devoluciones.vue')) },
    { name: "Compras", icon: ShoppingCart, component: defineAsyncComponent(() => import('@/Pages/Inventario/Compras.vue')) },
];

// Función para cambiar el módulo seleccionado
const loadModule = (module) => {
    selectedModule.value = module.component;
};
</script>

<template>
    <div class="flex flex-col min-h-screen bg-white dark:bg-gray-900">
        <!-- Barra de navegación superior -->
        <nav class="w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-md p-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="https://cdn-icons-png.flaticon.com/256/4951/4951200.png" alt="Logo" class="w-8 h-8"/>
                <span class="text-gray-900 dark:text-white font-bold text-xl">BMS - Inventario</span>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="flex-1 p-6">
            <!-- Mensaje de bienvenida (solo se muestra si no hay un módulo cargado) -->
            <div v-if="!selectedModule" class="mb-10 p-6 bg-blue-200 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-md shadow-md">
                <h2 class="text-lg font-semibold">📢 Módulo de Inventario</h2>
                <p class="mt-2">
                    ¡Bienvenido al Módulo de Inventario! Aquí puedes gestionar todos tus productos, controlar el stock,
                    administrar almacenes y mucho más. Algunas de las opciones disponibles incluyen:
                </p>
                <ul class="mt-2 list-disc list-inside">
                    <li>📦 Gestión de productos con categorías y variantes.</li>
                    <li>🔄 Control de stock en tiempo real con alertas de bajo inventario.</li>
                    <li>🚚 Seguimiento de movimientos y transferencias entre almacenes.</li>
                    <li>📊 Reportes detallados y dashboard con métricas clave.</li>
                </ul>
                <p class="mt-2">Utiliza las opciones de abajo para comenzar a administrar tu inventario.</p>
            </div>

            <!-- Cards con los módulos -->
            <div v-if="!selectedModule" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
                <button v-for="module in modules" :key="module.name" @click="loadModule(module)"
                        class="bg-gray-300 dark:bg-gray-700 p-6 rounded-lg shadow-md flex flex-col items-center text-gray-900 dark:text-gray-100 hover:shadow-xl transition transform hover:scale-105">
                    <span class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200">{{ module.name }}</span>
                    <component :is="module.icon" class="w-14 h-14 text-gray-700 dark:text-gray-400"/>
                </button>
            </div>

            <!-- Aquí se carga dinámicamente el módulo seleccionado -->
            <div v-if="selectedModule" class="mt-6 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
                <component :is="selectedModule" />
            </div>

            <!-- Botón para volver al menú -->
            <div v-if="selectedModule" class="mt-6 text-center">
                <button @click="selectedModule = null"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md">
                    Volver al Inventario
                </button>
            </div>
        </main>

        <!-- Footer siempre en la parte inferior -->
        <Footer class="mt-auto"/>
    </div>
</template>
