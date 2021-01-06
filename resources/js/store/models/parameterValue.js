import model from './index'
import _ from "lodash";

let state = _.cloneDeep(model.state);

state.name = 'parameter-value';

state.fillable = [
    'product_id',
    'parameter_name_id',
    'parameter_unit_id',
    'numeric_value',
    'fraction',
    'string_value'
];

export default {
    namespaced: true,
    state,
    getters: model.getters,
    mutations: model.mutations,
    actions: model.actions,
}
