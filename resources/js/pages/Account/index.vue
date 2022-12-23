<template>
    <div class="container">
        <div class="row" style="margin-top: 20px">
            <div class="col-md-12"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h3>Xin chào {{ user.name }}</h3>
                    <p>Chỉnh sửa thông tin cá nhân của bạn.</p>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label class="info-title" for="name">Họ tên </label>
                            <input
                                type="text"
                                class="form-control unicase-form-control text-input"
                                id="name"
                                name="name"
                                required="true"
                                placeholder="Họ tên: "
                                v-model="name"
                            />
                        </div>
                        <div class="form-group">
                            <label class="info-title" for="email">Email </label>
                            <input
                                type="email"
                                class="form-control unicase-form-control text-input"
                                id="email"
                                name="email"
                                required="true"
                                placeholder="Email: "
                                v-model="email"
                            />
                        </div>
                        <div class="button-group">
                            <button
                                type="submit"
                                class="btn btn-success p-2"
                                name="update"
                                title="Sửa"
                                @click.prevent="changeInfo"
                            >
                                Sửa thông tin cá nhân
                            </button>
                            <a
                                href=""
                                class="btn btn-info p-2"
                                name="logout"
                                title="Đăng xuất"
                                >Đăng xuất</a
                            >
                        </div>
                    </form>
                    <p style="margin-top: 30px">Đổi mật khẩu</p>
                    <div class="form-group">
                        <label class="info-title" for="password"
                            >Mật khẩu cũ
                        </label>
                        <input
                            type="password"
                            class="form-control unicase-form-control text-input"
                            id="password"
                            name="password"
                            required="true"
                            placeholder="******** "
                            v-model="password"
                        />
                    </div>
                    <div class="form-group">
                        <label class="info-title" for="new_password"
                            >Mật khẩu mới
                        </label>
                        <input
                            type="password"
                            class="form-control unicase-form-control text-input"
                            id="new_password"
                            name="new_password"
                            required="true"
                            placeholder="******** "
                            v-model="new_password"
                        />
                    </div>
                    <div class="form-group">
                        <label
                            class="info-title"
                            for="new_password_confirmation"
                            >Nhập lại mật khẩu
                        </label>
                        <input
                            type="password"
                            class="form-control unicase-form-control text-input"
                            id="new_password_confirmation"
                            name="new_password_confirmation"
                            required="true"
                            placeholder="******** "
                            v-model="confirm_password"
                        />
                    </div>
                    <div class="button-group">
                        <button
                            type="submit"
                            class="btn btn-success"
                            name="update"
                            title="Sửa"
                            @click.prevent="changePass"
                        >
                            Đổi mật khẩu
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useUserStore } from "@/stores/user";
import { ref, toRef } from "@vue/reactivity";
import { onBeforeMount } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import Swal from "sweetalert2";
import { useRouter } from "vue-router";

const router = useRouter();

const userStore = useUserStore();

const { user } = storeToRefs(userStore);

const { change, info, changePassword } = useUserStore();

const name = ref(user.value.name);
const email = ref(user.value.email);
const password = ref("");
const new_password = ref("");
const confirm_password = ref("");

const changeInfo = async () => {
    const data = new FormData();

    data.append("name", name.value);
    data.append("email", email.value);

    try {
        const response = await change(data);

        await Swal.fire({
            title: "Thành công",
            text: response.data.message,
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        await info();
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: error.response.data.message,
            showConfirmButton: false,
            timer: 1500,
        });
    }
};

const changePass = async () => {
    const data = new FormData();

    data.append("password", password.value);
    data.append("new_password", new_password.value);
    data.append("confirm_password", confirm_password.value);

    try {
        const response = await changePassword(data);

        await Swal.fire({
            title: "Thành công",
            text: response.data.message,
            icon: "success",
            showConfirmButton: false,
            timer: 1000,
            width: 360,
        });

        router.push("/login");
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: error.response.data.message,
            showConfirmButton: false,
            timer: 1500,
        });
    }
};

onBeforeMount(async () => {
    await info();
});
</script>
