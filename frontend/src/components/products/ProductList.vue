<script>
import axios from "axios";
//import ProductsTableView from "../../views/products/ProductsTableView.vue";
export default {
  name: "ProductList",
  components: {
    ProductsTableView,
  },
  data() {
    return {
      keyApi: "QWERQDRFAQER1293@@U+-+1283U4-3473e7aa8drf",
    };
  },
  methods: {
    async getProductAll() {
      axios
        .post(
          "http://localhost/php-api-e-commerce/backend/api/orders/ordersAll.php",
          {
            APP_API_KEY: this.keyApi,
          }
        )
        .then((response) => {
          console.log(response);
        });
    },
  },
  mounted() {
    this.getProductAll();
  },
};
</script>

<template>
  <div class="product-list">
    <div class="container text-center">
      <div class="row">
        <div class="col-sm-8">col-sm-8</div>
        <div class="col-sm-4">col-sm-4</div>
      </div>
      <div class="row">
        <div class="col-sm">col-sm</div>
        <div class="col-sm">col-sm</div>
        <div class="col-sm">col-sm</div>
      </div>
    </div>
    <ProductsTableView></ProductsTableView>
  </div>
</template>
