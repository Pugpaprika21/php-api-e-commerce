<script>
import ProductsCreateView from "./ProductsCreateView.vue";

export default {
  components: {
    ProductsCreateView,
  },
};
</script>

<template>
  <div class="container" id="product-home-main">
    <ProductsCreateView></ProductsCreateView>
    <div class="row" id="product-list">
      <div class="col-md-12">รายการสินค้า</div>
    </div>
  </div>
</template>

<style scoped>
.container {
  margin-top: 15px;
}
</style>

