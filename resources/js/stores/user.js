import { defineStore } from "pinia";
import { post } from "@/services/api";

export const useUserStore = defineStore("user", {
    state: () => ({
        user: {},
        isAuthenticated: false,
    }),
    getters: {
        getUser: (state) => state.user,
        getAuthenticated: (state) => state.isAuthenticated,
    },
    actions: {
        login: async (data) => {
            const response = await post("/api/login", data);
            console.log(response);
        },
    },
});
