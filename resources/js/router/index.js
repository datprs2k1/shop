import Admin from "./admin";

import { createRouter, createWebHistory } from "vue-router";

const routes = [...Admin];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    document.title = to.meta.title ? to.meta.title : "DATPRS";
    next();
});

export default router;
