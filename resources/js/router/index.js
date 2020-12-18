import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from "../components/Login";
import Register from "../components/Register";
import User from "../components/User";
import NotFound from "../components/404";
import ArticleEdit from "../components/ArticleEdit";
import Category from "../components/Category";


Vue.use(VueRouter);

const routes = [
    {
        name: 'article-edit',
        path: '/article-edit',
        component: ArticleEdit,
    },
    {
        name: 'category',
        path: '/category/:slug/:id',
        component: Category,
    },
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
        path: '*',
        component: NotFound,
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
