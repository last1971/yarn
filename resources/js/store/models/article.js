import model from './index'
import _ from "lodash";

let state = _.cloneDeep(model.state);

state.name = 'article';

state.fillable = ['name', 'content'];

export default {
    namespaced: true,
    state,
    getters: model.getters,
    mutations: model.mutations,
    actions: model.actions,
}
