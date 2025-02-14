<script setup>
import { ref, computed, onMounted } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { FolderOpen, Trash, Edit } from 'lucide-vue-next';
import Swal from 'sweetalert2';

const props = defineProps({
    cajas: Array,
});

const vistaActual = ref('lista');
const form = useForm({
    numero: '',
    nombre: '',
    efectivo: '',
    estado: 'Habilitada',
});
const busqueda = ref('');
const cajaLista = ref([...props.cajas]);

const cajaEncontrada = computed(() => {
    return cajaLista.value.filter(caja =>
        caja.numero.toLowerCase().includes(busqueda.value.toLowerCase()) ||
        caja.nombre.toLowerCase().includes(busqueda.value.toLowerCase()) ||
        caja.efectivo.toString().includes(busqueda.value) ||
        caja.estado.toLowerCase().includes(busqueda.value.toLowerCase())
    );
});

onMounted(() => {
    router.reload({ only: ['cajas'] });
});

const agregarCaja = () => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Los datos serán guardados en el sistema',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.post(route('inventario.Caja.store'), {
                onSuccess: () => {
                    form.reset();
                    Swal.fire('¡Caja agregada!', 'La caja se agregó con éxito', 'success');
                }
            });
        }
    });
};

const eliminarCaja = (id) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('inventario.Caja.destroy', id), {
                onSuccess: () => {
                    cajaLista.value = cajaLista.value.filter(caja => caja.id !== id);
                    Swal.fire('¡Caja eliminada!', 'Se eliminó con éxito', 'success');
                }
            });
        }
    });
};

const editarCaja = (caja) => {
    router.visit(route('inventario.Caja.edit', caja.id));
};
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-6">📋 Lista de Cajas</h2>

        <p class="text-center text-gray-700 dark:text-gray-300 mb-6 max-w-3xl mx-auto">
            En el módulo CAJA podrá registrar y gestionar las cajas de ventas del sistema. Además, podrá actualizar los datos de las cajas, realizar búsquedas y eliminarlas si lo desea.
        </p>

        <!-- Botones de Navegación -->
        <div class="flex justify-center gap-4 mb-8">
            <button @click="vistaActual = 'lista'" class="px-6 py-3 rounded-lg shadow-md bg-blue-600 text-white hover:bg-blue-700 transition duration-300">Lista de Cajas</button>
            <button @click="vistaActual = 'nueva'" class="px-6 py-3 rounded-lg shadow-md bg-green-600 text-white hover:bg-green-700 transition duration-300">Nueva Caja</button>
            <button @click="vistaActual = 'buscar'" class="px-6 py-3 rounded-lg shadow-md bg-yellow-600 text-white hover:bg-yellow-700 transition duration-300">Buscar Caja</button>
        </div>

        <!-- FORMULARIO PARA AGREGAR CAJA -->
        <div v-if="vistaActual === 'nueva'">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">➕ Información de la Caja</h3>
            <form @submit.prevent="agregarCaja" class="space-y-4">
                <input v-model="form.numero" type="text" placeholder="Número de Caja" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-500 mb-3">
                <input v-model="form.nombre" type="text" placeholder="Nombre/Código de Caja" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-500 mb-3">
                <input v-model="form.efectivo" type="number" placeholder="Efectivo en Caja" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-500 mb-3">
                <select v-model="form.estado" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-500 mb-3">
                    <option value="Habilitada">Habilitada</option>
                    <option value="Deshabilitada">Deshabilitada</option>
                </select>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">Guardar</button>
            </form>
        </div>

        <!-- BUSCAR CAJA -->
        <div v-if="vistaActual === 'buscar'">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">🔎 Buscar Caja</h3>
            <input v-model="busqueda" type="text" placeholder="Buscar por Número, Nombre, Efectivo o Estado"
                   class="w-full p-3 border rounded-md focus:ring-2 focus:ring-blue-500 mb-3">
        </div>

        <!-- TABLA DE CAJAS -->
        <div v-if="vistaActual !== 'nueva'">
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-x-auto">
                <thead>
                <tr class="bg-gray-300 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="px-4 py-2">Número</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Efectivo</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Movimientos</th>
                    <th class="px-4 py-2">Actualizar</th>
                    <th class="px-4 py-2">Eliminar</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="caja in cajaEncontrada" :key="caja.id" class="hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-300">
                    <td class="px-4 py-2">{{ caja.numero }}</td>
                    <td class="px-4 py-2">{{ caja.nombre }}</td>
                    <td class="px-4 py-2">${{ caja.efectivo }}</td>
                    <td class="px-4 py-2">{{ caja.estado }}</td>
                    <td class="px-4 py-2">
                        <button class="text-blue-600 hover:text-blue-800">
                            <FolderOpen />
                        </button>
                    </td>
                    <td class="px-4 py-2">
                        <button @click="editarCaja(caja)" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-300">✏️</button>
                    </td>
                    <td class="px-4 py-2">
                        <button @click="eliminarCaja(caja.id)" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-300">🗑️</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full bg-white dark:bg-gray-800 text-center py-6 mt-auto border-t border-gray-200">
        <div class="container mx-auto px-6">
            <div class="flex justify-center items-center mb-4">
                <img src="https://cdn-icons-png.flaticon.com/256/4951/4951200.png" alt="BMS Logo" class="w-8 h-8"/>
                <span class="text-gray-800 dark:text-white font-bold text-xl ml-2">BMS</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-4">
                <div>
                    <h3 class="font-semibold text-gray-700 dark:text-white">Home</h3>
                    <ul>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Services</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">About Us</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Open Source</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 dark:text-white">Company</h3>
                    <ul>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">About us</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Careers</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Security</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Status</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Terms & privacy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 dark:text-white">Resources</h3>
                    <ul>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Help center</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Pricing</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Blog</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Community</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Integrations</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 dark:text-white">Explore more</h3>
                    <ul>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Templates</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Affiliates</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Do Not Sell or Share My Info</a></li>
                        <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-blue-500">Cookie settings</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <p>© 2025 BMS - Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</template>

<style scoped>
footer {
    border-top: 1px solid #ddd;
}
</style>
