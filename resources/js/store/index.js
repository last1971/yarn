import Vue from 'vue';
import Vuex from 'vuex';
import auth from "./auth";
import snackbar from "./snackbar";
import article from "./models/article";
import category from "./models/category";
import producer from "./models/producer";
import product from "./models/product";
import price from "./models/price";
import parameterName from "./models/parameterName";
import parameterValue from "./models/parameterValue";
import supplier from "./models/supplier";
import warehouse from "./models/warehouse";
import warehouseBalance from "./models/warehouseBalance";

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
        'PARAMETER-NAME': parameterName,
        'PARAMETER-VALUE': parameterValue,
        PRICE: price,
        PRODUCER: producer,
        PRODUCT: product,
        SNACKBAR: snackbar,
        SUPPLIER: supplier,
        WAREHOUSE: warehouse,
        'WAREHOUSE-BALANCE': warehouseBalance,
    }
});
