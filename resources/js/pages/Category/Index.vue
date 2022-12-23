<template>
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="">Home</a></li>
                    <li class="active">{{ category.name }}</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-result-container">
                        <div
                            id="myTabContent"
                            class="tab-content category-list"
                        >
                            <div class="tab-pane active" id="grid-container">
                                <div class="category-product">
                                    <div
                                        class="row"
                                        style="
                                            display: flex;
                                            flex-wrap: wrap;
                                            justify-content: flex-start;
                                        "
                                    >
                                        <div
                                            class="col-sm-6 col-md-3 wow fadeInUp"
                                            v-for="product in category.products"
                                            :key="product.id"
                                        >
                                            <div class="products">
                                                <div class="product">
                                                    <div class="product-image">
                                                        <div class="image">
                                                            <router-link
                                                                :to="{
                                                                    name: 'product',
                                                                    params: {
                                                                        id: product.id,
                                                                    },
                                                                }"
                                                                ><img
                                                                    :src="`/storage/images/products/${product.image}`"
                                                                    alt=""
                                                                    class="images"
                                                            /></router-link>
                                                        </div>
                                                        <!-- /.image -->
                                                    </div>
                                                    <!-- /.product-image -->
                                                    <div
                                                        class="product-info text-left"
                                                    >
                                                        <h3 class="name">
                                                            <router-link
                                                                :to="{
                                                                    name: 'product',
                                                                    params: {
                                                                        id: product.id,
                                                                    },
                                                                }"
                                                                >{{
                                                                    product.name
                                                                }}</router-link
                                                            >
                                                        </h3>
                                                        <div
                                                            class="rating rateit-small"
                                                        ></div>
                                                        <div
                                                            class="description"
                                                        ></div>

                                                        <div
                                                            class="product-price"
                                                        >
                                                            <span class="price">
                                                                {{
                                                                    product.price
                                                                }}
                                                                VND
                                                            </span>
                                                        </div>
                                                        <!-- /.product-price -->
                                                    </div>
                                                    <!-- /.product-info -->
                                                    <div
                                                        class="cart clearfix animate-effect cart_danhmuc"
                                                    >
                                                        <div class="action">
                                                            <div
                                                                id="them_gio_hang"
                                                            >
                                                                <ul
                                                                    class="list-unstyled"
                                                                >
                                                                    <li
                                                                        class="add-cart-button btn-group"
                                                                    >
                                                                        <button
                                                                            data-toggle="tooltip"
                                                                            class="btn btn-primary icon"
                                                                            type="button"
                                                                            title=""
                                                                            data-original-title="Thêm"
                                                                            @click="
                                                                                add(
                                                                                    product.id
                                                                                )
                                                                            "
                                                                            :class="{
                                                                                disabled:
                                                                                    product.status !=
                                                                                    0,
                                                                            }"
                                                                        >
                                                                            <i
                                                                                class="fa fa-shopping-cart"
                                                                            ></i>
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <!-- /.action -->
                                                        </div>
                                                        <!-- /.cart -->
                                                    </div>
                                                    <!-- /.product -->
                                                </div>
                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.item -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.category-product -->
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->

                        <!-- /.filters-container -->
                    </div>
                    <!-- /.search-result-container -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- ============================================== BRANDS CAROUSEL ============================================== -->

            <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.body-content -->
</template>

<script setup>
import { useRoute } from "vue-router";
import { useRouter } from "vue-router";
import { useCategoryStore } from "@/stores/category";
import { useUserStore } from "@/stores/user";
import { useCartStore } from "@/stores/cart";
import { storeToRefs } from "pinia";
import { onBeforeMount, ref } from "@vue/runtime-core";
import Swal from "sweetalert2";

const route = useRoute();

const router = useRouter();

const store = useCategoryStore();

const cartStore = useCartStore();

const userStore = useUserStore();

const { isAuthenticated } = storeToRefs(userStore);

const { category } = storeToRefs(store);

const { cart } = storeToRefs(cartStore);

const { getDetailCategoryHome } = store;

const { addCart, editCart, getListCart } = cartStore;

const edit = ref();

const add = async (id) => {
    if (isAuthenticated.value == false) {
        router.push({
            name: "login",
        });

        return;
    }

    let find = false;

    cart.value.forEach(async (element) => {
        if (element.product_id === id) {
            edit.value = {
                id: element.id,
                quantity: element.quantity + 1,
            };
            find = true;
        }
    });

    if (find) {
        const formData = new FormData();
        formData.append("product_id", id);
        formData.append("quantity", edit.value.quantity);
        formData.append("_method", "PUT");

        await editCart(edit.value.id, formData);
        await getListCart();
    }

    if (!find) {
        const formData = new FormData();
        formData.append("product_id", id);
        formData.append("quantity", 1);

        await addCart(formData);

        await getListCart();
    }

    Swal.fire({
        title: "Thêm công.",
        text: "Thêm thành công.",
        icon: "success",
        showConfirmButton: false,
        timer: 1000,
        width: 360,
        position: "top-end",
    });
};

onBeforeMount(async () => {
    await getDetailCategoryHome(route.params.id);

    document.title = category.value.name;
});
</script>
