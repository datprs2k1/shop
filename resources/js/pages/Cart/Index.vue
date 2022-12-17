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
    
    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-12 bg-white">
                    <h3>Chọn địa chỉ giao hàng</h3>
                    <div style="display: flex; align-item:center; margin-bottom: 10px;">
                        <input type="radio" value="" name="dia_chi" style="margin-right: 20px">
                        <div class="infor-wrap">
                            <span style="font-size: 16px"><b>Nguyễn Thế Văn</b></span><br>
                            <span style="font-size: 14px">SĐT: 0123454789</span> <br>
                            <span style="font-size: 14px">Địa chỉ: Thái Thụy - Thái Bình</span>
                        </div>
                    </div>
                    <div style="display: flex; align-item:center; margin-bottom: 10px;">
                        <input type="radio" value="" name="dia_chi" style="margin-right: 20px">
                        <div class="infor-wrap">
                            <span style="font-size: 16px"><b>Nguyễn Thế Văn</b></span><br>
                            <span style="font-size: 14px">SĐT: 0123454789</span> <br>
                            <span style="font-size: 14px">Địa chỉ: Thái Thụy - Thái Bình</span>
                        </div>
                    </div>
                    <div style="display: flex; align-item:center; margin-bottom: 10px;">
                        <input type="radio" value="" name="dia_chi" style="margin-right: 20px">
                        <div class="infor-wrap">
                            <span style="font-size: 16px"><b>Nguyễn Thế Văn</b></span><br>
                            <span style="font-size: 14px">SĐT: 0123454789</span> <br>
                            <span style="font-size: 14px">Địa chỉ: Thái Thụy - Thái Bình</span>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="shopping-cart">
                    <div class="shopping-cart-table">
                        <div class="table-responsive" id="cart">
                            <div class="col-md-12" v-if="cart.length == 0">
                                <h3 class="cart-empty-tittle">
                                    Giỏ hàng trống! Tiếp tục mua hàng thôi nào!!!
                                </h3>
                                <div class="img-cart-wrapper">
                                    <img src="" alt="" />
                                </div>
                            </div>
                            <table class="table" v-else>
                                <thead>
                                    <tr>
                                        <th class="cart-romove item">Xoá</th>
                                        <th class="cart-description item">
                                            Ảnh
                                        </th>
                                        <th class="cart-product-name item">
                                            Tên sản phẩm
                                        </th>
                                        <th class="cart-qty item">Số lượng</th>
                                        <th>Đơn vị</th>
                                        <th class="cart-sub-total item">Giá</th>
                                        <th class="cart-total last-item">
                                            Tổng
                                        </th>
                                    </tr>
                                </thead>
                                <!-- /thead -->
                                <tbody id="danh_sach_gio_hang">
                                    <tr
                                        v-for="item in productUnit"
                                        :key="item.id"
                                    >
                                        <td class="remove-item">
                                            <div title="Xoá" class="icon">
                                                <i
                                                    class="fa fa-trash"
                                                    id="xoa_gio_hang"
                                                    @click="delCart(item.id)"
                                                ></i>
                                            </div>
                                        </td>
                                        <td class="cart-image">
                                            <a class="entry-thumbnail" href="">
                                                <img
                                                    :src="`/storage/${item.product.image}`"
                                                    alt=""
                                                />
                                            </a>
                                        </td>
                                        <td class="cart-product-name-info">
                                            <h4
                                                class="cart-product-description"
                                                id="
                                                                                                                                                                                                                                            item_gio_hang"
                                            >
                                                <a href=""
                                                    ><b>{{
                                                        item.product.name
                                                    }}</b></a
                                                >
                                            </h4>
                                        </td>
                                        <td class="cart-product-quantity">
                                            <div class="quant-input">
                                                <input
                                                    type="number"
                                                    name=""
                                                    id="so_luong"
                                                    min="1"
                                                    v-model="item.quantity"
                                                    @change="edit(item)"
                                                />
                                            </div>
                                        </td>
                                        <td>
                                            {{ item.unit.name }}
                                        </td>
                                        <td class="cart-product-sub-total">
                                            <span
                                                class="cart-sub-total-price"
                                                >{{ item.product.price }}</span
                                            >
                                        </td>
                                        <td class="cart-product-grand-total">
                                            <span
                                                class="cart-grand-total-price"
                                                >{{
                                                    item.quantity *
                                                    item.product.price
                                                }}</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- /tbody -->
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <div class="shopping-cart-btn">
                                                <span class="">
                                                    <a
                                                        href="javascript:history.go(-1)"
                                                        class="btn btn-upper btn-primary pull-right outer-right-xs"
                                                        >Tiếp tục mua</a
                                                    >
                                                </span>
                                            </div>
                                            <!-- /.shopping-cart-btn -->
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <!-- /table -->
                            <div class="row">
                                <div
                                    class="col-md-8 address-form"
                                    style="height: 300px"
                                >
                                    <h5>Vui lòng chọn địa chỉ giao hàng.</h5>

                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label for="ten_nguoi_nhan"
                                                    >Tên người nhận:
                                                </label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="ten_nguoi_nhan"
                                                    id="ten_nguoi_nhan"
                                                    placeholder="Nguyen Văn A"
                                                    v-model="name"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="so_dien_thoai"
                                                    >Số điện thoại:
                                                </label>
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    name="so_dien_thoai"
                                                    id="so_dien_thoai"
                                                    maxlength="10"
                                                    v-model="phone"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="tinh">Tỉnh</label>
                                            <select
                                                id="tinh"
                                                class="form-control"
                                                name="tinh"
                                                v-model="city"
                                                @change="getDistrict()"
                                            >
                                                <option value="">
                                                    Chọn tỉnh.
                                                </option>
                                                <option
                                                    v-for="(
                                                        value, key, index
                                                    ) in cities"
                                                    :key="index"
                                                    :value="{
                                                        name: key,
                                                        code: value.code,
                                                    }"
                                                >
                                                    {{ key }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="huyen">Huyện</label>
                                            <select
                                                id="huyen"
                                                class="form-control"
                                                name="huyen"
                                                v-model="district"
                                                @change="getWard()"
                                            >
                                                <option value="">
                                                    Chọn huyện.
                                                </option>
                                                <option
                                                    v-for="district in districts"
                                                    :key="district.name"
                                                    :value="{
                                                        name: district.name,
                                                        pre: district.pre,
                                                        ward: district.ward,
                                                    }"
                                                >
                                                    {{ district.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="xa">Xã</label>
                                            <select
                                                id="xa"
                                                class="form-control"
                                                name="xa"
                                                v-model="ward"
                                            >
                                                <option value="">
                                                    Chọn xã.
                                                </option>
                                                <option
                                                    v-for="ward in wards"
                                                    :key="ward.name"
                                                    :value="ward"
                                                >
                                                    {{ ward.name }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="xa-phuong:"
                                            >Địa chỉ nhận mong muốn:
                                        </label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="diachi"
                                            id="diachi"
                                            placeholder="VD: số nhà 3 ..."
                                            v-model="address"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="thanhtoan"
                                            >Phương thức thanh toán</label
                                        >
                                        <select
                                            id="thanhtoan"
                                            class="form-control"
                                            name="thanhtoan"
                                            v-model="method"
                                        >
                                            <option value="">
                                                Chọn phương thức.
                                            </option>
                                            <option
                                                v-for="method in methods"
                                                :key="method.id"
                                                :value="method.id"
                                            >
                                                {{ method.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="col-md-4 col-sm-12 cart-shopping-total"
                                    style="height: 300px"
                                >
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div
                                                        class="cart-grand-total"
                                                    >
                                                        Tổng<span
                                                            class="inner-left-md"
                                                            >{{ total }}</span
                                                        >
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <!-- /thead -->
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div
                                                        class="cart-checkout-btn pull-right"
                                                    >
                                                        <button
                                                            type="submit"
                                                            class="btn btn-primary checkout-btn"
                                                            id="dat_hang"
                                                            @click.prevent="
                                                                create()
                                                            "
                                                        >
                                                            Đặt hàng
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!-- /tbody -->
                                    </table>
                                    <!-- /table -->
                                </div>
                            </div>
                        </div>
                        <!-- /.shopping-cart-table -->
                    </div>
                    <!-- /.cart-shopping-total -->
                </div>
                <!-- /.shopping-cart -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</template>

<script setup>
import { useCartStore } from "@/stores/cart";
import { useProductStore } from "@/stores/product";
import { useOrderStore } from "@/stores/order";
import { get } from "@/services/api";

import { computed, onBeforeMount, ref } from "@vue/runtime-core";
import { storeToRefs } from "pinia";

const cartStore = useCartStore();

const productStore = useProductStore();

const orderStore = useOrderStore();

const { cart } = storeToRefs(cartStore);

const { unit } = storeToRefs(productStore);

const { methods } = storeToRefs(orderStore);

const { getProductUnit } = productStore;

const { editCart, deleteCart, getListCart } = cartStore;

const { createOrder, getMethod } = orderStore;

const cities = ref([]);

const districts = ref([]);

const wards = ref([]);

const city = ref("");

const district = ref("");

const ward = ref("");

const name = ref("");

const phone = ref("");

const address = ref("");

const method = ref("");

const isAdd = ref(false);

const edit = async (item) => {
    const formData = new FormData();
    formData.append("quantity", item.quantity);
    formData.append("_method", "PUT");

    await editCart(item.id, formData);
    await getListCart();
};

const delCart = async (id) => {
    await deleteCart(id);
    await getListCart();
};

const getCity = async () => {
    const response = await get("/address/city");

    cities.value = response.data;
};

const getDistrict = async () => {
    const response = await get(`/address/district/${city.value.code}`);

    districts.value = response.data.district;
};

const getWard = () => {
    wards.value = district.value.ward;
};

const create = async () => {
    const formData = new FormData();

    formData.append("name", name.value);
    formData.append("phone", phone.value);
    formData.append("city", city.value.name);
    formData.append("district", district.value.pre + " " + district.value.name);
    formData.append("ward", ward.value.pre + " " + ward.value.name);
    formData.append("address", address.value);
    formData.append("method", method.value);

    await createOrder(formData);
};

onBeforeMount(async () => {
    await getProductUnit();
    await getCity();
    await getMethod();
    await getListAddress();
});

const total = computed(() => {
    let total = 0;
    cart.value.forEach((item) => {
        total += item.product.price * item.quantity;
    });
    return total;
});

const productUnit = computed(() => {
    return cart.value.map((item) => {
        return {
            ...item,
            unit: unit.value.find((unit) => unit.id == item.product.unit),
        };
    });
});
</script>
