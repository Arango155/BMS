<script setup>
import { ref } from "vue";
import { VueDraggableNext } from "vue-draggable-next";

const tasks = ref([
    { id: 1, text: "Tarea 1" },
    { id: 2, text: "Tarea 2" },
    { id: 3, text: "Tarea 3" },
]);
</script>

<template>
    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md w-full">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Tablero de Tareas</h2>
        <VueDraggableNext v-model="tasks" group="tasks" item-key="id" class="space-y-2">
            <template #item="{ element }">
                <div class="p-4 bg-blue-100 dark:bg-blue-700 text-blue-900 dark:text-white rounded-md shadow cursor-pointer hover:bg-blue-200 dark:hover:bg-blue-600">
                    {{ element.text }}
                </div>
            </template>
        </VueDraggableNext>
    </div>
</template>
