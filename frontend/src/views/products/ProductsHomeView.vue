<script>
import Navbar from "../../components/Navbar.vue";
import ProductsCreateView from "./ProductsCreateView.vue";
import ProductsTableView from "./ProductsTableView.vue";

export default {
  components: {
    Navbar,
    ProductsCreateView,
    ProductsTableView,
  },
};
</script>

<template>
  <div id="product-home-main">
    <header>
      <Navbar></Navbar>
    </header>
    <div class="container">
      <ProductsCreateView></ProductsCreateView>
      <ProductsTableView></ProductsTableView>
    </div>
  </div>
</template>

<style scoped>
.container {
  margin-top: 15px;
}
</style>

