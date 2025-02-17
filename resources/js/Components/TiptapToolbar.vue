<script setup>
defineProps({ editor: Object });
</script>

<template>
    <div class="flex gap-2 bg-gray-100 dark:bg-gray-900 !important p-3 rounded-md shadow-md border border-gray-300 dark:border-gray-700 !important">
        <!-- Bold -->
        <button
            @click="editor.chain().focus().toggleBold().run()"
            :class="{
                '!bg-gray-300 dark:!bg-gray-700 !hover:bg-gray-400 dark:!hover:bg-gray-600 !important': true,
                'font-bold dark:!text-yellow-400 !shadow-md dark:!shadow-yellow-500 !important': editor.isActive('bold'),
            }"
            class="px-3 py-1 rounded-md transition-all duration-200 ease-in-out"
        >
            B
        </button>

        <!-- Italic -->
        <button
            @click="editor.chain().focus().toggleItalic().run()"
            :class="{
                '!bg-gray-300 dark:!bg-gray-700 !hover:bg-gray-400 dark:!hover:bg-gray-600 !important': true,
                'italic dark:!text-blue-400 !shadow-md dark:!shadow-blue-500 !important': editor.isActive('italic'),
            }"
            class="px-3 py-1 rounded-md transition-all duration-200 ease-in-out"
        >
            I
        </button>

        <!-- Heading (H2) -->
        <button
            @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
            :class="{
                '!bg-gray-300 dark:!bg-gray-700 !hover:bg-gray-400 dark:!hover:bg-gray-600 !important': true,
                '!text-green-600 dark:!text-green-400 !underline !shadow-md dark:!shadow-green-500 !important': editor.isActive('heading', { level: 2 }),
            }"
            class="px-3 py-1 rounded-md transition-all duration-200 ease-in-out"
        >
            H2
        </button>
    </div>
</template>
