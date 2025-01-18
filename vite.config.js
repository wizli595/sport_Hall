import {
    defineConfig
} from 'vite';
import symfonyPlugin from 'vite-plugin-symfony';

export default defineConfig({
    plugins: [
        symfonyPlugin(),
    ],
    build: {
        outDir: 'public/build',
        rollupOptions: {
            input: {
                theme: './assets/styles/app.css',
                app: './assets/app.js',
                adminDashboard: './assets/js/adminDashboard.js',
            },
        },
        cssCodeSplit: false,
        assetsInlineLimit: 0,
    },
    server: {
        watch: {
            usePolling: true,
        },
    },
});