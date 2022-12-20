import { defineStore } from "pinia";
import { del, get, post, put } from "@/services/api";

export const useProductStore = defineStore("product", {
    state: () => ({
        product: {},
        products: [],
        trash: [],
        status: [],
        unit: [],
    }),

    getters: {
        getProduct: (state) => state.product,
        getProduct: (state) => state.products,
        getTrash: (state) => state.trash,
        getStatus: (state) => state.status,
        getUnit: (state) => state.unit,
    },

    actions: {
        async addProduct(data) {
            const response = await post("/admin/product", data);

            return response;
        },

        async editProduct(id, data) {
            const response = await post("/admin/product/" + id, data);

            return response;
        },

        async deleteProduct(id) {
            const response = await del("/admin/product/" + id);

            return response;
        },

        async getListProduct(url = `/admin/product/`) {
            const response = await get(url);

            this.products = response.data;
        },

        async getListTrashProduct(url = `/admin/product/trash`) {
            const response = await get(url);

            this.trash = response.data;
        },

        async deleteTrash(id) {
            const response = await del(`/admin/product/trash/` + id);

            return response;
        },

        async restoreFromTrash(id) {
            const response = await put(`/admin/product/trash/restore/` + id);

            return response;
        },

        async getProductStatus() {
            const response = await get(`/product/status`);

            this.status = response.data;
        },

        async getProductUnit() {
            const response = await get(`/product/unit`);

            this.unit = response.data;
        },

        async getDetailProduct(id) {
            const response = await get(`/product/` + id);

            this.product = response.data;
        },
    },
});
