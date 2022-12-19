<template>
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li>
                        <router-link
                            :to="{
                                name: 'home',
                            }"
                            >Home</router-link
                        >
                    </li>
                    <li class="active">Đăng nhập</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="sign-in-page">
                <div class="row">
                    <!-- Sign-in -->
                    <div class="col-md-6 col-sm-6 sign-in">
                        <h4 class="">Đăng nhập</h4>
                        <p class="">
                            bac, Vui lòng đăng nhập tài khoản của bạn.
                        </p>
                        <form class="register-form outer-top-xs" role="form">
                            <div class="form-group">
                                <label class="info-title" for="email"
                                    >Email: <span>*</span></label
                                >
                                <input
                                    type="email"
                                    class="form-control unicase-form-control text-input"
                                    id="_email"
                                    name="_email"
                                    v-model="email"
                                />
                                <div class="invalid-feedback" id="email"></div>
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="password"
                                    >Mật khẩu:</label
                                >
                                <span>*</span>
                                <input
                                    type="password"
                                    class="form-control unicase-form-control text-input"
                                    id="_password"
                                    name="_password"
                                    v-model="password"
                                />
                                <div class="invalid-feedback" id="email"></div>
                            </div>

                            <button
                                class="btn-upper btn btn-primary checkout-page-button"
                                name="btn-dangnhap"
                                id="btn-dangnhap"
                                @click.prevent="Login()"
                            >
                                Đăng nhập
                            </button>
                        </form>
                    </div>
                    <!-- Sign-in -->

                    <!-- create a new account -->
                    <div class="col-md-6 col-sm-6 create-new-account">
                        <h4 class="checkout-subtitle">Đăng ký</h4>
                        <p class="text title-tag-line">
                            Tạo tài khoản mới của bạn.
                        </p>
                        <form class="register-form outer-top-xs" role="form">
                            <div class="form-group">
                                <label class="info-title" for="name"
                                    >Họ tên <span>*</span></label
                                >
                                <input
                                    type="text"
                                    class="form-control unicase-form-control text-input"
                                    id="name"
                                    name="name"
                                    v-model="name"
                                />
                                <div class="invalid-feedback" id="email"></div>
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="email"
                                    >Email <span>*</span></label
                                >
                                <input
                                    type="email"
                                    class="form-control unicase-form-control text-input"
                                    id="email"
                                    name="email"
                                    v-model="r_email"
                                />
                                <div class="invalid-feedback" id="email"></div>
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="password"
                                    >Mật khẩu <span>*</span></label
                                >
                                <input
                                    type="password"
                                    class="form-control unicase-form-control text-input"
                                    id="password"
                                    name="password"
                                    v-model="r_password"
                                />
                                <div class="invalid-feedback" id="email"></div>
                            </div>
                            <div class="form-group">
                                <label
                                    class="info-title"
                                    for="password_confirmation"
                                    >Xác nhận lại mật khẩu <span>*</span></label
                                >
                                <input
                                    type="password"
                                    class="form-control unicase-form-control text-input"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    v-model="r_password_confirmation"
                                />
                                <div class="invalid-feedback" id="email"></div>
                            </div>
                            <button
                                class="btn-upper btn btn-primary checkout-page-button"
                                name="btn-dangky"
                                id="btn-dangky"
                                @click.prevent="Register()"
                            >
                                Đăng ký
                            </button>
                        </form>
                    </div>
                    <!-- create a new account -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.sigin-in-->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.body-content -->
</template>

<script setup>
import { useUserStore } from "@/stores/user";
import { ref } from "@vue/reactivity";
import { useRouter } from "vue-router";
import Swal from "sweetalert2";

const userStore = useUserStore();
const router = useRouter();

const { login, register } = userStore;

const email = ref("");
const password = ref("");

const name = ref("");
const r_email = ref("");
const r_password = ref("");
const r_password_confirmation = ref("");

const Login = async () => {
    try {
        const formData = new FormData();
        formData.append("email", email.value);
        formData.append("password", password.value);

        await login(formData);

        Swal.fire({
            title: "Thành công",
            text: "Đăng nhập thành công.",
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        router.push({ name: "home" });
    } catch (error) {
        console.log(error);
    }
};

const Register = async () => {
    try {
        const formData = new FormData();
        formData.append("name", name.value);
        formData.append("email", r_email.value);
        formData.append("password", r_password.value);
        formData.append("password_confirmation", r_password_confirmation.value);

        await register(formData);

        Swal.fire({
            title: "Thành công",
            text: "Đăng ký thành công.",
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        router.push({ name: "home" });
    } catch (error) {
        console.log(error);
    }
};
</script>
