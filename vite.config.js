import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import imagemin from 'vite-plugin-imagemin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        imagemin({
            // Compresión de imágenes
            gifsicle: {
                optimizationLevel: 3,
            },
            mozjpeg: {
                quality: 80,
            },
            pngquant: {
                quality: [0.7, 0.8],
            },
            webp: {
                quality: 80,
            },
        }),
    ],
    build: {
        minify: 'terser',
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs'],
                },
            },
        },
        assetsInlineLimit: 4096,
        cssCodeSplit: true,
        sourcemap: false,
    },
    server: {
        hmr: {
            overlay: true,
        },
    },
    optimizeDeps: {
        include: ['alpinejs'],
    },
});
