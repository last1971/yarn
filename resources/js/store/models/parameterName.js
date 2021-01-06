import model from './index'
import _ from "lodash";

let state = _.cloneDeep(model.state);

state.name = 'parameter-name';

state.fillable = ['name', 'type', 'parameter_unit_id'];

export default {
    namespaced: true,
    state,
    getters: model.getters,
    mutations: model.mutations,
    actions: model.actions,
}
