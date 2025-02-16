<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { useToast } from 'vue-toastification';

const toast = useToast();
const vistaActual = ref('lista'); // Puede ser 'lista', 'nueva' o 'editar'
const categorias = ref([]);
const form = ref({
    id: null,
    nombre: '',
    ubicacion: '',
    estado: 'Habilitado',
    productos: 0
});

// ✅ Cargar las categorías desde el servidor
const cargarCategorias = async () => {
    try {
        const response = await axios.get('/inventario/categorias/list');
        categorias.value = response.data;
    } catch (error) {
        console.error("Error al cargar las categorías:", error);
        toast.error('❌ Error al cargar las categorías.', { timeout: 3000 });
    }
};

// ✅ Llamar la función cuando el componente se monte
onMounted(cargarCategorias);

// ✅ Función para agregar o actualizar una categoría
const guardarCategoria = async () => {
    try {
        if (form.value.id) {
            // Actualizar categoría existente
            await axios.put(`/inventario/categorias/${form.value.id}/update`, form.value);
            toast.success('✅ Categoría actualizada correctamente.', { timeout: 3000 });
        } else {
            // Agregar nueva categoría
            await axios.post('/inventario/categorias/store', form.value);
            toast.success('✅ Categoría agregada correctamente.', { timeout: 3000 });
        }

        // Recargar la lista y volver a la vista de lista
        cargarCategorias();
        vistaActual.value = 'lista';

        // Resetear el formulario
        form.value = { id: null, nombre: '', ubicacion: '', estado: 'Habilitado', productos: 0 };
    } catch (error) {
        console.error("Error al guardar la categoría:", error.response?.data);
        toast.error('❌ Error al guardar la categoría.', { timeout: 3000 });
    }
};

// ✅ Función para cargar los datos en el formulario antes de editar
const editarCategoria = (categoria) => {
    form.value = { ...categoria };
    vistaActual.value = 'editar';
};

// ✅ Función para eliminar una categoría con Swal minimalista
const eliminarCategoria = async (id) => {
    Swal.fire({
        title: "¿Eliminar Categoría?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        reverseButtons: true,
        buttonsStyling: false,
        customClass: {
            popup: 'rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800',
            title: 'text-gray-900 dark:text-white text-lg font-semibold',
            htmlContainer: 'text-gray-700 dark:text-gray-300 text-sm',
            confirmButton: 'bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium',
            cancelButton: 'bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-white px-4 py-2 rounded-lg font-medium ml-2'
        }
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                await axios.delete(`/inventario/categorias/destroy/${id}`);
                toast.success('✅ Categoría eliminada correctamente.', { timeout: 3000 });

                // Recargar lista de categorías
                cargarCategorias();
            } catch (error) {
                console.error("Error al eliminar la categoría:", error);
                toast.error('❌ Error al eliminar la categoría.', { timeout: 3000 });
            }
        }
    });
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
                    <th class="py-3 px-5 text-left">📦 Productos</th>
                    <th class="py-3 px-5 text-left">⚡ Estado</th>
                    <th class="py-3 px-5 text-center">⚙️ Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(categoria, index) in categorias" :key="categoria.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ index + 1 }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ categoria.nombre }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ categoria.ubicacion }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ categoria.productos }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">
                        <span :class="categoria.estado === 'Habilitado' ? 'bg-green-500' : 'bg-red-500'"
                              class="text-white px-3 py-1 rounded-lg text-sm">
                            {{ categoria.estado }}
                        </span>
                    </td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                        <button @click="editarCategoria(categoria)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                            ✏️ Editar
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

        <!-- FORMULARIO PARA AGREGAR / EDITAR CATEGORÍA -->
        <div v-if="vistaActual === 'nueva' || vistaActual === 'editar'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ form.id ? '✏️ Editar' : '➕ Agregar' }} Categoría</h3>
            <form @submit.prevent="guardarCategoria" class="space-y-4 bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <input v-model="form.nombre" type="text" placeholder="🏷️ Nombre de la Categoría" class="w-full p-3 border rounded-md">
                <input v-model="form.ubicacion" type="text" placeholder="📍 Ubicación" class="w-full p-3 border rounded-md">
                <input v-model="form.productos" type="number" placeholder="📦 Cantidad de Productos" class="w-full p-3 border rounded-md">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md">{{ form.id ? 'Guardar Cambios' : 'Guardar' }}</button>
            </form>
        </div>
    </div>
</template>
