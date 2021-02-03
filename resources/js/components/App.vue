<template>
    <v-app>
        <v-navigation-drawer
            app
            v-model="drawer"
        >
            <v-list dense nav>
                <v-list-item
                    :key="menu.id"
                    :to="menu.to"
                    link
                    v-for="menu in menus"
                >
                    <v-list-item-action>
                        <v-icon>{{ menu.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>{{ menu.text }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
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
            <v-tooltip v-if="isAdmin" bottom>
                <template v-slot:activator="{ on }">
                    <v-btn icon @click="$store.commit('AUTH/EDIT-MODE-TOGGLE')" v-on="on">
                        <v-icon v-if="editMode">mdi-pencil-off-outline</v-icon>
                        <v-icon v-else>mdi-pencil-outline</v-icon>
                    </v-btn>
                </template>
                <span v-if="editMode">Выйти из режима редактирования</span>
                <span v-else>Войти в режим редактирования</span>
            </v-tooltip>
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
            <span class="white--text">Ласточкин Дом" &copy; 2021</span>
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
import isAdmin from "../mixins/isAdmin";

export default {
    name: "App",
    mixins: [isAdmin],
    data() {
        return {
            drawer: false,
            menus: [
                { id: 1, text: 'Категории', to: {name: 'categories'}, icon: 'mdi-shape'},
                // { id: 2, text: 'Производители', to: {name: 'producers'}, icon: 'mdi-professional-hexagon'},
                { id: 3, text: 'Продукты', to: {name: 'products'}, icon: 'mdi-volleyball'},
                { id: 4, text: 'Заказ', to: {name: 'order'}, icon: 'mdi-cart'}
            ],
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
