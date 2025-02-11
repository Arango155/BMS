<script setup>
defineProps({
    title: String,
});
</script>

<template>
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ title }}</h2>
        <slot />
    </div>
</template>
