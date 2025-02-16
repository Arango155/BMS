<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { useToast } from 'vue-toastification';

const toast = useToast();
const vistaActual = ref('lista'); // Puede ser 'lista', 'nueva' o 'editar'
const compras = ref([]);
const form = ref({
    id: null,
    proveedor: '',
    monto: '',
    fecha: '',
    estado: 'Pendiente'
});

// ✅ Cargar las compras desde el servidor
const cargarCompras = async () => {
    try {
        const response = await axios.get('/inventario/compras/list');
        compras.value = response.data;
    } catch (error) {
        console.error("Error al cargar las compras:", error);
        toast.error('❌ Error al cargar las compras.', { timeout: 3000 });
    }
};

// ✅ Llamar la función cuando el componente se monte
onMounted(cargarCompras);

// ✅ Función para agregar o actualizar una compra
const guardarCompra = async () => {
    try {
        if (form.value.id) {
            await axios.put(`/inventario/compras/${form.value.id}/update`, form.value);
            toast.success('✅ Compra actualizada correctamente.', { timeout: 3000 });
        } else {
            await axios.post('/inventario/compras/store', form.value);
            toast.success('✅ Compra agregada correctamente.', { timeout: 3000 });
        }

        // Recargar la lista y volver a la vista de lista
        cargarCompras();
        vistaActual.value = 'lista';

        // Resetear el formulario
        form.value = { id: null, proveedor: '', monto: '', fecha: '', estado: 'Pendiente' };
    } catch (error) {
        console.error("Error al guardar la compra:", error.response?.data);
        toast.error('❌ Error al guardar la compra.', { timeout: 3000 });
    }
};

// ✅ Función para cargar los datos en el formulario antes de editar
const editarCompra = (compra) => {
    form.value = { ...compra };
    vistaActual.value = 'editar';
};

// ✅ Función para cambiar a la vista de nueva compra
const nuevaCompra = () => {
    form.value = { id: null, proveedor: '', monto: '', fecha: '', estado: 'Pendiente' };
    vistaActual.value = 'nueva';
};

// ✅ Función para eliminar una compra con Swal minimalista
const eliminarCompra = async (id) => {
    Swal.fire({
        title: "¿Eliminar Compra?",
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
                await axios.delete(`/inventario/compras/destroy/${id}`);
                toast.success('✅ Compra eliminada correctamente.', { timeout: 3000 });
                cargarCompras();
            } catch (error) {
                console.error("Error al eliminar la compra:", error);
                toast.error('❌ Error al eliminar la compra.', { timeout: 3000 });
            }
        }
    });
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">📦 Gestión de Compras</h2>

        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'" class="px-5 py-3 rounded-lg shadow-md" :class="vistaActual === 'lista' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'">
                📋 Lista de Compras
            </button>
            <button @click="nuevaCompra" class="px-5 py-3 rounded-lg shadow-md" :class="vistaActual === 'nueva' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'">
                ➕ Nueva Compra
            </button>
        </div>

        <div v-if="vistaActual === 'lista'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📋 Lista de Compras</h3>
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">Proveedor</th>
                    <th class="py-3 px-5 text-left">Monto</th>
                    <th class="py-3 px-5 text-left">Fecha</th>
                    <th class="py-3 px-5 text-left">Estado</th>
                    <th class="py-3 px-5 text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="compra in compras" :key="compra.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5">{{ compra.proveedor }}</td>
                    <td class="py-3 px-5">${{ compra.monto }}</td>
                    <td class="py-3 px-5">{{ compra.fecha }}</td>
                    <td class="py-3 px-5">{{ compra.estado }}</td>
                    <td class="py-3 px-5 text-center">
                        <button @click="editarCompra(compra)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">✏️ Editar</button>
                        <button @click="eliminarCompra(compra.id)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md mx-1">🗑️ Eliminar</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA AGREGAR / EDITAR COMPRA -->
        <div v-if="vistaActual === 'nueva' || vistaActual === 'editar'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                {{ form.id ? '✏️ Editar' : '➕ Agregar' }} Compra
            </h3>
            <form @submit.prevent="guardarCompra" class="space-y-4 bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <input v-model="form.proveedor" type="text" placeholder="🏷️ Proveedor" class="w-full p-3 border rounded-md">
                <input v-model="form.monto" type="number" placeholder="💰 Monto" class="w-full p-3 border rounded-md">
                <input v-model="form.fecha" type="date" class="w-full p-3 border rounded-md">
                <select v-model="form.estado" class="w-full p-3 border rounded-md">
                    <option value="Pendiente">⏳ Pendiente</option>
                    <option value="Completado">✅ Completado</option>
                    <option value="Cancelado">❌ Cancelado</option>
                </select>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md">
                    {{ form.id ? 'Guardar Cambios' : 'Guardar' }}
                </button>
            </form>
        </div>

    </div>
</template>
