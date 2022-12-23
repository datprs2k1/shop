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
                                        <b-cols class="mr-4">
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
                            :items="suppliers.data"
                            :fields="fields"
                            v-model:sort-by="sortBy"
                            v-model:sort-desc="sortDesc"
                        >
                            <template #cell(logo)="row">
                                <div>
                                    <center>
                                        <span>
                                            <img
                                                style="
                                                    border-radius: 5px;
                                                    width: 100px;
                                                    height: 80px;
                                                    box-shadow: 0px 0px 10px
                                                        #ccc;
                                                "
                                                :src="`/storage/images/suppliers/${row.item.logo}`"
                                            />
                                        </span>
                                    </center>
                                </div>
                            </template>
                            <template #cell(description)="row">
                                {{
                                    row.item.description.length > 100
                                        ? row.item.description.substr(0, 100) +
                                          "..."
                                        : row.item.description
                                }}
                            </template>
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
            <b-form-group label="Địa chỉ:" label-for="input-address">
                <b-form-textarea
                    id="input-address"
                    name="address"
                    v-model="address"
                    placeholder="Nhập mô tả"
                    rows="3"
                    required
                    class="form-control"
                    :class="{ 'is-invalid': errors.address }"
                />
                <div class="invalid-feedback">
                    {{ errors.address }}
                </div>
            </b-form-group>
            <b-form-group label="Số điện thoại:" label-for="input-phone">
                <b-form-input
                    id="input-phone"
                    name="phone"
                    v-model="phone"
                    type="number"
                    placeholder="Nhập Số điện thoại"
                    required
                    class="form-control"
                    :class="{
                        'is-invalid': errors.phone,
                    }"
                />
                <div class="invalid-feedback">
                    {{ errors.phone }}
                </div>
            </b-form-group>
            <b-form-group label="Email:" label-for="input-email">
                <b-form-input
                    id="input-email"
                    name="email"
                    v-model="email"
                    type="email"
                    placeholder="Nhập Email"
                    required
                    class="form-control"
                    :class="{
                        'is-invalid': errors.email,
                    }"
                />
                <div class="invalid-feedback">
                    {{ errors.email }}
                </div>
            </b-form-group>
            <b-form-group label="Website:" label-for="input-website">
                <b-form-input
                    id="input-website"
                    name="website"
                    v-model="website"
                    type="website"
                    placeholder="Nhập website"
                    required
                    class="form-control"
                    :class="{
                        'is-invalid': errors.website,
                    }"
                />
                <div class="invalid-feedback">
                    {{ errors.email }}
                </div>
            </b-form-group>
            <b-form-group label="Logo:" label-for="input-logo">
                <b-row>
                    <b-col md="4">
                        <input
                            id="input-logo"
                            type="file"
                            @change="onFileChange"
                            plain
                            :class="{
                                'input-error': errors.image,
                            }"
                            ref="input_logo"
                        />

                        <img
                            v-if="url"
                            :src="url"
                            class="img-fluid"
                            style="
                                border-radius: 5px;
                                box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.1);
                                margin-top: 6px;
                                max-width: 160px;
                                max-height: 160px;
                            "
                        />
                    </b-col>
                </b-row>
                <div
                    v-if="errors.image"
                    style="color: #dc3545; font-size: 12.6px; margin-top: 3px"
                >
                    {{ errors.image }}
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
            :fields="restoreFields"
            v-model:sort-by="sortBy"
            v-model:sort-desc="sortDesc"
        >
            <template #cell(logo)="row">
                <div>
                    <center>
                        <span>
                            <img
                                style="
                                    border-radius: 5px;
                                    width: 100px;
                                    height: 80px;
                                    box-shadow: 0px 0px 10px #ccc;
                                "
                                :src="`/storage/images/suppliers/${row.item.logo}`"
                            />
                        </span>
                    </center>
                </div>
            </template>
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

import { useSupplierStore } from "@/stores/supplier";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const store = useSupplierStore();

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

const server = ref("/admin/upload");
const logo = ref();
const url = ref();

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
        key: "logo",
        label: "Logo",
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
        key: "address",
        label: "Địa chỉ",
        sortable: true,
        class: "text-center",
    },
    {
        key: "phone",
        label: "SĐT",
        sortable: true,
        class: "text-center",
    },
    {
        key: "email",
        label: "Email",
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

const restoreFields = ref([
    {
        key: "id",
        label: "ID",
        class: "text-center",
    },
    {
        key: "logo",
        label: "Logo",
        class: "text-center",
    },
    {
        key: "name",
        label: "Tên nhà cung cấp",
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

const input_logo = ref(null);

defineExpose({
    input_logo,
});

const onFileChange = (e) => {
    logo.value = e.target.files[0];
    url.value = URL.createObjectURL(logo.value);
};

const supplierScheme = yup.object({
    name: yup.string().required("Tên nhà cung cấp không được để trống."),
    description: yup.string().required("Mô tả không được để trống."),
    address: yup.string().required("Địa chỉ không được để trống."),
    phone: yup
        .string()
        .required("Số điện thoại không được để trống.")
        .length(10, "Số điện thoại phải có 10 số."),
    email: yup
        .string()
        .required("Email không được để trống.")
        .email("Email không đúng định dạng."),
    website: yup.string().required("Website không được để trống."),
});

const { meta, errors, useFieldModel, resetForm, setErrors, setValues } =
    useForm({
        validationSchema: supplierScheme,
    });

const [id, name, description, address, phone, email, website] = useFieldModel([
    "id",
    "name",
    "description",
    "address",
    "phone",
    "email",
    "website",
]);

onBeforeMount(async () => {
    await getListSupplier();
});

const currenPage = watch(current_page, async (newPage) => {
    const url = suppliers.value.links[newPage].url;

    await getListSupplier(url.slice(20, url.length));
});

const add = async () => {
    const data = new FormData();

    data.append("name", name.value);
    data.append("description", description.value);
    data.append("address", address.value);
    data.append("phone", phone.value);
    data.append("email", email.value);
    data.append("logo", logo.value);
    data.append("website", website.value);

    try {
        const response = await addSupplier(data);
        await getListSupplier();

        Swal.fire({
            title: "Thành công",
            text: response.data.message,
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        resetForm();
        url.value = "";
        logo.value = "";
        input_logo.value.value = "";

        closeModal();
    } catch (error) {
        setErrors(error.response.data.errors);
    }
};

const del = async (id) => {
    try {
        const response = await deleteSupplier(id);
        await getListSupplier();

        Swal.fire({
            title: "Thành công",
            text: response.data.message,
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });
    } catch (error) {
        Swal.fire({
            title: "Thất bại",
            text:  error.response.data.message,
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
    data.append("address", address.value);
    data.append("phone", phone.value);
    data.append("email", email.value);
    data.append("logo", logo.value);
    data.append("website", website.value);
    data.append("_method", "PUT");

    try {
        const response = await editSupplier(id.value, data);

        await getListSupplier();

        resetForm();
        url.value = "";
        logo.value = "";
        input_logo.value.value = "";

        closeModal();

        Swal.fire({
            title: "Thành công",
            text: response.data.message,
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });
    } catch (error) {
        setErrors(error.response.data.errors);
    }
};

const search = async () => {
    const url =
        keyword != null
            ? `/admin/supplier/?q=${keyword.value}`
            : "/admin/supplier";
    await getListSupplier(url);
};

const searchTrash = async () => {
    const url =
        keyword_trash != null
            ? `/admin/supplier/trash/?q=${keyword_trash.value}`
            : "/admin/supplier/trash";
    await getListTrashSupplier(url);
};

const show = (supplier) => {
    showModal.value = true;
    isAdd.value = false;

    setValues({
        id: supplier.id,
        name: supplier.name,
        description: supplier.description,
        address: supplier.address,
        phone: supplier.phone,
        email: supplier.email,
        website: supplier.website,
    });

    url.value = supplier.logo;
};

const showTrash = async () => {
    showTrashModal.value = !showTrashModal.value;
    try {
        await getListTrashSupplier();
    } catch (error) {}
};

const restoreTrash = async (id) => {
    try {
        const response = await restoreFromTrash(id);
        Swal.fire({
            title: "Thành công",
            text: response.data.message,
            icon: "success",
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
                const response = await deleteTrash(id);
                Swal.fire({
                    title: "Đã xoá!",
                    text: response.data.message,
                    icon: "success",
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

const exportExcel = async () => {
    const url = "/api/admin/supplier/export";
    window.location.href =
        window.location.protocol + "//" + window.location.host + url;
};
</script>
