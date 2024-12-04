import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',

				'resources/css/app.css',
				'resources/css/categories.css',
                'resources/sass/invoices.scss',
                'resources/sass/projects.scss',
                'resources/sass/calendar.scss',
                'resources/sass/utilities.scss',

                'resources/js/app.js',
                'resources/js/tinymce.js',

				'resources/js/clients.js',
				'resources/js/suppliers.js',
				'resources/js/categories.js',
                'resources/js/invoices.js',
                'resources/js/invoicesIndex.js',
                'resources/js/payments.js',
                'resources/js/materials.js',
                'resources/js/workers.js',
                'resources/js/projectsIndex.js',

				'resources/js/jquery-sortable.js',

				'resources/js/sweetAlert.js',
				'resources/js/generalFunctions.js',
                'resources/js/autocomplete.js',
            ],
            refresh: true,
        }),
    ],
});
