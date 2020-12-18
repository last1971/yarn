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
    async created() {
        if (document.head.querySelector('meta[name="token"]')) {
            localStorage.setItem('token', document.head.querySelector('meta[name="token"]').content)
        }
        if (this.$store.getters['AUTH/IS_LOGGEDIN']) {
            window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
            try {
                await this.$store.dispatch('AUTH/REFRESH');
                //await this.$store.dispatch('CATEGORY/GET', '49556882-feb9-4404-ba4b-babb0de83b06');
            } catch (e) {
                this.$router.push({name: 'login'});
            }
        }
    }
});
