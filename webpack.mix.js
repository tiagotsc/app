const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);

mix.styles([
    'resources/css/customized.css'
], 'public/css/customized.min.css');

/**
 * Inclui icones bootstrap
 */
mix.sass('resources/sass/app.scss', 'public/css/additional_template.css');

/**
 * Alpine Script usado em todo o sistema
 */
mix.scripts([
    'resources/js/alpinejs.main.js'
], 'public/js/alpinejs.main.min.js');

/**
 * Util - funções utilizadas em todo o sistema
 */
mix.scripts([
    'resources/js/util.js'
], 'public/js/util.min.js'); 

/**
 * Usuário
 */
 mix.scripts([
    'resources/js/users/alpinejs.frm.js'
], 'public/js/users/alpinejs.frm.min.js'); // Script Alpine
mix.scripts([
    'resources/js/users/frm.js'
], 'public/js/users/frm.min.js'); // Script Jquery
mix.scripts([
    'resources/js/users/index.js'
], 'public/js/users/index.min.js'); // Script Jquery

/**
 * Permissões
 */
 mix.scripts([
    'resources/js/permissions/alpinejs.frm.js'
], 'public/js/permissions/alpinejs.frm.min.js'); // Script Alpine
mix.scripts([
    'resources/js/permissions/frm.js'
], 'public/js/permissions/frm.min.js'); // Script Jquery
mix.scripts([
    'resources/js/permissions/index.js'
], 'public/js/permissions/index.min.js'); // Script Jquery

/**
 * Perfis
 */
 mix.scripts([
    'resources/js/roles/alpinejs.frm.js'
], 'public/js/roles/alpinejs.frm.min.js'); // Script Alpine
mix.scripts([
    'resources/js/roles/frm.js'
], 'public/js/roles/frm.min.js'); // Script Jquery
mix.scripts([
    'resources/js/roles/index.js'
], 'public/js/roles/index.min.js'); // Script Jquery

/**
 * Carteira
 */
 mix.scripts([
    'resources/js/wallet/alpinejs.frm.js'
], 'public/js/wallet/alpinejs.frm.min.js'); // Script Alpine
mix.scripts([
    'resources/js/wallet/frm.js'
], 'public/js/wallet/frm.min.js'); // Script Jquery
mix.scripts([
    'resources/js/wallet/index.js'
], 'public/js/wallet/index.min.js'); // Script Jquery

