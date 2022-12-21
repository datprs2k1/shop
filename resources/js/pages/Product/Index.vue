<template>
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="">Home</a></li>
                    <li>
                        <a href="">{{ product.category.name }}</a>
                    </li>
                    <li class="active">{{ product.name }}</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row single-product">
                <div class="col-md-12">
                    <div class="detail-block">
                        <div class="row wow fadeInUp">
                            <div
                                class="col-xs-12 col-sm-6 col-md-5 gallery-holder"
                            >
                                <div
                                    class="product-item-holder size-big single-product-gallery small-gallery"
                                >
                                    <div id="owl-single-product">
                                        <div
                                            class="single-product-gallery-item"
                                            id="slide1"
                                        >
                                            <vueper-slides
                                                autoplay
                                                class="no-shadow"
                                                slide-multiple
                                                :bullets="false"
                                                :touchable="false"
                                                fixedHeight="420px"
                                            >
                                                <vueper-slide>
                                                    <template v-slot:content>
                                                        <img
                                                            class="img-responsive"
                                                            :src="`/storage/images/products/${product.image}`"
                                                        />
                                                    </template>
                                                </vueper-slide>
                                                <vueper-slide
                                                    v-for="slide in product.images"
                                                    :key="slide.id"
                                                    :duration="2000"
                                                >
                                                    <template v-slot:content>
                                                        <img
                                                            class="img-responsive"
                                                            :src="`/storage/images/products/${slide.name}`"
                                                        />
                                                    </template>
                                                </vueper-slide>
                                            </vueper-slides>
                                        </div>
                                        <!-- /.single-product-gallery-item -->
                                    </div>

                                    <!-- /.single-product-slider -->
                                </div>
                                <!-- /.single-product-gallery -->
                            </div>
                            <!-- /.gallery-holder -->
                            <div class="col-sm-6 col-md-7 product-info-block">
                                <div class="product-info">
                                    <h1 class="name">
                                        {{ product.name }}
                                    </h1>

                                    <div class="rating-reviews m-t-20">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div
                                                    class="rating rateit-small"
                                                ></div>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.rating-reviews -->

                                    <div
                                        class="stock-container info-container m-t-10"
                                    >
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="stock-box">
                                                    <span class="label"
                                                        >Tình trạng :</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="stock-box">
                                                    <span class="value"
                                                        >{{
                                                            productStatus.name
                                                        }}
                                                        - Số lượng:
                                                        {{
                                                            product.inventory
                                                                .quantity
                                                        }}</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.stock-container -->
                                    <div
                                        class="price-container info-container m-t-20"
                                    >
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="price-box">
                                                    <span class="price"
                                                        >{{
                                                            product.price
                                                        }}
                                                        VNĐ</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.price-container -->

                                    <div
                                        class="quantity-container info-container"
                                    >
                                        <div
                                            class="row quantity-container_wrapper"
                                        >
                                            <div class="col-sm-2">
                                                <span class="label">Qty :</span>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="cart-quantity">
                                                    <input
                                                        class="soluong_input"
                                                        type="number"
                                                        name="so_luong"
                                                        min="1"
                                                        v-model="quantity"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-sm-7">
                                                <b>{{ productUnit.name }}</b>
                                            </div>
                                        </div>
                                        <!-- /.row -->

                                        <div class="row mt15">
                                            <div class="col-12">
                                                <button
                                                    class="btn btn-primary"
                                                    id="them_gio_hang"
                                                    @click="add(product.id)"
                                                    :class="{
                                                        disabled:
                                                            productStatus.status !=
                                                            1,
                                                    }"
                                                >
                                                    <i
                                                        class="fa fa-shopping-cart inner-right-vs"
                                                    ></i>
                                                    Thêm vào giỏ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.quantity-container -->
                                </div>
                                <!-- /.product-info -->
                            </div>
                            <!-- /.col-sm-7 -->
                        </div>
                        <!-- /.row -->
                    </div>

                    <div class="product-tabs inner-bottom-xs wow fadeInUp">
                        <div class="row">
                            <div class="col-sm-3">
                                <ul
                                    id="product-tabs"
                                    class="nav nav-tabs nav-tab-cell"
                                >
                                    <li
                                        :class="{
                                            active: isActived('description'),
                                        }"
                                    >
                                        <a
                                            data-toggle="tab"
                                            @click.prevent="
                                                setActive('description')
                                            "
                                            >Mô tả</a
                                        >
                                    </li>
                                    <li
                                        :class="{
                                            active: isActived('manual'),
                                        }"
                                    >
                                        <a
                                            data-toggle="tab"
                                            @click.prevent="setActive('manual')"
                                            >Hướng dẫn sử dụng</a
                                        >
                                    </li>
                                    <li
                                        :class="{
                                            active: isActived('supplier'),
                                        }"
                                    >
                                        <a
                                            data-toggle="tab"
                                            @click.prevent="
                                                setActive('supplier')
                                            "
                                            >Nhà cung cấp</a
                                        >
                                    </li>
                                </ul>
                                <!-- /.nav-tabs #product-tabs -->
                            </div>
                            <div class="col-sm-9">
                                <div class="tab-content">
                                    <div
                                        id="description"
                                        class="tab-pane"
                                        :class="{
                                            active: isActived('description'),
                                        }"
                                    >
                                        <div class="product-tab">
                                            <p
                                                class="text"
                                                v-html="product.description"
                                            ></p>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div
                                        id="review"
                                        class="tab-pane"
                                        :class="{
                                            active: isActived('manual'),
                                        }"
                                    >
                                        <div class="product-tab">
                                            <div class="product-reviews">
                                                <p
                                                    class="text"
                                                    v-html="product.manual"
                                                ></p>
                                            </div>
                                            <!-- /.product-HDSD -->
                                        </div>
                                        <!-- /.product-tab -->
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div
                                        id="nha_cung_cap"
                                        class="tab-pane"
                                        :class="{
                                            active: isActived('supplier'),
                                        }"
                                    >
                                        <div class="product-tab">
                                            <div class="product-reviews">
                                                <img
                                                    :src="`${product.supplier.logo}`"
                                                    alt=""
                                                    style="
                                                        width: 150px;
                                                        height: 100px;
                                                        margin-left: auto;
                                                        margin-right: auto;
                                                        display: block;
                                                    "
                                                />
                                                <h1 style="text-align: center">
                                                    {{ product.supplier.name }}
                                                </h1>
                                                <div class="thong_tin">
                                                    <h4>
                                                        Địa chỉ:
                                                        {{
                                                            product.supplier
                                                                .address
                                                        }}
                                                    </h4>
                                                    <h4>
                                                        Điện thoại:
                                                        {{
                                                            product.supplier
                                                                .phone
                                                        }}
                                                    </h4>
                                                    <h4>
                                                        Email:
                                                        {{
                                                            product.supplier
                                                                .email
                                                        }}
                                                    </h4>
                                                    <h4>
                                                        Website:
                                                        <a
                                                            target="_blank"
                                                            href=""
                                                            >{{
                                                                product.supplier
                                                                    .website
                                                            }}</a
                                                        >
                                                    </h4>
                                                </div>
                                                <div class="gioi_thieu">
                                                    <h4>Giới thiệu:</h4>
                                                    <p class="text">
                                                        {{
                                                            product.supplier
                                                                .description
                                                        }}
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- /.product-HDSD -->
                                        </div>
                                        <!-- /.product-tab -->
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.product-tabs -->
                </div>
                <!-- /.col -->
                <div class="clearfix"></div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.body-content -->
</template>

<style scoped>
.vueperslides__arrow {
    color: yellow;
}
</style>

<script setup>
import { useProductStore } from "@/stores/product";
import { useCartStore } from "@/stores/cart";
import { useUserStore } from "@/stores/user";
import { computed, onBeforeMount, ref } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();

const router = useRouter();

const store = useProductStore();

const cartStore = useCartStore();

const userStore = useUserStore();

const { isAuthenticated } = storeToRefs(userStore);

const { product, unit, status } = storeToRefs(store);

const { cart } = storeToRefs(cartStore);

const { addCart, getListCart, editCart } = cartStore;

const { getDetailProduct, getProductUnit, getProductStatus } = store;

const activeItem = ref("description");

const quantity = ref(1);

const edit = ref();

const setActive = (item) => {
    activeItem.value = item;
};

const isActived = (item) => {
    return activeItem.value === item;
};

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
                quantity: element.quantity + quantity.value,
            };
            find = true;
        }
    });

    if (find) {
        const formData = new FormData();
        formData.append("quantity", edit.value.quantity);
        formData.append("product_id", id);
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
    await getDetailProduct(route.params.id);
    await getProductUnit();
    await getProductStatus();

    document.title = product.value.name;
});

const productUnit = computed(() => {
    return unit.value.find((item) => item.id === product.value.unit);
});

const productStatus = computed(() => {
    return status.value.find((item) => item.id === product.value.status);
});
</script>
