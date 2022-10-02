<template>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="" class="h1"><b>Admin</b>LTE</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <Form
                        @submit="onSubmit"
                        :validation-schema="loginScheme"
                        v-slot="{ errors }"
                    >
                        <div class="input-group mb-3">
                            <Field
                                name="email"
                                type="email"
                                class="form-control"
                                placeholder="Email"
                                :class="{ 'is-invalid': errors.email }"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                {{ errors.email }}
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <Field
                                name="password"
                                type="password"
                                class="form-control"
                                placeholder="Password"
                                :class="{ 'is-invalid': errors.password }"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                {{ errors.password }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" />
                                    <label for="remember"> Remember Me </label>
                                </div>
                            </div>

                            <div class="col-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-block"
                                >
                                    Sign In
                                </button>
                            </div>
                        </div>
                    </Form>
                    <div class="social-auth-links text-center mt-2 mb-3">
                        <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i> Sign in using
                            Facebook
                        </a>
                        <a href="#" class="btn btn-block btn-danger">
                            <i class="fab fa-google-plus mr-2"></i> Sign in
                            using Google+
                        </a>
                    </div>

                    <p class="mb-1">
                        <a href="forgot-password.html">I forgot my password</a>
                    </p>
                    <p class="mb-0">
                        <a href="register.html" class="text-center"
                            >Register a new membership</a
                        >
                    </p>
                </div>
            </div>
        </div>
    </body>
</template>

<script setup>
import { Form, Field } from "vee-validate";
import * as yup from "yup";
import { useUserStore } from "@/stores/user";
import Swal from "sweetalert2";
import { useRouter } from "vue-router";

const { login } = useUserStore();

const router = useRouter();

const loginScheme = yup.object({
    email: yup.string().email().required(),
    password: yup.string().required().min(6),
});

async function onSubmit(values) {
    try {
        await login(values);

        Swal.fire({
            title: "Thành công",
            text: "Thêm thành công.",
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        router.push({
            name: "dashboard",
        });
    } catch (error) {
        Swal.fire({
            title: "Thất bại",
            text: "Có lỗi xảy ra.",
            icon: "danger",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });
    }
}
</script>
