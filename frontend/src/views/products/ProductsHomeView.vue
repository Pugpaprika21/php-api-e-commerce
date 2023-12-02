<script>
import ProductsCreateView from "./ProductsCreateView.vue";
import ProductsTableView from "./ProductsTableView.vue";

export default {
  components: {
    ProductsCreateView,
    ProductsTableView
  },
};
</script>

<template>
  <div class="container" id="product-home-main">
    <ProductsCreateView></ProductsCreateView>
    <ProductsTableView></ProductsTableView>
  </div>
</template>

<style scoped>
.container {
  margin-top: 15px;
}
</style>

