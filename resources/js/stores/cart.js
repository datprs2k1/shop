import { defineStore } from "pinia";
import { del, get, post, put } from "@/services/api";

export const useCartStore = defineStore("cart", {
    state: () => ({
        cart: {},
    }),

    getters: {
        getCart: (state) => state.cart,
    },

    actions: {
        async addCart(data) {
            const response = await post("/cart", data);
        },

        async editCart(id, data) {
            const response = await post("/cart/" + id, data);
        },

        async deleteCart(id) {
            const response = await del("/cart/" + id);
        },

        async getListCart() {
            const response = await get("/cart");

            this.cart = response.data;
        },
    },
});
