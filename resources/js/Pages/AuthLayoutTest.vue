<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Prueba de Layout" />
    <AuthenticatedLayout>
        <div class="p-10">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                ✅ El Authenticated Layout se está mostrando correctamente.
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-4">
                Si ves este mensaje con el sidebar y navbar, entonces el layout funciona bien.
            </p>
        </div>
    </AuthenticatedLayout>
</template>
