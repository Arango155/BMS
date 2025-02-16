<script setup>
import { ref, computed } from 'vue';

// Estado para controlar qué sección se muestra
const vistaActual = ref('lista'); // 'lista', 'nueva', 'buscar', 'almacen', 'masVendidos', 'porCategoria', 'porVencimiento', 'stockMinimo'

// Estado de la lista de productos
const productos = ref([
    { id: 1, codigo: '1234', sku: '4321', nombre: 'Aceite', stock: 15, stock_min: 5, precio: 480, descuento: 20, estado: 'Habilitado', vencimiento: 'No tiene', vendidos: 11, categoria: 'Alimentos' },
    { id: 2, codigo: '0001', sku: '0000333', nombre: 'Celular A55', stock: 62, stock_min: 10, precio: 15, descuento: 0, estado: 'Habilitado', vencimiento: 'En 306 días', vendidos: 32, categoria: 'Electrónica' }
]);

// Estado del formulario de nuevo producto
const nuevoProducto = ref({
    codigo: '',
    sku: '',
    nombre: '',
    stock: '',
    stock_min: '',
    precio: '',
    descuento: '',
    estado: 'Habilitado',
    vencimiento: 'No tiene',
    categoria: '',
    vendidos: 0
});

// Estado para la búsqueda de productos
const busqueda = ref('');
const productoEncontrado = computed(() => {
    return productos.value.find(producto => producto.codigo.includes(busqueda.value) || producto.nombre.toLowerCase().includes(busqueda.value.toLowerCase()));
});

// Estado para manejar la edición de un producto
const productoEditando = ref(null);

// Función para seleccionar un producto y editarlo
const editarProducto = (producto) => {
    productoEditando.value = { ...producto };
    vistaActual.value = 'editar';
};

// Función para guardar los cambios en el producto editado
const guardarEdicion = () => {
    const index = productos.value.findIndex(p => p.id === productoEditando.value.id);
    if (index !== -1) {
        productos.value[index] = { ...productoEditando.value };
    }
    productoEditando.value = null;
    vistaActual.value = 'lista';
};

// Función para eliminar un producto
const eliminarProducto = (id) => {
    productos.value = productos.value.filter(producto => producto.id !== id);
};

// Función para agregar un nuevo producto
const agregarProducto = () => {
    productos.value.push({ id: productos.value.length + 1, ...nuevoProducto.value });
    nuevoProducto.value = {
        codigo: '',
        sku: '',
        nombre: '',
        stock: '',
        stock_min: '',
        precio: '',
        descuento: '',
        estado: 'Habilitado',
        vencimiento: 'No tiene',
        categoria: '',
        vendidos: 0
    };
    vistaActual.value = 'lista';
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">🛒 Gestión de Productos</h2>

        <!-- Botones de navegación -->
        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'"
                    :class="vistaActual === 'lista' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                📋 Lista de Productos
            </button>
            <button @click="vistaActual = 'nueva'"
                    :class="vistaActual === 'nueva' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                ➕ Nuevo Producto
            </button>
            <button @click="vistaActual = 'buscar'"
                    :class="vistaActual === 'buscar' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                🔍 Buscar Producto
            </button>
        </div>

        <!-- SECCIONES ADICIONALES -->
        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'almacen'"
                    class="bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                📦 Productos en Almacén
            </button>
            <button @click="vistaActual = 'masVendidos'"
                    class="bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                🔥 Más Vendidos
            </button>
            <button @click="vistaActual = 'porCategoria'"
                    class="bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                📂 Por Categoría
            </button>
            <button @click="vistaActual = 'porVencimiento'"
                    class="bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                ⏳ Por Vencimiento
            </button>
            <button @click="vistaActual = 'stockMinimo'"
                    class="bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                ⚠️ Stock Mínimo
            </button>
        </div>

        <!-- SECCIONES DINÁMICAS -->
        <div v-if="vistaActual === 'almacen'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📦 Productos en Almacén</h3>
            <p class="text-gray-700 dark:text-gray-300">Lista de todos los productos en almacén.</p>
        </div>

        <div v-if="vistaActual === 'masVendidos'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">🔥 Productos Más Vendidos</h3>
            <p class="text-gray-700 dark:text-gray-300">Lista de productos con más ventas.</p>
        </div>

        <div v-if="vistaActual === 'porCategoria'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📂 Productos por Categoría</h3>
            <p class="text-gray-700 dark:text-gray-300">Lista de productos organizados por categoría.</p>
        </div>

        <div v-if="vistaActual === 'porVencimiento'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">⏳ Productos por Vencimiento</h3>
            <p class="text-gray-700 dark:text-gray-300">Lista de productos próximos a vencer.</p>
        </div>

        <div v-if="vistaActual === 'stockMinimo'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">⚠️ Productos en Stock Mínimo</h3>
            <p class="text-gray-700 dark:text-gray-300">Lista de productos con bajo stock.</p>
        </div>
    </div>
</template>
