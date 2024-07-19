import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',

				'resources/css/app.css',
				'resources/css/categories.css',

                'resources/js/app.js',
				'resources/js/clients.js',
				'resources/js/suppliers.js',
				'resources/js/categories.js',
				'resources/js/jquery-sortable.js',

				'resources/js/sweetAlert.js',
				'resources/js/generalFunctions.js',
            ],
            refresh: true,
        }),
    ],
});
