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
    },
    methods: {
        logout() {
            this.$router.replace({name: 'home'})
                .catch(() => {
                })
                .then(() => {
                    this.$store.dispatch('AUTH/LOGOUT')
                        .then(() => {
                            this.$store.commit('BREADCRUMBS/SET', []);
                            this.$router.push({name: 'login'});
                            this.$destroy();
                            window.location.reload();
                        })
                })
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
