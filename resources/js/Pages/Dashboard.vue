<script setup>
import { computed, ref } from 'vue';
import { useForm, Head, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification'; // Importar Vue Toastification
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const profile = computed(() => page.props.profile);
const showInviteModal = ref(false);
const toast = useToast(); // Inicializar el toast

console.log("Usuario en Vue:", user.value); // 🔍 Verifica en la consola del navegador

// 📌 Formulario de invitación
const form = useForm({
    email: '',
    role: 'empleado',
});

// 📌 Enviar la invitación con notificación toast
const sendInvitation = () => {
    form.post(route('invite.send'), {
        onSuccess: () => {
            form.reset();
            showInviteModal.value = false;
            toast.success('✅ Invitación enviada con éxito.', { timeout: 3000 });
        },
        onError: (errors) => {
            toast.error('❌ Error al enviar la invitación.', { timeout: 3000 });
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>¡Has iniciado sesión!</p>
                        <p><strong>Base de datos activa:</strong> {{ $page.props.currentDatabase }}</p>

                        <!-- 📌 Botón para gestión de usuarios -->
                        <div class="mt-4">
                            <a :href="route('users.index')" class="bg-blue-500 text-white px-4 py-2 rounded">Gestión de Usuarios</a>
                        </div>

                        <!-- 📌 Botón de invitación (Solo visible para admin) -->
                        <div v-if="user?.role === 'admin'" class="mt-4">
                            <button @click="showInviteModal = true" class="bg-green-500 text-white px-4 py-2 rounded">
                                Invitar Usuario
                            </button>
                        </div>

                        <div v-if="profile" class="mt-4">
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

        <!-- 📌 Modal de invitación -->
        <Modal :show="showInviteModal" @close="showInviteModal = false">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Invitar Usuario</h2>

                <form @submit.prevent="sendInvitation">
                    <div class="mb-4">
                        <InputLabel for="email" value="Correo Electrónico" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="role" value="Rol" />
                        <select v-model="form.role" class="block w-full border-gray-300 rounded-md">
                            <option value="admin">Admin</option>
                            <option value="empleado">Empleado</option>
                            <option value="gerente">Gerente</option>
                        </select>
                    </div>

                    <div class="flex justify-end mt-4">
                        <PrimaryButton class="mr-2" @click="showInviteModal = false">Cancelar</PrimaryButton>
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Enviar Invitación
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
