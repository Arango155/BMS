<script setup>



// 📌 Obtener datos del usuario desde Inertia.js
const page = usePage();
const user = computed(() => page.props.auth?.user ?? { name: 'User' });
const profile = computed(() => page.props.profile ?? { dashboard_name: 'BMS Management System' });


import Dropdown from '@/Components/Dropdown.vue';

import ApplicationLogo from '@/Components/ApplicationLogo.vue';

import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useDarkMode } from '@/utils/theme'; // Importa la función
import {
    Home, PackageCheck ,Users, Truck, Wrench, Package, ShoppingCart, DollarSign, FileText, Briefcase,
    Settings, ChevronDown, ChevronRight, Bell, Moon, Sun, LogOut, Banknote, FileSignature
} from 'lucide-vue-next';

// 📌 Modo oscuro
const { isDarkMode, toggleDarkMode } = useDarkMode();


const expandedSections = ref({
    inventory: false,
    sales: false,
    purchases: false,
    accounting: false,
    hr: false,
    users: false,
    legal: false,
    logistics: false,
    crm: false
});

const toggleSection = (section) => {
    expandedSections.value[section] = !expandedSections.value[section];
};
</script>

<template>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <aside class="w-72 p-4 border-r border-gray-200 dark:border-gray-700 min-h-screen">
            <a href="/">
                <div class="flex items-center space-x-2 p-4">
                    <ApplicationLogo class="w-10 h-10" />
                    <span class="text-xl font-bold">BMS ERP</span>
                </div>
            </a>

            <nav class="flex flex-col gap-2 mt-4">
                <router-link to="/dashboard" class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <Home class="w-5 h-5" /> Inicio
                </router-link>
                <router-link to="/nasa" class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    Consumir API
                </router-link>


                <!-- Gestión de Usuarios -->
                <div @click="toggleSection('users')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Users class="w-5 h-5" /> Gestión de Usuarios
                    </div>
                    <ChevronDown v-if="expandedSections.users" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.users" class="ml-6 flex flex-col gap-2">
                    <router-link to="/UM/customers">👥 Clientes</router-link>
                    <router-link to="/UM/employees">👤 Empleados</router-link>
                    <router-link to="/users">📝 Usuarios Registrados</router-link>
                    <router-link to="/UM/roles">🔑 Roles y Permisos</router-link>
                </div>

                <!-- Inventario -->
                <div @click="toggleSection('inventory')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Package class="w-5 h-5" /> Inventario
                    </div>
                    <ChevronDown v-if="expandedSections.inventory" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.inventory" class="ml-6 flex flex-col gap-2">
                    <router-link to="/inventory/cashbox">🏦 Caja</router-link>
                    <router-link to="/inventory/categories">🏷 Categorías</router-link>
                    <router-link to="/inventory/products">📦 Productos</router-link>
                    <router-link to="/inventory/supplier">🚚 Proveedores</router-link>
                    <router-link to="/inventory/warehouses">🏭 Almacenes</router-link>
                </div>

                <!-- Ventas -->
                <div @click="toggleSection('sales')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <DollarSign class="w-5 h-5" /> Ventas
                    </div>
                    <ChevronDown v-if="expandedSections.sales" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.sales" class="ml-6 flex flex-col gap-2">
                    <router-link to="/sales/invoices">🧾 Facturación</router-link>
                    <router-link to="/sales/orders">📑 Pedidos</router-link>
                    <router-link to="/sales/quotes">📄 Cotizaciones</router-link>
                </div>

                <!-- Recursos Humanos -->
                <div @click="toggleSection('hr')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Briefcase class="w-5 h-5" /> Recursos Humanos
                    </div>
                    <ChevronDown v-if="expandedSections.hr" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.hr" class="ml-6 flex flex-col gap-2">
                    <router-link to="/hr/payroll">💰 Nómina</router-link>
                    <router-link to="/hr/employees">👤 Empleados</router-link>
                    <router-link to="/hr/attendance">📊 Asistencia</router-link>
                    <router-link to="/hr/benefits">🎁 Beneficios</router-link>
                </div>

                <!-- Contabilidad -->
                <div @click="toggleSection('accounting')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Banknote class="w-5 h-5" /> Contabilidad
                    </div>
                    <ChevronDown v-if="expandedSections.accounting" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.accounting" class="ml-6 flex flex-col gap-2">
                    <router-link to="/accounting/expenses">📉 Gastos</router-link>
                    <router-link to="/accounting/income">📈 Ingresos</router-link>
                    <router-link to="/accounting/reports">📊 Reportes</router-link>
                    <router-link to="/accounting/taxes">💼 Impuestos</router-link>
                    <router-link to="/finance/accounting">📊 Contabilidad General</router-link>
                    <router-link to="/finance/budgeting">💰 Gestión de Presupuestos</router-link>
                    <router-link to="/finance/treasury">🏦 Tesorería</router-link>
                    <router-link to="/finance/reports">📑 Reportes Fiscales</router-link>

                </div>

                <!-- Compras -->
                <div @click="toggleSection('purchases')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <ShoppingCart class="w-5 h-5" /> Compras
                    </div>
                    <ChevronDown v-if="expandedSections.purchases" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.purchases" class="ml-6 flex flex-col gap-2">
                    <router-link to="/purchases/purchases">📑 Lista de Compras</router-link>
                    <router-link to="/purchases/orders">📑 Órdenes</router-link>
                    <router-link to="/purchases/invoices">🧾 Facturas</router-link>
                </div>

                <!-- Devoluciones -->
                <div @click="toggleSection('returns')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <PackageCheck class="w-5 h-5" /> Devoluciones
                    </div>
                    <ChevronDown v-if="expandedSections.returns" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.returns" class="ml-6 flex flex-col gap-2">
                    <router-link to="/returns/products">📦 Devolución de Productos</router-link>
                    <router-link to="/returns/ordenreturn">📑 Devolución de Órdenes</router-link>
                </div>


                <!-- Sección Legal con más módulos y subpestañas -->
                <div @click="toggleSection('legal')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <FileSignature class="w-5 h-5" /> Legal
                    </div>
                    <ChevronDown v-if="expandedSections.legal" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.legal" class="ml-6 flex flex-col gap-2">
                    <router-link to="/legal/contracts">📜 Contratos</router-link>
                    <router-link to="/legal/compliance">⚖️ Cumplimiento Normativo</router-link>
                    <router-link to="/legal/litigation">⚖️ Litigios y Disputas</router-link>
                    <router-link to="/legal/intellectual-property">📄 Propiedad Intelectual</router-link>
                    <router-link to="/legal/regulations">📑 Regulaciones y Políticas</router-link>
                    <router-link to="/legal/risk-management">🚨 Gestión de Riesgos Legales</router-link>
                    <router-link to="/legal/legal-reports">📊 Informes Legales</router-link>
                    <router-link to="/legal/documents">📂 Documentos Legales</router-link>
                </div>



                <!-- Producción y Operaciones -->
                <div @click="toggleSection('production')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Settings class="w-5 h-5" /> Producción & Operaciones
                    </div>
                    <ChevronDown v-if="expandedSections.production" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.production" class="ml-6 flex flex-col gap-2">
                    <router-link to="/production/orders">📋 Órdenes de Producción</router-link>
                    <router-link to="/production/quality">✅ Control de Calidad</router-link>
                    <router-link to="/production/resources">⚙️ Gestión de Recursos</router-link>
                </div>

                <!-- Logística y Cadena de Suministro -->
                <div @click="toggleSection('logistics')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Truck class="w-5 h-5" /> Logística & Suministro
                    </div>
                    <ChevronDown v-if="expandedSections.logistics" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.logistics" class="ml-6 flex flex-col gap-2">
                    <router-link to="/logistics/shipments">🚛 Planificación de Envíos</router-link>
                    <router-link to="/logistics/warehouse">🏭 Gestión de Almacenes</router-link>
                    <router-link to="/logistics/routing">🗺️ Optimización de Rutas</router-link>
                </div>

                <!-- Gestión de Activos y Mantenimiento -->
                <div @click="toggleSection('assets')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Wrench class="w-5 h-5" /> Activos & Mantenimiento
                    </div>
                    <ChevronDown v-if="expandedSections.assets" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.assets" class="ml-6 flex flex-col gap-2">
                    <router-link to="/assets/machinery">🔧 Gestión de Equipos</router-link>
                    <router-link to="/assets/maintenance">🛠️ Mantenimiento</router-link>
                    <router-link to="/assets/replacements">♻️ Reemplazo de Activos</router-link>
                </div>

                <!-- Gestión Documental -->
                <div @click="toggleSection('documents')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <FileText class="w-5 h-5" /> Documentación
                    </div>
                    <ChevronDown v-if="expandedSections.documents" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.documents" class="ml-6 flex flex-col gap-2">
                    <router-link to="/documents/storage">📂 Almacenamiento</router-link>
                    <router-link to="/documents/security">🔒 Seguridad & Permisos</router-link>
                    <router-link to="/documents/legal">⚖️ Documentos Legales</router-link>
                </div>

                <!-- Configuración -->
                <router-link to="/settings">⚙️ Configuración</router-link>
            </nav>
        </aside>


        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Head Section -->
            <nav class="p-4 flex justify-between items-center">
                <div class="text-lg font-bold">{{ profile.dashboard_name || 'BMS Management System' }}</div>

                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button
                        @click="toggleDarkMode"
                        class="p-2 rounded-full transition-all duration-300 ease-in-out bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 shadow-md shadow-gray-400 dark:shadow-gray-900"
                    >
                        <Moon v-if="!isDarkMode" class="w-5 h-5 text-gray-700" />
                        <Sun v-else class="w-5 h-5 text-yellow-400" />
                    </button>

                    <!-- Notifications Bell -->
                    <button class="p-2 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        <Bell />
                    </button>

                    <!-- User Dropdown -->
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md focus:outline-none transition">
                                {{ user?.name || 'User' }}
                                <ChevronDown class="w-4 h-4 ml-2" />
                            </button>
                        </template>
                        <template #content>
                            <div class="shadow-md rounded-md p-2 w-48">
                                <router-link
                                    to="/profile"
                                    class="block px-4 py-2 rounded-md transition">
                                    👤 Profile
                                </router-link>

                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="flex items-center w-full px-4 py-2 text-left rounded-md transition">
                                    <LogOut class="w-5 h-5 mr-2" /> Logout
                                </DropdownLink>
                            </div>
                        </template>


                    </Dropdown>
                </div>
            </nav>

            <main class="flex-1 p-8">
                <router-view />
            </main>
        </div>
    </div>
    <Footer></Footer>
</template>
