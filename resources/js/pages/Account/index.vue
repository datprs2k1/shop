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
          <form action="" method="POST">
            <div class="form-group">
              <label class="info-title" for="password">Mật khẩu cũ </label>
              <input
                type="password"
                class="form-control unicase-form-control text-input"
                id="password"
                name="password"
                required="true"
                placeholder="******** "
              />
            </div>
            <div class="form-group">
              <label class="info-title" for="new_password">Mật khẩu mới </label>
              <input
                type="password"
                class="form-control unicase-form-control text-input"
                id="new_password"
                name="new_password"
                required="true"
                placeholder="******** "
              />
            </div>
            <div class="form-group">
              <label class="info-title" for="new_password_confirmation"
                >Nhập lại mật khẩu
              </label>
              <input
                type="password"
                class="form-control unicase-form-control text-input"
                id="new_password_confirmation"
                name="new_password_confirmation"
                required="true"
                placeholder="******** "
              />
            </div>
            <div class="button-group">
              <button
                type="submit"
                class="btn btn-success"
                name="update"
                title="Sửa"
              >
                Đổi mật khẩu
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useUserStore } from "@/stores/user";
import { ref, toRef } from "@vue/reactivity";
import { storeToRefs } from "pinia";

const userStore = useUserStore();

const { user } = storeToRefs(userStore);

const { change, info } = useUserStore();

const name = ref(user.value.name);
const email = ref(user.value.email);
const password = ref(user.value.password);

const changeInfo = async () => {
  const data = new FormData();

  data.append("name", name.value);
  data.append("email", email.value);

  await change(user.value.id, data);

  await info();
};
</script>