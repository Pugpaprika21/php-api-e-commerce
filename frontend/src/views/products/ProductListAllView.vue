<script>
import Navbar from "../../components/Navbar.vue";
import ProductBtnTable from "../../components/buttons/ProductBtnTable.vue";
import IconBtnEditProduct from "../../components/icons/IconBtnEditProduct.vue";
import IconBtnDelProduct from "../../components/icons/IconBtnDelProduct.vue";

export default {
  data() {
    return {
      filterProduct: {
        limit: 10,
        search: "",
      },
      currentPage: 10,
      totalProducts: 0,
      productsList: [],
    };
  },
  components: {
    Navbar,
    ProductBtnTable,
    IconBtnEditProduct,
    IconBtnDelProduct,
  },
  methods: {
    getProductAll: function (cPage = 0) {
      this.$axios.get(`${process.env.VUE_BACKEND_URL}products/productAll.php`, {
          params: {
            page: cPage,
            limit: this.filterProduct.limit,
            search: this.filterProduct.search,
            APP_API_KEY: process.env.APP_API_KEY,
          },
        })
        .then((response) => {
          if (response.status == 200) {
            this.productsList = response.data.data.Data;
            this.totalProducts = response.data.data.TotalProduct.Total;
            console.log(response.data.data.TotalProduct.Total);
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
    changePage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        this.getProductAll(page - 1);
        console.log(this.currentPage);
      }
    },
  },
  computed: {
    totalPages() {
      return Math.ceil(this.totalProducts / this.filterProduct.limit);
    },
    paginatedProducts() {
      let start = (this.currentPage - 1) * this.filterProduct.limit;
      let end = start + this.filterProduct.limit;
      return this.productsList.slice(start, end);
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
            <b
              ><span class="badge rounded-pill text-bg-primary"
                >รายการสินค้า</span
              ></b
            >
          </div>
          <div class="col-md-2 mt-3">
            <div class="input-group input-group-sm mb-3">
              <label class="input-group-text" for="inputGroupSelect01"
              >ข้อมูล</label
            >
              <select
                class="form-select"
                v-model="filterProduct.limit"
                @change="getProductAll()"
              >
                <option disabled>จำนวนรายการสินค้า</option>
                <option v-for="i in 10" :key="i" :value="i * 10">
                  {{ i * 10 }}
                </option>
                <option value="1000">ทั้งหมด</option>
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
            <table class="table table-hover align-middle" id="products-table">
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
                      ><IconBtnDelProduct></IconBtnDelProduct
                    ></ProductBtnTable>
                    &nbsp;
                    <ProductBtnTable :action="`edit`" :productId="product.Id"
                      ><IconBtnEditProduct></IconBtnEditProduct
                    ></ProductBtnTable>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="product-pagination">
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-end">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <a class="page-link" @click="changePage(currentPage - 1)"
                    >Previous</a
                  >
                </li>
                <li
                  v-for="page in totalPages"
                  :key="page"
                  class="page-item"
                  :class="{ active: currentPage === page }"
                >
                  <a class="page-link" @click="changePage(page)">{{ page }}</a>
                </li>
                <li
                  class="page-item"
                  :class="{ disabled: currentPage === totalPages }"
                >
                  <a class="page-link" @click="changePage(currentPage + 1)"
                    >Next</a
                  >
                </li>
              </ul>
            </nav>
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

.form-control,
.form-select {
  border: 1px solid #ccc;
  transition: border 0.3s ease;
}

.form-control:hover,
.form-select:hover {
  border: 1px solid #4c47bf;
}
</style>