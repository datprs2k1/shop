<template>
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->

    <div class="container">
        <div class="row">
            <div class="col-md-8 addres-container">
                <div class="address">
                    <h3>Địa chỉ nhận hàng</h3>
                    <p class="nguoinhan">
                        <strong>Người nhận: {{ order.address.name }}</strong>
                    </p>
                    <p>Số điện thoại: {{ order.address.phone }}</p>
                    <p>Địa chỉ nhận hàng tại:</p>
                    <p>
                        {{ order.address.ward }}, {{ order.address.district }},
                        {{ order.address.city }}
                    </p>
                    <p>
                        {{ order.address.address }}
                    </p>
                </div>
            </div>
            <div class="col-md-4 addres-container tinhtrang">
                <h3>Tình trạng đơn hàng</h3>
                <p>Mã hoá đơn: {{ order.id }}</p>
                <p>
                    <strong>{{ statusOrder.name }}</strong>
                </p>
            </div>
        </div>
    </div>

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row">
                <div class="shopping-cart">
                    <div class="shopping-cart-table">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="cart-romove item">STT</th>
                                        <th class="cart-description item">
                                            Ảnh
                                        </th>
                                        <th class="cart-product-name item">
                                            Tên sản phẩm
                                        </th>
                                        <th class="cart-qty item">Số lượng</th>
                                        <th class="cart-sub-total item">Giá</th>
                                        <th class="cart-total last-item">
                                            Tổng
                                        </th>
                                    </tr>
                                </thead>
                                <!-- /thead -->
                                <tbody>
                                    <tr
                                        v-for="(item, index) in order.products"
                                        :key="item.id"
                                    >
                                        <td class="romove-item">
                                            {{ index + 1 }}
                                        </td>
                                        <td class="cart-image">
                                            <a class="entry-thumbnail" href="">
                                                <img
                                                    :src="`/storage/images/products/${item.image}`"
                                                    alt=""
                                                />
                                            </a>
                                        </td>
                                        <td class="cart-product-name-info">
                                            <h4
                                                class="cart-product-description"
                                            >
                                                <router-link
                                                    :to="{
                                                        name: 'product',
                                                        params: { id: item.id },
                                                    }"
                                                    ><b>{{
                                                        item.name
                                                    }}</b></router-link
                                                >
                                            </h4>
                                        </td>
                                        <td class="cart-product-quantity">
                                            <div class="quant-input">
                                                <h4>
                                                    {{ item.pivot.quantity }}
                                                </h4>
                                            </div>
                                        </td>
                                        <td class="cart-product-sub-total">
                                            <span class="cart-sub-total-price"
                                                >{{ item.price }} VNĐ</span
                                            >
                                        </td>
                                        <td class="cart-product-grand-total">
                                            <span class="cart-grand-total-price"
                                                >{{
                                                    item.pivot.quantity *
                                                    item.price
                                                }}
                                                VNĐ</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- /tbody -->
                            </table>
                            <!-- /table -->
                        </div>
                    </div>
                    <!-- /.shopping-cart-table -->
                    <div
                        class="col-md-4 col-sm-offset-8 col-sm-12 cart-shopping-total"
                    >
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="cart-grand-total">
                                            Tổng<span class="inner-left-md"
                                                >{{ order.total }} VNĐ</span
                                            >
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                        </table>
                        <!-- /table -->
                    </div>
                    <!-- /.cart-shopping-total -->
                </div>
                <!-- /.shopping-cart -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.body-content -->
</template>

<script setup>
import { useOrderStore } from "@/stores/order";
import { computed, onBeforeMount } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import { useRoute } from "vue-router";

const route = useRoute();

const orderStore = useOrderStore();

const { order, status } = storeToRefs(orderStore);

const { getOrderDetail, getStatus } = orderStore;

onBeforeMount(async () => {
    await getOrderDetail(route.params.id);
    await getStatus();
});

const statusOrder = computed(() => {
    return status.value.find((item) => item.id === order.value.status);
});
</script>
