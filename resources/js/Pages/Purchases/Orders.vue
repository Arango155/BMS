<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { useToast } from 'vue-toastification';

const toast = useToast();
const vistaActual = ref('lista');
const ordenes = ref([]);
const form = ref({
    id: null,
    numero_orden: '',
    proveedor: '',
    monto_total: '',
    fecha: '',
    estado: 'Pendiente'
});

// ✅ Cargar órdenes desde el servidor
const cargarOrdenes = async () => {
    try {
        const response = await axios.get('/ordenes-compra/list');
        ordenes.value = response.data;
    } catch (error) {
        toast.error('❌ Error al cargar las órdenes de compra.');
    }
};

onMounted(cargarOrdenes);

// ✅ Agregar o actualizar una orden de compra
const guardarOrden = async () => {
    try {
        if (form.value.id) {
            await axios.put(`/ordenes-compra/${form.value.id}/update`, form.value);
            toast.success('✅ Orden de compra actualizada correctamente.');
        } else {
            await axios.post('/ordenes-compra/store', form.value);
            toast.success('✅ Orden de compra agregada correctamente.');
        }
        cargarOrdenes();
        vistaActual.value = 'lista';
        form.value = { id: null, numero_orden: '', proveedor: '', monto_total: '', fecha: '', estado: 'Pendiente' };
    } catch (error) {
        toast.error('❌ Error al guardar la orden de compra.');
    }
};

// ✅ Cargar datos para editar
const editarOrden = (orden) => {
    form.value = { ...orden };
    vistaActual.value = 'editar';
};

// ✅ Mostrar formulario para nueva orden
const nuevaOrden = () => {
    form.value = { id: null, numero_orden: '', proveedor: '', monto_total: '', fecha: '', estado: 'Pendiente' };
    vistaActual.value = 'nueva';
};

// ✅ Eliminar orden
const eliminarOrden = async (id) => {
    Swal.fire({
        title: "¿Eliminar Orden de Compra?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
    }).then(async (result) => {
        if (result.isConfirmed) {
            await axios.delete(`/ordenes-compra/${id}`);
            toast.success('✅ Orden de compra eliminada correctamente.');
            cargarOrdenes();
        }
    });
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-white">📦 Gestión de Órdenes de Compra</h2>

        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'"
                    class="px-5 py-3 rounded-lg shadow-md"
                    :class="vistaActual === 'lista' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'">
                📋 Lista de Órdenes
            </button>
            <button @click="nuevaOrden"
                    class="px-5 py-3 rounded-lg shadow-md"
                    :class="vistaActual === 'nueva' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'">
                ➕ Nueva Orden
            </button>
        </div>

        <!-- LISTA DE ÓRDENES -->
        <div v-if="vistaActual === 'lista'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📋 Lista de Órdenes de Compra</h3>
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">📌 Número de Orden</th>
                    <th class="py-3 px-5 text-left">🏷️ Proveedor</th>
                    <th class="py-3 px-5 text-left">💰 Monto</th>
                    <th class="py-3 px-5 text-left">📅 Fecha</th>
                    <th class="py-3 px-5 text-left">⚡ Estado</th>
                    <th class="py-3 px-5 text-center">⚙️ Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(orden, index) in ordenes" :key="orden.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ orden.numero_orden }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ orden.proveedor }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">${{ orden.monto_total }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ orden.fecha }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">
                            <span :class="orden.estado === 'Aprobada' ? 'bg-green-500' : orden.estado === 'Pendiente' ? 'bg-yellow-500' : 'bg-red-500'"
                                  class="text-white px-3 py-1 rounded-lg text-sm">
                                {{ orden.estado }}
                            </span>
                    </td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                        <button @click="editarOrden(orden)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                            ✏️ Editar
                        </button>
                        <button @click="eliminarOrden(orden.id)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md mx-1">
                            🗑️ Eliminar
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA AGREGAR / EDITAR ORDEN -->
        <div v-if="vistaActual === 'nueva' || vistaActual === 'editar'" class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                {{ form.id ? '✏️ Editar Orden de Compra' : '➕ Nueva Orden de Compra' }}
            </h3>
            <form @submit.prevent="guardarOrden" class="space-y-4">
                <input v-model="form.numero_orden" type="text" placeholder="📌 Número de Orden" class="w-full p-3 border rounded-md">
                <input v-model="form.proveedor" type="text" placeholder="🏷️ Proveedor" class="w-full p-3 border rounded-md">
                <input v-model="form.monto_total" type="number" placeholder="💰 Monto Total" class="w-full p-3 border rounded-md">
                <input v-model="form.fecha" type="date" class="w-full p-3 border rounded-md">
                <select v-model="form.estado" class="w-full p-3 border rounded-md">
                    <option value="Pendiente">⏳ Pendiente</option>
                    <option value="Aprobada">✅ Aprobada</option>
                    <option value="Cancelada">❌ Cancelada</option>
                </select>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md">
                    {{ form.id ? 'Guardar Cambios' : 'Guardar' }}
                </button>
            </form>
        </div>
    </div>
</template>
