<template>
    <v-card>
        <v-card-title class="text--secondary">
            Ваш профиль
        </v-card-title>
        <v-card-text v-if="user">
            <v-row>
                <v-col>
                    <v-img height="300px" width="300px" :src="'/avatar/300/' + user.avatar"/>
                </v-col>
                <v-col>
                    <v-file-input prepend-icon="mdi-camera"
                                  placeholder="Выбрать новый аватар"
                                  label="Аватар"
                                  accept="image/*"
                                  @change="upload"
                    />
                    <v-text-field prepend-icon="mdi-account" v-model="user.name" label="Имя"/>
                    <v-text-field prepend-icon="mdi-email" v-model="user.email" label="Email" disabled/>
                </v-col>
            </v-row>
            <input
                type="file"
                accept="image/*"
                style="display:none"
            />
        </v-card-text>
    </v-card>
</template>

<script>
import {mapGetters} from 'vuex';

export default {
    name: "User",
    data() {
        return {

        }
    },
    computed: {
        ...mapGetters({
            user: 'AUTH/GET',
            snackbar: 'SNACKBAR/GET',
        }),
    },
    methods: {
        async upload(avatar) {
            try {
                const formData = new FormData();
                formData.append('picture', avatar);
                const response = await axios.post(
                    '/api/avatar-upload',
                    formData,
                    {headers: {'Content-Type': 'multipart/form-data'}},
                );
                this.$store.commit('AUTH/SET_USER', response.data);
            } catch (e) {
                console.log(e);
            }
        }
    }
}
</script>

<style scoped>

</style>
