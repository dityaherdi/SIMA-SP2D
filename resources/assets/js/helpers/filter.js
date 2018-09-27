import Vue from 'vue';
import moment from 'moment';

const currentYear = moment().format('YYYY');
window.currentYear = currentYear;

Vue.filter('userCreatedDate', function(created) {
    return moment(created).locale('id').format('LL');
})

Vue.filter('breadcrumbActive', function(text) {
    return text.charAt(1).toUpperCase() + text.slice(2);
})

Vue.filter('uppercase', function(text) {
    return text.toUpperCase();
})

Vue.filter('noDash', function(text) {
    return text.replace(/-/g, ' ');
})