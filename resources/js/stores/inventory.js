import { defineStore } from "pinia";
import { del, get, post, put } from "@/services/api";

export const useInventoryStore = defineStore("inventory", {
    state: () => ({
        inventory: {},
        inventories: [],
        status: [],
        logStatus: [],
    }),

    getters: {
        getInventory: (state) => state.inventory,
        getInventories: (state) => state.inventories,
        getStatus: (state) => state.status,
        getLogStatus: (state) => state.logStatus,
    },

    actions: {
        async getListInventory() {
            const response = await get("/admin/inventory");
            this.inventories = response.data;
        },

        async getInfoInventory(id) {
            const response = await get(`/admin/inventory/${id}`);
            this.inventory = response.data;
        },

        async getInventoryStatus() {
            const response = await get("/admin/inventory/status");
            this.status = response.data;
        },

        async getLogInventoryStatus() {
            const response = await get("/admin/inventory/logstatus");
            this.logStatus = response.data;
        },
    },
});
