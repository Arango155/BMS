<script setup>
import { ref } from "vue";
import { useForm, Head } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    token: String,
    email: String,
});

const form = useForm({
    name: "",
    email: props.email,
    password: "",
    password_confirmation: "",
    token: props.token,
});

const submit = () => {
    form.post(route("invite.register"));
};
</script>

<template>
    <GuestLayout>
        <Head title="Aceptar Invitación" />
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Registro de Usuario</h2>
            <p class="text-gray-600 mb-4">Estás aceptando una invitación a unirte a esta empresa.</p>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Nombre Completo" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Correo Electrónico" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        readonly
                    />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Contraseña" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirmar Contraseña" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                    />
                </div>

                <div class="mt-6">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Aceptar Invitación
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
