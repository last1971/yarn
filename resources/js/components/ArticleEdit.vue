<template>
    <v-card>
        <v-card-title>
            Редактирование статьи
        </v-card-title>
        <v-card-text>
            <v-row>
                <v-col>
                    <v-text-field label="Уникальное название статьи"   v-model="article.name"/>
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
            <v-btn rounded color="primary">
                <v-icon
                    left
                    dark
                    color="success"
                >
                    mdi-content-save
                </v-icon>
                Сохранить
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import { VueEditor, Quill } from "vue2-editor";
import ImageResize from 'quill-image-resize-vue';
import { ImageDrop } from "quill-image-drop-module";

Quill.register("modules/imageDrop", ImageDrop);
Quill.register("modules/imageResize", ImageResize);

export default {
    name: "ArticleEdit",
    components: { VueEditor },
    data() {
        return {
            article: {
                id: null,
                name: null,
                picture_id: null,
                content: null,
            },
            editorSettings: {
                modules: {
                    imageDrop: true,
                    imageResize: {},
                }
            }
        }
    },
    methods: {
        handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {

            const formData = new FormData();
            formData.append("picture", file);
            formData.append("slug", "test");

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
        }
    }
}
</script>

<style scoped>

</style>
