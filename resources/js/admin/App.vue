<template>
    <div class="sidebar-mini layout-fixed">
        <div class="wrapper">
            <admin-header v-if="isAuthenticated" />
            <div class="content-wrapper">
                <router-view />
            </div>
            <admin-footer v-if="isAuthenticated" />
        </div>
    </div>
</template>

<script setup>
import AdminHeader from "../components/AdminHeader.vue";
import AdminFooter from "../components/AdminFooter.vue";
import { ref } from "vue";
import { useUserStore } from "../stores/user";
import { storeToRefs } from "pinia";

const store = useUserStore();
const { isAuthenticated } = storeToRefs(store);
</script>

<style src="admin-lte/dist/css/adminlte.css"></style>
<style src="@/assets/css/fontawesome/css/all.min.css"></style>
