<script>
import axios from "axios";
import ProductBtnTableDelete from "../../components/buttons/ProductBtnTableDelete.vue";

export default {
  data() {
    return {
      productsList: [],
    };
  },
  components: {
    ProductBtnTableDelete,
  },
  methods: {
    getProductAll: function () {
      axios
        .get(`${process.env.VUE_BACKEND_URL}products/productAll.php`, {
          APP_API_KEY: process.env.APP_API_KEY,
        })
        .then((response) => {
          if (response.status == 200) {
            this.productsList = response.data.data.Data;
           // console.log(response.data.data.Data);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.getProductAll();
  },
};
</script>

<template>
  <div class="row" id="product-list">
    <div class="col-md-12">
      <span class="badge rounded-pill text-bg-primary">รายการสินค้า</span>
    </div>
    <div class="product-table-list">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">ชื่อสินค้า</th>
            <th scope="col">รายละเอียด</th>
            <th scope="col">ราคา</th>
            <th scope="col">คลัง (ชิ้น)</th>
            <th scope="col">สร้าง</th>
            <th scope="col">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(product, index) in productsList" :key="product.Id">
            <td>{{ index + 1 }}</td>
            <td>{{ product.Name }}</td>
            <td>{{ product.Description }}</td>
            <td>{{ product.Price }}</td>
            <td>{{ product.StockQuantity }}</td>
            <td>{{ product.CreatedAt }}</td>
            <td>
              <ProductBtnTableDelete :productId="product.Id">
                ปุ่มลบ
              </ProductBtnTableDelete>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
.center-text {
  text-align: center;
}
</style>