<script setup>
import { ref, computed } from 'vue';

// Estado para controlar qué sección se muestra
const vistaActual = ref('lista'); // 'lista', 'nueva', 'buscar'

// Estado de la lista de usuarios
const usuarios = ref([
    { id: 1, documento: '12345678', cargo: 'Administrador', nombre: 'Juan Pérez', usuario: 'jperez', telefono: '555-1234' },
    { id: 2, documento: '87654321', cargo: 'Empleado', nombre: 'Ana Gómez', usuario: 'agomez', telefono: '555-5678' }
]);

// Estado del formulario de nuevo usuario
const nuevoUsuario = ref({
    tipo_documento: 'DNI',
    documento: '',
    cargo: '',
    nombres: '',
    apellidos: '',
    telefono: ''
});

// Estado para la búsqueda de usuarios
const busqueda = ref('');
const usuarioEncontrado = computed(() => {
    return usuarios.value.find(usuario => usuario.documento.includes(busqueda.value) || usuario.nombre.toLowerCase().includes(busqueda.value.toLowerCase()));
});

// Estado para manejar la edición de un usuario
const usuarioEditando = ref(null);

// Función para seleccionar un usuario y editarlo
const editarUsuario = (usuario) => {
    usuarioEditando.value = { ...usuario };
    vistaActual.value = 'editar';
};

// Función para guardar los cambios en el usuario editado
const guardarEdicion = () => {
    const index = usuarios.value.findIndex(u => u.id === usuarioEditando.value.id);
    if (index !== -1) {
        usuarios.value[index] = { ...usuarioEditando.value };
    }
    usuarioEditando.value = null;
    vistaActual.value = 'lista';
};

// Función para eliminar un usuario
const eliminarUsuario = (id) => {
    usuarios.value = usuarios.value.filter(usuario => usuario.id !== id);
};

// Función para agregar un nuevo usuario
const agregarUsuario = () => {
    usuarios.value.push({ id: usuarios.value.length + 1, ...nuevoUsuario.value });
    nuevoUsuario.value = { tipo_documento: 'DNI', documento: '', cargo: '', nombres: '', apellidos: '', telefono: '' };
    vistaActual.value = 'lista';
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">👤 Gestión de Usuarios</h2>

        <!-- Botones de navegación -->
        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'"
                    :class="vistaActual === 'lista' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                📋 Lista de Usuarios
            </button>
            <button @click="vistaActual = 'nueva'"
                    :class="vistaActual === 'nueva' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                ➕ Nuevo Usuario
            </button>
            <button @click="vistaActual = 'buscar'"
                    :class="vistaActual === 'buscar' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                🔍 Buscar Usuario
            </button>
        </div>

        <!-- LISTA DE USUARIOS -->
        <div v-if="vistaActual === 'lista'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📋 Lista de Usuarios</h3>
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">#</th>
                    <th class="py-3 px-5 text-left">📜 Documento</th>
                    <th class="py-3 px-5 text-left">🏢 Cargo</th>
                    <th class="py-3 px-5 text-left">👤 Nombre</th>
                    <th class="py-3 px-5 text-left">🆔 Usuario</th>
                    <th class="py-3 px-5 text-left">📞 Teléfono</th>
                    <th class="py-3 px-5 text-center">⚙️ Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="usuario in usuarios" :key="usuario.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ usuario.id }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ usuario.documento }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ usuario.cargo }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ usuario.nombre }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ usuario.usuario }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ usuario.telefono }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                        <button @click="editarUsuario(usuario)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                            ✏️ Actualizar
                        </button>
                        <button @click="eliminarUsuario(usuario.id)"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md mx-1">
                            🗑️ Eliminar
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA NUEVO USUARIO -->
        <div v-if="vistaActual === 'nueva'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">➕ Agregar Nuevo Usuario</h3>
            <form @submit.prevent="agregarUsuario" class="space-y-4 bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <select v-model="nuevoUsuario.tipo_documento"
                        class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                    <option value="DNI">DNI</option>
                    <option value="Pasaporte">Pasaporte</option>
                </select>
                <input v-model="nuevoUsuario.documento" type="text" placeholder="📜 Número de Documento"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevoUsuario.cargo" type="text" placeholder="🏢 Cargo"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevoUsuario.nombres" type="text" placeholder="👤 Nombres"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevoUsuario.apellidos" type="text" placeholder="👤 Apellidos"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="nuevoUsuario.telefono" type="text" placeholder="📞 Teléfono"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Guardar Usuario
                </button>
            </form>
        </div>
    </div>
</template>
