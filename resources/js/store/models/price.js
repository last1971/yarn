import model from './index'
import _ from "lodash";

let state = _.cloneDeep(model.state);

state.name = 'price';

state.fillable = ['min', 'product_id', 'price'];

export default {
    namespaced: true,
    state,
    getters: model.getters,
    mutations: model.mutations,
    actions: model.actions,
}
