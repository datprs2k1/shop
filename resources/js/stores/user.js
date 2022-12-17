import { defineStore } from "pinia";
import { post, get } from "@/services/api";

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
            const response = await post("/login", data);

            this.user = response.data.user;
            this.token = response.data.token;
            this.type = response.data.type;
            this.expires_in =
                new Date().getTime() + response.data.expires_in * 1000;
            this.isAuthenticated = true;
        },

        async register(data) {
            const response = await post("/register", data);

            this.user = response.data.user;
            this.token = response.data.token;
            this.type = response.data.type;
            this.expires_in =
                new Date().getTime() + response.data.expires_in * 1000;
            this.isAuthenticated = true;
        },

        reset() {
            this.user = null;
            this.token = null;
            this.type = null;
            this.expires_in = null;
            this.isAuthenticated = false;
        },

        async info() {
            const response = get('/user');
            console.log(response);
        },
        async change(id, data) {
            const response = await post('/account/' + id, data);
        }
    },
    persist: true,
});
