import model from './index'
import _ from "lodash";

let state = _.cloneDeep(model.state);

state.name = 'product';

state.fillable = ['name', 'description', 'picture_id', 'article_id', 'category_id', 'producer_id'];

export default {
    namespaced: true,
    state,
    getters: model.getters,
    mutations: model.mutations,
    actions: model.actions,
}
