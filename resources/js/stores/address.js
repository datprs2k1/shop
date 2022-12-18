import { defineStore } from "pinia";
import { del, get, post, put } from "@/services/api";

export const useAddressStore = defineStore("address", {
    state: () => ({
        addresses: [],
    }),

    getters: {
        getAddresses: (state) => state.addresses,
    },

    actions: {
        async getListAddress() {
            const response = await get("/address");

            this.addresses = response.data;
        },

        async addAddress(address) {
            const response = await post("/address", address);
        },
    },
});
