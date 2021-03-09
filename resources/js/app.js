
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
require('../assets/js/inspinia');
require('vue-loading-overlay/dist/vue-loading.css');

window.Vue = require('vue');
window.lang = document.documentElement.lang.substr(0, 2);
window.VueInternationalization = require('vue-i18n').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.use(VueInternationalization);

const i18n = new VueInternationalization({
    locale: lang,
    fallbackLocale: 'id',
    // messages: Locales
});

Vue.component('select2', require('./components/Select2.vue').default);
Vue.component('select2-ajax', require('./components/Select2Ajax').default);
Vue.component('select2-ajax-child', require('./components/Select2AjaxChild').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('vue-loading-overlay', require('vue-loading-overlay'));

Vue.component('products-create', require('./components/products/Create').default);
Vue.component('products-edit', require('./components/products/Edit').default);
Vue.component('products-adjust', require('./components/products/Adjust').default);
Vue.component('transaction-ins-create', require('./components/transaction_ins/Create').default);
Vue.component('transaction-ins-edit', require('./components/transaction_ins/Edit').default);
Vue.component('transaction-outs-create', require('./components/transaction_outs/Create').default);
Vue.component('transaction-outs-edit', require('./components/transaction_outs/Edit').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: 'body>#wrapper',
    i18n
});

window.app = app;
