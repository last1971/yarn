const state = {
    name: '',
    keyType: String,
    key: 'id',
    items: [],
    fillable: [],
};

const getters = {
    NAME: state => state.name,
    KEY: state => state.key,
    KEYTYPE: state => state.keyType,
    URL: state => `/api/${state.name}`,
    GET: state => (id) => {
        return _.isArray(id)
            ? state.items.filter(
                (item) => id.indexOf(state.keyType === Number ? parseInt(item[state.key]) : item[state.key]) >= 0
            )
            : _.find(state.items, {[state.key]: state.keyType === Number ? parseInt(id) : id}) || null
    },
    ALL: state => state.items,
    FILLABLE: state => state.fillable,
};

const mutations = {
    CLEAR(state) {
        state.items = [];
    },

    SET(state, newData) {
        if (!_.isArray(newData)) {
            const error = 'Data must be an array but ' + typeof newData + ' given.';
            this.commit('SNACKBAR/ERROR', error);
            throw new Error(error);
        }
        state.items = _.cloneDeep(newData);
    },

    MERGE(state, mergeData) {
        if (!_.isArray(mergeData)) {
            const error = 'Data must be an array but ' + typeof newData + ' given.';
            this.commit('SNACKBAR/ERROR', error);
            throw new Error(error);
        }
        state.items = _.unionBy(mergeData, state.items, state.key);
    },

    CREATE(state, newDataRow) {
        if (!newDataRow[state.key]) {
            const error = 'New row of ' + state.name + ' must have key';
            this.commit('SNACKBAR/ERROR', error);
            throw new Error(error);
        }
        state.items.push(_.cloneDeep(newDataRow));
    },

    UPDATE(state, newDataRow) {
        let index = _.findIndex(state.items, {[state.key]: newDataRow[state.key]});
        if (index >= 0) {
            state.items.splice(index, 1, _.cloneDeep(newDataRow));
        } else if (!newDataRow[state.key]) {
            const error = 'New row of ' + state.name + ' must have key';
            this.commit('SNACKBAR/ERROR', error);
            throw new Error(error);
        } else {
            state.items.push(_.cloneDeep(newDataRow));
        }
    },

    REMOVE(state, removeData) {
        const key = typeof removeData === 'object' ? removeData[state.key] : removeData;
        if (!key) {
            const error = 'Wrong key value ' + key + ' for ' + state.name;
            this.commit('SNACKBAR/ERROR', error);
            throw new Error(error);
        }
        const index = _.findIndex(state.items, {[state.key]: key});
        if (index < 0) {
        //    const error = 'Imposible remove ' + state.name + ' with key ' + key;
        //    this.commit('SNACKBAR/ERROR', error);
        //    throw new Error(error);
        } else {
            state.items.splice(index, 1);
        }
    },
};

let actions = {
    CACHE({getters, commit, dispatch}, payload) {
        let id = typeof payload === 'object' ? payload.id : payload;
        const res = getters.GET(id);
        if (res) return Promise.resolve(res);
        return dispatch('GET', payload);

    },
    GET({state, getters, commit}, payload) {
        const id = typeof payload === 'object' ? payload.id : payload;
        return new Promise((resolve, reject) => {
            axios
                .get(getters.URL + '/' + id)
                .then(response => {
                    commit('MERGE', [response.data.data || response.data]);
                    resolve(response.data.data || response.data)
                })
                .catch((error) => {
                    commit('SNACKBAR/ERROR', error.response.data.message, {root: true});
                    reject(error);
                });
        });
    },
    async ALL({state, getters, commit}, payload) {
        try {
            const query = _.cloneDeep(payload);
            const response = await axios.get(getters.URL, { params: query });
            if (response.data.data && response.data.data.length > 0) {
                commit('MERGE', response.data.data);
            }
            return {
                itemIds: response.data.data.map((item) => item[state.key]),
                copyItems: response.data.data,
                total: response.data.total !== undefined ? response.data.total : response.data.meta.total
            }
        } catch (error) {
            commit('SNACKBAR/ERROR', error.response.data.message, {root: true});
            throw error;
        }
    },
    REMOVE({getters, commit}, id) {
        return new Promise((resolve, reject) => {
            axios.delete(getters.URL + '/' + id)
                .then((response) => {
                    commit(
                        'SNACKBAR/SET',
                        {
                            text: getters.NAME + ' with id ' + id + ' was deleted.',
                            color: 'success',
                            status: true,
                            timeout: 3000
                        },
                        {root: true}
                    );
                    commit('REMOVE', id);
                    resolve(response);
                })
                .catch((error) => {
                    commit('SNACKBAR/ERROR', error.response.data.message, {root: true});
                    reject(error);
                });
        });
    },
    CREATE({state, getters, commit, rootGetters}, payload) {
        const create = _.pick(payload,  getters.FILLABLE);
        return new Promise((resolve, reject) => {
            axios.post(getters.URL, create)
                .then(response => {
                    commit('CREATE', response.data);
                    commit(
                        'SNACKBAR/SET',
                        {
                            text: getters.NAME + ' with id ' + response.data[getters.KEY] + ' was created.',
                            color: 'success',
                            status: true,
                            timeout: 3000
                        },
                        {root: true}
                    );
                    resolve(response.data)
                })
                .catch((error) => {
                    commit('SNACKBAR/ERROR', error.response.data.message, {root: true});
                    reject(error);
                });
        });
    },
    UPDATE({state, getters, commit, rootGetters}, payload) {
        const update = _.pick(payload, getters.FILLABLE);
        return new Promise((resolve, reject) => {
            axios.put(getters.URL + '/' + payload[getters.KEY], update)
                .then(response => {
                    commit('UPDATE', response.data);
                    commit(
                        'SNACKBAR/SET',
                        {
                            text: getters.NAME + ' with id ' + payload[getters.KEY] + ' was saved.',
                            color: 'success',
                            status: true,
                            timeout: 3000
                        },
                        {root: true}
                    );
                    resolve(response.data)
                })
                .catch((error) => {
                    commit('SNACKBAR/ERROR', error.response.data.message, {root: true});
                    reject(error);
                });
        });
    },
};

export default {
    state,
    getters,
    mutations,
    actions
}
