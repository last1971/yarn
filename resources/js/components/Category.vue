<template>
    <v-tabs>
        <v-tab>Подкатегории</v-tab>
        <v-tab>Описание</v-tab>
        <v-tab-item>
            <categories v-if="instance" :options.sync="options" />
        </v-tab-item>
        <v-tab-item>
            <v-container v-if="instance">
                <div v-if="editMode">
                    <v-row>
                        <v-col>
                            <v-text-field v-model="proxy.name" label="Название категории">
                                <template v-slot:append>
                                    <v-btn icon :disabled="instance.name === proxy.name" @click="save">
                                        <v-icon color="success">mdi-content-save</v-icon>
                                    </v-btn>
                                </template>
                            </v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col col="8">
                            <picture-slider-edit v-model="instance" model="category" v-if="instance"/>
                        </v-col>
                        <v-col col="4">
                            <v-textarea v-model="proxy.description" label="Краткое описание" counter="500" auto-grow>
                                <template v-slot:append>
                                    <v-btn icon :disabled="instance.description === proxy.description" @click="save">
                                        <v-icon color="success">mdi-content-save</v-icon>
                                    </v-btn>
                                </template>
                            </v-textarea>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <article-edit v-model="proxy.article_id" @input="save"/>
                        </v-col>
                    </v-row>
                </div>
                <v-container v-else>
                    <v-row>
                        <v-col cols="8">
                            <picture-slider-edit v-model="instance" model="category" v-if="instance"/>
                        </v-col>
                        <v-col cols="4">
                            <v-card min-height="500" class="mt-6">
                                <v-card-title>
                                    {{ proxy.name }}
                                </v-card-title>
                                <v-card-subtitle>
                                    {{ proxy.description }}
                                    <router-link :to="{ name: 'category', params: { id: parent.id, slug: parent.slug } }" v-if="parent">
                                        {{ parent.name }}
                                    </router-link>
                                </v-card-subtitle>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-row>
                        <article-show v-model="proxy.article_id"/>
                    </v-row>
                </v-container>
            </v-container>
        </v-tab-item>
    </v-tabs>
</template>

<script>
import PictureSliderEdit from "./PictureSliderEdit";
import ArticleEdit from "./ArticleEdit";
import ArticleShow from "./ArticleShow";
import isAdmin from "../mixins/isAdmin";
import Categories from "./Categories";
import modelMixin from "../mixins/modelMixin";
export default {
    name: "Category",
    components: {Categories, ArticleShow, ArticleEdit, PictureSliderEdit},
    mixins:[isAdmin, modelMixin],
    data() {
        return {
            instanceId: null,
            model: 'CATEGORY',
            proxy: null,
            options: {}
        }
    },
    computed: {
        parent() {
            if (!this.instance.parent_id) return null;
            const parent = this.$store.getters[this.model + '/GET'](this.instance.parent_id);
            if (!parent) this.$store.dispatch(this.model + '/CACHE', this.instance.parent_id);
            return parent;
        }
    },
    methods: {
        setInstanceId(instanceId) {
            this.$store.dispatch(this.model + '/CACHE', instanceId)
                .then(() => {
                    if (instanceId) {
                        this.options.whereAttributes = ['parent_id'];
                        this.options.whereOperators = ['='];
                        this.options.whereValues = [instanceId];
                    }
                    this.instanceId = instanceId;
                });
        },
    },
}
</script>

<style scoped>

</style>
