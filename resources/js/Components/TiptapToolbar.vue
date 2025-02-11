<script setup>
defineProps({ editor: Object });
</script>

<template>
    <div class="flex gap-2 bg-gray-100 dark:bg-gray-800 p-2 rounded-t-md shadow">
        <button @click="editor.chain().focus().toggleBold().run()" class="px-3 py-1 rounded-md bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600">
            Bold
        </button>
        <button @click="editor.chain().focus().toggleItalic().run()" class="px-3 py-1 rounded-md bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600">
            Italic
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" class="px-3 py-1 rounded-md bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600">
            H2
        </button>
    </div>
</template>
