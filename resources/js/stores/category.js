import { defineStore } from "pinia";
import { del, get, post } from "@/services/api";

export const useCategoryStore = defineStore("category", {
    state: () => ({
        category: {},
        categories: [],
    }),

    getters: {
        getCategory: (state) => state.category,
        getCategories: (state) => state.categories,
    },

    actions: {
        async addCategory(data) {
            const response = await post("/admin/category", data);
        },

        async editCategory(id, data) {
            const response = await post("/admin/category/" + id, data);
        },

        async deleteCategory(id) {
            const response = await del("/admin/category/" + id);
        },

        async getListCategory(url = `/admin/category/`) {
            const response = await get(url);

            this.categories = response.data;
        },

        async getListTrashCategory(url = `/admin/category/trash`) {
            const response = await get(url);

            this.categories = response.data;
        },
    },
});
