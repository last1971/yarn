<template>
    <v-autocomplete
        :auto-select-first="true"
        :clearable="true"
        :error="!proxy"
        item-text="name"
        item-value="id"
        :items="items"
        label="Статья"
        :loading="isLoading"
        :search-input.sync="search"
        hide-no-data
        hide-selected
        placeholder="Название статьи"
        v-model="proxy"
    >
        <template v-slot:prepend>
            <v-dialog v-model="addArticle">
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" class="pb-2">
                        <v-icon color="green">mdi-plus</v-icon>
                    </v-btn>
                </template>
                <v-card>
                    <v-card-title class="headline">
                        <span class="headline">Создать новую статью</span>
                        <v-spacer/>
                        <v-btn @click="close" icon right>
                            <v-icon color="red">
                                mdi-close
                            </v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field v-model="name"
                                      label="Новая статья"
                                      placeholder="Введите уникальное название"
                                      :error-messages="errors.name"
                        />
                    </v-card-text>
                    <v-card-actions>
                        <v-btn rounded color="success" :disabled="saveNotPossible" @click="save">
                            <v-icon left>
                                mdi-content-save
                            </v-icon>
                            Сохранить
                        </v-btn>
                        <v-btn rounded color="danger" @click="close">
                            <v-icon left>
                                mdi-close
                            </v-icon>
                            Отменить
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </template>
    </v-autocomplete>
</template>

<script>
import _ from "lodash";

export default {
    name: "ArticleSelect",
    props: {
        value: {type: [Array, Number, String]},
    },
    data() {
        return {
            isLoading: false,
            search: '',
            model: 'ARTICLE',
            itemIds: [],
            addArticle: false,
            name: '',
            errors: {},
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
        saveNotPossible() {
            return !this.name;
        }
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
    methods: {
        async getItems(name = '') {
            this.isLoading = true;
            const response = await this.$store.dispatch(this.model + '/ALL', { name });
            this.itemIds = response.itemIds;
            this.isLoading = false;
        },
        async getItem(id) {
            this.isLoading = true;
            await this.$store.dispatch(this.model + '/CACHE', id);
            this.itemIds.push(id);
            this.isLoading = false;
        },
        close() {
            this.name = '';
            this.addArticle = false;
        },
        async save() {
            const { name, model } = this;
            try {
                const response = await this.$store.dispatch(model + '/CREATE', { name });
                this.proxy = response.id;
                this.itemIds = _.union(this.itemIds, [response.id]);
                this.close();
            } catch (e) {
                this.errors = e.response.data.errors;
            }
        }
    }
}
</script>

<style scoped>

</style>
