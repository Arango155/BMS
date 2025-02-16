<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { useToast } from 'vue-toastification';

const toast = useToast();
const vistaActual = ref('lista'); // Puede ser 'lista', 'nueva' o 'editar'
const cajas = ref([]);
const form = ref({
    id: null,
    numero: '',
    nombre: '',
    efectivo: '',
    estado: 'Habilitada'
});

// ✅ Cargar las cajas desde el servidor
const cargarCajas = async () => {
    try {
        const response = await axios.get('/inventario/caja/list');
        cajas.value = response.data;
    } catch (error) {
        console.error("Error al cargar las cajas:", error);
        toast.error('❌ Error al cargar las cajas.', { timeout: 3000 });
    }
};

// ✅ Llamar la función cuando el componente se monte
onMounted(cargarCajas);

// ✅ Función para agregar o actualizar una caja
const guardarCaja = async () => {
    try {
        if (form.value.id) {
            // Actualizar caja existente
            await axios.put(`/inventario/caja/${form.value.id}/update`, form.value);
            toast.success('✅ Caja actualizada correctamente.', { timeout: 3000 });
        } else {
            // Agregar nueva caja
            await axios.post('/inventario/caja/store', form.value);
            toast.success('✅ Caja agregada correctamente.', { timeout: 3000 });
        }

        // Recargar la lista y volver a la vista de lista
        cargarCajas();
        vistaActual.value = 'lista';

        // Resetear el formulario
        form.value = { id: null, numero: '', nombre: '', efectivo: '', estado: 'Habilitada' };
    } catch (error) {
        console.error("Error al guardar la caja:", error.response?.data);
        toast.error('❌ Error al guardar la caja.', { timeout: 3000 });
    }
};

// ✅ Función para cargar los datos en el formulario antes de editar
const editarCaja = (caja) => {
    form.value = { ...caja };
    vistaActual.value = 'editar';
};

// ✅ Función para eliminar una caja con Swal minimalista
const eliminarCaja = async (id) => {
    Swal.fire({
        title: "¿Eliminar Caja?",
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
                await axios.delete(`/inventario/caja/destroy/${id}`);
                toast.success('✅ Caja eliminada correctamente.', { timeout: 3000 });

                // Recargar lista de cajas
                cargarCajas();
            } catch (error) {
                console.error("Error al eliminar la caja:", error);
                toast.error('❌ Error al eliminar la caja.', { timeout: 3000 });
            }
        }
    });
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">📦 Gestión de Cajas</h2>

        <!-- Botones de navegación -->
        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'"
                    :class="vistaActual === 'lista' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                📋 Lista de Cajas
            </button>
            <button @click="vistaActual = 'nueva'"
                    :class="vistaActual === 'nueva' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                ➕ Nueva Caja
            </button>
        </div>

        <!-- LISTA DE CAJAS -->
        <div v-if="vistaActual === 'lista'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📋 Lista de Cajas</h3>
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">#</th>
                    <th class="py-3 px-5 text-left">🏷️ Número</th>
                    <th class="py-3 px-5 text-left">📛 Nombre</th>
                    <th class="py-3 px-5 text-left">💰 Efectivo</th>
                    <th class="py-3 px-5 text-left">⚡ Estado</th>
                    <th class="py-3 px-5 text-center">⚙️ Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(caja, index) in cajas" :key="caja.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ index + 1 }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ caja.numero }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ caja.nombre }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">${{ caja.efectivo }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">
                        <span :class="caja.estado === 'Habilitada' ? 'bg-green-500' : 'bg-red-500'"
                              class="text-white px-3 py-1 rounded-lg text-sm">
                            {{ caja.estado }}
                        </span>
                    </td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                        <button @click="editarCaja(caja)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                            ✏️ Editar
                        </button>
                        <button @click="eliminarCaja(caja.id)"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md mx-1">
                            🗑️ Eliminar
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA AGREGAR / EDITAR CAJA -->
        <div v-if="vistaActual === 'nueva' || vistaActual === 'editar'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ form.id ? '✏️ Editar' : '➕ Agregar' }} Caja</h3>
            <form @submit.prevent="guardarCaja" class="space-y-4 bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <input v-model="form.numero" type="text" placeholder="🏷️ Número de Caja" class="w-full p-3 border rounded-md">
                <input v-model="form.nombre" type="text" placeholder="📛 Nombre" class="w-full p-3 border rounded-md">
                <input v-model="form.efectivo" type="number" placeholder="💰 Efectivo" class="w-full p-3 border rounded-md">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md">{{ form.id ? 'Guardar Cambios' : 'Guardar' }}</button>
            </form>
        </div>
    </div>
</template>
