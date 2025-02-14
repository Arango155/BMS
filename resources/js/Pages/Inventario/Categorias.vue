<script setup>
import { ref, computed } from 'vue';

// Estado para controlar qué sección se muestra
const vistaActual = ref('lista'); // 'lista', 'nueva', 'buscar'

// Estado de la lista de categorías
const categorias = ref([
    { id: 1, nombre: 'Electrónica', ubicacion: 'Pasillo 3', estado: 'Habilitado', productos: 120 },
    { id: 2, nombre: 'Ropa', ubicacion: 'Pasillo 7', estado: 'No Habilitado', productos: 80 }
]);

// Estado del formulario de nueva categoría
const nuevaCategoria = ref({
    nombre: '',
    ubicacion: '',
    estado: 'Habilitado'
});

// Estado para la búsqueda de categorías
const busqueda = ref('');
const categoriaEncontrada = computed(() => {
    return categorias.value.find(categoria => categoria.nombre.toLowerCase().includes(busqueda.value.toLowerCase()) || categoria.ubicacion.toLowerCase().includes(busqueda.value.toLowerCase()));
});

// Estado para manejar la edición de una categoría
const categoriaEditando = ref(null);

// Función para seleccionar una categoría y editarla
const editarCategoria = (categoria) => {
    categoriaEditando.value = { ...categoria };
    vistaActual.value = 'editar';
};

// Función para guardar los cambios en la categoría editada
const guardarEdicion = () => {
    const index = categorias.value.findIndex(c => c.id === categoriaEditando.value.id);
    if (index !== -1) {
        categorias.value[index] = { ...categoriaEditando.value };
    }
    categoriaEditando.value = null;
    vistaActual.value = 'lista';
};

// Función para eliminar una categoría
const eliminarCategoria = (id) => {
    categorias.value = categorias.value.filter(categoria => categoria.id !== id);
};

// Función para agregar una nueva categoría
const agregarCategoria = () => {
    categorias.value.push({ id: categorias.value.length + 1, ...nuevaCategoria.value });
    nuevaCategoria.value = { nombre: '', ubicacion: '', estado: 'Habilitado' };
    vistaActual.value = 'lista';
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">📦 Gestión de Categorías</h2>

        <!-- Botones de navegación -->
        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'"
                    :class="vistaActual === 'lista' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                📋 Lista de Categorías
            </button>
            <button @click="vistaActual = 'nueva'"
                    :class="vistaActual === 'nueva' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                ➕ Nueva Categoría
            </button>
            <button @click="vistaActual = 'buscar'"
                    :class="vistaActual === 'buscar' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                🔍 Buscar Categoría
            </button>
        </div>

        <!-- LISTA DE CATEGORÍAS -->
        <div v-if="vistaActual === 'lista'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📋 Lista de Categorías</h3>
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">#</th>
                    <th class="py-3 px-5 text-left">🏷️ Nombre</th>
                    <th class="py-3 px-5 text-left">📍 Ubicación</th>
                    <th class="py-3 px-5 text-left">📍 Estado</th>
                    <th class="py-3 px-5 text-left">📦 Productos</th>
                    <th class="py-3 px-5 text-center">⚙️ Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="categoria in categorias" :key="categoria.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ categoria.id }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ categoria.nombre }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ categoria.ubicacion }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">
                            <span :class="categoria.estado === 'Habilitado' ? 'bg-green-500' : 'bg-red-500'"
                                  class="text-white px-3 py-1 rounded-lg text-sm">
                                {{ categoria.estado }}
                            </span>
                    </td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ categoria.productos }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                        <button @click="editarCategoria(categoria)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                            ✏️ Actualizar
                        </button>
                        <button @click="eliminarCategoria(categoria.id)"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md mx-1">
                            🗑️ Eliminar
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA NUEVA CATEGORÍA -->
        <div v-if="vistaActual === 'nueva'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">➕ Agregar Nueva Categoría</h3>
            <form @submit.prevent="agregarCategoria" class="space-y-4 bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <input v-model="nuevaCategoria.nombre" type="text" placeholder="🏷️ Nombre de la Categoría"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevaCategoria.ubicacion" type="text" placeholder="📍 Ubicación o Pasillo"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <select v-model="nuevaCategoria.estado"
                        class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                    <option value="Habilitado">✅ Habilitado</option>
                    <option value="No Habilitado">❌ No Habilitado</option>
                </select>
                <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Guardar Categoría
                </button>
            </form>
        </div>
    </div>
</template>
