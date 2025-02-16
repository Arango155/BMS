<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { useToast } from 'vue-toastification';

const toast = useToast();
const vistaActual = ref('lista');
const proveedores = ref([]);
const form = ref({
    id: null,
    nombre: '',
    contacto: '',
    telefono: '',
    email: '',
    direccion: ''
});

// ✅ Cargar proveedores desde el servidor
const cargarProveedores = async () => {
    try {
        const response = await axios.get('/proveedores/list');
        proveedores.value = response.data;
    } catch (error) {
        toast.error('❌ Error al cargar los proveedores.');
    }
};

onMounted(cargarProveedores);

// ✅ Agregar o actualizar un proveedor
const guardarProveedor = async () => {
    try {
        let response;
        if (form.value.id) {
            response = await axios.put(`/proveedores/${form.value.id}/update`, form.value);
            toast.success('✅ Proveedor actualizado correctamente.');
        } else {
            response = await axios.post('/proveedores/store', form.value);
            toast.success('✅ Proveedor agregado correctamente.');
        }
        cargarProveedores();
        vistaActual.value = 'lista';
        form.value = { id: null, nombre: '', contacto: '', telefono: '', email: '', direccion: '' };
    } catch (error) {
        console.error('❌ Error al guardar el proveedor:', error.response?.data);
        if (error.response && error.response.status === 422) {
            const errores = error.response.data.errors;
            Object.keys(errores).forEach((campo) => {
                toast.error(`❌ ${errores[campo][0]}`);
            });
        } else {
            toast.error('❌ Error al guardar el proveedor.');
        }
    }
};


// ✅ Cargar datos para editar
const editarProveedor = (proveedor) => {
    form.value = { ...proveedor };
    vistaActual.value = 'editar';
};

// ✅ Mostrar formulario para nuevo proveedor
const nuevoProveedor = () => {
    form.value = { id: null, nombre: '', contacto: '', telefono: '', email: '', direccion: '' };
    vistaActual.value = 'nueva';
};

// ✅ Eliminar proveedor
const eliminarProveedor = async (id) => {
    Swal.fire({
        title: "¿Eliminar Proveedor?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
    }).then(async (result) => {
        if (result.isConfirmed) {
            await axios.delete(`/proveedores/${id}`);
            toast.success('✅ Proveedor eliminado correctamente.');
            cargarProveedores();
        }
    });
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-white">🏢 Gestión de Proveedores</h2>

        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'"
                    class="px-5 py-3 rounded-lg shadow-md"
                    :class="vistaActual === 'lista' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'">
                📋 Lista de Proveedores
            </button>
            <button @click="nuevoProveedor"
                    class="px-5 py-3 rounded-lg shadow-md"
                    :class="vistaActual === 'nueva' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'">
                ➕ Nuevo Proveedor
            </button>
        </div>

        <!-- LISTA DE PROVEEDORES -->
        <div v-if="vistaActual === 'lista'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📋 Lista de Proveedores</h3>
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">📌 Nombre</th>
                    <th class="py-3 px-5 text-left">📞 Contacto</th>
                    <th class="py-3 px-5 text-left">📞 Telefono</th>

                    <th class="py-3 px-5 text-left">📧 Email</th>
                    <th class="py-3 px-5 text-left">📍 Dirección</th>
                    <th class="py-3 px-5 text-center">⚙️ Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(proveedor, index) in proveedores" :key="proveedor.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ proveedor.nombre }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ proveedor.contacto }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ proveedor.telefono }}</td>

                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ proveedor.email }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ proveedor.direccion }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                        <button @click="editarProveedor(proveedor)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                            ✏️ Editar
                        </button>
                        <button @click="eliminarProveedor(proveedor.id)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md mx-1">
                            🗑️ Eliminar
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA AGREGAR / EDITAR PROVEEDOR -->
        <div v-if="vistaActual === 'nueva' || vistaActual === 'editar'" class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                {{ form.id ? '✏️ Editar Proveedor' : '➕ Nuevo Proveedor' }}
            </h3>
            <form @submit.prevent="guardarProveedor" class="space-y-4">
                <input v-model="form.nombre" type="text" placeholder="🏢 Nombre del Proveedor" class="w-full p-3 border rounded-md">
                <input v-model="form.contacto" type="text" placeholder="📞 Contacto" class="w-full p-3 border rounded-md">
                <input v-model="form.telefono" type="tel" placeholder="📱 Teléfono" class="w-full p-3 border rounded-md">
                <input v-model="form.email" type="email" placeholder="📧 Email" class="w-full p-3 border rounded-md">
                <textarea v-model="form.direccion" placeholder="📍 Dirección" class="w-full p-3 border rounded-md"></textarea>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md">
                    {{ form.id ? 'Guardar Cambios' : 'Guardar' }}
                </button>
            </form>
        </div>
    </div>
</template>
