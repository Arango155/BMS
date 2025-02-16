<script setup>
import { ref, computed } from 'vue';

// Estado para controlar qué sección se muestra
const vistaActual = ref('lista'); // 'lista', 'nueva', 'mayoreo', 'contado', 'credito', 'pendientes', 'buscarFecha', 'buscarCodigo'

// Estado de la lista de ventas
const ventas = ref([
    { id: 1, tipo: 'Contado', codigo: 'V001', fecha: '13/02/2025', cliente: 'Juan Pérez', vendedor: 'Ana López', total: '$500.00', estado: 'Completada' },
    { id: 2, tipo: 'Crédito', codigo: 'V002', fecha: '14/02/2025', cliente: 'Empresa X', vendedor: 'Carlos Gómez', total: '$1,200.00', estado: 'Pendiente' }
]);

// Estado del formulario de nueva venta
const nuevaVenta = ref({
    codigoProducto: '',
    cliente: 'Público General',
    tipoVenta: 'Contado',
    descuento: 0,
    totalPagado: 0,
    cambio: 0
});

// Estado para la búsqueda de ventas
const busqueda = ref('');
const ventaEncontrada = computed(() => {
    return ventas.value.find(venta => venta.codigo.includes(busqueda.value) || venta.fecha.includes(busqueda.value));
});

// Función para agregar un producto a la venta (simulación)
const productosEnVenta = ref([]);
const agregarProducto = () => {
    if (nuevaVenta.value.codigoProducto) {
        productosEnVenta.value.push({
            codigo: nuevaVenta.value.codigoProducto,
            nombre: 'Producto de prueba',
            cantidad: 1,
            precio: 100,
            subtotal: 100
        });
        nuevaVenta.value.codigoProducto = '';
    }
};

// Función para eliminar un producto de la venta
const eliminarProducto = (index) => {
    productosEnVenta.value.splice(index, 1);
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">🛒 Gestión de Ventas</h2>

        <!-- Botones de navegación -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <button @click="vistaActual = 'nueva'"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md shadow-md hover:scale-105 transition">
                ➕ Nueva Venta
            </button>
            <button @click="vistaActual = 'mayoreo'"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:scale-105 transition">
                🏷️ Nueva Venta (Mayoreo)
            </button>
            <button @click="vistaActual = 'contado'"
                    class="bg-green-500 text-white px-4 py-2 rounded-md shadow-md hover:scale-105 transition">
                💵 Ventas al Contado
            </button>
            <button @click="vistaActual = 'credito'"
                    class="bg-orange-500 text-white px-4 py-2 rounded-md shadow-md hover:scale-105 transition">
                🏦 Ventas al Crédito
            </button>
            <button @click="vistaActual = 'pendientes'"
                    class="bg-red-500 text-white px-4 py-2 rounded-md shadow-md hover:scale-105 transition">
                ⚠️ Ventas Pendientes
            </button>
            <button @click="vistaActual = 'buscarFecha'"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-md hover:scale-105 transition">
                🔍 Buscar Venta (Fecha)
            </button>
            <button @click="vistaActual = 'buscarCodigo'"
                    class="bg-gray-600 text-white px-4 py-2 rounded-md shadow-md hover:scale-105 transition">
                🔍 Buscar Venta (Código)
            </button>
        </div>

        <!-- NUEVA VENTA -->
        <div v-if="vistaActual === 'nueva' || vistaActual === 'mayoreo'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                {{ vistaActual === 'nueva' ? '🛍️ Nueva Venta' : '🏷️ Nueva Venta (Mayoreo)' }}
            </h3>
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <input v-model="nuevaVenta.codigoProducto" type="text" placeholder="📦 Código de Producto"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white mb-3">
                <button @click="agregarProducto"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md shadow-md hover:scale-105 transition">
                    ➕ Agregar Producto
                </button>

                <!-- Tabla de productos en la venta -->
                <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md mt-4">
                    <thead>
                    <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                        <th class="py-3 px-5 text-left">📜 Código</th>
                        <th class="py-3 px-5 text-left">🏷️ Producto</th>
                        <th class="py-3 px-5 text-left">📦 Cantidad</th>
                        <th class="py-3 px-5 text-left">💵 Precio</th>
                        <th class="py-3 px-5 text-left">🔢 Subtotal</th>
                        <th class="py-3 px-5 text-center">❌ Remover</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(producto, index) in productosEnVenta" :key="index" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ producto.codigo }}</td>
                        <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ producto.nombre }}</td>
                        <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ producto.cantidad }}</td>
                        <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">${{ producto.precio }}</td>
                        <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">${{ producto.subtotal }}</td>
                        <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                            <button @click="eliminarProducto(index)"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md">
                                ❌
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LISTA DE VENTAS -->
        <div v-if="['lista', 'contado', 'credito', 'pendientes'].includes(vistaActual)">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                📋 {{ vistaActual === 'lista' ? 'Lista de Ventas' : vistaActual === 'contado' ? 'Ventas al Contado' : vistaActual === 'credito' ? 'Ventas al Crédito' : 'Ventas Pendientes' }}
            </h3>
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">#</th>
                    <th class="py-3 px-5 text-left">📜 Tipo</th>
                    <th class="py-3 px-5 text-left">📅 Fecha</th>
                    <th class="py-3 px-5 text-left">👤 Cliente</th>
                    <th class="py-3 px-5 text-left">🛒 Vendedor</th>
                    <th class="py-3 px-5 text-left">💰 Total</th>
                    <th class="py-3 px-5 text-left">📍 Estado</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="venta in ventas" :key="venta.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ venta.id }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ venta.tipo }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
