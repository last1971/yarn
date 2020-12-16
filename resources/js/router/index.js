import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from "../components/Login";
import Register from "../components/Register";
import User from "../components/User";
import NotFound from "../components/404";
import ArticleEdit from "../components/ArticleEdit";

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
    {
        name: 'article-edit',
        path: '/article-edit',
        component: ArticleEdit,
    },
    {
        path: '*',
        component: NotFound,
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
