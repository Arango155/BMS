<script setup>
import { ref, defineAsyncComponent } from 'vue';
import Footer from "@/Components/Footer.vue";
import { router } from '@inertiajs/vue3';
import { Package, Users, ShoppingCart, Tag, Box, DollarSign, FileText, RefreshCw } from 'lucide-vue-next';

// Estado para la visibilidad del menú en móviles
const isMenuOpen = ref(false);

// Módulos disponibles
const modules = [
    { name: "Cajas", icon: Box, route: "/inventario/Caja" },
    { name: "Proveedores", icon: Users, route: "/inventario/Proveedor" },
    { name: "Categorías", icon: Tag, route: "/inventario/Categorias" },
    { name: "Usuarios", icon: Users, route: "/inventario/Usuarios" },
    { name: "Productos", icon: Package, route: "/inventario/Productos" },
    { name: "Clientes", icon: Users, route: "/inventario/Clientes" },
    { name: "Ventas", icon: DollarSign, route: "/inventario/Ventas" },
    { name: "Cotizaciones", icon: FileText, route: "/inventario/Cotizaciones" },
    { name: "Devoluciones", icon: RefreshCw, route: "/inventario/Devoluciones" },
    { name: "Compras", icon: ShoppingCart, route: "/inventario/Compras" },
];

// Redirigir al módulo seleccionado
const redirectToModule = (module) => {
    if (module.route) {
        router.visit(module.route); // Redirige usando Inertia
    }
};
</script>

<template>
    <div class="flex flex-col min-h-screen bg-white dark:bg-gray-900">
        <!-- Barra de navegación superior -->
        <nav class="w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-md p-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="https://cdn-icons-png.flaticon.com/256/4951/4951200.png" alt="Logo" class="w-8 h-8" />
                <span class="text-gray-900 dark:text-white font-bold text-xl">BMS - Inventario</span>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="flex-1 p-6">
            <!-- Mensaje de bienvenida -->
            <div class="mb-10 p-6 bg-blue-200 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-md shadow-md">
                <h2 class="text-lg font-semibold">📢 Módulo de Inventario</h2>
                <p class="mt-2">
                    ¡Bienvenido al Módulo de Inventario! Aquí puedes gestionar todos tus productos, controlar el stock,
                    administrar almacenes y mucho más.
                </p>
            </div>

            <!-- Cards con los módulos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
                <button v-for="module in modules" :key="module.name" @click="redirectToModule(module)"
                        class="bg-gray-300 dark:bg-gray-700 p-6 rounded-lg shadow-md flex flex-col items-center text-gray-900 dark:text-gray-100 hover:shadow-xl transition transform hover:scale-105">
                    <span class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200">{{ module.name }}</span>
                    <component :is="module.icon" class="w-14 h-14 text-gray-700 dark:text-gray-400" />
                </button>
            </div>
        </main>

        <!-- Footer siempre en la parte inferior -->
        <Footer class="mt-auto" />
    </div>
</template>
