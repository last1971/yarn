import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from "../components/Login";
import Register from "../components/Register";
import User from "../components/User";

Vue.use(VueRouter);

const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'user',
        path: '/user',
        component: User
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
