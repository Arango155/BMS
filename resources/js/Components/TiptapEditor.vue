<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { Editor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Toolbar from "@/Components/TiptapToolbar.vue";

const editor = ref(null);

onMounted(() => {
    editor.value = new Editor({
        extensions: [StarterKit],
        content: "<p>Escribe algo aquí...</p>",
        editorProps: {
            attributes: {
                class: "prose dark:prose-invert focus:outline-none min-h-[200px] p-4 bg-white dark:bg-gray-900 !text-gray-900 dark:!text-gray-200 rounded-md shadow-md transition-colors duration-300 !important",
            },
        },
    });
});

// Limpiar instancia del editor cuando el componente se desmonta
onBeforeUnmount(() => {
    if (editor.value) {
        editor.value.destroy();
    }
});
</script>

<template>
    <div>
        <Toolbar v-if="editor" :editor="editor" />
        <EditorContent v-if="editor" :editor="editor" class="transition-colors duration-300 !important" />
        <p v-else class="text-gray-500 dark:!text-gray-400 text-center !important">Cargando editor...</p>
    </div>
</template>

<style scoped>
/* 🔥 Asegurar que se aplique el estilo */
.prose {
    max-width: 100% !important;
}
</style>
