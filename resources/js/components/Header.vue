<template>
    <!-- Order your soul. Reduce your wants. - Augustine -->

    <!-- ============================================== HEADER ============================================== -->
    <header class="header-style-1">
        <!-- ============================================== TOP MENU ============================================== -->
        <div class="top-bar animate-dropdown">
            <div class="container">
                <div class="header-top-inner">
                    <div class="cnt-account">
                        <ul class="list-unstyled">
                            <li v-show="isAuthenticated">
                                <a href=""
                                    ><i class="icon fa fa-user"></i>Tài khoản</a
                                >
                            </li>
                            <li v-show="isAuthenticated">
                                <a href=""
                                    ><i class="icon fa fa-shopping-cart"></i>Giỏ
                                    hàng</a
                                >
                            </li>
                            <li v-show="isAuthenticated">
                                <a href=""
                                    ><i class="icon fa fa-list-alt"></i>Hoá
                                    đơn</a
                                >
                            </li>
                            <li v-show="isAuthenticated">
                                <a href="" @click.prevent="logoutUser"
                                    ><i class="icon fa fa-list-alt"></i>Đăng
                                    xuất</a
                                >
                            </li>
                            <li>
                                <a href=""
                                    ><i class="icon fa fa-shopping-cart"></i>Giỏ
                                    hàng</a
                                >
                            </li>
                            <li>
                                <a href="#"
                                    ><i class="icon fa fa-check"></i>Thanh
                                    toán</a
                                >
                            </li>
                            <li v-show="isAuthenticated == false">
                                <router-link :to="{ name: 'login' }"
                                    ><i class="icon fa fa-lock"></i>Đăng
                                    nhập</router-link
                                >
                            </li>
                        </ul>
                    </div>
                    <!-- /.cnt-account -->

                    <div class="clearfix"></div>
                </div>
                <!-- /.header-top-inner -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.header-top -->
        <!-- ============================================== TOP MENU : END ============================================== -->
        <div class="main-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-1 logo-holder">
                        <!-- ============================================================= LOGO ============================================================= -->
                        <div class="logo">
                            <router-link
                                :to="{
                                    name: 'home',
                                }"
                            >
                                <img
                                    src="@/assets/images/shop-icon-png-6.jpg"
                                    alt=""
                                    style="width: 70%"
                                />
                            </router-link>
                        </div>
                        <!-- /.logo -->
                        <!-- ============================================================= LOGO : END ============================================================= -->
                    </div>
                    <!-- /.logo-holder -->

                    <div class="col-xs-12 col-sm-12 col-md-9 top-search-holder">
                        <!-- /.contact-row -->
                        <!-- ============================================================= SEARCH AREA ============================================================= -->
                        <div class="search-area">
                            <form method="POST" action="">
                                <div class="control-group">
                                    <ul
                                        class="categories-filter animate-dropdown"
                                    >
                                        <li class="dropdown">
                                            <a
                                                class="dropdown-toggle"
                                                data-toggle="dropdown"
                                                href="category.html"
                                                >Tìm kiếm</a
                                            >
                                        </li>
                                    </ul>

                                    <input
                                        class="search-field"
                                        name="tim-kiem"
                                        placeholder="Nhập tên sản phẩm để tìm kiếm..."
                                    />
                                    <button
                                        type="submit"
                                        name="search-btn"
                                        class="search-button"
                                        id="btn-tim-kiem"
                                    ></button>
                                    <div id="ket-qua"></div>
                                </div>
                            </form>
                        </div>
                        <!-- /.search-area -->
                        <!-- ============================================================= SEARCH AREA : END ============================================================= -->
                    </div>
                    <!-- /.top-search-holder -->

                    <div
                        class="col-xs-12 col-sm-12 col-md-2 animate-dropdown top-cart-row"
                        padding-right="0"
                    >
                        <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->

                        <div
                            class="dropdown dropdown-cart"
                            :class="{ open: isActived }"
                        >
                            <a
                                href="#"
                                class="dropdown-toggle lnk-cart"
                                data-toggle="dropdown"
                            >
                                <div
                                    class="items-cart-inner"
                                    @click="isActived = !isActived"
                                >
                                    <div class="basket">
                                        <i
                                            class="fa-solid fa-cart-shopping"
                                        ></i>
                                    </div>
                                    <div class="basket-item-count">
                                        <span class="count" id="count">{{
                                            cart ? cart.length : 0
                                        }}</span>
                                    </div>
                                    <div class="total-price-basket">
                                        <span class="lbl">Giỏ hàng</span>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <div v-if="cart.length > 0">
                                    <li v-for="item in cart" :key="item.id">
                                        <div class="cart-item product-summary">
                                            <div class="row" id="item_gio_hang">
                                                <div class="col-xs-4">
                                                    <div class="image">
                                                        <a href="#"
                                                            ><img
                                                                :src="`/storage/${item.product.image}`"
                                                                alt=""
                                                        /></a>
                                                    </div>
                                                </div>
                                                <div class="col-xs-7">
                                                    <h3 class="name">
                                                        <a href="">
                                                            {{
                                                                item.product
                                                                    .name
                                                            }}
                                                            <br />x
                                                            {{ item.quantity }}
                                                        </a>
                                                    </h3>
                                                    <div class="price">
                                                        {{
                                                            item.product.price *
                                                            item.quantity
                                                        }}
                                                    </div>
                                                </div>
                                                <div class="col-xs-1 action">
                                                    <i
                                                        class="fa fa-trash"
                                                        @click="
                                                            delCart(item.id)
                                                        "
                                                    ></i>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>
                                        <!-- /.cart-item -->
                                        <div class="clearfix"></div>
                                        <div class="clearfix cart-total">
                                            <div class="pull-right">
                                                <span class="text">
                                                    Tổng tiền: {{ total }}
                                                </span>
                                            </div>
                                            <div class="clearfix"></div>
                                            <router-link
                                                :to="{ name: 'cart' }"
                                                class="btn btn-upper btn-primary btn-block m-t-20"
                                                >Thanh toán</router-link
                                            >
                                        </div>
                                        <!-- /.cart-total-->
                                    </li>
                                </div>
                                <div v-else>Giỏ hàng trống</div>
                            </ul>
                            <!-- /.dropdown-menu-->
                        </div>
                        <!-- /.dropdown-cart -->

                        <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
                    </div>
                    <!-- /.top-cart-row -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.main-header -->

        <!-- ============================================== NAVBAR ============================================== -->
        <div class="header-nav animate-dropdown">
            <div class="container">
                <div class="yamm navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button
                            data-target="#mc-horizontal-menu-collapse"
                            data-toggle="collapse"
                            class="navbar-toggle collapsed"
                            type="button"
                        >
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="nav-bg-class">
                        <div
                            class="navbar-collapse collapse"
                            id="mc-horizontal-menu-collapse"
                        >
                            <div class="nav-outer">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown yamm-fw">
                                        <router-link
                                            :to="{
                                                name: 'home',
                                            }"
                                            >Home</router-link
                                        >
                                    </li>

                                    <li
                                        class="dropdown yamm-fw"
                                        v-for="item in categories"
                                        :key="item.id"
                                    >
                                        <router-link
                                            :to="{
                                                name: 'category',
                                                params: {
                                                    id: item.id,
                                                },
                                            }"
                                            >{{ item.name }}</router-link
                                        >
                                    </li>
                                </ul>
                                <!-- /.navbar-nav -->
                                <div class="clearfix"></div>
                            </div>
                            <!-- /.nav-outer -->
                        </div>
                        <!-- /.navbar-collapse -->
                    </div>
                    <!-- /.nav-bg-class -->
                </div>
                <!-- /.navbar-default -->
            </div>
            <!-- /.container-class -->
        </div>
        <!-- /.header-nav -->
        <!-- ============================================== NAVBAR : END ============================================== -->
    </header>
</template>

<script setup>
import { useCategoryStore } from "@/stores/category";
import { useCartStore } from "@/stores/cart";
import { useUserStore } from "@/stores/user";
import { computed, onBeforeMount, onMounted, ref } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import { useRouter } from "vue-router";
import Swal from "sweetalert2";

const store = useCategoryStore();

const cartStore = useCartStore();

const userStore = useUserStore();

const router = useRouter();

const { isAuthenticated, user } = storeToRefs(userStore);

const { logout } = userStore;

const { categories } = storeToRefs(store);

const { cart } = storeToRefs(cartStore);

const { getListCategoryHome } = store;

const { getListCart, deleteCart } = cartStore;

const isActived = ref(false);

const total = computed(() => {
    let total = 0;
    cart.value.forEach((item) => {
        total += item.product.price * item.quantity;
    });
    return total;
});

const delCart = async (id) => {
    await deleteCart(id);
    await getListCart();
};

const logoutUser = async () => {
    try {
        const response = await logout();

        await Swal.fire({
            icon: "success",
            title: response.data.message,
            showConfirmButton: false,
            timer: 1500,
        });

        router.push({ name: "login" });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Đăng xuất thất bại",
            showConfirmButton: false,
            timer: 1500,
        });
    }
};

onBeforeMount(async () => {
    await getListCategoryHome();
    try {
        await getListCart();
    } catch (error) {
        cart.value = [];
    }
});
</script>
