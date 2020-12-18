import Vue from 'vue';
import Vuex from 'vuex';
import auth from "./auth";
import snackbar from "./snackbar";
import article from "./models/article";
import category from "./models/category";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        ARTICLE: article,
        AUTH: auth,
        CATEGORY: category,
        SNACKBAR: snackbar,
    }
});
