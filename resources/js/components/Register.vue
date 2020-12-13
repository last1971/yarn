<template>
    <v-main>
        <v-container fill-height justify-center>
            <v-flex class="login-form text-xs-center">
                <v-card class="elevation-12">
                    <v-toolbar
                        color="primary"
                        dark
                    >
                        <v-toolbar-title>Регистрация</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text class="px-4">
                        <v-form>
                            <v-text-field
                                :error-messages="error.name"
                                label="Имя"
                                prepend-icon="mdi-account"
                                type="text"
                                v-model="user.name"
                            />
                            <v-text-field
                                :error-messages="error.email"
                                label="E-mail"
                                name="login"
                                prepend-icon="mdi-email"
                                type="text"
                                v-model="user.email"
                            />
                            <v-text-field
                                :error-messages="error.password"
                                label="Пароль"
                                name="password"
                                prepend-icon="mdi-lock"
                                type="password"
                                v-model="user.password"
                            />
                            <v-text-field
                                :error-messages="error.password_confirmation"
                                label="Подтверждение пароля"
                                name="password"
                                prepend-icon="mdi-lock"
                                type="password"
                                v-model="user.password_confirmation"
                            />
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="px-4 pb-4">
                        <v-spacer/>
                        <v-btn @click="register" color="primary" type="submit" :loading="loading">
                            Зарегистрироваться
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-container>
    </v-main>
</template>

<script>
import authMixin from "../mixins/authMixin";

export default {
    name: "Register",
    mixins:[authMixin],
    data() {
        return {
            user: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
            error: {},
            loading: false,
        }
    },
    methods: {
        async register() {
            this.loading = true;
            try {
                await this.$store.dispatch('AUTH/REGISTER', this.user);
                await this.$router.push({name: 'user'})
            } catch (error) {
                this.error = error.response.data.errors || {};
            }
            this.loading = false;
        }
    }
}
</script>

<style scoped>
    .login-form {
        max-width: 800px
    }
</style>
