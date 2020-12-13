import vuetify from "./vuetify";
import router from "./router";
import store from "./store";

require('./bootstrap');

window.Vue = require('vue');

Vue.component('app', require('./components/App.vue').default);

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
});
