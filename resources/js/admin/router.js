window.Vue = require("vue");

import VueRouter from "vue-router";

Vue.use(VueRouter);

import store from '@/store'

import AdminLayout from "./pages/AdminLayout";

import NotFound from "./pages/NotFound";

import OrdersIndex from "./pages/orders/OrdersIndex";

import DeliveryIndex from "./pages/deliveries/DeliveryIndex";

import InventoryIndex from "./pages/inventory/InventoryIndex";
import InventoryEdit from "./pages/inventory/InventoryEdit";
import InventoryCreate from "./pages/inventory/InventoryCreate";

import OrderEdit from "./pages/orders/OrdersEdit";
import OrderShow from "./pages/orders/OrderShow";


import Home from "./../frontend/pages/Home";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: '/',
            name: "home",
            component: Home
        },
        {
            path: '/admin',
            redirect: { name: 'inventory.index' },
            component: AdminLayout,
            meta: { requiresAuth: true },
            children: [
                {
                    path: "orders",
                    name: "orders.index",
                    component: OrdersIndex,
                },
                {
                    path: "deliveries",
                    name: "deliveries.index",
                    component: DeliveryIndex,
                },
                {
                    path: "meals",
                    name: "inventory.index",
                    component: InventoryIndex,
                    meta: {adminOnly: true}
                },
                {
                    path: "inventory/create",
                    name: "inventory.create",
                    component: InventoryCreate,
                    meta: {adminOnly: true}
                },
                {
                    path: "inventory/:id/edit",
                    name: "inventory.edit",
                    component: InventoryEdit,
                    meta: {adminOnly: true}
                },
                {
                    path: "orders/:id/edit",
                    name: "orders.edit",
                    component: OrderEdit,
                },

                {
                    path: "orders/:id/show",
                    name: "orders.show",
                    component: OrderShow,
                }
            ]
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

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.userIsAuthenticated) {
            next({
                name: "home"
            })
        }

        next()

    } else {
        next()
    }

    if (to.matched.some(record => record.meta.adminOnly)) {
        if (!store.getters["userIsAdmin"]) {
            next({
                name: "home"
            })
        }
        next()

    } else {
        next()
    }
});

export default router;
