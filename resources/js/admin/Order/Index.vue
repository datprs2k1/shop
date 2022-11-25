<template>
    <section class="content">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <b-container-fluid>
            <b-row>
                <b-col cols="12">
                    <b-card header-tag="header" footer-tag="footer">
                        <template #header>
                            <b-row>
                                <b-col md="8"> </b-col>
                                <b-col md="4">
                                    <b-row>
                                        <b-col md="8">
                                            <b-form-group>
                                                <b-input-group>
                                                    <b-form-input
                                                        id="search"
                                                        v-model="keyword"
                                                        type="search"
                                                        placeholder="Nhập từ khóa tìm kiếm"
                                                    ></b-form-input>
                                                </b-input-group>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <button
                                                class="btn btn-success"
                                                @click="search"
                                            >
                                                Tìm kiếm
                                            </button>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>
                        </template>
                        <b-table
                            striped
                            hover
                            :items="orders.data"
                            :fields="fields"
                            v-model:sort-by="sortBy"
                            v-model:sort-desc="sortDesc"
                        >
                            <template #cell(action)="row">
                                <span class="mr-3"
                                    ><b-button
                                        size="sm"
                                        variant="primary"
                                        @click="approve(row.item.id)"
                                        v-b-tooltip.hover.v-secondary
                                        title="
                                                Sửa bản ghi
                                            "
                                    >
                                        <i class="fas fa-edit fa-lg"></i>
                                    </b-button>
                                </span>
                                <span>
                                    <b-button
                                        size="sm"
                                        variant="danger"
                                        @click="cancel(row.item.id)"
                                        v-b-tooltip.hover.v-secondary
                                        title="
                                                Xóa bản ghi
                                            "
                                    >
                                        <i class="fas fa-trash fa-lg"></i>
                                    </b-button>
                                </span>
                            </template>
                            <template #cell(status)="row">
                                <div>
                                    <center>
                                        <span>
                                            {{
                                                status.find(
                                                    (item) =>
                                                        item.id ==
                                                        row.item.status
                                                ).name
                                            }}
                                        </span>
                                    </center>
                                </div>
                            </template>
                        </b-table>
                        <b-pagination
                            class="d-flex justify-content-end mt-4"
                            v-model="current_page"
                            :total-rows="orders.total"
                            :per-page="orders.per_page"
                            first-text="First"
                            prev-text="Prev"
                            next-text="Next"
                            last-text="Last"
                        ></b-pagination>
                    </b-card>
                </b-col>
            </b-row>
        </b-container-fluid>
    </section>
</template>

<script setup>
import { computed, onBeforeMount, ref, toRef, watch } from "vue";

import { useOrderStore } from "../../stores/order";

import { useForm } from "vee-validate";

import * as yup from "yup";

import Swal from "sweetalert2";
import { storeToRefs } from "pinia";

const sortBy = ref("id");
const sortDesc = ref(false);
const current_page = ref(1);
const keyword = ref(null);

const fields = ref([
    {
        key: "id",
        label: "Mã hoá đơn",
        class: "text-center",
    },
    {
        key: "total",
        label: "Tổng tiền",
        sortable: true,
        class: "text-center",
    },
    {
        key: "status",
        label: "Trạng thái",
        sortable: true,
        class: "text-center",
    },
    {
        key: "created_at",
        label: "Ngày tạo",
        sortable: true,
        class: "text-center",
    },
    {
        key: "action",
        label: "Hành động",
        class: "text-center",
    },
]);

const orderStore = useOrderStore();

const { orders, status } = storeToRefs(orderStore);

const { getListOrdersAdmin, getStatus, approveOrder, cancelOrder } = orderStore;

onBeforeMount(async () => {
    await getListOrdersAdmin();
    await getStatus();
});

const currenPage = watch(current_page, async (newPage) => {
    const url = orders.value.links[newPage].url;

    await getListCategory(url.slice(19, url.length));
});

const search = async () => {
    const url =
        keyword != null
            ? `/admin/category/?q=${keyword.value}`
            : "/admin/category";
    await getListCategory(url);
};

const approve = async (id) => {
    await approveOrder(id);
    await getListOrdersAdmin();
};

const cancel = async (id) => {
    await cancelOrder(id);
    await getListOrdersAdmin();
};
</script>
