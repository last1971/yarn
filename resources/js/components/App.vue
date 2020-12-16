<template>
    <v-app>
        <v-navigation-drawer
            app
            v-model="drawer"
        >
            <v-list dense nav>
                <v-list-item>One</v-list-item>
                <v-list-item>Two</v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar
            app
            color="primary"
            dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"/>
            <v-toolbar-title>Ласточкин дом</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu
                v-if="user"
                bottom
                rounded
                offset-y
            >
                <template v-slot:activator="{ on }">
                    <v-btn icon x-large v-on="on">
                        <v-avatar>
                            <img :src="'/avatar/50/' + user.avatar" :alt="user.name" />
                        </v-avatar>
                    </v-btn>
                </template>
                <v-card>
                    <v-list-item-content class="justify-center">
                        <v-btn depressed rounded text :to="{ name: 'user' }">
                            Редактировать Аккаунт
                        </v-btn>
                        <v-divider class="my-3"></v-divider>
                        <v-btn depressed rounded text @click="logout">
                            Выход
                        </v-btn>
                    </v-list-item-content>
                </v-card>
            </v-menu>
            <v-tooltip bottom v-else>
                <template v-slot:activator="{ on }">
                    <v-btn @click="$router.push({ name: 'login' })" icon v-on="on" :disabled="isLoginPage">
                        <v-icon>mdi-login-variant</v-icon>
                    </v-btn>
                </template>
                <span>Войти / Зарегистрироваться</span>
            </v-tooltip>
        </v-app-bar>
        <v-main>
            <transition>
                <keep-alive>
                    <router-view></router-view>
                </keep-alive>
            </transition>
        </v-main>
        <v-footer
            app
            color="primary"
        >
            <span class="white--text">Ласточкин Дом" &copy; 2020</span>
        </v-footer>
        <v-snackbar
            :color="snackbar.color"
            :multi-line="snackbar.multi"
            :timeout="snackbar.timeout"
            @input="$store.commit('SNACKBAR/SHIFT')"
            v-model="snackbar.status"
        >
            {{ snackbar.text }}
            <v-btn
                @click="closeSnackbar"
                dark
                text
            >
                Закрыть
            </v-btn>
        </v-snackbar>
    </v-app>
</template>

<script>

import {mapGetters} from 'vuex';

export default {
    name: "App",
    data() {
        return {
            drawer: false,
        }
    },
    computed: {
        ...mapGetters({
            user: 'AUTH/GET',
            hasPermission: 'AUTH/HAS_PERMISSION',
            snackbar: 'SNACKBAR/GET',
        }),
        isLoginPage() {
            return this.$route.name === 'login';
        }
    },
    methods: {
        async logout() {
            await this.$store.dispatch('AUTH/LOGOUT');
            this.$store.commit('BREADCRUMBS/SET', []);
            await this.$router.push({name: 'login'});
            this.$destroy();
            window.location.reload();
        },
        closeSnackbar() {
            this.$store.commit('SNACKBAR/STATUS', false);
            this.$store.commit('SNACKBAR/SHIFT');
        }
    }
}
</script>

<style scoped>

</style>
