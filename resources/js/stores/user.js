import { defineStore } from "pinia";
import { post } from "@/services/api";

export const useUserStore = defineStore("user", {
    state: () => ({
        user: {},
        token: {},
        type: "",
        expires_in: 0,
        isAuthenticated: false,
    }),
    getters: {
        getUser: (state) => state.user,
        getToken: (state) => state.token,
        getType: (state) => state.type,
        getExpiresIn: (state) => state.expires_in,
        getAuthenticated: (state) => state.isAuthenticated,
    },
    actions: {
        async login(data) {
            const response = await post("/api/login", data);

            this.user = response.data.user;
            this.token = response.data.token;
            this.type = response.data.type;
            this.expires_in =
                new Date().getTime() + response.data.expires_in * 1000;
            this.isAuthenticated = true;
        },
    },
    persist: true,
});
