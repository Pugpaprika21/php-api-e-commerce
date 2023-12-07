<script>
import IconBtnDelProduct from "../components/icons/IconBtnDelProduct.vue";
import IconBtnEditProduct from "../components/icons/IconBtnDelProduct.vue";
import IconAddToCartProduct from "../components/icons/IconAddToCartProduct.vue";
import Navbar from "../components/Navbar.vue";

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
      ordersAddToCart: [],
      totalOrders: 0
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
    changePage: function (page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        this.getProductAll(page - 1);
      }
    },
    productCheckStockQuantity: function(productId, stockQuantity, totalAmount) {
      this.$axios.get(`${process.env.VUE_BACKEND_URL}products/productCheckStockQuantity.php?productId=${productId}&stockQuantity=${stockQuantity}&totalAmount=${totalAmount}`, {
          headers: {
            Authorization: `Bearer ${process.env.APP_API_KEY}`
          }
        })
        .then((response) => {
          if (response.status == 200) {
            console.log(response);
            return;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    setOrdersToCart: function (product) {
      let orders = {
        productId: product.Id,
        stockQuantity: product.StockQuantity,
        totalAmount: product.TotalAmount,
      };
      this.ordersAddToCart.push(orders);
      this.productCheckStockQuantity(product.Id, product.StockQuantity, product.TotalAmount);
    },
    saveOrdersToCart: function () {
      if (this.ordersAddToCart.length > 0) {
        this.$axios.post(`${process.env.VUE_BACKEND_URL}orders/createOrders.php`, {
            formOrders: {
              userId: parseInt(sessionStorage.getItem("Id")),
              orders: this.ordersAddToCart,
            },
            headers: {
              Authorization: `Bearer ${process.env.APP_API_KEY}`
            }
          })
          .then((response) => {
            if (response.status == 200) {
              this.$swal.fire({
                  title: response.data.data.Msg,
                  text: "",
                  icon: "success",
                  timer: 1000,
                })
                .then((result) => {
                  this.getTotalOrders();
                  this.ordersAddToCart = [];
                  this.$router.go(0);
                });
            }
          })
          .catch((err) => {
            console.log(err);
          });
        return;
      }
      this.$swal.fire({
        title: "ไม่พบรายการสั่งชิ้อ",
        text: "",
        icon: "warning",
        timer: 1000,
      })
      .then((result) => {
        this.getTotalOrders();
      });
    },
    getTotalOrders: function() {
      this.$axios.get(`${process.env.VUE_BACKEND_URL}orders/getOrders.php`, {
          params: {
            userId: parseInt(sessionStorage.getItem("Id")), 
            APP_API_KEY: process.env.APP_API_KEY
          },
        })
        .then((response) => {
          if (response.status == 200) {
            this.totalOrders = response.data.data[0].TotalOrders;
            return;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    }
  },
  computed: {
    totalPages: function () {
      return Math.ceil(this.totalProducts / this.filterProduct.limit);
    },
    paginatedProducts: function() {
      let start = (this.currentPage - 1) * this.filterProduct.limit;
      let end = start + this.filterProduct.limit;
      return this.productsList.slice(start, end);
    },
  },
  mounted: function () {
    this.getProductAll();
    this.getTotalOrders();
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
            <div class="col-md-6 mt-3">
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
            <!--  -->
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
            <div class="col-md-2 mt-3">
              <a
                href="#"
                class="link-offset-2 link-underline link-underline-opacity-0"
                @click="saveOrdersToCart()"
                >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เพิ่มในตระกร้า
                &nbsp;</a
              >
              <span
                class="badge position-relative"
                style="background-color: #272f90"
              >
                <IconAddToCartProduct>
                  เพิ่มในตระกร้า
                </IconAddToCartProduct>
                <span
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                  >{{ totalOrders }}+</span
                >
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-12 mt-3">
          <table class="table table-hover align-middle" id="products-table">
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
                      style="width: 100%"
                      v-model="product.TotalAmount"
                      @change.prevent="setOrdersToCart(product)"
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

<style scoped>
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
</style>