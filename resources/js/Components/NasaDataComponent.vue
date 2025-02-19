<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';

const toast = useToast();
const nasaData = ref(null);
const loading = ref(true);
const error = ref(null);

// ✅ Fetch NASA Data
const fetchNasaData = async () => {
    try {
        const response = await axios.get('/nasa-data'); // Fetch data from Laravel API
        nasaData.value = response.data;
        toast.success("✅ NASA data loaded successfully!", { timeout: 3000 });
    } catch (err) {
        error.value = "❌ Error fetching NASA data.";
        toast.error(error.value, { timeout: 3000 });
    } finally {
        loading.value = false;
    }
};

// ✅ Fetch data on component mount
onMounted(fetchNasaData);
</script>

<template>
    <div class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-6">🚀 NASA Astronomy Picture of the Day</h2>

        <!-- Loading State -->
        <div v-if="loading" class="text-center">
            <p class="text-lg font-semibold text-gray-700 dark:text-white">Loading data...</p>
        </div>

        <!-- Error State -->
        <div v-if="error" class="text-center text-red-500 dark:text-red-400">
            <p>{{ error }}</p>
        </div>

        <!-- Data Table -->
        <div v-if="nasaData">
            <table class="w-full bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                <thead>
                <tr class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white">
                    <th class="py-3 px-5 text-left">📅 Date</th>
                    <th class="py-3 px-5 text-left">📝 Title</th>
                    <th class="py-3 px-5 text-left">📄 Explanation</th>
                    <th class="py-3 px-5 text-center">🖼️ Image</th>
                </tr>
                </thead>
                <tbody>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">{{ nasaData.date }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 font-semibold">{{ nasaData.title }}</td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600">
                        {{ nasaData.explanation.substring(0, 150) }}...
                    </td>
                    <td class="py-3 px-5 border-b border-gray-300 dark:border-gray-600 text-center">
                        <img :src="nasaData.url" alt="NASA Image" class="rounded-lg shadow-md w-32">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
