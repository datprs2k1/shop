import Admin from "./admin";

import { createRouter, createWebHistory } from "vue-router";

import { useUserStore } from "../stores/user";
import { storeToRefs } from "pinia";

const routes = [...Admin];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from) => {
    const store = useUserStore();
    const { isAuthenticated, user, expires_in } = storeToRefs(store);
    const { reset } = store;

    document.title = to.meta.title || "DATPRS";

    if (new Date().getTime() > expires_in.value) {
        reset();
    }

    if (to.meta.requireAuth) {
        if (!isAuthenticated.value && to.name !== "login") {
            return { name: "login" };
        }
    }

    if (to.meta.role === "Admin") {
        if (user.value.role !== "Admin") {
            return { name: "login" };
        }
    }
});

export default router;
