<script setup>
import { computed, ref, onMounted, watchEffect } from 'vue';
import { useForm, Head, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import { useDark } from '@vueuse/core';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CustomCard from '@/Components/CustomCard.vue';
import TiptapEditor from '@/Components/TiptapEditor.vue';
import DraggableBoard from '@/Components/DraggableBoard.vue';
import { Plus } from 'lucide-vue-next';
import { Doughnut, Bar } from 'vue-chartjs';
import { Chart as ChartJS, ArcElement, Tooltip, Legend, CategoryScale, LinearScale, BarElement } from 'chart.js';
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';

// Register Chart.js elements
ChartJS.register(ArcElement, Tooltip, Legend, CategoryScale, LinearScale, BarElement);

const page = usePage();
const user = computed(() => page.props.auth?.user);
const profile = computed(() => page.props.profile);
const showInviteModal = ref(false);
const toast = useToast();

// ✅ Modo oscuro con persistencia
const isDarkMode = useDark({
    selector: 'html',
    attribute: 'class',
    valueDark: 'dark',
    valueLight: 'light',
    storageKey: 'darkModePreference',
});



// ✅ Asegurar que el tema se aplique correctamente sin forzar
onMounted(() => {
    document.documentElement.classList.toggle('dark', isDarkMode.value);
});

watchEffect(() => {
    document.documentElement.classList.toggle('dark', isDarkMode.value);
});

const form = useForm({
    email: '',
    role: 'employee',
});

const sendInvitation = () => {
    form.post(route('invite.send'), {
        onSuccess: () => {
            form.reset();
            showInviteModal.value = false;
            toast.success('✅ Invitation sent successfully.', { timeout: 3000 });
        },
        onError: () => {
            toast.error('❌ Error sending invitation.', { timeout: 3000 });
        },
    });
};

// ✅ Chart Data
const chartData = {
    labels: ['Sales', 'Users', 'Tasks'],
    datasets: [
        {
            data: [300, 150, 100],
            backgroundColor: ['#4F46E5', '#22C55E', '#F97316'],
        },
    ],
};

const barChartData = {
    labels: ['January', 'February', 'March', 'April', 'May'],
    datasets: [
        {
            label: 'Visits',
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
            <h1 class="text-lg font-semibold mb-4">Invite User</h1>
            <form @submit.prevent="sendInvitation">
                <div class="mb-4">
                    <InputLabel for="email" value="Email Address" />
                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="mb-4">
                    <InputLabel for="role" value="Role" />
                    <select v-model="form.role" class="block w-full border-gray-300 rounded-md">
                        <option value="admin">Admin</option>
                        <option value="employee">Employee</option>
                        <option value="manager">Manager</option>
                    </select>
                </div>
                <div class="flex justify-end mt-4">
                    <PrimaryButton class="mr-2" @click="showInviteModal = false">Cancel</PrimaryButton>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Send Invitation
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>

    <div class="flex flex-col min-h-screen">
        <div class="flex flex-1">
            <div class="flex-1 p-8 max-w-7xl mx-auto grid gap-10">
                <div class="flex justify-between items-center">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100">Welcome, {{ user?.name }}</h1>
                    <div class="flex gap-4">
                        <button
                            @click="showInviteModal = true"
                            class="flex items-center px-6 py-3 rounded-lg shadow-md hover:scale-105 transition-all
        bg-blue-600 dark:bg-blue-500 text-gray-900 dark:text-white"
                        >
                            <Plus class="mr-2 text-gray-900 dark:text-white" />
                            Invite User
                        </button>


                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <CustomCard title="📊 Weekly Sales">
                        <Doughnut :data="chartData" />
                    </CustomCard>
                    <CustomCard title="📈 Visits">
                        <Bar :data="barChartData" />
                    </CustomCard>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <CustomCard title="🏢 Company Name">
                        <p class="text-lg font-semibold">{{ profile?.empresa_nombre || 'Not available' }}</p>
                    </CustomCard>
                    <CustomCard title="🏷️ Company Type">
                        <p class="text-lg font-semibold">{{ profile?.empresa_tipo || 'Not available' }}</p>
                    </CustomCard>
                    <CustomCard title="🖥️ Dashboard Name">
                        <p class="text-lg font-semibold">{{ profile?.dashboard_name || 'Not available' }}</p>
                    </CustomCard>
                    <CustomCard title="✅ Onboarding Completed">
                        <p class="text-lg font-semibold">{{ profile?.onboarding_completo ? 'Yes' : 'No' }}</p>
                    </CustomCard>
                    <CustomCard title="📂 Available Modules">
                        <p class="text-lg font-semibold">{{ profile?.modulos || 'Not available' }}</p>
                    </CustomCard>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <CustomCard title="📝 Notes Editor">
                        <TiptapEditor />
                    </CustomCard>
                    <CustomCard title="📌 Task Board">
                        <DraggableBoard />
                    </CustomCard>
                </div>

                <div class="mt-8">
                    <CustomCard title="📅 Event Calendar">
                        <VueCal />
                    </CustomCard>
                </div>
            </div>
        </div>
    </div>
</template>
