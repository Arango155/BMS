<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    empresa: "",
    tipo_empresa: "",
});

const statusMessage = ref(""); // Mensaje de confirmación o error
const isSubmitting = ref(false); // Evita múltiples envíos

const submit = () => {
    if (!form.empresa || !form.tipo_empresa) {
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
    <div class="p-6">
        <h2 class="text-lg font-bold">Completa tu perfil</h2>
        <form @submit.prevent="submit">
            <label class="block mt-4">
                Nombre de la empresa:
                <input type="text" v-model="form.empresa" class="border p-2 w-full" />
            </label>

            <label class="block mt-4">
                Tipo de empresa:
                <input type="text" v-model="form.tipo_empresa" class="border p-2 w-full" />
            </label>

            <button
                type="submit"
                class="mt-4 bg-blue-500 text-white p-2 rounded disabled:opacity-50"
                :disabled="isSubmitting"
            >
                {{ isSubmitting ? "Enviando..." : "Finalizar" }}
            </button>

            <p v-if="statusMessage" class="mt-4 text-sm"
               :class="statusMessage.includes('Error') ? 'text-red-500' : 'text-green-500'">
                {{ statusMessage }}
            </p>
        </form>
    </div>
</template>
