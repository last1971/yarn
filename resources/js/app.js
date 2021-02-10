import vuetify from "./vuetify";
import router from "./router";
import store from "./store";
import Vue from "vue";
import VueMeta from 'vue-meta'
Vue.use(VueMeta);

require('./bootstrap');

Vue.component('app', require('./components/App.vue').default);

Vue.filter('formatRub', function (d) {
    return new Intl.NumberFormat('ru-RU', {style: 'currency', currency: 'RUB'}).format(d);
});

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    async created() {
        if (document.head.querySelector('meta[name="token"]')) {
            localStorage.setItem('token', document.head.querySelector('meta[name="token"]').content)
        }
        if (this.$store.getters['AUTH/IS_LOGGEDIN']) {
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
            try {
                await this.$store.dispatch('AUTH/REFRESH');
            } catch (e) {
                await this.$router.push({name: 'login'});
            }
        }
    }
});
