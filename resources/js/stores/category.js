import { defineStore } from "pinia";
import { post } from "@/services/api";

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
    },
});
