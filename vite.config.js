import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,  // Asegura que la página se refresque cuando cambian los assets
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null, // Usar URLs relativas para assets
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        proxy: {
            '/app': 'http://127.0.0.1:8000',  // Proxy para Laravel
        },
        watch: {
            usePolling: true,  // Activar el polling si estás en un entorno como Docker o VM
        },
        hmr: {
            protocol: 'ws',
            host: 'localhost',  // HMR funcionando desde localhost
            port: 3000,  // Puerto 3000 para que coincida con el servidor de Vite
        },
    },
});
