import model from './index'
import _ from "lodash";

let state = _.cloneDeep(model.state);

state.name = 'producer';

state.fillable = ['name', 'description', 'picture_id', 'article_id', 'site'];

export default {
    namespaced: true,
    state,
    getters: model.getters,
    mutations: model.mutations,
    actions: model.actions,
}
