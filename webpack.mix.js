const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Establecer el directorio público correcto
mix.setPublicPath('public');

// Compilar SCSS a CSS
mix.sass('resources/scss/paper-dashboard.scss', 'css');

// Opcionalmente, establecer la raíz de los recursos para ajustar las rutas de los recursos estáticos
mix.setResourceRoot('/PuntoAcceso/public/');

// Versionado de archivos para cache-busting
mix.version();
