<script>
import Navbar from "../../components/Navbar.vue";
import ProductBtnTable from "../../components/buttons/ProductBtnTable.vue";

export default {
  data() {
    return {
      filterProduct: {
        limit: 10,
        search: "",
      },
      productsList: [],
    };
  },
  components: {
    Navbar,
    ProductBtnTable,
  },
  methods: {
    getProductAll: function () {
      this.$axios
        .get(`${process.env.VUE_BACKEND_URL}products/productAll.php`, {
          params: {
            limit: this.filterProduct.limit,
            search: this.filterProduct.search,
            APP_API_KEY: process.env.APP_API_KEY,
          },
        })
        .then((response) => {
          if (response.status == 200) {
            this.productsList = response.data.data.Data;
            return;
          }
          this.filterProduct.limit = 10;
          this.filterProduct.search = "";
          return;
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
  <div id="product-all-main">
    <header>
      <Navbar></Navbar>
    </header>
    <div class="container">
      <div class="row" id="product-list">
        <div class="row">
          <div class="col-md-8 mt-3">
            <b><span class="badge rounded-pill text-bg-primary">รายการสินค้า</span></b>
          </div>
          <div class="col-md-2 mt-3">
            <div class="input-group input-group-sm mb-3">
              <select
                class="form-select"
                v-model="filterProduct.limit"
                @change="getProductAll()"
              >
                <option disabled>จำนวนรายการสินค้า</option>
                <option v-for="i in 10" :key="i" :value="i * 10">
                  {{ i * 10 }}
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-2 mt-3">
            <div class="input-group input-group-sm mb-3">
              <span class="input-group-text" id="inputGroup-sizing-sm"
                >ค้นหา</span
              >
              <input
                type="text"
                class="form-control"
                v-model="filterProduct.search"
                @keyup="getProductAll()"
              />
            </div>
          </div>
        </div>
        <div class="col-md-12 mt-3">
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
                    <ProductBtnTable :action="`delete`" :productId="product.Id"
                      ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-trash3-fill"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"
                        /></svg
                    ></ProductBtnTable>
                    &nbsp;
                    <ProductBtnTable :action="`edit`" :productId="product.Id"
                      ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-pencil-fill"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"
                        /></svg
                    ></ProductBtnTable>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.center-text {
  text-align: center;
}

.table th,
.table td {
  font-size: 14px;
}

@media screen and (max-width: 767px) {
  .table th,
  .table td {
    font-size: 12px;
  }
}

@media screen and (max-width: 575px) {
  .table th,
  .table td {
    font-size: 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
}

.form-control, .form-select {
    border: 1px solid #ccc;
    transition: border 0.3s ease;
  }
  
  .form-control:hover, .form-select:hover {
    border: 1px solid #4C47BF;
  }
  
</style>