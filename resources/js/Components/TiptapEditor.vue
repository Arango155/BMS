<script setup>
import { ref, onMounted } from "vue";
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
                class: "prose dark:prose-invert focus:outline-none min-h-[200px] p-4 bg-white dark:bg-gray-800 rounded-md shadow-md",
            },
        },
    });
});
</script>

<template>
    <div class="border rounded-lg shadow-md bg-white dark:bg-gray-800 w-full p-4">
        <Toolbar v-if="editor" :editor="editor" />
        <EditorContent v-if="editor" :editor="editor" />
        <p v-else class="text-gray-500 dark:text-gray-400 text-center">Cargando editor...</p>
    </div>
</template>

<style scoped>
.prose {
    max-width: 100%;
}
</style>
