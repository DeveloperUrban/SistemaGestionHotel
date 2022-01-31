
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('dasboard', require('./components/Dasboard.vue'));
Vue.component('piso', require('./components/Piso.vue'));
Vue.component('tipohabitacion', require('./components/Tipohabitacion.vue'));
Vue.component('habitacion', require('./components/Habitacion.vue'));
Vue.component('categoria', require('./components/Categoria.vue'));
Vue.component('subcategoria', require('./components/Subcategoria.vue'));
Vue.component('producto', require('./components/Producto.vue'));
Vue.component('cliente', require('./components/Cliente.vue'));
Vue.component('recepcion', require('./components/Recepcion.vue'));
Vue.component('venta', require('./components/Venta.vue'));

const app = new Vue({
    el: '#app',
    data:{
        menu:0 /*Iniciañlizamos la variable menu en cero */
    }
});
