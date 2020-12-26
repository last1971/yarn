<template>
    <v-autocomplete
        :auto-select-first="true"
        :clearable="true"
        :error="!proxy"
        item-text="name"
        item-value="id"
        :items="items"
        label="Производитель"
        :loading="isLoading"
        :search-input.sync="search"
        hide-no-data
        hide-selected
        placeholder="Название производителя"
        v-model="proxy"
    ></v-autocomplete>
</template>

<script>
import _ from "lodash";

export default {
    name: "ProducerSelect",
    props: {
        value: {type: [Array, Number, String]},
    },
    data() {
        return {
            isLoading: false,
            search: '',
            model: 'PRODUCER',
            itemIds: [],
        }
    },
    computed: {
        proxy: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit('input', val || null);
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
