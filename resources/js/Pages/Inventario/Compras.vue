<script setup>
import { ref, computed } from 'vue';

// Estado para controlar qué sección se muestra
const vistaActual = ref('lista'); // 'lista', 'nueva', 'buscar', 'editar'

// Estado de la lista de cajas
const cajas = ref([
    { id: 1, numero: '001', nombre: 'Caja Principal', efectivo: 1500, estado: 'Activa' },
    { id: 2, numero: '002', nombre: 'Caja Secundaria', efectivo: 800, estado: 'Inactiva' }
]);

// Estado del formulario de nueva caja
const nuevaCaja = ref({ numero: '', nombre: '', efectivo: '', estado: 'Activa' });

// Estado para la búsqueda de cajas
const busqueda = ref('');
const cajaEncontrada = computed(() => {
    return cajas.value.find(caja => caja.numero === busqueda.value);
});

// Estado para manejar la edición de una caja
const cajaEditando = ref(null);

// Función para seleccionar una caja y editarla
const editarCaja = (caja) => {
    cajaEditando.value = { ...caja }; // Copiar valores de la caja seleccionada
    vistaActual.value = 'editar';
};

// Función para guardar los cambios en la caja editada
const guardarEdicion = () => {
    const index = cajas.value.findIndex(c => c.id === cajaEditando.value.id);
    if (index !== -1) {
        cajas.value[index] = { ...cajaEditando.value }; // Actualizar datos en la lista
    }
    cajaEditando.value = null;
    vistaActual.value = 'lista';
};

// Función para eliminar una caja
const eliminarCaja = (id) => {
    cajas.value = cajas.value.filter(caja => caja.id !== id);
};

// Agregar nueva caja
const agregarCaja = () => {
    cajas.value.push({ id: cajas.value.length + 1, ...nuevaCaja.value });
    nuevaCaja.value = { numero: '', nombre: '', efectivo: '', estado: 'Activa' };
    vistaActual.value = 'lista';
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">️ Gestión de Cajas</h2>

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
            <button @click="vistaActual = 'buscar'"
                    :class="vistaActual === 'buscar' ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white'"
                    class="px-5 py-3 rounded-lg shadow-md hover:scale-105 transition-transform">
                🔍 Buscar Caja
            </button>
        </div>

        <!-- LISTA DE CAJAS -->
        <div v-if="vistaActual === 'lista'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">📋 Lista de Cajas</h3>
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">📌 Número de Caja</th>
                    <th class="py-3 px-5 text-left">🏷️ Nombre / Código</th>
                    <th class="py-3 px-5 text-left">💵 Efectivo Disponible</th>
                    <th class="py-3 px-5 text-left">📍 Estado de la Caja</th>
                    <th class="py-3 px-5 text-center">⚙️ Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="caja in cajas" :key="caja.id" class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ caja.numero }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ caja.nombre }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-green-500 font-bold">${{ caja.efectivo }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">
                            <span :class="caja.estado === 'Activa' ? 'bg-green-500' : 'bg-red-500'"
                                  class="text-white px-3 py-1 rounded-lg text-sm">
                                {{ caja.estado }}
                            </span>
                    </td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                        <button @click="editarCaja(caja)" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md mx-1">
                            ✏️ Actualizar
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

        <!-- FORMULARIO PARA EDITAR UNA CAJA -->
        <div v-if="vistaActual === 'editar'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">✏️ Editar Caja</h3>
            <form @submit.prevent="guardarEdicion" class="space-y-4 bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
                <input v-model="cajaEditando.numero" type="text" placeholder="📌 Número de Caja"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="cajaEditando.nombre" type="text" placeholder="🏷️ Nombre / Código de Caja"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <input v-model="cajaEditando.efectivo" type="number" placeholder="💵 Efectivo en Caja"
                       class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                <select v-model="cajaEditando.estado"
                        class="p-3 border rounded-lg w-full bg-gray-100 dark:bg-gray-800 dark:text-white">
                    <option value="Activa">✅ Activa</option>
                    <option value="Inactiva">❌ Inactiva</option>
                </select>
                <button type="submit" class="mt-4 w-full bg-yellow-500 text-white py-3 rounded-lg font-semibold hover:bg-yellow-600 transition">
                    Guardar Cambios
                </button>
            </form>
        </div>
    </div>
</template>
