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
                                <b-col md="8">
                                    <b-row>
                                        <b-cols class="mr-4">
                                            <span>
                                                <button
                                                    class="btn btn-success"
                                                    @click="
                                                        showAddModal =
                                                            !showAddModal;
                                                        isAdd = true;
                                                    "
                                                    v-b-tooltip.hover.v-secondary
                                                    title="
                                                        Thêm nhà cung cấp
                                                    "
                                                >
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </span>
                                        </b-cols>
                                        <b-cols class="mr-4">
                                            <span>
                                                <button
                                                    class="btn btn-success"
                                                    v-b-tooltip.hover.v-secondary="
                                                        'Xuất PDF các bản ghi ở trang hiện tại'
                                                    "
                                                >
                                                    <i
                                                        class="fa fa-file-excel"
                                                        @click="exportExcel"
                                                    ></i>
                                                </button>
                                            </span>
                                        </b-cols>
                                    </b-row>
                                </b-col>
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
                            :items="inventories.data"
                            :fields="fields"
                            v-model:sort-by="sortBy"
                            v-model:sort-desc="sortDesc"
                        >
                            <template #cell(product)="row">
                                {{ row.item.product.name }}
                            </template>

                            <template #cell(supplier)="row">
                                {{ row.item.supplier.name }}
                            </template>

                            <template #cell(status)="row">
                                {{
                                    status.find(
                                        (item) => item.id == row.item.status
                                    ).name
                                }}
                            </template>

                            <template #cell(action)="row">
                                <span class="mr-3"
                                    ><b-button
                                        size="sm"
                                        variant="primary"
                                        @click="show(row.item.id)"
                                        v-b-tooltip.hover.v-secondary
                                        title="
                                                Sửa bản ghi
                                            "
                                    >
                                        <i class="fas fa-edit fa-lg"></i>
                                    </b-button>
                                </span>
                            </template>
                        </b-table>
                        <b-pagination
                            class="d-flex justify-content-end mt-4"
                            v-model="current_page"
                            :total-rows="inventories.total"
                            :per-page="inventories.per_page"
                            first-text="First"
                            prev-text="Prev"
                            next-text="Next"
                            last-text="Last"
                        ></b-pagination>
                    </b-card>
                </b-col>
            </b-row>
        </b-container-fluid>

        <b-modal v-model="showModal" id="modal" size="lg">
            <template #title> Lịch sử </template>
            <b-row>
                <b-col md="6">
                    <b-row> </b-row>
                </b-col>
            </b-row>
            <b-table striped hover :items="inventory.logs" :fields="logFileds">
                <template #cell(index)="row">
                    {{ row.index + 1 }}
                </template>
                <template #cell(product)>
                    {{ inventory.product.name }}
                </template>
                <template #cell(supplier)>
                    {{ inventory.supplier.name }}
                </template>
                <template #cell(status)="row">
                    {{
                        logStatus.find((item) => item.id == row.item.status)
                            .name
                    }}
                </template>
            </b-table>
        </b-modal>
        <b-modal v-model="showAddModal" id="modal" size="lg">
            <template #title> Nhập hàng </template>
            <b-form>
                <b-form-group label="Sản phẩm:" label-for="input-category">
                    <multiselect
                        v-model="product_id"
                        :options="products.data"
                        placeholder="Nhập từ khóa tìm kiếm"
                        selectedLabel="Đã được chọn"
                        selectLabel="Click hoặc enter để chọn"
                        deselectLabel="Click hoặc enter để bỏ chọn"
                        label="name"
                        track-by="name"
                        :class="{
                            'is-invalid': errors.product_id,
                        }"
                    >
                    </multiselect>
                    <div class="invalid-feedback">
                        {{ errors.product_id }}
                    </div>
                </b-form-group>
                <b-form-group label="Số lượng:" label-for="input-name">
                    <b-form-input
                        id="input-name"
                        name="name"
                        v-model="quantity"
                        type="text"
                        placeholder="Nhập số lượng"
                        required
                        class="form-control"
                        :class="{
                            'is-invalid': errors.quantity,
                        }"
                    />
                    <div class="invalid-feedback">
                        {{ errors.name }}
                    </div>
                </b-form-group>
            </b-form>
            <template #footer>
                <div>
                    <b-button
                        variant="success"
                        @click="addInventory()"
                        class="mr-3"
                    >
                        Xác nhận
                    </b-button>
                    <b-button variant="danger" @click="closeModal()">
                        Hủy
                    </b-button>
                </div>
            </template>
        </b-modal>
    </section>
</template>

<script setup>
import { computed, onBeforeMount, ref, toRef, watch } from "vue";

import { useInventoryStore } from "../../stores/inventory";

import { storeToRefs } from "pinia";

import { useProductStore } from "../../stores/product";

import { get } from "@/services/api";

import Swal from "sweetalert2";

const sortBy = ref("id");
const sortDesc = ref(false);
const current_page = ref(1);
const keyword = ref(null);
const showModal = ref(false);
const showAddModal = ref(false);
const product_id = ref();
const quantity = ref(1);

const errors = ref({});

const closeModal = () => {
    showAddModal.value = !showModal.value;
};

const fields = ref([
    {
        key: "id",
        label: "ID",
        class: "text-center",
    },
    {
        key: "product",
        label: "Sản phẩm",
        sortable: true,
        class: "text-center",
    },
    {
        key: "supplier",
        label: "Nhà cung cấp",
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

const logFileds = ref([
    {
        key: "index",
        label: "STT",
        class: "text-center",
    },
    {
        key: "product",
        label: "Sản phẩm",
        sortable: true,
        class: "text-center",
    },
    {
        key: "supplier",
        label: "Nhà cung cấp",
        sortable: true,
        class: "text-center",
    },
    {
        key: "quantity",
        label: "Số lượng",
        sortable: true,
        class: "text-center",
    },
    {
        key: "remain",
        label: "Còn lại",
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
]);

const log = ref([]);

const inventoryStore = useInventoryStore();

const productStore = useProductStore();

const { inventory, inventories, status, logStatus } =
    storeToRefs(inventoryStore);

const { products } = storeToRefs(productStore);

const {
    getInfoInventory,
    getListInventory,
    getInventoryStatus,
    getLogInventoryStatus,
    add,
} = inventoryStore;

const { getListProduct } = productStore;

onBeforeMount(async () => {
    await getListInventory();
    await getInventoryStatus();
    await getLogInventoryStatus();
    await getListProduct();
});

const currenPage = watch(current_page, async (newPage) => {
    const url = inventories.value.links[newPage].url;

    await getListInventory(url.slice(19, url.length));
});

const search = async () => {
    const url =
        keyword != null
            ? `/admin/category/?q=${keyword.value}`
            : "/admin/category";
    await getListInventory(url);
};

const show = async (id) => {
    await getInfoInventory(id);
    showModal.value = true;
};

const addInventory = async () => {
    const data = new FormData();
    data.append("product_id", product_id.value.id);
    data.append("quantity", quantity.value);

    try {
        const response = await add(data);

        Swal.fire({
            title: "Thành công",
            text: response.data.message,
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        showAddModal.value = false;
    } catch (error) {
        errors.value = error.response.data.errors;
    }
};

const exportExcel = async () => {
    const url = "/api/admin/inventory/export";
    window.location.href =
        window.location.protocol + "//" + window.location.host + url;
};
</script>
