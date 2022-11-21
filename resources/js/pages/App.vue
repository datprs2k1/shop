<template>
    <home-header />
    <router-view />
    <home-footer />
</template>

<script setup>
import { useUserStore } from "../stores/user";
import { storeToRefs } from "pinia";
import { onBeforeMount } from "@vue/runtime-core";
import { useRoute } from "vue-router";

import HomeHeader from "../components/Header.vue";
import HomeFooter from "../components/Footer.vue";

const store = useUserStore();

const route = useRoute();

onBeforeMount(() => {
    document.body.classList.add("cnt-home");
});
</script>

<style src="@/assets/css/bootstrap.min.css"></style>
<style src="@/assets/css/bootstrap-select.min.css"></style>
<style src="@/assets/css/main.css"></style>
<style src="@/assets/css/blue.css"></style>
<style src="@/assets/css/animate.min.css"></style>
<style src="@/assets/css/fontawesome/css/all.min.css"></style>
