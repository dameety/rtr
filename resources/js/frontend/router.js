window.Vue = require("vue");

import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from "./pages/Home";
import Login from "./pages/auth/Login";
import Register from "./pages/auth/register";
import NotFound from "./pages/NotFound";

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/auth/login',
            name: "login",
            component: Login
        },
        {
            path: '/auth/register',
            name: "register",
            component: Register
        },
        {
            path: '*',
            component: NotFound
        }
    ],
    scrollBehavior(to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});

export default router;
