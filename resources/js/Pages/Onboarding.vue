<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

// Crear el formulario con todos los campos vacíos
const form = useForm({
    dashboard_name: "",
    empresa_nombre: "",
    empresa_tipo: "",
    modulos: "",
    onboarding_completo: false,
});

const currentStep = ref(1); // Controla en qué paso estamos
const isSubmitting = ref(false);
const statusMessage = ref("");

const nextStep = () => {
    // Lógica para avanzar al siguiente paso
    if (currentStep.value < 4) {
        currentStep.value++;
    }
};

const submit = () => {
    if (!form.empresa_nombre || !form.empresa_tipo) {
        statusMessage.value = "Todos los campos son obligatorios.";
        return;
    }

    isSubmitting.value = true;
    statusMessage.value = "Enviando...";

    form.post("/onboarding", {
        onSuccess: () => {
            statusMessage.value = "Onboarding completado correctamente.";
            setTimeout(() => {
                window.location.href = "/dashboard";
            }, 1000);
        },
        onError: (errors) => {
            statusMessage.value = "Error al completar el onboarding.";
            console.error(errors);
            isSubmitting.value = false;
        }
    });
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <h2 class="text-center text-3xl font-extrabold text-gray-900">Completa tu perfil</h2>
            <div v-if="currentStep === 1" class="bg-white p-8 rounded-lg shadow-md">
                <!-- Paso 1: Nombre del dashboard -->
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-700">¿Cuál es el nombre de tu dashboard?</h3>
                    <input type="text" v-model="form.dashboard_name" class="mt-4 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button @click="nextStep" class="mt-6 w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Siguiente
                    </button>
                </div>
            </div>

            <div v-if="currentStep === 2" class="bg-white p-8 rounded-lg shadow-md">
                <!-- Paso 2: Nombre de la empresa -->
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-700">¿Cuál es el nombre de tu empresa?</h3>
                    <input type="text" v-model="form.empresa_nombre" class="mt-4 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button @click="nextStep" class="mt-6 w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Siguiente
                    </button>
                </div>
            </div>

            <div v-if="currentStep === 3" class="bg-white p-8 rounded-lg shadow-md">
                <!-- Paso 3: Tipo de empresa -->
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-700">¿Qué tipo de empresa eres?</h3>
                    <input type="text" v-model="form.empresa_tipo" class="mt-4 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button @click="nextStep" class="mt-6 w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Siguiente
                    </button>
                </div>
            </div>

            <div v-if="currentStep === 4" class="bg-white p-8 rounded-lg shadow-md">
                <!-- Paso 4: Módulos -->
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-700">¿Qué módulos necesitas?</h3>
                    <input type="text" v-model="form.modulos" class="mt-4 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button @click="submit" class="mt-6 w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500" :disabled="isSubmitting">
                        {{ isSubmitting ? "Enviando..." : "Finalizar" }}
                    </button>
                </div>
            </div>

            <p v-if="statusMessage" class="mt-4 text-sm text-center"
               :class="statusMessage.includes('Error') ? 'text-red-500' : 'text-green-500'">
                {{ statusMessage }}
            </p>
        </div>
    </div>
</template>

<style scoped>
button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
