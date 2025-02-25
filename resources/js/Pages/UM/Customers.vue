<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { useToast } from 'vue-toastification';
import {useDarkMode} from "@/utils/theme.js";

const toast = useToast();
const vistaActual = ref('lista');
const clientes = ref([]);


const { isDarkMode, toggleDarkMode } = useDarkMode();


// ✅ Formulario de cliente
const form = ref({
    id: null,
    tipo_documento: 'DNI',
    documento: '',
    nombres: '',
    apellidos: '',
    estado_residencia: '',
    ciudad: '',
    direccion: '',
    telefono: '',
    email: ''
});

// ✅ Cargar clientes
const cargarClientes = async () => {
    try {
        const response = await axios.get('/clientes/list');
        clientes.value = response.data;
    } catch (error) {
        toast.error('❌ Error al cargar los clientes.');
    }
};

onMounted(cargarClientes);

// ✅ Guardar cliente
const guardarCliente = async () => {
    try {
        if (form.value.id) {
            await axios.put(`/clientes/${form.value.id}/update`, form.value);
            toast.success('✅ Cliente actualizado correctamente.');
        } else {
            await axios.post('/clientes/store', form.value);
            toast.success('✅ Cliente agregado correctamente.');
        }
        cargarClientes();
        vistaActual.value = 'lista';
        resetForm();
    } catch (error) {
        toast.error('❌ Error al guardar el cliente.');
    }
};

// ✅ Resetear formulario
const resetForm = () => {
    form.value = {
        id: null,
        tipo_documento: 'DNI',
        documento: '',
        nombres: '',
        apellidos: '',
        estado_residencia: '',
        ciudad: '',
        direccion: '',
        telefono: '',
        email: ''
    };
};

// ✅ Editar cliente
const editarCliente = (cliente) => {
    form.value = { ...cliente };
    vistaActual.value = 'editar';
};

// ✅ Nuevo Cliente
const nuevoCliente = () => {
    resetForm();
    vistaActual.value = 'nueva';
};

// ✅ Eliminar cliente
const eliminarCliente = async (id) => {
    Swal.fire({
        title: "¿Eliminar Cliente?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar"
    }).then(async (result) => {
        if (result.isConfirmed) {
            await axios.delete(`/clientes/${id}/delete`);
            toast.success('✅ Cliente eliminado correctamente.');
            cargarClientes();
        }
    });
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-900 rounded-xl shadow-lg text-gray-900 dark:text-white">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">👥 Gestión de Clientes</h2>
            <button @click="toggleDarkMode"
                    class="p-2 rounded-full bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                {{ isDarkMode ? '🌞' : '🌙' }}
            </button>
        </div>

        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'"
                    class="px-5 py-3 rounded-lg shadow-md transition"
                    :class="vistaActual === 'lista' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white'">
                📋 Lista de Clientes
            </button>
            <button @click="nuevoCliente"
                    class="px-5 py-3 rounded-lg shadow-md transition"
                    :class="vistaActual === 'nueva' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-white'">
                ➕ Nuevo Cliente
            </button>
        </div>

        <!-- LISTA DE CLIENTES -->
        <div v-if="vistaActual === 'lista'">
            <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">#</th>
                    <th class="py-3 px-5 text-left">📜 Documento</th>
                    <th class="py-3 px-5 text-left">👤 Nombre</th>
                    <th class="py-3 px-5 text-left">📧 Email</th>
                    <th class="py-3 px-5 text-left">📞 Teléfono</th>
                    <th class="py-3 px-5 text-center">⚙️ Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(cliente, index) in clientes" :key="cliente.id">
                    <td class="py-3 px-5 border-b">{{ index + 1 }}</td>
                    <td class="py-3 px-5 border-b">{{ cliente.documento }}</td>
                    <td class="py-3 px-5 border-b">{{ cliente.nombres }} {{ cliente.apellidos }}</td>
                    <td class="py-3 px-5 border-b">{{ cliente.email }}</td>
                    <td class="py-3 px-5 border-b">{{ cliente.telefono }}</td>
                    <td class="py-3 px-5 border-b text-center">
                        <button @click="editarCliente(cliente)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                            ✏️ Editar
                        </button>
                        <button @click="eliminarCliente(cliente.id)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md mx-1">
                            🗑️ Eliminar
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO -->
        <div v-if="vistaActual === 'nueva' || vistaActual === 'editar'" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                {{ form.id ? '✏️ Editar Cliente' : '➕ Nuevo Cliente' }}
            </h3>
            <form @submit.prevent="guardarCliente" class="space-y-4">
                <select v-model="form.tipo_documento" class="w-full p-3 border rounded-md dark:bg-gray-700 dark:text-white">
                    <option value="DNI">DNI</option>
                    <option value="RUC">RUC</option>
                    <option value="Pasaporte">Pasaporte</option>
                </select>
                <input v-model="form.documento" type="text" placeholder="📜 Número de Documento" class="w-full p-3 border rounded-md dark:bg-gray-700 dark:text-white">
                <input v-model="form.nombres" type="text" placeholder="👤 Nombres" class="w-full p-3 border rounded-md dark:bg-gray-700 dark:text-white">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md">
                    {{ form.id ? 'Guardar Cambios' : 'Guardar' }}
                </button>
            </form>
        </div>
    </div>
</template>
