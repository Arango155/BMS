<template>
    <button @click="toggleDarkMode" class="p-2 bg-gray-200 dark:bg-gray-800 rounded">
        {{ isDark ? '☀️' : '🌙' }}
    </button>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useDark } from '@vueuse/core';

// Usamos useDark para detectar el estado inicial
const isDark = useDark();

// Función para alternar entre modos claro y oscuro
const toggleDarkMode = () => {
    isDark.value = !isDark.value;
    // Guardar el estado en localStorage para mantenerlo
    localStorage.setItem('dark-mode', isDark.value ? 'true' : 'false');
};

// Cargar el estado de localStorage cuando se monta el componente
onMounted(() => {
    const savedMode = localStorage.getItem('dark-mode');
    if (savedMode === 'true') {
        isDark.value = true;
    } else {
        isDark.value = false;
    }
});
</script>

<style scoped>
/* Estilos opcionales */
</style>
