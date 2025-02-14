<script setup>
import { ref, computed } from 'vue';

// Estado para controlar qué sección se muestra
const vistaActual = ref('lista'); // 'lista', 'nueva', 'buscar'

// Estado de la lista de proveedores
const proveedores = ref([
    { id: 1, documento: '12345678', nombre: 'Proveedor A', telefono: '555-1234', email: 'proveedorA@email.com', estado: 'Habilitado' },
    { id: 2, documento: '87654321', nombre: 'Proveedor B', telefono: '555-5678', email: 'proveedorB@email.com', estado: 'No Habilitado' }
]);

// Estado del formulario de nuevo proveedor
const nuevoProveedor = ref({
    documento: '',
    nombre: '',
    direccion: '',
    estado: 'Habilitado',
    encargado: '',
    telefono: '',
    email: ''
});

// Estado para la búsqueda de proveedores
const busqueda = ref('');
const proveedorEncontrado = computed(() => {
    return proveedores.value.find(proveedor => proveedor.documento === busqueda.value);
});

// Estado para manejar la edición de un proveedor
const proveedorEditando = ref(null);

// Función para seleccionar un proveedor y editarlo
const editarProveedor = (proveedor) => {
    proveedorEditando.value = { ...proveedor };
    vistaActual.value = 'editar';
};

// Función para guardar los cambios en el proveedor editado
const guardarEdicion = () => {
    const index = proveedores.value.findIndex(p => p.id === proveedorEditando.value.id);
    if (index !== -1) {
        proveedores.value[index] = { ...proveedorEditando.value };
    }
    proveedorEditando.value = null;
    vistaActual.value = 'lista';
};

// Función para eliminar un proveedor
const eliminarProveedor = (id) => {
    proveedores.value = proveedores.value.filter(proveedor => proveedor.id !== id);
};

// Función para agregar un nuevo proveedor
const agregarProveedor = () => {
    proveedores.value.push({ id: proveedores.value.length + 1, ...nuevoProveedor.value });
    nuevoProveedor.value = { documento: '', nombre: '', direccion: '', estado: 'Habilitado', encargado: '', telefono: '', email: '' };
    vistaActual.value = 'lista';
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">🏢 Gestión de Proveedores</h2>

        <!-- Botones de navegación -->
        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'"
                    :class="vistaActual === 'lista' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                📋 Lista de Proveedores
            </button>
            <button @click="vistaActual = 'nueva'"
                    :class="vistaActual === 'nueva' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                ➕ Nuevo Proveedor
            </button>
            <button @click="vistaActual = 'buscar'"
                    :class="vistaActual === 'buscar' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                🔍 Buscar Proveedor
            </button>
        </div>

        <!-- LISTA DE PROVEEDORES -->
        <div v-if="vistaActual === 'lista'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📋 Lista de Proveedores</h3>
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">#</th>
                    <th class="py-3 px-5 text-left">📜 Documento</th>
                    <th class="py-3 px-5 text-left">🏢 Nombre</th>
                    <th class="py-3 px-5 text-left">📞 Teléfono</th>
                    <th class="py-3 px-5 text-left">✉️ Email</th>
                    <th class="py-3 px-5 text-left">📍 Estado</th>
                    <th class="py-3 px-5 text-center">⚙️ Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="proveedor in proveedores" :key="proveedor.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ proveedor.id }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ proveedor.documento }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ proveedor.nombre }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ proveedor.telefono }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ proveedor.email }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">
                            <span :class="proveedor.estado === 'Habilitado' ? 'bg-green-500' : 'bg-red-500'"
                                  class="text-white px-3 py-1 rounded-lg text-sm">
                                {{ proveedor.estado }}
                            </span>
                    </td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                        <button @click="editarProveedor(proveedor)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                            ✏️ Actualizar
                        </button>
                        <button @click="eliminarProveedor(proveedor.id)"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md mx-1">
                            🗑️ Eliminar
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA NUEVO PROVEEDOR -->
        <div v-if="vistaActual === 'nueva'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">➕ Agregar Nuevo Proveedor</h3>
            <form @submit.prevent="agregarProveedor" class="space-y-4 bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <input v-model="nuevoProveedor.documento" type="text" placeholder="📜 Número de Documentación"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevoProveedor.nombre" type="text" placeholder="🏢 Nombre"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevoProveedor.direccion" type="text" placeholder="📍 Dirección"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevoProveedor.telefono" type="text" placeholder="📞 Teléfono"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Guardar Proveedor
                </button>
            </form>
        </div>
    </div>
</template>
