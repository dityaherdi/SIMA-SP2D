
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Signal = new Vue();

import { Form, HasError, AlertError } from 'vform';
import VueRouter from 'vue-router';
import router from './routes.js';
import store from './store';
import { initialize } from './helpers/init';
import './helpers/filter';
import './helpers/alert';
import VueProgressBar from 'vue-progressbar';

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.use(VueRouter);
Vue.use(VueProgressBar, {
    color: 'rgb(66, 206, 244)',
    failedColor: 'red',
    height: '5px'
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('vue-app', require('./components/App.vue'));

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store
});