<script>
import IconAddToCartProduct from "../components/icons/IconAddToCartProduct.vue";
import IconBtnDelProduct from "../components/icons/IconBtnDelProduct.vue";
import IconBtnEditProduct from "../components/icons/IconBtnDelProduct.vue";
import Navbar from "../components/Navbar.vue";

export default {
  data() {
    return {
      filterProduct: {
        limit: 10,
        search: "",
      },
      currentPage: 20,
      totalProducts: 0,
      productsList: [],
    };
  },
  components: {
    Navbar,
    IconBtnDelProduct,
    IconBtnEditProduct,
    IconAddToCartProduct,
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
    this.getProductAll(this.currentPage); // Pass the current page as a parameter
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
  <div id="home-main">
    <header>
      <Navbar></Navbar>
    </header>
    <div class="container">
      <div class="row" id="product-list">
        <div class="row">
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
        </div>
        <div class="col-md-12 mt-3">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">ชื่อสินค้า</th>
                <th scope="col">รายละเอียด</th>
                <th scope="col">ราคา</th>
                <th scope="col">คลัง (ชิ้น)</th>
                <th scope="col">ชิ้อ (จำนวน)</th>
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
                <td>
                  <div class="input-group input-group-sm">
                    <input
                      type="number"
                      class="form-control"
                      style="max-width: 30%"
                    />
                  </div>
                </td>
                <td></td>
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
</template>