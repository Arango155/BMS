import { createRouter, createWebHistory } from 'vue-router';

// 📌 Importamos las páginas principales
import Dashboard from '@/Pages/Dash2.vue';
import Users from '@/Pages/Users/Index.vue';
import Profile from '@/Pages/Profile/Edit.vue';

// 📌 Importamos todas las páginas del módulo de Inventario
import Caja from '@/Pages/Inventario/Caja.vue';
import Categorias from '@/Pages/Inventario/Categorias.vue';
import Clientes from '@/Pages/Inventario/Clientes.vue';
import Compras from '@/Pages/Inventario/Compras.vue';
import Cotizaciones from '@/Pages/Inventario/Cotizaciones.vue';
import Devoluciones from '@/Pages/Inventario/Devoluciones.vue';
import Productos from '@/Pages/Inventario/Productos.vue';
import Proveedor from '@/Pages/Inventario/Proveedor.vue';
import UsuariosInventario from '@/Pages/Inventario/Usuarios.vue';
import Ventas from '@/Pages/Inventario/Ventas.vue';
import Ordenes from '@/Pages/Inventario/Ordenes.vue';

const routes = [
    {
        path: '/',
        redirect: '/dashboard', // Redirige automáticamente a dashboard
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,  // Solo carga el componente Dashboard
    },
    {
        path: '/users',
        name: 'users',
        component: Users,  // Solo carga el componente Users
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile,  // Solo carga el componente Profile
    },

    // 📌 Rutas del módulo de Inventario
    {
        path: '/inventario/caja',
        name: 'caja',
        component: Caja,
    },
    {
        path: '/inventario/categorias',
        name: 'categorias',
        component: Categorias,
    },
    {
        path: '/inventario/clientes',
        name: 'clientes',
        component: Clientes,
    },
    {
        path: '/inventario/compras',
        name: 'compras',
        component: Compras,
    },
    {
        path: '/inventario/cotizaciones',
        name: 'cotizaciones',
        component: Cotizaciones,
    },
    {
        path: '/inventario/devoluciones',
        name: 'devoluciones',
        component: Devoluciones,
    },
    {
        path: '/inventario/productos',
        name: 'productos',
        component: Productos,
    },
    {
        path: '/inventario/proveedor',
        name: 'proveedor',
        component: Proveedor,
    },
    {
        path: '/inventario/usuarios',
        name: 'usuarios-inventario',
        component: UsuariosInventario,
    },
    {
        path: '/inventario/ventas',
        name: 'ventas',
        component: Ventas,
    },

    {
        path: '/inventario/ordenes',
        name: 'ordenes',
        component: Ordenes,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
