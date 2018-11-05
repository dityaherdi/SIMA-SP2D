import Vue from 'vue';
import moment from 'moment';
window.moment = moment
const currentYear = moment().format('YYYY');
window.currentYear = currentYear;

Vue.filter('tanggalLokal', function(text) {
    return moment(text).locale('id').format('LL');
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

Vue.filter('cleanKodeSkpd', function(text) {
    return text.slice(0,6)
})

Vue.filter('statusUserInProfile', function(text) {
    if (text==1) {
        return 'Aktif'
    } else {
        return 'Non-Aktif'
    }
})