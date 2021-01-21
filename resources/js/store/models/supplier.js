import model from './index'
import _ from "lodash";

let state = _.cloneDeep(model.state);

state.name = 'supplier';

state.newValue = { id: null, name: null };

state.fillable = ['name', ];

export default {
    namespaced: true,
    state,
    getters: model.getters,
    mutations: model.mutations,
    actions: model.actions,
}
