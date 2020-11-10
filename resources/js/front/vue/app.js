/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
window.Vuex = Vuex;
Vue.use(Vuex);

import VueSweetalert2 from "vue-sweetalert2";
/*import 'sweetalert2/dist/sweetalert2.min.css';*/
Vue.use(VueSweetalert2)

import store from './store.js';

//import Storage from './services/Storage'

Vue.component('cart-view', require('./components/CartView/CartView').default);
//Vue.component('cart-drawer', require('./components/CartDrawer/CartDrawer').default);
Vue.component('cart-nav-icon', require('./components/CartNavIcon/CartNavIcon').default);
Vue.component('add-to-cart-btn', require('./components/AddToCartBtn/AddToCartBtn').default);
//Vue.component('add-to-cart-btn-simple', require('./components/AddToCartBtnSimple/AddToCartBtnSimple').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#agapp',
    store: new Vuex.Store(store)
});


window.ToastSuccess = app.$swal.mixin({
    toast: true,
    icon: 'success',
    position: 'top-end',
    showConfirmButton: false,
    timer: 2500,
})

window.ToastWarning = app.$swal.mixin({
    toast: true,
    icon: 'warning',
    position: 'top-end',
    showConfirmButton: false,
    timer: 2500,
})
