import { defineStore } from "pinia";
import { del, get, post, put } from "@/services/api";

export const useOrderStore = defineStore("order", {
    state: () => ({
        order: {},
        orders: [],
        methods: [],
        status: [],
    }),

    getters: {
        getOrder: (state) => state.order,
        getOrders: (state) => state.orders,
        getMethods: (state) => state.methods,
    },

    actions: {
        async createOrder(data) {
            const response = await post("/order", data);

            return response.data;
        },

        async getOrderDetail(id) {
            const response = await get(`/order/${id}`);
            this.order = response.data;
        },

        async getListOrders() {
            const response = await get("/order");
            this.orders = response.data;
        },

        async getListOrdersAdmin() {
            const response = await get("/admin/order");
            this.orders = response.data;
        },

        async getMethod() {
            const response = await get("/order/method");
            this.methods = response.data.data;
        },

        async getStatus() {
            const response = await get("/order/status");
            this.status = response.data.data;
        },

        async approveOrder(id) {
            const response = await post(`/admin/order/approve/${id}`);

            return response;
        },
        async cancelOrder(id) {
            const response = await post(`/admin/order/cancel/${id}`);

            return response;
        },
    },
});
