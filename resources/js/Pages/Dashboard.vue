<script setup>
import { computed, ref } from 'vue';
import { useForm, Head, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Card from '@/Components/ui/Card.vue';
import CardContent from '@/Components/ui/CardContent.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const profile = computed(() => page.props.profile);
const showInviteModal = ref(false);
const toast = useToast();

const form = useForm({
    email: '',
    role: 'empleado',
});

const sendInvitation = () => {
    form.post(route('invite.send'), {
        onSuccess: () => {
            form.reset();
            showInviteModal.value = false;
            toast.success('✅ Invitación enviada con éxito.', { timeout: 3000 });
        },
        onError: () => {
            toast.error('❌ Error al enviar la invitación.', { timeout: 3000 });
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="p-6 max-w-6xl mx-auto grid gap-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Bienvenido, {{ user?.name }}</h1>

            <div class="grid md:grid-cols-3 gap-6">
                <Card>
                    <CardContent>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Base de datos activa</p>
                        <h2 class="text-lg font-semibold">{{ $page.props.currentDatabase || 'No disponible' }}</h2>
                    </CardContent>
                </Card>

                <Card>
                    <CardContent>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Empresa</p>
                        <h2 class="text-lg font-semibold">{{ profile?.empresa_nombre || 'No disponible' }}</h2>
                    </CardContent>
                </Card>

                <Card>
                    <CardContent>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Tipo de empresa</p>
                        <h2 class="text-lg font-semibold">{{ profile?.empresa_tipo || 'No disponible' }}</h2>
                    </CardContent>
                </Card>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <Card>
                    <CardContent>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Módulos</p>
                        <h2 class="text-lg font-semibold">{{ profile?.modulos || 'No disponible' }}</h2>
                    </CardContent>
                </Card>

                <Card>
                    <CardContent>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Onboarding Completo</p>
                        <h2 :class="profile?.onboarding_completo ? 'text-green-500' : 'text-red-500'">
                            {{ profile?.onboarding_completo ? 'Sí' : 'No' }}
                        </h2>
                    </CardContent>
                </Card>
            </div>

            <div class="flex gap-4">
                <a :href="route('users.index')" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">Gestión de Usuarios</a>
                <button v-if="user?.roles?.includes('admin')" @click="showInviteModal = true" class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600">
                    Invitar Usuario
                </button>
            </div>
        </div>

        <Modal :show="showInviteModal" @close="showInviteModal = false">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Invitar Usuario</h2>
                <form @submit.prevent="sendInvitation">
                    <div class="mb-4">
                        <InputLabel for="email" value="Correo Electrónico" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
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
