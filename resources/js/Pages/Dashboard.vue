<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;
;

const { profile } = usePage().props;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
       

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>¡Has iniciado sesión!</p>

                        <div v-if="profile">
                            <p><strong>Nombre del Dashboard:</strong> {{ profile.dashboard_name || 'No disponible' }}</p>
                            <p><strong>Empresa:</strong> {{ profile.empresa_nombre || 'No disponible' }}</p>
                            <p><strong>Tipo de empresa:</strong> {{ profile.empresa_tipo || 'No disponible' }}</p>
                            <p><strong>Módulos:</strong> {{ profile.modulos || 'No disponible' }}</p>
                            <p><strong>Onboarding Completo:</strong>
                                <span :class="profile.onboarding_completo ? 'text-green-500' : 'text-red-500'">
                                    {{ profile.onboarding_completo ? 'Sí' : 'No' }}
                                </span>
                            </p>
                        </div>
                        <div v-else>
                            <p class="text-red-500">Perfil no disponible.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

