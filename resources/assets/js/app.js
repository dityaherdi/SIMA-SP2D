
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Signal = new Vue();

import { Form, HasError, AlertError } from 'vform'
import VueRouter from 'vue-router'
import router from './routes.js'
import store from './store'
import { initialize } from './helpers/init'
import './helpers/filter'
import './helpers/alert'
import { getGedung, getRuangan, getRak, getBox, getSkpd, getJenis } from './helpers/getters'
import { createData, readData, updateData, deleteData } from './helpers/operations'
import { showModal, forceCloseModal } from './helpers/modal'
import VueProgressBar from 'vue-progressbar'
import Datepicker from 'vuejs-datepicker'
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'

window.jsPDF = jsPDF
window.html2canvas = html2canvas

Vue.component('datepicker', Datepicker)

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.use(VueRouter);
Vue.use(VueProgressBar, {
    color: 'rgb(66, 206, 244)',
    failedColor: 'red',
    height: '5px'
});

Vue.mixin({
    methods : {
        // dropdown getters
        getGedung,
        getRuangan,
        getRak,
        getBox,
        getSkpd,
        getJenis,

        // data operations
        createData,
        readData,
        updateData,
        deleteData,

        // modal
        showModal,
        forceCloseModal
    }
})

Vue.component('vue-app', require('./components/App.vue'));
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('not-found', require('./components/NotFound.vue'));

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store
});