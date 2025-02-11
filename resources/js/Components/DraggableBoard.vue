<script setup>
import { ref } from "vue";
import { VueDraggableNext } from "vue-draggable-next";

const tasks = ref([
    { id: 1, text: "📌 Primera tarea" },
    { id: 2, text: "✅ Completar integración" },
    { id: 3, text: "🚀 Implementar mejoras" },
]);
</script>

<template>
    <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md w-full">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">📋 Tablero de Tareas</h2>
        <VueDraggableNext v-model="tasks" group="tasks" item-key="id" class="space-y-2">
            <template #item="{ element }">
                <div class="p-4 bg-blue-200 dark:bg-blue-700 text-blue-900 dark:text-white rounded-md shadow cursor-pointer hover:bg-blue-300 dark:hover:bg-blue-600 transition">
                    {{ element.text }}
                </div>
            </template>
        </VueDraggableNext>
    </div>
</template>
