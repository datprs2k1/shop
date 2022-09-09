import Admin from "./admin";

import { createRouter, createWebHistory } from "vue-router";

const routes = [...Admin];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
