<script setup>



// 📌 Obtener datos del usuario desde Inertia.js
const page = usePage();
const user = computed(() => page.props.auth?.user ?? { name: 'User' });
const profile = computed(() => page.props.profile ?? { dashboard_name: 'BMS Management System' });


import Dropdown from '@/Components/Dropdown.vue';


import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useDarkMode } from '@/utils/theme'; // Importa la función
import {
    Home, Users, Package, ShoppingCart, DollarSign, FileText, Briefcase,
    Settings, ChevronDown, ChevronRight, Bell, Moon, Sun, LogOut, Banknote
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
            <a href="/">  <div class="flex items-center space-x-2 p-4">
                <ApplicationLogo class="w-10 h-10" />
                <span class="text-xl font-bold">BMS ERP</span>
            </div></a>

            <nav class="flex flex-col gap-2 mt-4">
                <router-link to="/dashboard" class="flex items-center gap-3 p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <Home class="w-5 h-5" /> Dashboard
                </router-link>

                <!-- User Management -->
                <div @click="toggleSection('users')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Users class="w-5 h-5" /> User Management
                    </div>
                    <ChevronDown v-if="expandedSections.users" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.users" class="ml-6 flex flex-col gap-2">
                    <router-link to="/UM/customers">👥 Customers</router-link>
                    <router-link to="/UM/employees">👤 Employees</router-link>

                    <router-link to="/users">📝 Registered Users</router-link>
                    <router-link to="/UM/roles">🔑 Roles & Permissions</router-link>
                </div>

                <!-- Inventory -->
                <div @click="toggleSection('inventory')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Package class="w-5 h-5" /> Inventory
                    </div>
                    <ChevronDown v-if="expandedSections.inventory" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.inventory" class="ml-6 flex flex-col gap-2">
                    <router-link to="/inventory/cashbox">🏦 Cash Box</router-link>
                    <router-link to="/inventory/categories">🏷 Categories</router-link>
                    <router-link to="/inventory/products">📦 Products</router-link>
                    <router-link to="/inventory/supplier">🚚 Suppliers</router-link>
                    <router-link to="/inventory/warehouses">🏭 Warehouses</router-link>
                </div>

                <!-- Sales -->
                <div @click="toggleSection('sales')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <DollarSign class="w-5 h-5" /> Sales
                    </div>
                    <ChevronDown v-if="expandedSections.sales" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.sales" class="ml-6 flex flex-col gap-2">
                    <router-link to="/sales/invoices">🧾 Invoicing</router-link>
                    <router-link to="/sales/orders">📑 Orders</router-link>
                    <router-link to="/sales/quotes">📄 Quotes</router-link>
                </div>

                <!-- Human Resources -->
                <div @click="toggleSection('hr')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Briefcase class="w-5 h-5" /> Human Resources
                    </div>
                    <ChevronDown v-if="expandedSections.hr" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.hr" class="ml-6 flex flex-col gap-2">
                    <router-link to="/hr/payroll">💰 Payroll</router-link>
                    <router-link to="/hr/employees">👤 Employees</router-link>
                    <router-link to="/hr/attendance">📊 Attendance</router-link>
                    <router-link to="/hr/benefits">🎁 Benefits</router-link>
                </div>

                <!-- Accounting -->
                <div @click="toggleSection('accounting')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Banknote class="w-5 h-5" /> Accounting
                    </div>
                    <ChevronDown v-if="expandedSections.accounting" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.accounting" class="ml-6 flex flex-col gap-2">
                    <router-link to="/accounting/expenses">📉 Expenses</router-link>
                    <router-link to="/accounting/income">📈 Income</router-link>
                    <router-link to="/accounting/reports">📊 Reports</router-link>
                    <router-link to="/accounting/taxes">💼 Taxes</router-link>
                </div>

                <!-- Purchases -->
                <div @click="toggleSection('purchases')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <ShoppingCart class="w-5 h-5" /> Purchases
                    </div>
                    <ChevronDown v-if="expandedSections.purchases" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.purchases" class="ml-6 flex flex-col gap-2">
                    <router-link to="/purchases/purchases">📑 List</router-link>
                    <router-link to="/purchases/orders">📑 Orders</router-link>
                    <router-link to="/purchases/invoices">🧾 Invoices</router-link>
                </div>

                <!-- Returns -->
                <div @click="toggleSection('returns')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <FileText class="w-5 h-5" /> Returns
                    </div>
                    <ChevronDown v-if="expandedSections.returns" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.returns" class="ml-6 flex flex-col gap-2">
                    <router-link to="/returns/products">📦 Product Returns</router-link>
                    <router-link to="/returns/ordenreturn">📑 Order Returns</router-link>
                </div>


                <!-- Legal -->
                <div @click="toggleSection('legal')" class="flex justify-between items-center cursor-pointer p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <Scale class="w-5 h-5" /> Legal
                    </div>
                    <ChevronDown v-if="expandedSections.legal" class="w-5 h-5" />
                    <ChevronRight v-else class="w-5 h-5" />
                </div>
                <div v-if="expandedSections.legal" class="ml-6 flex flex-col gap-2">
                    <router-link to="/legal/contracts">📜 Contracts</router-link>
                    <router-link to="/legal/compliance">⚖️ Compliance</router-link>
                </div>

                <!-- Settings -->
                <router-link to="/settings">⚙️ Settings</router-link>




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
