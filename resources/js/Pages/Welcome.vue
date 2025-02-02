<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Footer from "@/components/Footer.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

// Reactive state to control menu visibility
const isMenuOpen = ref(false);
</script>

<template>
    <div class="bg-white shadow-lg p-4 relative">
        <nav class="flex justify-between items-center flex-wrap">
            <!-- Left side with logo and "BMS" -->
            <div class="flex items-center space-x-2">
                <img src="https://cdn-icons-png.flaticon.com/256/4951/4951200.png" alt="Logo" class="w-8 h-8"/>
                <span class="text-gray-800 font-bold text-xl">BMS</span>
            </div>

            <!-- Hamburger Menu Button (visible on small screens) -->
            <div class="sm:hidden flex items-center">
                <button @click="isMenuOpen = !isMenuOpen" class="text-gray-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links for large screens -->
            <div class="hidden sm:flex justify-center flex-1 space-x-8">
                <Link to="#features" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Features</Link>
                <Link to="#solutions" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Solutions</Link>
                <Link to="#plans" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Plans</Link>
                <Link to="#pricing" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Pricing</Link>
                <Link to="#download" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Download</Link>
                <Link to="#modules" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Modules</Link>
                <Link to="#community" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Community</Link>
                <Link to="#other" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Other</Link>
            </div>

            <!-- Right side (Login/Register) for large screens -->
            <div class="hidden sm:flex items-center space-x-4">
                <div v-if="canLogin" class="space-x-4">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-gray-800 font-bold hover:text-blue-500 text-xl">Dashboard</Link>
                    <template v-else>
                        <Link :href="route('login')" class="text-gray-800 font-bold hover:text-blue-500 text-xl">Log in</Link>
                        <Link v-if="canRegister" :href="route('register')" class="text-white bg-blue-500 hover:bg-blue-600 font-bold text-xl w-full text-center py-3 px-6 rounded-md mt-4 sm:mt-0">
                            Get started with BMS
                        </Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Full-Screen Navigation Links (hidden on small screens, visible on larger screens) -->
        <div v-if="isMenuOpen" class="fixed custom-inset bg-white bg-opacity-90 z-50 flex flex-col justify-start items-center space-y-6 pt-16 transition-all duration-500 ease-in-out transform" @click.self="isMenuOpen = false" style="transition: transform 0.5s ease-in-out; transform: translateY(0);">
            <div class="flex flex-col items-center space-y-8 text-3xl font-bold">
                <Link to="#features" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Features</Link>
                <Link to="#solutions" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Solutions</Link>
                <Link to="#plans" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Plans</Link>
                <Link to="#pricing" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Pricing</Link>
                <Link to="#download" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Download</Link>
                <Link to="#modules" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Modules</Link>
                <Link to="#community" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Community</Link>
                <Link to="#other" class="text-gray-800 font-bold hover:text-blue-500 transition-colors duration-300">Other</Link>

                <hr class="text-gray-500 mt-6"/>

                <div v-if="canLogin" class="mt-6 space-y-4 items-center">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-gray-800 font-bold hover:text-blue-500 text-xl">Dashboard</Link>
                    <template v-else>
                        <Link :href="route('login')" class="text-gray-800 font-bold hover:text-blue-500 text-xl w-full text-center">Log in</Link>
                        <Link v-if="canRegister" :href="route('register')" class="btn btn-primary hover:text-blue-500 font-bold text-xl w-full text-center mt-4 sm:mt-0 py-3 px-6 rounded-md bg-blue-500 text-white">
                            Get started with BMS
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <br>
    <Footer />
</template>

