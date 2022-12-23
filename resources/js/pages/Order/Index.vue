<template>
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li class="active">Hoá đơn</li>
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
                <div class="shopping-cart">
                    <div class="shopping-cart-table">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="cart-romove item">STT</th>
                                        <th class="cart-description item">
                                            Mã hoá đơn
                                        </th>
                                        <th class="cart-product-name item">
                                            Thanh toán
                                        </th>
                                        <th class="cart-qty item">Tổng tiền</th>
                                        <th class="cart-product-sub-total item">
                                            Trạng thái
                                        </th>
                                        <th class="cart-total last-item">
                                            Ngày tạo
                                        </th>
                                    </tr>
                                </thead>
                                <!-- /thead -->
                                <tbody>
                                    <tr
                                        v-for="(order, index) in ordersStatus"
                                        :key="order.id"
                                    >
                                        <td class="romove-item">
                                            {{ index + 1 }}
                                        </td>
                                        <td class="romove-item">
                                            <router-link
                                                :to="{
                                                    name: 'order-detail',
                                                    params: { id: order.id },
                                                }"
                                                >{{ order.id }}</router-link
                                            >
                                        </td>
                                        <td class="romove-item">
                                            {{ order.method }}
                                        </td>
                                        <td class="cart-product-quantity">
                                            <div class="quant-input">
                                                <h5>{{ order.total }} VNĐ</h5>
                                            </div>
                                        </td>
                                        <td class="cart-product-sub-total">
                                            {{ order.status.name }}
                                        </td>
                                        <td class="cart-product-grand-total">
                                            {{ order.created_at }}
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- /tbody -->
                            </table>
                            <!-- /table -->
                        </div>
                    </div>
                    <!-- /.shopping-cart-table -->
                </div>
                <!-- /.shopping-cart -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</template>

<script setup>
import { useOrderStore } from "@/stores/order";
import { computed, onBeforeMount } from "@vue/runtime-core";
import { storeToRefs } from "pinia";

const orderStore = useOrderStore();

const { orders, status } = storeToRefs(orderStore);

const { getListOrders, getStatus } = orderStore;

onBeforeMount(async () => {
    await getListOrders();
    await getStatus();
});

const ordersStatus = computed(() => {
    return orders.value.map((order) => {
        return {
            ...order,
            status: status.value.find((item) => item.id === order.status),
        };
    });
});
</script>
