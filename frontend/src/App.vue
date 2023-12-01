<script setup>
import { RouterLink, RouterView } from "vue-router";
import Navbar from "./components/Navbar.vue";
import ProductList from "./components/products/ProductList.vue";
</script>

<template>
  <div class="container-fluid">
    <Navbar></Navbar>
    <ProductList></ProductList>
  </div>
</template>

<style scoped>
</style>
