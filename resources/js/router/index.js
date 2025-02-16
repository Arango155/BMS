import { createRouter, createWebHistory } from 'vue-router';

// 📌 Import main pages
import Dashboard from '@/Pages/Dash2.vue';
import Users from '@/Pages/Users/Index.vue';
import Profile from '@/Pages/Profile/Edit.vue';

// 📌 Import all pages from the Inventory module
import CashBox from '@/Pages/Inventory/CashBox.vue';
import Categories from '@/Pages/Inventory/Categories.vue';
import Customers from '@/Pages/UM/Customers.vue';
import Products from '@/Pages/Inventory/Products.vue';
import Supplier from '@/Pages/Inventory/Supplier.vue';
import InventoryUsers from '@/Pages/UM/Users.vue';
import Sales from '@/Pages/Inventory/Sales.vue';

// 📌 Import pages for Purchases and Orders
import Purchases from '@/Pages/Purchases/Purchases.vue';
import Orders from '@/Pages/Purchases/Orders.vue';

// 📌 Import pages for Sales and Quotes
import Quotes from '@/Pages/Sales/Quotes.vue';

// 📌 Import pages for Returns
import OrdenReturn from '@/Pages/Returns/OrdenReturn.vue';

const routes = [
    {
        path: '/',
        redirect: '/dashboard', // Automatically redirects to the dashboard
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard, // Loads only the Dashboard component
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile, // Loads only the Profile component
    },

    // 📌 Users module routes
    {
        path: '/users',
        name: 'users',
        component: Users,
    },
    {
        path: '/UM/customers',
        name: 'customers',
        component: Customers,
    },
    {
        path: '/inventory/users',
        name: 'inventory-users',
        component: InventoryUsers,
    },

    // 📌 Inventory module routes
    {
        path: '/inventory/cashbox',
        name: 'cashbox',
        component: CashBox,
    },
    {
        path: '/inventory/categories',
        name: 'categories',
        component: Categories,
    },
    {
        path: '/inventory/products',
        name: 'products',
        component: Products,
    },
    {
        path: '/inventory/supplier',
        name: 'supplier',
        component: Supplier,
    },
    {
        path: '/inventory/sales',
        name: 'sales',
        component: Sales,
    },

    // 📌 Purchases module routes
    {
        path: '/purchases/purchases',
        name: 'purchases',
        component: Purchases,
    },
    {
        path: '/purchases/orders',
        name: 'orders',
        component: Orders,
    },

    // 📌 Sales module routes
    {
        path: '/sales/quotes',
        name: 'quotes',
        component: Quotes,
    },

    // 📌 Returns module routes
    {
        path: '/returns/ordenreturn',
        name: 'ordenreturn',
        component: OrdenReturn,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
