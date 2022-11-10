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
                                                        showModal = !showModal;
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
                                        <b-cols>
                                            <span>
                                                <button
                                                    class="btn btn-success"
                                                    @click="showTrash()"
                                                    v-b-tooltip.hover.v-secondary
                                                    title="
                                                        Thùng rác
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-trash-restore"
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
                            :items="suppliers.data"
                            :fields="fields"
                            v-model:sort-by="sortBy"
                            v-model:sort-desc="sortDesc"
                        >
                            <template #cell(action)="row">
                                <span class="mr-3"
                                    ><b-button
                                        size="sm"
                                        variant="primary"
                                        @click="show(row.item)"
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
                                        @click="del(row.item.id)"
                                        v-b-tooltip.hover.v-secondary
                                        title="
                                                Xóa bản ghi
                                            "
                                    >
                                        <i class="fas fa-trash fa-lg"></i>
                                    </b-button>
                                </span>
                            </template>
                        </b-table>
                        <b-pagination
                            class="d-flex justify-content-end mt-4"
                            v-model="current_page"
                            :total-rows="suppliers.total"
                            :per-page="suppliers.per_page"
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
    <b-modal v-model="showModal" id="modal" size="lg">
        <template #title>
            {{ isAdd ? "Thêm nhà cung cấp" : "Sửa nhà cung cấp" }}
        </template>
        <b-form>
            <b-form-input
                id="input-id"
                name="id"
                v-model="id"
                type="text"
                hidden
            />
            <b-form-group label="Tên nhà cung cấp:" label-for="input-name">
                <b-form-input
                    id="input-name"
                    name="name"
                    v-model="name"
                    type="text"
                    placeholder="Nhập tên nhà cung cấp"
                    required
                    class="form-control"
                    :class="{
                        'is-invalid': errors.name,
                    }"
                />
                <div class="invalid-feedback">
                    {{ errors.name }}
                </div>
            </b-form-group>
            <b-form-group label="Mô tả:" label-for="input-description">
                <b-form-textarea
                    id="input-description"
                    name="description"
                    v-model="description"
                    placeholder="Nhập mô tả"
                    rows="3"
                    required
                    class="form-control"
                    :class="{ 'is-invalid': errors.description }"
                />
                <div class="invalid-feedback">
                    {{ errors.description }}
                </div>
            </b-form-group>
        </b-form>
        <template #footer>
            <div>
                <b-button
                    :disabled="!meta.valid"
                    variant="success"
                    @click="isAdd ? add() : edit()"
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
    <b-modal v-model="showTrashModal" id="modal" size="lg">
        <template #title> Thùng rác </template>
        <b-row>
            <b-col md="6">
                <b-row>
                    <b-col md="8">
                        <b-form-group>
                            <b-input-group>
                                <b-form-input
                                    id="search"
                                    v-model="keyword_trash"
                                    type="search"
                                    placeholder="Nhập từ khóa tìm kiếm"
                                ></b-form-input>
                            </b-input-group>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <button class="btn btn-success" @click="searchTrash">
                            Tìm kiếm
                        </button>
                    </b-col>
                </b-row>
            </b-col>
        </b-row>
        <b-table
            striped
            hover
            :items="trash.data"
            :fields="fields"
            v-model:sort-by="sortBy"
            v-model:sort-desc="sortDesc"
        >
            <template #cell(action)="row">
                <span class="mr-3"
                    ><b-button
                        size="sm"
                        variant="primary"
                        @click="restoreTrash(row.item.id)"
                        v-b-tooltip.hover.v-secondary
                        title="
                                                Khôi phục
                                            "
                    >
                        <i class="fas fa-trash-restore fa-lg"></i>
                    </b-button>
                </span>
                <span>
                    <b-button
                        size="sm"
                        variant="danger"
                        @click="delTrash(row.item.id)"
                        v-b-tooltip.hover.v-secondary
                        title="
                                                Xóa vĩnh viễn
                                            "
                    >
                        <i class="fas fa-trash fa-lg"></i>
                    </b-button>
                </span>
            </template>
        </b-table>
        <b-pagination
            class="d-flex justify-content-end mt-4"
            v-model="current_page_trash"
            :total-rows="trash.total"
            :per-page="trash.per_page"
            first-text="First"
            prev-text="Prev"
            next-text="Next"
            last-text="Last"
        ></b-pagination>
    </b-modal>
</template>

<script setup>
import { computed, onBeforeMount, ref, toRef, watch } from "vue";

import { useForm } from "vee-validate";

import * as yup from "yup";

import Swal from "sweetalert2";

import { useCategoryStore } from "@/stores/category";
import { storeToRefs } from "pinia";

const store = useCategoryStore();

const { suppliers, trash } = storeToRefs(store);

const {
    addSupplier,
    deleteSupplier,
    editSupplier,
    getListSupplier,
    getListTrashSupplier,
    deleteTrash,
    restoreFromTrash,
} = store;

const sortBy = ref("id");
const sortDesc = ref(false);
const current_page = ref(1);
const keyword = ref(null);

const current_page_trash = ref(1);
const keyword_trash = ref(null);

const fields = ref([
    {
        key: "id",
        label: "ID",
        class: "text-center",
    },
    {
        key: "name",
        label: "Tên nhà cung cấp",
        sortable: true,
        class: "text-center",
    },
    {
        key: "description",
        label: "Mô tả",
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
        key: "updated_at",
        label: "Ngày sửa",
        sortable: true,
        class: "text-center",
    },
    {
        key: "action",
        label: "Hành động",
        class: "text-center",
    },
]);

const showModal = ref(false);

const showTrashModal = ref(false);

const closeModal = () => {
    resetForm();
    showModal.value = !showModal.value;
};

const isAdd = ref(true);

const categoryScheme = yup.object({
    name: yup.string().required("Tên nhà cung cấp không được để trống."),
    description: yup.string().required("Mô tả không được để trống."),
});

const { meta, errors, useFieldModel, resetForm, setErrors, setValues } =
    useForm({
        validationSchema: categoryScheme,
    });

const [id, name, description] = useFieldModel(["id", "name", "description"]);

onBeforeMount(async () => {
    await getListSupplier();
});

const currenPage = watch(current_page, async (newPage) => {
    const url = suppliers.value.links[newPage].url;

    await getListSupplier(url.slice(19, url.length));
});

const add = async () => {
    const data = new FormData();

    data.append("name", name.value);
    data.append("description", description.value);

    try {
        await addSupplier(data);
        await getListSupplier();

        Swal.fire({
            title: "Thành công",
            text: "Thêm thành công.",
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        closeModal();
    } catch (error) {
        setErrors(error.response.data.errors);
    }
};

const del = async (id) => {
    try {
        await deleteSupplier(id);
        await getListSupplier();

        Swal.fire({
            title: "Thành công",
            text: "Thêm thành công.",
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });
    } catch (error) {
        Swal.fire({
            title: "Thất bại",
            text: "Có lỗi xảy ra.",
            icon: "error",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });
    }
};

const edit = async () => {
    const data = new FormData();

    data.append("name", name.value);
    data.append("description", description.value);
    data.append("_method", "PUT");

    try {
        await editSupplier(id.value, data);

        await getListSupplier();

        closeModal();

        Swal.fire({
            title: "Thành công",
            text: "Thêm thành công.",
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });
    } catch (error) {}
};

const search = async () => {
    const url =
        keyword != null
            ? `/admin/category/?q=${keyword.value}`
            : "/admin/category";
    await getListSupplier(url);
};

const searchTrash = async () => {
    const url =
        keyword_trash != null
            ? `/admin/category/trash/?q=${keyword_trash.value}`
            : "/admin/category/trash";
    await getListTrashSupplier(url);
};

const show = (category) => {
    showModal.value = true;
    isAdd.value = false;

    setValues({
        id: category.id,
        name: category.name,
        description: category.description,
    });
};

const showTrash = async () => {
    showTrashModal.value = !showTrashModal.value;
    try {
        await getListTrashSupplier();
    } catch (error) {}
};

const restoreTrash = async (id) => {
    Swal.fire({
        title: "Bạn chắc chắn muốn xóa?",
        text: "Bạn sẽ không thể hoàn tác!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Đồng ý!",
        cancelButtonText: "Hủy",
        width: 480,
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                await restoreFromTrash(id);
                Swal.fire({
                    title: "Đã xóa!",
                    icon: "success",
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1000,
                    width: 360,
                });

                await getListTrashSupplier();
                await getListSupplier();
            } catch (error) {
                Swal.fire({
                    title: "Thất bại",
                    text: "Có lỗi xảy ra.",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1000,
                    width: 360,
                });
            }
        }
    });
};

const delTrash = async (id) => {
    Swal.fire({
        title: "Bạn chắc chắn muốn xóa?",
        text: "Bạn sẽ không thể hoàn tác!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Đồng ý!",
        cancelButtonText: "Hủy",
        width: 480,
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                await deleteTrash(id);
                Swal.fire({
                    title: "Đã xóa!",
                    icon: "success",
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1000,
                    width: 360,
                });

                await getListTrashSupplier();
                await getListSupplier();
            } catch (error) {
                Swal.fire({
                    title: "Thất bại",
                    text: "Có lỗi xảy ra.",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 1000,
                    width: 360,
                });
            }
        }
    });
};
</script>
