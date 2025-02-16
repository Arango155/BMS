<script setup>
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

// 📌 Definir props con un valor predeterminado para evitar errores si `cotizaciones` está vacío
const props = defineProps({
    cotizaciones: {
        type: Array,
        default: () => []
    }
});

// Estado para controlar la vista actual
const vistaActual = ref('lista'); // 'lista', 'nueva', 'buscar', 'editar'

// Estado reactivo para almacenar las cotizaciones
const listaCotizaciones = ref([...props.cotizaciones]);

// Debugging: Verificar si las cotizaciones están cargando correctamente
console.log('Cotizaciones recibidas:', props.cotizaciones);
console.log('Lista de cotizaciones:', listaCotizaciones.value);

// Estado del formulario de nueva cotización
const form = useForm({
    codigo: '',
    cliente: '',
    total: 0,
    estado: 'Pendiente'
});

// Estado para la búsqueda de cotizaciones
const busqueda = ref('');
const cotizacionesFiltradas = computed(() => {
    return listaCotizaciones.value.filter(cotizacion =>
        cotizacion.codigo.toLowerCase().includes(busqueda.value.toLowerCase()) ||
        cotizacion.cliente.toLowerCase().includes(busqueda.value.toLowerCase()) ||
        cotizacion.estado.toLowerCase().includes(busqueda.value.toLowerCase())
    );
});

// Estado para manejar la edición de una cotización
const cotizacionEditando = ref(null);

// 📌 Agregar nueva cotización con Inertia.js
const agregarCotizacion = () => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Los datos serán guardados en el sistema',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.post('/inventario/cotizaciones/store', { // 📌 Ruta corregida
                onSuccess: () => {
                    form.reset();
                    Swal.fire('¡Cotización agregada!', 'La cotización se agregó con éxito', 'success');
                }
            });
        }
    });
};

// 📌 Editar cotización
const editarCotizacion = (cotizacion) => {
    cotizacionEditando.value = { ...cotizacion }; // Clonar objeto
    vistaActual.value = 'editar';
};

// 📌 Guardar cambios en una cotización editada
const guardarEdicion = () => {
    router.put(`/inventario/cotizaciones/update/${cotizacionEditando.value.id}`, cotizacionEditando.value, {
        onSuccess: () => {
            Swal.fire('¡Actualizado!', 'La cotización ha sido modificada con éxito', 'success');
            vistaActual.value = 'lista';
            cotizacionEditando.value = null;
        }
    });
};

// 📌 Eliminar cotización
const eliminarCotizacion = (id) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/inventario/cotizaciones/destroy/${id}`, {
                onSuccess: () => {
                    listaCotizaciones.value = listaCotizaciones.value.filter(cotizacion => cotizacion.id !== id);
                    Swal.fire('¡Eliminado!', 'La cotización ha sido eliminada.', 'success');
                }
            });
        }
    });
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-6">📄 Gestión de Cotizaciones</h2>

        <!-- Botones de navegación -->
        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'" class="px-6 py-3 rounded-lg shadow-md bg-blue-600 text-white hover:bg-blue-700 transition duration-300">
                📋 Lista de Cotizaciones
            </button>
            <button @click="vistaActual = 'nueva'" class="px-6 py-3 rounded-lg shadow-md bg-green-600 text-white hover:bg-green-700 transition duration-300">
                ➕ Nueva Cotización
            </button>
            <button @click="vistaActual = 'buscar'" class="px-6 py-3 rounded-lg shadow-md bg-yellow-600 text-white hover:bg-yellow-700 transition duration-300">
                🔍 Buscar Cotización
            </button>
        </div>

        <!-- LISTA DE COTIZACIONES -->
        <div v-if="vistaActual === 'lista'">
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md">
                <thead>
                <tr class="bg-gray-300 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="px-4 py-2">Código</th>
                    <th class="px-4 py-2">Cliente</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="cotizacion in cotizacionesFiltradas" :key="cotizacion.id">
                    <td class="px-4 py-2">{{ cotizacion.codigo }}</td>
                    <td class="px-4 py-2">{{ cotizacion.cliente }}</td>
                    <td class="px-4 py-2">${{ cotizacion.total }}</td>
                    <td class="px-4 py-2">{{ cotizacion.estado }}</td>
                    <td class="px-4 py-2">
                        <button @click="editarCotizacion(cotizacion)" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition">✏️ Editar</button>
                        <button @click="eliminarCotizacion(cotizacion.id)" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">🗑️ Eliminar</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA NUEVA COTIZACIÓN -->
        <div v-if="vistaActual === 'nueva'">
            <form @submit.prevent="agregarCotizacion" class="space-y-4">
                <input v-model="form.codigo" type="text" placeholder="Código" class="w-full p-3 border rounded-md">
                <input v-model="form.cliente" type="text" placeholder="Cliente" class="w-full p-3 border rounded-md">
                <input v-model="form.total" type="number" placeholder="Total" class="w-full p-3 border rounded-md">
                <select v-model="form.estado" class="w-full p-3 border rounded-md">
                    <option value="Pendiente">Pendiente</option>
                    <option value="Aprobada">Aprobada</option>
                    <option value="Rechazada">Rechazada</option>
                </select>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Guardar</button>
            </form>
        </div>
    </div>
</template>
