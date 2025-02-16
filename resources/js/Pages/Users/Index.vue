<script setup>
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';

// 📌 Reactive state for users and loading state
const users = ref([]);
const isLoading = ref(true); // 🔄 State to show "Loading..."

const fetchUsers = async () => {
    isLoading.value = true; // 🔄 Activate loading state
    console.log("🔍 Initial `usePage().props.users`:", usePage().props.users);

    if (usePage().props.users && usePage().props.users.length > 0) {
        users.value = usePage().props.users;
        console.log("✅ Users retrieved from `usePage().props`:", users.value);
    } else {
        console.log("⚠️ `usePage().props.users` is empty. Fetching from API...");
        try {
            const response = await fetch('/api/users');
            const data = await response.json();
            users.value = data.users;
            console.log("✅ Users retrieved from API:", users.value);
        } catch (error) {
            console.error("⚠️ Error fetching users:", error);
        }
    }

    isLoading.value = false; // ✅ Disable loading state
};

// 📌 Fetch users when the component is mounted
onMounted(fetchUsers);

// 📌 Watch for changes in `usePage().props` and reload if necessary
watch(() => usePage().props.users, fetchUsers);

// 📌 Delete user without reloading the page
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

        console.log(`✅ User with ID ${id} deleted.`);
        fetchUsers(); // 🔄 Reload users after deletion
    } catch (error) {
        console.error("⚠️ Error deleting user:", error);
    }
};
</script>

<template>
    <Head title="User Management" />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">User Management</h2>

                <!-- 📌 Show loading message -->
                <p v-if="isLoading" class="text-center text-gray-500 dark:text-gray-300 my-4 animate-pulse">
                    🔄 Loading users...
                </p>

                <!-- 📌 Message if no users are registered -->
                <p v-else-if="users.length === 0" class="text-center text-gray-500 dark:text-gray-300 my-4">
                    No users registered.
                </p>

                <!-- 📌 Users table -->
                <table v-else class="min-w-full border-collapse mt-4">
                    <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id" class="border-b">
                        <td class="border px-4 py-2">{{ user.id }}</td>
                        <td class="border px-4 py-2">{{ user.name }}</td>
                        <td class="border px-4 py-2">{{ user.email }}</td>
                        <td class="border px-4 py-2">
                            <button @click="deleteUser(user.id)" class="bg-red-500 text-white px-2 py-1 rounded">
                                Delete
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
