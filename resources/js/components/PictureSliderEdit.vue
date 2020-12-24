<template>
    <v-container>
        <v-row>
            <v-col>
                <v-carousel v-model="pictureIndex">
                    <v-carousel-item v-for="picture in pictures"
                                     :key="picture.id"
                                     :src="picture.src"
                                     :alt="picture.name"
                    >
                        <div v-if="value.picture_id !== picture.id && editMode">
                            <v-btn icon @click="destroy(picture)">
                                <v-icon color="error">mdi-delete</v-icon>
                            </v-btn>
                            <v-btn icon @click="setMain(picture)">
                                <v-icon color="success">mdi-home-floor-1</v-icon>
                            </v-btn>
                        </div>
                    </v-carousel-item>
                </v-carousel>
                <v-file-input
                    v-if="editMode"
                    accept="image/*"
                    label="Добавить картинку"
                    placeholder="Выбрать файл"
                    prepend-icon="mdi-camera"
                    @change="upload"
                />
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import isAdmin from "../mixins/isAdmin";

export default {
    name: "PictureSliderEdit",
    mixins: [isAdmin],
    props: {
        value: { type: Object },
        model: { type: String },
    },
    data() {
        return {
            pictureIndex: 0,
        };
    },
    computed: {
        pictures() {
            return this.value.pictures
                ? this.value.pictures.map((v) => {
                    return {
                        src: '/picture/' + this.value.slug + '/' + this.value.id + '/' + v.file,
                        id: v.id,
                        name: this.value.name,
                    }
                })
                : [];
        }
    },
    methods: {
        async upload(picture) {
            try {
                const formData = new FormData();
                formData.append('picture', picture);
                formData.append('model', this.model);
                formData.append('id', this.value.id);
                const response = await axios.post(
                    '/api/picture',
                    formData,
                    {headers: {'Content-Type': 'multipart/form-data'}},
                );
                const newValue = _.cloneDeep(this.value);
                newValue.pictures.push(response.data);
                this.$store.commit(_.toUpper(this.model) + '/UPDATE', newValue);
                this.pictureIndex = newValue.pictures.length - 1;
            } catch (e) {
                console.log(e);
            }
        },
        async destroy(picture) {
            const { id } = picture;
            try {
                await axios.delete(`/api/picture/${id}`);
                const newValue = _.cloneDeep(this.value);
                const index = _.findIndex(newValue.pictures, { id });
                newValue.pictures.splice(index, 1);
                this.$store.commit(_.toUpper(this.model) + '/UPDATE', newValue);
            } catch (e) {
                console.log(e);
            }
        },
        async setMain(picture) {
            const newValue = _.cloneDeep(this.value);
            newValue.picture_id = picture.id;
            await this.$store.dispatch(_.toUpper(this.model) + '/UPDATE', newValue);
        }
    }
}
</script>

<style scoped>

</style>
