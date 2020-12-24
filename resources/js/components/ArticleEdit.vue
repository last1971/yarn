<template>
    <v-card>
        <v-card-title>
            Редактирование статьи
        </v-card-title>
        <v-card-text>
            <v-row>
                <article-select v-model="articleId"/>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field label="Уникальное название статьи"
                                  v-model="article.name"
                                  :error-messages="errors.name"
                    />
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <vue-editor v-model="article.content"
                                :editorOptions="editorSettings"
                                useCustomImageHandler
                                @image-added="handleImageAdded"
                    />
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
            <v-btn rounded color="success" :disabled="saveNotPossible" @click="save" :loading="isSaving">
                <v-icon left>mdi-content-save</v-icon>
                Сохранить
            </v-btn>
            <v-btn rounded color="danger" @click="cancel">
                <v-icon left>
                    mdi-close
                </v-icon>
                Отменить
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import { VueEditor, Quill } from "vue2-editor";
import ImageResize from 'quill-image-resize-vue';
import { ImageDrop } from "quill-image-drop-module";
import ArticleSelect from "./ArticleSelect";
import _ from "lodash";

Quill.register("modules/imageDrop", ImageDrop);
Quill.register("modules/imageResize", ImageResize);

export default {
    name: "ArticleEdit",
    components: {ArticleSelect, VueEditor },
    props: {
        value: { type: String },
    },
    data() {
        return {
            article: {
                id: null,
                name: null,
                picture_id: null,
                content: null,
            },
            articleId: null,
            editorSettings: {
                modules: {
                    imageDrop: true,
                    imageResize: {},
                }
            },
            isSaving: false,
            errors: {},
        }
    },
    computed: {
        saveNotPossible() {
            return _.isEqual(this.$store.getters['ARTICLE/GET'](this.articleId), this.article) || !this.articleId;
        }
    },
    watch: {
        articleId(val) {
            const clearVal = _.isEmpty(val) ? '' : val;
            if (val !== this.article.id) {
                this.article = _.cloneDeep(this.$store.getters['ARTICLE/GET'](val)) || {
                    id: null,
                    name: null,
                    picture_id: null,
                    content: null,
                };
                if (val !== this.value) this.$emit('input', clearVal);
            }
        },
        value(val) {
            if (val) {
                this.$store.dispatch('ARTICLE/CACHE', val).then(() => this.articleId = val);
            }
        }
    },
    created() {
        if (this.value) {
            this.$store.dispatch('ARTICLE/CACHE', this.value).then(() => {
                this.articleId = this.value;
            });
        }
    },
    methods: {
        handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {

            const formData = new FormData();
            formData.append("picture", file);
            formData.append("slug", this.article.slug);

            axios.post(
                '/api/picture-upload',
                formData,
                {headers: {'Content-Type': 'multipart/form-data'}},
            )
                .then(result => {
                    Editor.insertEmbed(cursorLocation, "image", result.data.src);
                    resetUploader();
                })
                .catch(err => {
                    console.log(err);
                });
        },
        cancel() {
            this.article = _.cloneDeep(this.$store.getters['ARTICLE/GET'](this.articleId))
        },
        async save() {
            this.isSaving = true;
            const { article } = this;
            try {
                await this.$store.dispatch('ARTICLE/UPDATE', article);
                this.cancel();
            } catch (e) {
                this.errors = e.response.data.errors;
            }
            this.isSaving = false;
        }
    }
}
</script>

<style scoped>

</style>
