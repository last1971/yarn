import vuetify from "./vuetify";

require('./bootstrap');

window.Vue = require('vue');

Vue.component('app', require('./components/App.vue').default);

const app = new Vue({
    el: '#app',
    vuetify,
});
