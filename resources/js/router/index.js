import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from "../components/Login";
import Register from "../components/Register";
import User from "../components/User";
import NotFound from "../components/404";
import Category from "../components/Category";
import Categories from "../components/Categories";
import Producers from "../components/Producers";
import Producer from "../components/Producer";
import Product from "../components/Product";
import Products from "../components/Products";
import Order from "../components/Order";


Vue.use(VueRouter);

const routes = [
    {
        name: 'home',
        path: '/',
        component: Categories,
    },
    {
        name: 'categories',
        path: '/category',
        component: Categories,
    },
    {
        name: 'category',
        path: '/category/:id/:slug',
        component: Category,
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'order',
        path: '/order',
        component: Order,
    },
    {
        name: 'producers',
        path: '/producer',
        component: Producers,
    },
    {
        name: 'producer',
        path: '/producer/:id/:slug',
        component: Producer,
    },
    {
        name: 'products',
        path: '/product',
        component: Products,
    },
    {
        name: 'product',
        path: '/product/:id/:slug',
        component: Product,
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

router.afterEach((to, from) => {
    // console.log(to.fullPath, window.location.origin + from.path);
    ym(72254152, 'hit', to.fullPath, {
        // title: 'Контактная информация',
        referer: window.location.origin + from.path
    });
});

export default router;
