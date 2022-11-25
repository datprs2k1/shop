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
                            :items="products.data"
                            :fields="fields"
                            v-model:sort-by="sortBy"
                            v-model:sort-desc="sortDesc"
                        >
                            <template #cell(image)="row">
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
                                                :src="`/storage/${row.item.image}`"
                                            />
                                        </span>
                                    </center>
                                </div>
                            </template>
                            <template #cell(quantity)="row">
                                <div>
                                    <center>
                                        <span>
                                            {{ row.item.inventory.quantity }}
                                        </span>
                                    </center>
                                </div>
                            </template>
                            <template #cell(unit)="row">
                                <div>
                                    <center>
                                        <span>
                                            {{
                                                unit.find(
                                                    (item) =>
                                                        item.id == row.item.unit
                                                ).name
                                            }}
                                        </span>
                                    </center>
                                </div>
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
                            <template #cell(supplier)="row">
                                <div>
                                    <center>
                                        <span>
                                            {{ row.item.supplier.name }}
                                        </span>
                                    </center>
                                </div>
                            </template>
                            <template #cell(category)="row">
                                <div>
                                    <center>
                                        <span>
                                            {{ row.item.category.name }}
                                        </span>
                                    </center>
                                </div>
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
                            :total-rows="products.total"
                            :per-page="products.per_page"
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
            {{ isAdd ? "Thêm sản phẩm" : "Sửa sản phẩm" }}
        </template>
        <b-form>
            <b-form-input
                id="input-id"
                name="id"
                v-model="id"
                type="text"
                hidden
            />
            <b-form-group label="Tên sản phẩm:" label-for="input-name">
                <b-form-input
                    id="input-name"
                    name="name"
                    v-model="name"
                    type="text"
                    placeholder="Nhập tên sản phẩm"
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
            <b-form-group label="Hướng dẫn sử dụng:" label-for="input-manual">
                <b-form-textarea
                    id="input-manual"
                    name="manual"
                    v-model="manual"
                    placeholder="Nhập hướng dẫn sử dụng"
                    rows="3"
                    required
                    class="form-control"
                    :class="{ 'is-invalid': errors.manual }"
                />
                <div class="invalid-feedback">
                    {{ errors.manual }}
                </div>
            </b-form-group>
            <b-form-group label="Giá:" label-for="input-price">
                <b-form-input
                    id="input-price"
                    name="price"
                    v-model="price"
                    type="price"
                    placeholder="Nhập giá"
                    required
                    class="form-control"
                    :class="{
                        'is-invalid': errors.price,
                    }"
                />
                <div class="invalid-feedback">
                    {{ errors.price }}
                </div>
            </b-form-group>
            <b-form-group label="Số lượng:" label-for="input-quantity">
                <b-form-input
                    id="input-quantity"
                    name="quantity"
                    v-model="quantity"
                    type="quantity"
                    placeholder="Nhập số lượng"
                    required
                    class="form-control"
                    :class="{
                        'is-invalid': errors.quantity,
                    }"
                />
                <div class="invalid-feedback">
                    {{ errors.quantity }}
                </div>
            </b-form-group>
            <b-form-group label="Đơn vị tính:" label-for="input-unit">
                <multiselect
                    v-model="unit_options"
                    :options="unit"
                    placeholder="Nhập từ khóa tìm kiếm"
                    selectedLabel="Đã được chọn"
                    selectLabel="Click hoặc enter để chọn"
                    deselectLabel="Click hoặc enter để bỏ chọn"
                    label="name"
                    track-by="name"
                    :class="{
                        'is-invalid': errors.unit,
                    }"
                >
                </multiselect>
                <div class="invalid-feedback">
                    {{ errors.unit }}
                </div>
            </b-form-group>
            <b-form-group label="Danh mục:" label-for="input-category">
                <multiselect
                    v-model="category_options"
                    :options="categories.data"
                    placeholder="Nhập từ khóa tìm kiếm"
                    selectedLabel="Đã được chọn"
                    selectLabel="Click hoặc enter để chọn"
                    deselectLabel="Click hoặc enter để bỏ chọn"
                    label="name"
                    track-by="name"
                    :class="{
                        'is-invalid': errors.category_id,
                    }"
                >
                </multiselect>
                <div class="invalid-feedback">
                    {{ errors.category }}
                </div>
            </b-form-group>
            <b-form-group label="Nhà cung cấp:" label-for="input-supplier">
                <multiselect
                    v-model="supplier_options"
                    :options="suppliers.data"
                    placeholder="Nhập từ khóa tìm kiếm"
                    selectedLabel="Đã được chọn"
                    selectLabel="Click hoặc enter để chọn"
                    deselectLabel="Click hoặc enter để bỏ chọn"
                    label="name"
                    track-by="name"
                    :option-height="104"
                    :class="{
                        'is-invalid': errors.supplier_id,
                    }"
                >
                    <template #singleLabel="props">
                        <img
                            class="option__image"
                            style="max-width: 80px; max-height: 80px"
                            :src="props.option.logo"
                            alt="Ảnh"
                        />
                        <span class="option__desc"
                            ><span class="option__title">{{
                                props.option.name
                            }}</span></span
                        >
                    </template>

                    <template #option="props"
                        ><img
                            style="max-width: 100px; max-height: 100px"
                            class="option__image"
                            :src="props.option.logo"
                            alt="Ảnh"
                        />
                        <span class="option__desc"
                            ><span class="option__title">{{
                                props.option.name
                            }}</span></span
                        >
                    </template>
                </multiselect>
                <div class="invalid-feedback">
                    {{ errors.supplier_id }}
                </div>
            </b-form-group>

            <b-form-group label="Trạng thái:" label-for="input-status">
                <multiselect
                    v-model="status_options"
                    :options="status"
                    placeholder="Nhập từ khóa tìm kiếm"
                    selectedLabel="Đã được chọn"
                    selectLabel="Click hoặc enter để chọn"
                    deselectLabel="Click hoặc enter để bỏ chọn"
                    label="name"
                    track-by="name"
                    :class="{
                        'is-invalid': errors.status,
                    }"
                >
                </multiselect>
                <div class="invalid-feedback">
                    {{ errors.status }}
                </div>
            </b-form-group>

            <b-form-group label="Hình ảnh chính:" label-for="input-image">
                <b-row>
                    <b-col md="4">
                        <input
                            id="input-image"
                            type="file"
                            @change="onFileChange"
                            plain
                            :class="{
                                'invalid-feedback': errors.image,
                            }"
                            ref="input_image"
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
                <div class="invalid-feedback">
                    {{ errors.status }}
                </div>
            </b-form-group>
            <b-form-group label="Hình ảnh bổ sung:" label-for="input-images">
                <upload-media
                    v-if="isAdd == true"
                    :server="server"
                    @media="Media"
                    :class="{
                        'invalid-feedback': errors.images,
                    }"
                >
                    <div class="invalid-feedback">
                        {{ errors.images }}
                    </div>
                </upload-media>
                <update-media
                    v-else
                    :server="server"
                    media_file_path="/storage/images/products"
                    :media_server="media_server"
                    @added-media="getAddMedia"
                    @deleted-media="getDeleteMedia"
                    :class="{
                        'invalid-feedback': errors.images,
                    }"
                >
                    <div class="invalid-feedback">
                        {{ errors.images }}
                    </div>
                </update-media>
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

import { useProductStore } from "@/stores/product";
import { useCategoryStore } from "@/stores/category";
import { useSupplierStore } from "@/stores/supplier";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const store = useProductStore();
const store1 = useCategoryStore();
const store2 = useSupplierStore();

const { products, trash, status, unit } = storeToRefs(store);
const { categories } = storeToRefs(store1);
const { suppliers } = storeToRefs(store2);

const {
    addProduct,
    deleteProduct,
    editProduct,
    getListProduct,
    getListTrashProduct,
    deleteTrash,
    restoreFromTrash,
    getProductStatus,
    getProductUnit,
} = store;

const { getListCategory } = store1;
const { getListSupplier } = store2;

const server = ref("/admin/upload");
const media_server = ref("");
const image = ref();
const url = ref();
const add_images = ref();
const delete_images = ref();

const category_options = ref(null);
const supplier_options = ref(null);
const status_options = ref(null);
const unit_options = ref(null);

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
        key: "image",
        label: "Ảnh",
        class: "text-center",
    },
    {
        key: "name",
        label: "Tên sản phẩm",
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
        key: "quantity",
        label: "Số lượng",
        sortable: true,
        class: "text-center",
    },
    {
        key: "unit",
        label: "Đơn vị tính",
        sortable: true,
        class: "text-center",
    },
    {
        key: "price",
        label: "Giá",
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
        key: "category",
        label: "Danh mục",
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

const images = ref(null);

defineExpose({
    image,
});

const onFileChange = (e) => {
    image.value = e.target.files[0];
    url.value = URL.createObjectURL(image.value);
};

const Media = (value) => {
    images.value = value.map((item) => {
        return item.name;
    });
};

const getAddMedia = (value) => {
    add_images.value = value.map((item) => {
        return item.name;
    });
};
const getDeleteMedia = (value) => {
    delete_images.value = value.map((item) => {
        return item.name;
    });
};

const productScheme = yup.object({
    name: yup.string().required("Tên nhà cung cấp không được để trống."),
    description: yup.string().required("Mô tả không được để trống."),
    manual: yup.string().required("Hướng dẫn sử dụng không được để trống."),
    price: yup
        .number()
        .required("Số lượng không được để trống.")
        .positive("Số lượng phải lớn hơn 0.")
        .integer("Số lượng phải là số nguyên."),
    quantity: yup
        .number()
        .required("Số lượng không được để trống.")
        .positive("Số lượng phải lớn hơn 0.")
        .integer("Số lượng phải là số nguyên."),
});

const { meta, errors, useFieldModel, resetForm, setErrors, setValues } =
    useForm({
        validationSchema: productScheme,
    });

const [id, name, description, manual, price, quantity] = useFieldModel([
    "id",
    "name",
    "description",
    "manual",
    "price",
    "quantity",
]);

onBeforeMount(async () => {
    await getListProduct();
    await getListCategory();
    await getListSupplier();
    await getProductStatus();
    await getProductUnit();
});

const currenPage = watch(current_page, async (newPage) => {
    const url = products.value.links[newPage].url;

    await getListProduct(url.slice(19, url.length));
});

const add = async () => {
    const data = new FormData();

    data.append("name", name.value);
    data.append("description", description.value);
    data.append("manual", manual.value);
    data.append("price", price.value);
    data.append("quantity", quantity.value);
    data.append("status", status_options.value.id);
    data.append("unit", unit_options.value.id);
    data.append("category_id", category_options.value.id);
    data.append("supplier_id", supplier_options.value.id);
    data.append("image", image.value);
    data.append("images", images.value);

    try {
        await addProduct(data);
        await getListProduct();

        closeModal();

        Swal.fire({
            title: "Thành công",
            text: "Thêm thành công.",
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        resetForm();
        url.value = "";
        logo.value = "";
        image.value.value = "";
    } catch (error) {
        setErrors(error.response.data.errors);
    }
};

const del = async (id) => {
    try {
        await deleteProduct(id);
        await getListProduct();

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
    data.append("manual", manual.value);
    data.append("price", price.value);
    data.append("quantity", quantity.value);
    data.append("status", status_options.value.id);
    data.append("unit", unit_options.value.id);
    data.append("category_id", category_options.value.id);
    data.append("supplier_id", supplier_options.value.id);
    data.append("image", image.value);
    data.append("add_images", add_images.value);
    data.append("delete_images", delete_images.value);
    data.append("_method", "PUT");

    try {
        await editProduct(id.value, data);

        await getListProduct();

        closeModal();

        Swal.fire({
            title: "Thành công",
            text: "Sửa thành công.",
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        resetForm();
        url.value = "";
        logo.value = "";
        image.value.value = "";
    } catch (error) {
        setErrors(error.response.data.errors);
    }
};

const search = async () => {
    const url =
        keyword.value != null
            ? `/admin/product/?q=${keyword.value}`
            : "/admin/product";
    await getListProduct(url);
};

const searchTrash = async () => {
    const url =
        keyword_trash.value != null
            ? `/admin/product/trash/?q=${keyword_trash.value}`
            : "/admin/product/trash";
    await getListTrashProduct(url);
};

const show = (product) => {
    showModal.value = true;
    isAdd.value = false;

    setValues({
        id: product.id,
        name: product.name,
        description: product.description,
        manual: product.manual,
        price: product.price,
        quantity: product.inventory.quantity,
    });

    unit_options.value = unit.value.find((item) => item.id == product.unit);

    status_options.value = status.value.find(
        (item) => item.id == product.status
    );
    category_options.value = product.category;
    supplier_options.value = product.supplier;

    url.value = product.image;

    media_server.value = "/admin/media/" + product.id;
};

const showTrash = async () => {
    showTrashModal.value = !showTrashModal.value;
    try {
        await getListTrashProduct();
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

                await getListTrashProduct();
                await getListProduct();
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

                await getListTrashProduct();
                await getListProduct();
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
