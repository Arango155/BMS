<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const users = ref([]);
const fetchUsers = async () => {
    users.value = usePage().props.users;
};

onMounted(fetchUsers);

const deleteUser = (id) => {
    if (confirm('¿Seguro que deseas eliminar este usuario?')) {
        router.delete(route('users.destroy', id));
    }
};
</script>

<template>
    <Head title="Gestión de Usuarios" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Gestión de Usuarios</h2>

                    <table class="min-w-full border-collapse mt-4">
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
    </AuthenticatedLayout>
</template>
