<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

// Crear el formulario con todos los campos vacíos
const form = useForm({
    dashboard_name: "",
    empresa_nombre: "",
    empresa_tipo: "",
    modulos: [],
    onboarding_completo: false,
});

const currentStep = ref(1); // Controla en qué paso estamos
const isSubmitting = ref(false);
const statusMessage = ref("");

// Tipos de empresa disponibles
const companyTypes = [
    { title: "Microempresa", icon: "text-green-500" },
    { title: "Pequeña", icon: "text-blue-500" },
    { title: "Mediana", icon: "text-yellow-500" },
    { title: "Grande", icon: "text-red-500" },
];

// Flags para comprobar si se ha hecho una selección
const isCompanyTypeSelected = ref(false);
const isModuleSelected = ref(false);

// Funciones de selección
const selectCompanyType = (type) => {
    form.empresa_tipo = type.title;
    isCompanyTypeSelected.value = true; // Marca que se ha seleccionado un tipo de empresa
};

const selectModule = (module) => {
    // Si el módulo ya está seleccionado, lo eliminamos, si no lo está lo agregamos
    const index = form.modulos.indexOf(module.title);
    if (index > -1) {
        // Eliminar módulo si ya estaba seleccionado
        form.modulos = form.modulos.replace(module.title, "").trim().replace(/\s+/g, ',');
    } else {
        // Agregar módulo si no estaba seleccionado
        form.modulos += form.modulos ? `, ${module.title}` : module.title;
    }

    // Actualizamos el estado de la selección del módulo
    isModuleSelected.value = form.modulos.length > 0;
};


// Lógica para avanzar al siguiente paso
const nextStep = () => {
    if (currentStep.value === 4 && !isModuleSelected.value) {
        statusMessage.value = "Debes seleccionar al menos un módulo para continuar.";
        return;
    }

    if (currentStep.value < 4) {
        currentStep.value++;
        statusMessage.value = ""; // Limpiar mensaje al avanzar
    }
};

// Enviar formulario
const submit = () => {
    if (!form.empresa_nombre || !form.empresa_tipo) {
        statusMessage.value = "Todos los campos son obligatorios.";
        return;
    }

    isSubmitting.value = true;
    statusMessage.value = "Enviando...";

    form.post("/onboarding", {
        onSuccess: () => {
            statusMessage.value = "Onboarding completado correctamente.";
            setTimeout(() => {
                window.location.href = "/dashboard";
            }, 1000);
        },
        onError: (errors) => {
            statusMessage.value = "Error al completar el onboarding.";
            console.error(errors);
            isSubmitting.value = false;
        }
    });
};

// Definir módulos
const modules = [
    { icon: "bi bi-cart", title: "Procurement", description: "Gestiona los procesos de compras y relaciones con proveedores." },
    { icon: "bi bi-cash-stack", title: "Finanzas y Contabilidad", description: "Gestiona transacciones financieras, informes y presupuestos." },
    { icon: "bi bi-people", title: "Gestión de Capital Humano", description: "Gestiona registros de empleados, nómina, y más." },
    // Agregar más módulos según sea necesario
];
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <h2 class="text-center text-3xl font-extrabold text-gray-900">Completa tu perfil</h2>

            <!-- Pasos de onboarding -->
            <div v-if="currentStep === 1" class="bg-white p-8 rounded-lg shadow-md">
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-700">¿Cuál es el nombre de tu dashboard?</h3>
                    <input type="text" v-model="form.dashboard_name" class="mt-4 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button @click="nextStep" :disabled="!form.dashboard_name" class="mt-6 w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Siguiente
                    </button>
                </div>
            </div>

            <div v-if="currentStep === 2" class="bg-white p-8 rounded-lg shadow-md">
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-700">¿Cuál es el nombre de tu empresa?</h3>
                    <input type="text" v-model="form.empresa_nombre" class="mt-4 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button @click="nextStep" :disabled="!form.empresa_nombre" class="mt-6 w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Siguiente
                    </button>
                </div>
            </div>

            <div v-if="currentStep === 3" class="bg-white p-8 rounded-lg shadow-md">
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-700">¿Qué tipo de empresa eres?</h3>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div class="card" v-for="(type, index) in companyTypes" :key="index" @click="selectCompanyType(type)">
                            <i class="bi bi-building" :class="type.icon"></i>
                            <span class="font-bold">{{ type.title }}</span>
                        </div>
                    </div>
                    <button @click="nextStep" :disabled="!isCompanyTypeSelected" class="mt-6 w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Confirmar selección y continuar
                    </button>
                </div>
            </div>

            <div v-if="currentStep === 4" class="bg-white p-8 rounded-lg shadow-md">
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-700">¿Qué módulos necesitas?</h3>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div class="card" v-for="(module, index) in modules" :key="index" @click="selectModule(module)" :class="{'selected': form.modulos.includes(module.title)}">
                            <i :class="module.icon"></i>
                            <span class="font-bold">{{ module.title }}</span>
                            <p class="text-sm">{{ module.description }}</p>
                        </div>
                    </div>
                    <button @click="submit" :disabled="!isModuleSelected" class="mt-6 w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Confirmar selección y continuar
                    </button>
                </div>
            </div>

            <!-- Mensaje de estado -->
            <p v-if="statusMessage" class="mt-4 text-sm text-center"
               :class="statusMessage.includes('Error') ? 'text-red-500' : 'text-green-500'">
                {{ statusMessage }}
            </p>
        </div>
    </div>
</template>

<style scoped>
button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.card {
    cursor: pointer;
    padding: 16px;
    border-radius: 8px;
    border: 2px solid #ddd;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: all 0.3s ease;
}

.card:hover {
    transform: scale(1.05);
    border-color: #4CAF50;
}

.card.selected {
    border-color: #4CAF50;
    background-color: #f1f9f3;
}

i {
    font-size: 36px;
    margin-bottom: 8px;
}

.card .font-bold {
    font-size: 1.25rem;
    margin-top: 8px;
}
</style>
