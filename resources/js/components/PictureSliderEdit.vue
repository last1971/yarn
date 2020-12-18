<template>
    <v-main>
        <v-row>
            <v-col>
                <v-carousel>
                    <v-carousel-item v-for="picture in pictures"
                                     :key="picture.id"
                                     :src="picture.src"
                                     :alt="picture.name"
                    />
                </v-carousel>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-file-input
                    accept="image/*"
                    label="Добавить картинку"
                    placeholder="Выбрать файл"
                    prepend-icon="mdi-camera"
                    @change="upload"
                />
            </v-col>
        </v-row>
    </v-main>
</template>

<script>
export default {
    name: "PictureSliderEdit",
    props: {
        value: { type: Object },
        model: { type: String },
    },
    data() {
        return {

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
            } catch (e) {
                console.log(e);
            }
        }
    }
}
</script>

<style scoped>

</style>
