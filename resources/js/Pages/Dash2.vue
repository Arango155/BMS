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
            <div class="flex flex-1">
                <!-- Barra Lateral -->
<!--                <aside class="w-64 bg-white dark:bg-gray-900 text-gray-900 dark:text-white p-6 flex flex-col gap-4 border-r border-gray-200 dark:border-gray-700">-->
<!--                    <h2 class="text-xl font-semibold">Módulos</h2>-->
<!--                    <nav class="flex flex-col gap-3">-->
<!--                        <a href="#" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800">-->
<!--                            <Users /> Usuarios-->
<!--                        </a>-->

<!--                        <a href="#" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800">-->
<!--                            <BarChart2 /> Reportes-->
<!--                        </a>-->
<!--                        <a href="#" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800">-->
<!--                            <MessageCircle /> Mensajes-->
<!--                        </a>-->

<!--                        <a :href="route('inventario')" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800">-->
<!--                            <Users /> Inventario-->
<!--                        </a>-->

<!--                        <a :href="route('users.index')" class="flex items-center gap-2 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800">-->
<!--                            <Users /> Gestión de Usuarios-->
<!--                        </a>-->
<!--                    </nav>-->
<!--                </aside>-->

                <div class="flex-1 p-8 max-w-7xl mx-auto grid gap-10">
                    <div class="flex justify-between items-center">
                        <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100">Bienvenido, {{ user?.name }}</h1>
                        <div class="flex gap-4">
<!--                            <button class="p-3 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600">-->
<!--                                <Bell />-->
<!--                            </button>-->
                            <button @click="showInviteModal = true" class="flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:scale-105 transition-all">
                                <Plus class="mr-2" /> Invitar Usuario
                            </button>

                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        <CustomCard title="📊 Ventas Semanales">
                            <Doughnut :data="chartData" />
                        </CustomCard>
                        <CustomCard title="📈 Visitas">
                            <Bar :data="barChartData" />
                        </CustomCard>

                    </div>


                    <div class="grid md:grid-cols-3 gap-8">

                        <CustomCard title="🏢 Nombre de la Empresa">
                            <p class="text-lg font-semibold">{{ profile?.empresa_nombre || 'No disponible' }}</p>
                        </CustomCard>
                        <CustomCard title="🏷️ Tipo de Empresa">
                            <p class="text-lg font-semibold">{{ profile?.empresa_tipo || 'No disponible' }}</p>
                        </CustomCard>
                        <CustomCard title="🖥️ Nombre del Dashboard">
                            <p class="text-lg font-semibold">{{ profile?.dashboard_name || 'No disponible' }}</p>
                        </CustomCard>
                        <CustomCard title="✅ Onboarding Activo">
                            <p class="text-lg font-semibold">{{ profile?.onboarding_completo ? 'Sí' : 'No' }}</p>
                        </CustomCard>
                        <CustomCard title="📂 Módulos Disponibles">
                            <p class="text-lg font-semibold">{{ profile?.modulos || 'No disponible' }}</p>
                        </CustomCard>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <CustomCard title="📝 Editor de Notas">
                            <TiptapEditor />
                        </CustomCard>
                        <CustomCard title="📌 Tablero de Tareas">
                            <DraggableBoard />
                        </CustomCard>
                    </div>

                    <div class="mt-8">
                        <CustomCard title="📅 Calendario de Eventos">
                            <VueCal />
                        </CustomCard>
                    </div>
                </div>
            </div>



        </div>

</template>
