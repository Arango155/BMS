<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email address" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>

        <!-- Social login buttons -->
        <div class="mt-6 flex flex-col space-y-3">
            <a href="/auth/google" class="w-full flex items-center justify-center px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg text-center">
                <i class="fab fa-google mr-2"></i> Google
            </a>
            <a href="/auth/facebook" class="w-full flex items-center justify-center px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg text-center">
                <i class="fab fa-facebook mr-2"></i> Facebook
            </a>
            <a href="/auth/github" class="w-full flex items-center justify-center px-4 py-2 text-white bg-gray-800 hover:bg-gray-900 rounded-lg text-center">
                <i class="fab fa-github mr-2"></i> GitHub
            </a>
            <a href="/auth/linkedin" class="w-full flex items-center justify-center px-4 py-2 text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-center">
                <i class="fab fa-linkedin mr-2"></i> LinkedIn
            </a>
            <a href="/auth/microsoft" class="w-full flex items-center justify-center px-4 py-2 text-white bg-gray-700 hover:bg-gray-800 rounded-lg text-center">
                <i class="fab fa-microsoft mr-2"></i> Microsoft
            </a>
            <a href="/auth/apple" class="w-full flex items-center justify-center px-4 py-2 text-white bg-black hover:bg-gray-900 rounded-lg text-center">
                <i class="fab fa-apple mr-2"></i> Apple
            </a>

            <hr>

            <!-- Redirect to registration page -->
            <div class="flex justify-between">
                <Link :href="route('register')" class="text-blue-600 hover:text-blue-700">
                    Create an account
                </Link>

                <Link href="/auth/password/reset" class="text-blue-600 hover:text-blue-700">
                    Forgot your password?
                </Link>
            </div>

            <!-- Additional information -->
            <div class="mt-4 text-sm text-gray-600 text-center">
                Account for BMS
                <br>
                <Link href="/privacy-policy" class="text-blue-600 hover:text-blue-700">
                    Privacy Policy
                </Link>
                •
                <Link href="/user-notice" class="text-blue-600 hover:text-blue-700">
                    User Notice
                </Link>
            </div>

            <div class="mt-2 text-xs text-gray-500 text-center">
                This site is protected by reCAPTCHA and the
                <Link href="https://policies.google.com/privacy" class="text-blue-600 hover:text-blue-700">
                    Privacy Policy
                </Link>
                and the
                <Link href="https://policies.google.com/terms" class="text-blue-600 hover:text-blue-700">
                    Terms of Service
                </Link>
                of Google apply.
            </div>
        </div>
        <br>
        <br>
    </GuestLayout>

</template>

<style scoped>
body {
    padding: 5%;
}
</style>
