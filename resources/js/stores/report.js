import { defineStore } from "pinia";
import { del, get, post, put } from "@/services/api";

export const useReportStore = defineStore("report", {
    state: () => ({
        month: {},
        year: {},
        product: {},
    }),

    getters: {
        getMonth: (state) => state.month,
        getYear: (state) => state.year,
        getProduct: (state) => state.product,
    },

    actions: {
        async getMonthReport() {
            const response = await get("/admin/report/month");

            this.month = response.data;
        },

        async getYearReport() {
            const response = await get("/admin/report/year");

            this.year = response.data;
        },

        async getProductReport() {
            const response = await get("/admin/report/product");

            this.product = response.data;
        },
    },
});
