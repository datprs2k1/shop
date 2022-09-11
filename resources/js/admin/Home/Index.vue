<template>
    <h1>Home</h1>
    <h1>{{ count }}</h1>
    <button @click="increment"></button>
</template>

<script setup>
import { useUserStore } from "@/stores/user";
import { storeToRefs } from "pinia";
const store = useUserStore();

const { count } = storeToRefs(store);

const { increment } = store;
</script>
