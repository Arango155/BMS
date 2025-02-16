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
import CustomCard from '@/Components/CustomCard.vue';
import TiptapEditor from '@/Components/TiptapEditor.vue';
import DraggableBoard from '@/Components/DraggableBoard.vue';
import { Plus, Bell, MessageCircle, Users, BarChart2 } from 'lucide-vue-next';
import { useMotion } from '@vueuse/motion';
import { Doughnut, Bar } from 'vue-chartjs';
import { Chart as ChartJS, ArcElement, Tooltip, Legend, CategoryScale, LinearScale, BarElement } from 'chart.js';
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';

ChartJS.register(ArcElement, Tooltip, Legend, CategoryScale, LinearScale, BarElement);

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

const chartData = {
    labels: ['Ventas', 'Usuarios', 'Tareas'],
    datasets: [
        {
            data: [300, 150, 100],
            backgroundColor: ['#4F46E5', '#22C55E', '#F97316'],
        },
    ],
};

const barChartData = {
    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
    datasets: [
        {
            label: 'Visitas',
            data: [40, 60, 80, 100, 120],
            backgroundColor: '#2563EB',
        },
    ],
};
</script>

<template>


    <Head title="Dashboard" />
    <AuthenticatedLayout>

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

        <div class="flex flex-col min-h-screen">


            <!-- Footer -->
            <footer class="bg-gray-200 dark:bg-gray-800 text-center p-4 mt-auto">
                <p class="text-gray-700 dark:text-gray-300">© 2025 BMS. Todos los derechos reservados.</p>
            </footer>
        </div>
    </AuthenticatedLayout>
</template>
