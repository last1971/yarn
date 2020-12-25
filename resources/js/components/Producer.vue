<template>
    <v-tabs>
        <v-tab>Товары</v-tab>
        <v-tab>Описание</v-tab>
        <v-tab-item>
            TO DO
        </v-tab-item>
        <v-tab-item>
            <v-container v-if="instance">
                <div v-if="editMode">
                    <v-row>
                        <v-col>
                            <v-text-field v-model="proxy.name" label="Название производителя">
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
                            <picture-slider-edit v-model="instance" model="producer" v-if="instance"/>
                        </v-col>
                        <v-col col="4">
                            <v-textarea v-model="proxy.description" label="Краткое описание" counter="500" auto-grow>
                                <template v-slot:append>
                                    <v-btn icon :disabled="instance.description === proxy.description" @click="save">
                                        <v-icon color="success">mdi-content-save</v-icon>
                                    </v-btn>
                                </template>
                            </v-textarea>
                            <v-text-field v-model="proxy.site" label="Сайт">
                                <template v-slot:append>
                                    <v-btn icon :disabled="instance.site === proxy.site" @click="save">
                                        <v-icon color="success">mdi-content-save</v-icon>
                                    </v-btn>
                                </template>
                            </v-text-field>
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
                            <picture-slider-edit v-model="instance" model="producer" v-if="instance"/>
                        </v-col>
                        <v-col cols="4">
                            <v-card min-height="500" class="mt-6">
                                <v-card-title>
                                    <a :href="proxy.site"  target="_blank" v-if="proxy.site">
                                        {{ proxy.name }}
                                    </a>
                                    <span v-else>
                                        {{ proxy.name }}
                                    </span>
                                </v-card-title>
                                <v-card-subtitle>
                                    {{ proxy.description }}
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
import ArticleShow from "./ArticleShow";
import ArticleEdit from "./ArticleEdit";
import PictureSliderEdit from "./PictureSliderEdit";
import isAdmin from "../mixins/isAdmin";
import modelMixin from "../mixins/modelMixin";

export default {
    name: "Producer",
    components: {ArticleShow, ArticleEdit, PictureSliderEdit},
    mixins:[isAdmin,modelMixin],
    data() {
        return {
            instanceId: null,
            model: 'PRODUCER',
            proxy: null,
            options: {
                page: 1,
                itemsPerPage: 10,
                mustSort: false,
                multiSort: false,
                groupBy: [],
                groupDesc: [],
                sortBy: [],
                sortDesc: [],
            }
        }
    },
    methods: {
        setInstanceId(instanceId) {
            this.$store.dispatch(this.model + '/CACHE', instanceId)
                .then(() => {
                    this.instanceId = instanceId;
                });
        },
    },
}
</script>

<style scoped>

</style>
