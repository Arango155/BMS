<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    dashboard_name: "",
    empresa_nombre: "", // Cambia de "empresa" a "empresa_nombre"
    empresa_tipo: "", // Cambia de "tipo_empresa" a "empresa_tipo"
    modulos: "",
    onboarding_completo: false,
});


const statusMessage = ref("");
const isSubmitting = ref(false);

const submit = () => {
    // Cambia la validación de los campos a los nombres correctos en form
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
    <div class="p-6">
        <h2 class="text-lg font-bold">Completa tu perfil</h2>
        <form @submit.prevent="submit">
            <label class="block mt-4">
                Nombre del dashboard:
                <input type="text" v-model="form.dashboard_name" class="border p-2 w-full" />
            </label>

            <label class="block mt-4">
                Nombre de la empresa:
                <input type="text" v-model="form.empresa_nombre" class="border p-2 w-full" />
            </label>

            <label class="block mt-4">
                Tipo de empresa:
                <input type="text" v-model="form.empresa_tipo" class="border p-2 w-full" />
            </label>


            <label class="block mt-4">
                Módulos:
                <input type="text" v-model="form.modulos" class="border p-2 w-full" />
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
