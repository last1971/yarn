<template>
    <v-autocomplete
        :auto-select-first="true"
        :clearable="true"
        :error="!proxy"
        item-text="name"
        item-value="id"
        :items="items"
        label="Категория"
        :loading="isLoading"
        :search-input.sync="search"
        hide-no-data
        hide-selected
        placeholder="Название категории"
        v-model="proxy"
    ></v-autocomplete>
</template>

<script>
import _ from "lodash";

export default {
    name: "CategorySelect",
    props: {
        value: {type: [Array, Number, String]},
    },
    data() {
        return {
            isLoading: false,
            search: '',
            model: 'CATEGORY',
            itemIds: [],
        }
    },
    computed: {
        proxy: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val);
            }
        },
        items() {
            return this.$store.getters[this.model + '/GET'](this.itemIds);
        },
    },
    watch: {
        search: _.debounce(function (val) {
            // case when not need update data from server
            if (!val || this.isLoading) return;
            this.$emit('search', val);
            this.getItems(val);
        }, 1000),
        name() {
            this.errors = {};
        },
        async value(val) {
            if (val) await this.getItem(val);
        }
    },
    async created() {
        if (this.value) await this.getItem(this.value);
    },
    methods: {
        async getItems(name = '') {
            this.isLoading = true;
            const response = await this.$store.dispatch(
                this.model + '/ALL',
                {
                    whereAttributes: ['name'],
                    whereOperators: ['like'],
                    whereValues: ['%' + name + '%'],
                    isLeaf: true,
                }
            );
            this.itemIds = response.itemIds;
            this.isLoading = false;
        },
        async getItem(id) {
            this.isLoading = true;
            await this.$store.dispatch(this.model + '/CACHE', id);
            this.itemIds.push(id);
            this.isLoading = false;
        },
    }
}
</script>

<style scoped>

</style>
