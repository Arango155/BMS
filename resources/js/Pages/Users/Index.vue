<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';

// 📌 Estado reactivo para usuarios y carga
const users = ref([]);
const isLoading = ref(true);

// 📌 Cargar usuarios
const fetchUsers = async () => {
    isLoading.value = true;

    if (usePage().props.users && usePage().props.users.length > 0) {
        users.value = usePage().props.users;
    } else {
        try {
            const response = await fetch('/api/users');
            const data = await response.json();
            users.value = data.users;
        } catch (error) {
            console.error("⚠️ Error fetching users:", error);
        }
    }

    isLoading.value = false;
};

// 📌 Ejecutar al montar
onMounted(fetchUsers);

// 📌 Vigilar cambios en `usePage().props.users`
watch(() => usePage().props.users, fetchUsers);

// 📌 Eliminar usuario sin recargar la página
const deleteUser = async (id) => {
    if (!confirm('Are you sure you want to delete this user?')) return;

    try {
        await fetch(`/users/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
        });

        fetchUsers(); // 🔄 Recargar usuarios después de eliminar
    } catch (error) {
        console.error("⚠️ Error deleting user:", error);
    }
};
</script>

<template>
    <Head title="User Management" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg p-6">

                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">User Management</h2>

                <!-- 📌 Mostrar "Cargando..." -->
                <p v-if="isLoading" class="text-center text-gray-500 dark:text-gray-300 my-4 animate-pulse">
                    🔄 Loading users...
                </p>

                <!-- 📌 Mensaje si no hay usuarios -->
                <p v-else-if="users.length === 0" class="text-center text-gray-500 dark:text-gray-300 my-4">
                    No users registered.
                </p>

                <!-- 📌 Tabla de Usuarios -->
                <div v-else class="overflow-x-auto mt-4">
                    <table class="min-w-full border border-gray-300 dark:border-gray-700 shadow-lg rounded-lg overflow-hidden">
                        <thead>
                        <tr class="bg-gray-300 dark:bg-gray-900 text-gray-900 dark:text-gray-100 uppercase text-sm">
                            <th class="border border-gray-400 dark:border-gray-700 px-6 py-3 text-left">ID</th>
                            <th class="border border-gray-400 dark:border-gray-700 px-6 py-3 text-left">Name</th>
                            <th class="border border-gray-400 dark:border-gray-700 px-6 py-3 text-left">Email</th>
                            <th class="border border-gray-400 dark:border-gray-700 px-6 py-3 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users" :key="user.id"
                            class="border-b border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <td class="border border-gray-300 dark:border-gray-700 px-6 py-4">{{ user.id }}</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-6 py-4">{{ user.name }}</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-6 py-4">{{ user.email }}</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-center">
                                <button @click="deleteUser(user.id)"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md shadow-md transition">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</template>
