<script setup>
defineProps({
    title: String,
});
</script>

<template>
    <div class="relative bg-white dark:bg-darkCard shadow-md rounded-xl p-6
                border border-gray-200 dark:border-darkBorder transition-all duration-500
                hover:scale-[1.02] hover:shadow-lg dark:hover:shadow-xl"
         style="background-color: var(--tw-bg-opacity) !important;">

        <!-- Título -->
        <h2 class="text-lg font-semibold text-gray-900 dark:text-darkText transition-colors duration-500 mb-3">
            {{ title }}
        </h2>

        <!-- Contenido -->
        <div class="text-gray-600 dark:text-gray-300 transition-colors duration-500">
            <slot />
        </div>
    </div>
</template>
