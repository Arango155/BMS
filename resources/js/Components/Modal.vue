<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

// Definir propiedades
const props = defineProps({
    show: { type: Boolean, default: false },
    maxWidth: { type: String, default: '2xl' },
    closeable: { type: Boolean, default: true },
});

// Emitir eventos
const emit = defineEmits(['close']);

// Bloquear el scroll cuando el modal está abierto
watch(() => props.show, (newVal) => {
    document.body.style.overflow = newVal ? 'hidden' : null;
});

// Función para cerrar el modal
const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

// Cerrar con tecla "Escape"
const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

// Manejo de eventos al montar y desmontar el componente
onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

// Clases de ancho dinámico
const maxWidthClass = computed(() => ({
    sm: 'sm:max-w-sm',
    md: 'sm:max-w-md',
    lg: 'sm:max-w-lg',
    xl: 'sm:max-w-xl',
    '2xl': 'sm:max-w-2xl',
}[props.maxWidth]));
</script>

<template>
    <Teleport to="body">
        <Transition leave-active-class="duration-200">
            <div v-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 flex items-center justify-center">

                <!-- Fondo oscuro con transición suave -->
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="show" class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75 transition-opacity" @click="close"></div>
                </Transition>

                <!-- Contenedor del modal -->
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        v-show="show"
                        class="relative w-full sm:mx-auto rounded-lg shadow-xl transition-all sm:w-full"
                        :class="[maxWidthClass, 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 shadow-lg dark:shadow-gray-900']"
                    >
                        <slot />
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
/* Aplicar efecto de desenfoque en el fondo */
.fixed {
    backdrop-filter: blur(6px);
}

/* Animación sutil en el modal */
.transition-opacity {
    transition: opacity 0.3s ease-in-out !important;
}
</style>
