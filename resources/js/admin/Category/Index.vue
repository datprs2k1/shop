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
                            <span>
                                <button
                                    class="btn btn-success"
                                    @click="showModalAdd = !showModalAdd"
                                    v-b-tooltip.hover.v-secondary
                                    title="
                                        Thêm danh mục
                                    "
                                >
                                    <i class="fas fa-plus"></i>
                                </button>
                            </span>
                        </template>
                        <b-table
                            striped
                            hover
                            :items="items"
                            :fields="fields"
                        ></b-table>
                    </b-card>
                </b-col>
            </b-row>
        </b-container-fluid>
    </section>
    <b-modal
        v-model="showModalAdd"
        id="modal-add"
        size="lg"
        title="Thêm danh mục"
        ref="modalAdd"
    >
        <b-form>
            <b-form-group label="Tên danh mục:" label-for="input-name">
                <b-form-input
                    id="input-name"
                    name="name"
                    v-model="name"
                    type="text"
                    placeholder="Nhập tên danh mục"
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
                <b-form-input
                    id="input-description"
                    name="description"
                    v-model="description"
                    type="text"
                    placeholder="Nhập mô tả"
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
                    @click="add"
                    class="mr-3"
                >
                    Xác nhận
                </b-button>
                <b-button
                    variant="danger"
                    @click="
                        resetForm();
                        showModalAdd = !showModalAdd;
                    "
                >
                    Hủy
                </b-button>
            </div>
        </template>
    </b-modal>
</template>

<script setup>
import { ref } from "vue";

import { useForm } from "vee-validate";

import * as yup from "yup";

import Swal from "sweetalert2";

import { useCategoryStore } from "@/stores/category";

const store = useCategoryStore();

const { addCategory } = store;

const fields = ref([
    {
        key: "age",
        label: "Tuổi",
    },
]);

const items = ref([
    { age: 40, first_name: "Dickerson", last_name: "Macdonald" },
    { age: 21, first_name: "Larsen", last_name: "Shaw" },
    { age: 89, first_name: "Geneva", last_name: "Wilson" },
    { age: 38, first_name: "Jami", last_name: "Carney" },
]);

const showModalAdd = ref(false);

const categoryScheme = yup.object({
    name: yup.string().required("Tên danh mục không được để trống."),
    description: yup.string().required("Mô tả không được để trống."),
});

const { meta, errors, useFieldModel, resetForm, setErrors } = useForm({
    validationSchema: categoryScheme,
});

const [name, description] = useFieldModel(["name", "description"]);

const add = async () => {
    const data = new FormData();

    data.append("name", name.value);
    data.append("description", description.value);

    try {
        await addCategory(data);

        Swal.fire({
            title: "Thành công",
            text: "Thêm thành công.",
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        showModalAdd.value = false;
    } catch (error) {
        setErrors(error.response.data.errors);
    }
};
</script>
