<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';

// 📌 Estado reactivo para usuarios y estado de carga
const users = ref([]);
const isLoading = ref(true); // 🔄 Estado para mostrar "Cargando..."

const fetchUsers = async () => {
    isLoading.value = true; // 🔄 Activamos la carga
    console.log("🔍 `usePage().props.users` inicial:", usePage().props.users);

    if (usePage().props.users && usePage().props.users.length > 0) {
        users.value = usePage().props.users;
        console.log("✅ Usuarios obtenidos desde `usePage().props`:", users.value);
    } else {
        console.log("⚠️ `usePage().props.users` vacío. Obteniendo desde la API...");
        try {
            const response = await fetch('/api/users');
            const data = await response.json();
            users.value = data.users;
            console.log("✅ Usuarios obtenidos desde la API:", users.value);
        } catch (error) {
            console.error("⚠️ Error al obtener usuarios:", error);
        }
    }

    isLoading.value = false; // ✅ Desactivamos la carga
};

// 📌 Ejecutar la carga de usuarios al montar el componente
onMounted(fetchUsers);

// 📌 Vigilar cambios en `usePage().props` y recargar si es necesario
watch(() => usePage().props.users, fetchUsers);

// 📌 Eliminar usuario sin recargar la página
const deleteUser = async (id) => {
    if (!confirm('¿Seguro que deseas eliminar este usuario?')) return;

    try {
        await fetch(`/users/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
        });

        console.log(`✅ Usuario con ID ${id} eliminado.`);
        fetchUsers(); // 🔄 Recargar usuarios después de eliminar
    } catch (error) {
        console.error("⚠️ Error al eliminar usuario:", error);
    }
};
</script>

<template>
    <Head title="Gestión de Usuarios" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Gestión de Usuarios</h2>

                <!-- 📌 Mostrar mensaje de carga -->
                <p v-if="isLoading" class="text-center text-gray-500 dark:text-gray-300 my-4 animate-pulse">
                    🔄 Cargando usuarios...
                </p>

                <!-- 📌 Mensaje si no hay usuarios -->
                <p v-else-if="users.length === 0" class="text-center text-gray-500 dark:text-gray-300 my-4">
                    No hay usuarios registrados.
                </p>

                <!-- 📌 Tabla de usuarios -->
                <table v-else class="min-w-full border-collapse mt-4">
                    <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Nombre</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id" class="border-b">
                        <td class="border px-4 py-2">{{ user.id }}</td>
                        <td class="border px-4 py-2">{{ user.name }}</td>
                        <td class="border px-4 py-2">{{ user.email }}</td>
                        <td class="border px-4 py-2">
                            <button @click="deleteUser(user.id)" class="bg-red-500 text-white px-2 py-1 rounded">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
