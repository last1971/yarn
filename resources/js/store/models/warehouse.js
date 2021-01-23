import model from './index'
import _ from "lodash";

let state = _.cloneDeep(model.state);

state.name = 'warehouse';

state.newValue = { id: null, name: null, supplier_id: null };

state.fillable = ['name', 'supplier_id'];

export default {
    namespaced: true,
    state,
    getters: model.getters,
    mutations: model.mutations,
    actions: model.actions,
}
