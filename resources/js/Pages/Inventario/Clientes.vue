<script setup>
import { ref, computed } from 'vue';

// Estado para controlar qué sección se muestra
const vistaActual = ref('lista'); // 'lista', 'nueva', 'buscar'

// Estado de la lista de clientes
const clientes = ref([
    { id: 1, documento: '12345678', nombre: 'Juan Pérez', estado: 'Activo', ciudad: 'Ciudad A', telefono: '555-1234' },
    { id: 2, documento: '87654321', nombre: 'Ana Gómez', estado: 'Inactivo', ciudad: 'Ciudad B', telefono: '555-5678' }
]);

// Estado del formulario de nuevo cliente
const nuevoCliente = ref({
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

// Estado para la búsqueda de clientes
const busqueda = ref('');
const clienteEncontrado = computed(() => {
    return clientes.value.find(cliente => cliente.documento.includes(busqueda.value) || cliente.nombre.toLowerCase().includes(busqueda.value.toLowerCase()));
});

// Estado para manejar la edición de un cliente
const clienteEditando = ref(null);

// Función para seleccionar un cliente y editarlo
const editarCliente = (cliente) => {
    clienteEditando.value = { ...cliente };
    vistaActual.value = 'editar';
};

// Función para guardar los cambios en el cliente editado
const guardarEdicion = () => {
    const index = clientes.value.findIndex(c => c.id === clienteEditando.value.id);
    if (index !== -1) {
        clientes.value[index] = { ...clienteEditando.value };
    }
    clienteEditando.value = null;
    vistaActual.value = 'lista';
};

// Función para eliminar un cliente
const eliminarCliente = (id) => {
    clientes.value = clientes.value.filter(cliente => cliente.id !== id);
};

// Función para agregar un nuevo cliente
const agregarCliente = () => {
    clientes.value.push({ id: clientes.value.length + 1, ...nuevoCliente.value });
    nuevoCliente.value = {
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
    vistaActual.value = 'lista';
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">👥 Gestión de Clientes</h2>

        <!-- Botones de navegación -->
        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'"
                    :class="vistaActual === 'lista' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                📋 Lista de Clientes
            </button>
            <button @click="vistaActual = 'nueva'"
                    :class="vistaActual === 'nueva' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                ➕ Nuevo Cliente
            </button>
            <button @click="vistaActual = 'buscar'"
                    :class="vistaActual === 'buscar' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                🔍 Buscar Cliente
            </button>
        </div>

        <!-- LISTA DE CLIENTES -->
        <div v-if="vistaActual === 'lista'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📋 Lista de Clientes</h3>
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">#</th>
                    <th class="py-3 px-5 text-left">📜 Documento</th>
                    <th class="py-3 px-5 text-left">👤 Nombre</th>
                    <th class="py-3 px-5 text-left">📍 Estado</th>
                    <th class="py-3 px-5 text-left">🏙️ Ciudad</th>
                    <th class="py-3 px-5 text-left">📞 Teléfono</th>
                    <th class="py-3 px-5 text-center">⚙️ Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="cliente in clientes" :key="cliente.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ cliente.id }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ cliente.documento }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ cliente.nombre }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ cliente.estado }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ cliente.ciudad }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ cliente.telefono }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                        <button @click="editarCliente(cliente)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                            ✏️ Actualizar
                        </button>
                        <button @click="eliminarCliente(cliente.id)"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md mx-1">
                            🗑️ Eliminar
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA NUEVO CLIENTE -->
        <div v-if="vistaActual === 'nueva'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">➕ Agregar Nuevo Cliente</h3>
            <form @submit.prevent="agregarCliente" class="space-y-4 bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <input v-model="nuevoCliente.documento" type="text" placeholder="📜 Número de Documento"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevoCliente.nombres" type="text" placeholder="👤 Nombres"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevoCliente.apellidos" type="text" placeholder="👤 Apellidos"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevoCliente.telefono" type="text" placeholder="📞 Teléfono"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Guardar Cliente
                </button>
            </form>
        </div>
    </div>
</template>
