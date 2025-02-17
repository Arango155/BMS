import { ref, watchEffect, onMounted } from 'vue';

export function useDarkMode() {
    const isDarkMode = ref(localStorage.getItem('darkModePreference') === 'true');

    const applyTheme = () => {
        document.documentElement.classList.toggle('dark', isDarkMode.value);
    };

    const toggleDarkMode = () => {
        isDarkMode.value = !isDarkMode.value;
        localStorage.setItem('darkModePreference', isDarkMode.value);
        applyTheme();
    };

    onMounted(() => {
        applyTheme(); // Aplica el modo guardado al cargar la página
    });

    watchEffect(() => {
        applyTheme(); // Reactivo a cambios en isDarkMode
    });

    return { isDarkMode, toggleDarkMode };
}
