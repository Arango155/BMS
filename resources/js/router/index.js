import { createRouter, createWebHistory } from 'vue-router';

// 📌 Import main pages
import Dashboard from '@/Pages/Dash2.vue';
import Profile from '@/Pages/Profile/Edit.vue';

// 📌 Import all pages from the Users module
import Users from '@/Pages/Users/Index.vue';
import Customers from '@/Pages/UM/Customers.vue';
import InventoryUsers from '@/Pages/UM/Users.vue';
import Roles from '@/Pages/UM/Roles.vue';  // Assuming a page for roles & permissions exists

// 📌 Import all pages from the Inventory module
import CashBox from '@/Pages/Inventory/CashBox.vue';
import Categories from '@/Pages/Inventory/Categories.vue';
import Products from '@/Pages/Inventory/Products.vue';
import Supplier from '@/Pages/Inventory/Supplier.vue';
import Warehouses from '@/Pages/Inventory/Warehouses.vue';  // Assuming a page for warehouses exists
import Sales from '@/Pages/Sales/Sales.vue';

// 📌 Import pages for Purchases module
import Purchases from '@/Pages/Purchases/Purchases.vue';
import Orders from '@/Pages/Purchases/Orders.vue';
import Invoices from '@/Pages/Purchases/Invoices.vue';  // Assuming a page for invoices exists

// 📌 Import pages for Sales module
import Quotes from '@/Pages/Sales/Quotes.vue';
import InvoicesSales from '@/Pages/Sales/Invoicing.vue';  // Assuming a page for invoicing exists

// 📌 Import pages for Returns module
import OrdenReturn from '@/Pages/Returns/OrdenReturn.vue';
import ProductReturns from '@/Pages/Returns/ProductReturns.vue';  // Assuming a page for product returns exists

// 📌 Import pages for HR module
import Payroll from '@/Pages/HR/Payroll.vue';
import EmployeesHR from '@/Pages/HR/Employees.vue';  // Assuming a page for HR employees exists
import Attendance from '@/Pages/HR/Attendance.vue';  // Assuming a page for attendance exists
import Benefits from '@/Pages/HR/Benefits.vue';  // Assuming a page for benefits exists

// 📌 Import pages for Accounting module
import Expenses from '@/Pages/Accounting/Expenses.vue';
import Income from '@/Pages/Accounting/Income.vue';
import Reports from '@/Pages/Accounting/Reports.vue';
import Taxes from '@/Pages/Accounting/Taxes.vue';

// 📌 Import pages for Legal module
import Contracts from '@/Pages/Legal/Contracts.vue';
import Compliance from '@/Pages/Legal/Compliance.vue';

// 📌 Import pages for Settings
// import Settings from '@/Pages/Settings.vue';

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
        path: '/UM/employees',
        name: 'employees',
        component: InventoryUsers, // Assuming you have a page for employees
    },
    {
        path: '/UM/roles',
        name: 'roles',
        component: Roles,
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
        path: '/inventory/warehouses',
        name: 'warehouses',
        component: Warehouses,
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
    {
        path: '/purchases/invoices',
        name: 'purchases-invoices',
        component: Invoices,
    },

    // 📌 Sales module routes
    {
        path: '/sales/quotes',
        name: 'quotes',
        component: Quotes,
    },
    {
        path: '/sales/invoices',
        name: 'sales-invoices',
        component: InvoicesSales,
    },

    // 📌 Returns module routes
    {
        path: '/returns/ordenreturn',
        name: 'ordenreturn',
        component: OrdenReturn,
    },
    {
        path: '/returns/products',
        name: 'product-returns',
        component: ProductReturns,
    },

    // 📌 HR module routes
    {
        path: '/hr/payroll',
        name: 'payroll',
        component: Payroll,
    },
    {
        path: '/hr/employees',
        name: 'hr-employees',
        component: EmployeesHR,
    },
    {
        path: '/hr/attendance',
        name: 'attendance',
        component: Attendance,
    },
    {
        path: '/hr/benefits',
        name: 'benefits',
        component: Benefits,
    },

    // 📌 Accounting module routes
    {
        path: '/accounting/expenses',
        name: 'expenses',
        component: Expenses,
    },
    {
        path: '/accounting/income',
        name: 'income',
        component: Income,
    },
    {
        path: '/accounting/reports',
        name: 'reports',
        component: Reports,
    },
    {
        path: '/accounting/taxes',
        name: 'taxes',
        component: Taxes,
    },

    // 📌 Legal module routes
    {
        path: '/legal/contracts',
        name: 'contracts',
        component: Contracts,
    },
    {
        path: '/legal/compliance',
        name: 'compliance',
        component: Compliance,
    },

    // 📌 Settings
    // {
    //     path: '/settings',
    //     name: 'settings',
    //     component: Settings,
    // },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
