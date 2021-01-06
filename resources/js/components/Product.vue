<template>
    <v-container v-if="instance">
        <div v-if="editMode">
            <v-row>
                <v-col>
                    <v-text-field v-model="proxy.name" label="Название товара">
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
                    <picture-slider-edit v-model="instance" model="product" v-if="instance"/>
                </v-col>
                <v-col col="4">
                    <v-textarea v-model="proxy.description" label="Краткое описание" counter="500" auto-grow>
                        <template v-slot:append>
                            <v-btn icon :disabled="instance.description === proxy.description" @click="save">
                                <v-icon color="success">mdi-content-save</v-icon>
                            </v-btn>
                        </template>
                    </v-textarea>
                    <category-select v-model="proxy.category_id" @input="save"/>
                    <producer-select v-model="proxy.producer_id" @input="save"/>
                    <prices v-model="proxy" />
                    <parameters-edit v-model="proxy" />
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
                    <picture-slider-edit v-model="instance" model="product" v-if="instance"/>
                </v-col>
                <v-col cols="4">
                    <v-card min-height="500" class="mt-6">
                        <v-card-title>
                            {{ proxy.name }}
                        </v-card-title>
                        <v-card-subtitle>
                            {{ proxy.description }}
                        </v-card-subtitle>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col>Категория:</v-col>
                                    <v-col>
                                        <router-link
                                            :to="{
                                                name: 'category',
                                                params: { slug: proxy.category.slug, id: proxy.category.id }
                                            }"
                                        >
                                            {{ proxy.category.name }}
                                        </router-link>
                                    </v-col>
                                </v-row>
                                <v-row v-if="proxy.producer">
                                    <v-col>Производитель:</v-col>
                                    <v-col>
                                        <router-link
                                            :to="{
                                                name: 'producer',
                                                params: { slug: proxy.producer.slug, id: proxy.producer.id }
                                            }"
                                        >
                                            {{ proxy.producer.name }}
                                        </router-link>
                                    </v-col>
                                </v-row>
                                <prices v-model="proxy" />
                                <parameters-show v-model="proxy" />
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <article-show v-model="proxy.article_id"/>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
import ArticleShow from "./ArticleShow";
import ArticleEdit from "./ArticleEdit";
import PictureSliderEdit from "./PictureSliderEdit";
import isAdmin from "../mixins/isAdmin";
import modelMixin from "../mixins/modelMixin";
import CategorySelect from "./CategorySelect";
import ProducerSelect from "./ProducerSelect";
import Prices from "./Prices";
import ParametersShow from "./ParameterComponents/ParametersShow";
import ParametersEdit from "./ParameterComponents/ParametersEdit";

export default {
    name: "Product",
    components: {
        ParametersEdit,
        ParametersShow, Prices, ProducerSelect, CategorySelect, ArticleShow, ArticleEdit, PictureSliderEdit},
    mixins:[isAdmin,modelMixin],
    data() {
        return {
            instanceId: null,
            model: 'PRODUCT',
            proxy: null,
        }
    },
    methods: {
        async setInstanceId(instanceId) {
            await this.$store.dispatch(this.model + '/CACHE', instanceId)
            this.instanceId = instanceId;
        },
    }
}
</script>

<style scoped>

</style>
