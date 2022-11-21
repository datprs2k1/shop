<template>
    <div class="body-content outer-top-xs" id="top-banner-and-menu">
        <div class="container">
            <div class="row">
                <!-- ============================================== CONTENT ============================================== -->
                <div class="col-xs-12 col-sm-12 homebanner-holder">
                    <!-- ============================================== INFO BOXES ============================================== -->
                    <div class="info-boxes wow fadeInUp">
                        <div class="info-boxes-inner">
                            <div class="row">
                                <div class="col-md-6 col-sm-4 col-lg-4">
                                    <div class="info-box">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4
                                                    class="info-box-heading green"
                                                >
                                                    Hoàn tiền
                                                </h4>
                                            </div>
                                        </div>
                                        <h6 class="text">
                                            Hoàn tiền tới 30 ngày
                                        </h6>
                                    </div>
                                </div>
                                <!-- .col -->

                                <div class="hidden-md col-sm-4 col-lg-4">
                                    <div class="info-box">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4
                                                    class="info-box-heading green"
                                                >
                                                    miễn phí vận chuyển
                                                </h4>
                                            </div>
                                        </div>
                                        <h6 class="text">
                                            Miễn phí vận chuyển đơn hàng từ
                                            150.000đ
                                        </h6>
                                    </div>
                                </div>
                                <!-- .col -->

                                <div class="col-md-6 col-sm-4 col-lg-4">
                                    <div class="info-box">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h4
                                                    class="info-box-heading green"
                                                >
                                                    Siêu khuyến mãi
                                                </h4>
                                            </div>
                                        </div>
                                        <h6 class="text">
                                            Giảm tới 90% các loại mặt hàng
                                        </h6>
                                    </div>
                                </div>
                                <!-- .col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.info-boxes-inner -->
                    </div>
                    <!-- /.info-boxes -->
                    <!-- ============================================== INFO BOXES : END ============================================== -->
                    <!-- ============================================== SCROLL TABS ============================================== -->
                    <div
                        id="product-tabs-slider"
                        class="scroll-tabs outer-top-vs wow fadeInUp"
                        v-for="category in categories"
                        :key="category.id"
                    >
                        <div class="more-info-tab clearfix">
                            <h3 class="new-product-title pull-left">
                                {{ category.name }}
                            </h3>
                            <router-link
                                :to="{
                                    name: 'category',
                                    params: {
                                        id: category.id,
                                    },
                                }"
                                >Xem thêm</router-link
                            >
                        </div>
                        <div class="tab-content outer-top-xs">
                            <div class="tab-pane in active" id="all">
                                <div
                                    class="product-slider"
                                    v-for="product in category.products"
                                    :key="product.id"
                                >
                                    <div
                                        class="owl-carousel home-owl-carousel custom-carousel owl-theme"
                                        data-item="4"
                                        style="opacity: 1; display: block"
                                    >
                                        <div class="owl-wrapper-outer">
                                            <div
                                                class="owl-wrapper"
                                                style="
                                                    width: 100%;
                                                    left: 0px;
                                                    display: flex;
                                                    flex-wrap: wrap;
                                                    justify-content: flex-start;
                                                "
                                            >
                                                <div
                                                    class="owl-item product-wrapper"
                                                    style="width: 20%"
                                                >
                                                    <div
                                                        class="item item-carousel"
                                                    >
                                                        <div class="products">
                                                            <div
                                                                class="product"
                                                            >
                                                                <router-link
                                                                    :to="{
                                                                        name: 'product',
                                                                        params: {
                                                                            id: product.id,
                                                                        },
                                                                    }"
                                                                >
                                                                    <div
                                                                        class="product-image"
                                                                    >
                                                                        <div
                                                                            class="image"
                                                                        >
                                                                            <a
                                                                                href=""
                                                                            >
                                                                                <img
                                                                                    :src="`${product.image}`"
                                                                                    alt=""
                                                                                />
                                                                            </a>
                                                                        </div>
                                                                        <!-- /.image -->
                                                                    </div>
                                                                </router-link>
                                                                <!-- /.product-image -->
                                                                <router-link
                                                                    :to="{
                                                                        name: 'product',
                                                                        params: {
                                                                            id: product.id,
                                                                        },
                                                                    }"
                                                                >
                                                                    <div
                                                                        class="product-info text-center"
                                                                    >
                                                                        <h3
                                                                            class="name"
                                                                        >
                                                                            <a
                                                                                href=""
                                                                            >
                                                                                {{
                                                                                    product.name
                                                                                }}
                                                                            </a>
                                                                        </h3>
                                                                        <div
                                                                            class="product-price"
                                                                        >
                                                                            <span
                                                                                class="price"
                                                                            >
                                                                                {{
                                                                                    product.price
                                                                                }}
                                                                                VND
                                                                            </span>
                                                                        </div>
                                                                        <!-- /.product-price -->
                                                                    </div>
                                                                </router-link>

                                                                <!-- /.product-info -->
                                                                <div
                                                                    class="cart clearfix animate-effect"
                                                                >
                                                                    <div
                                                                        class="action"
                                                                    >
                                                                        <div
                                                                            id=""
                                                                            data-id="{{ $sanpham->id }}"
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
                                                            <!-- /.products -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.home-owl-carousel -->
                                    </div>
                                    <!-- /.product-slider -->
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.scroll-tabs -->
                        <!-- ============================================== SCROLL TABS : END ============================================== -->
                    </div>
                    <!-- /.homebanner-holder -->

                    <!-- ============================================== CONTENT : END ============================================== -->
                    <!-- ============================================== BRANDS CAROUSEL ============================================== -->

                    <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
                </div>
                <!-- /.container -->
            </div>
            <!-- /#top-banner-and-menu -->
        </div>
        <!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->

        <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
    </div>
    <!-- /.container -->
</template>

<script setup>
import { useCategoryStore } from "@/stores/category";
import { useCartStore } from "@/stores/cart";
import { useUserStore } from "@/stores/user";
import { onBeforeMount, onMounted, ref } from "@vue/runtime-core";
import { storeToRefs } from "pinia";

const store = useCategoryStore();

const cartStore = useCartStore();

const userStore = useUserStore();

const { isAuthenticated } = storeToRefs(userStore);

const { cart } = storeToRefs(cartStore);

const { categories } = storeToRefs(store);

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
        formData.append("quantity", edit.value.quantity);
        formData.append("_method", "PUT");

        await editCart(edit.value.id, formData);
        await getListCart();
    }

    if (!find) {
        const formData = new FormData();
        formData.append("product_id", id);
        formData.append("quantity", quantity.value);

        await addCart(formData);

        await getListCart();
    }
};
</script>
