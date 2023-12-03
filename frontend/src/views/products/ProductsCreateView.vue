<script>
export default {
  data() {
    return {
      formProduct: {
        id: 0,
        name: "",
        description: "",
        price: 0,
        stock_quantity: 0,
      },
      updateProduct: {
        action: false,
      },
      productData: [],
    };
  },
  methods: {
    handleNumericInput(field) {
      this.formProduct[field] = this.formProduct[field].replace(/[^0-9.]/g, "");
      let parts = this.formProduct[field].split(".");
      if (parts.length > 2) {
        this.formProduct[field] = `${parts[0]}.${parts[1]}`;
      }
    },
    formCreateProduct: function () {
      if (this.formProduct.name == "") {
        this.$swal.fire({
          title: "ใส่ชื่อสินค้า...",
          text: "",
          icon: "warning",
          timer: 1000,
        });
        return;
      }
      if (this.formProduct.description == "") {
        this.$swal.fire({
          title: "ใส่รายละเอียดสินค้า...",
          text: "",
          icon: "warning",
          timer: 1000,
        });
        return;
      }
      if (this.formProduct.price == "") {
        this.$swal.fire({
          title: "ใส่ราคาสินค้า...",
          text: "",
          icon: "warning",
          timer: 1000,
        });
        return;
      }
      if (this.formProduct.stock_quantity == "") {
        this.$swal.fire({
          title: "ใส่จำนวนสินค้า...",
          text: "",
          icon: "warning",
          timer: 1000,
        });
        return;
      }

      this.$axios.post(`${process.env.VUE_BACKEND_URL}products/productCreate.php`, {
          APP_API_KEY: process.env.APP_API_KEY,
          formProduct: {
            name: this.formProduct.name,
            description: this.formProduct.description,
            price: parseInt(this.formProduct.price),
            stock_quantity: parseFloat(this.formProduct.stock_quantity),
          },
        })
        .then((response) => {
          if (response.status == 200) {
            this.$swal
              .fire({
                title: response.data.data.Msg,
                text: "",
                icon: "success",
                timer: 1000,
              })
              .then((result) => {
                this.$router.go(0);
              });
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    formUpdateProduct: function () {
      this.$axios.put(`${process.env.VUE_BACKEND_URL}products/productUpdate.php`, {
          APP_API_KEY: process.env.APP_API_KEY,
          formProduct: {
            id: this.formProduct.id,
            name: this.formProduct.name,
            description: this.formProduct.description,
            price: parseInt(this.formProduct.price),
            stock_quantity: parseFloat(this.formProduct.stock_quantity),
          },
        })
        .then((response) => {
          if (response.status == 200) {
            this.$swal
              .fire({
                title: response.data.data.Msg,
                text: "",
                icon: "success",
                timer: 1000,
              })
              .then((result) => {
                this.resetPage();
              });
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getProductIdUseUpdateProduct: function () {
      let productId = this.$route.query.params;
      if (productId != undefined) {
        this.$axios.get(`${process.env.VUE_BACKEND_URL}products/productEdit.php`, {
            params: {
              productId: parseInt(productId),
              APP_API_KEY: process.env.APP_API_KEY,
            },
          })
          .then((response) => {
            if (response.status == 200) {
              let productData = response.data.data.Data;
              this.formProduct.id = productData.Id;
              this.formProduct.name = productData.Name;
              this.formProduct.description = productData.Description;
              this.formProduct.price = productData.Price;
              this.formProduct.stock_quantity = productData.StockQuantity;
              this.updateProduct.action = false;
            }
          })
          .catch((err) => {
            console.log(err);
          });
        return;
      }
      this.updateProduct.action = true;
    },
    resetPage: function () {
      window.location.href = "/product/home";
    },
  },
  mounted() {
    this.getProductIdUseUpdateProduct();
  },
};
</script>

<template>
  <div class="row" id="product-create">
    <form
      method="post"
      @submit.prevent="
        updateProduct.action ? formCreateProduct() : formUpdateProduct()
      "
    >
      <p>
        <span class="badge rounded-pill text-bg-primary">เพิ่มสินค้า</span>
      </p>
      <div class="row">
        <div class="col-md-2">ชื่อสินค้า</div>
        <input type="hidden" v-model="formProduct.id" v-if="updateProduct.action == false">
        <div class="col-md-10">
          <div class="mb-3" v-if="updateProduct.action == true">
            <input
              type="text"
              class="form-control"
              v-model="formProduct.name"
            />
          </div>
          <div class="mb-3" v-if="updateProduct.action == false">
            <input
              type="text"
              class="form-control"
              v-model="formProduct.name"
            />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">รายละเอียด</div>
        <div class="col-md-10">
          <div class="mb-3" v-if="updateProduct.action == true">
            <textarea
              class="form-control"
              v-model="formProduct.description"
              rows="3"
            ></textarea>
          </div>
          <div class="mb-3" v-if="updateProduct.action == false">
            <textarea
              class="form-control"
              v-model="formProduct.description"
              rows="3"
            ></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">ราคา</div>
        <div class="col-md-10">
          <div class="mb-3" v-if="updateProduct.action == true">
            <input
              type="text"
              class="form-control"
              v-model="formProduct.price"
              @input="handleNumericInput('price')"
            />
          </div>
          <div class="mb-3" v-if="updateProduct.action == false">
            <input
              type="text"
              class="form-control"
              v-model="formProduct.price"
              @input="handleNumericInput('price')"
            />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">คลัง (ชิ้น)</div>
        <div class="col-md-10">
          <div class="mb-3" v-if="updateProduct.action == true">
            <input
              type="text"
              class="form-control"
              v-model="formProduct.stock_quantity"
              @input="handleNumericInput('stock_quantity')"
            />
          </div>
          <div class="mb-3" v-if="updateProduct.action == false">
            <input
              type="text"
              class="form-control"
              v-model="formProduct.stock_quantity"
              @input="handleNumericInput('stock_quantity')"
            />
          </div>
        </div>
      </div>
      <div id="btn-create-product" v-if="updateProduct.action == true">
        <button class="btn-main-create btn-create-product">บันทึก</button>
      </div>
      <div id="btn-create-product" v-if="updateProduct.action == false">
        <button class="btn-main-edit btn-edit-product">เเก้ไข</button>
        <button class="btn-main-reset btn-reset-product" @click="resetPage()">เพิ่มสินค้า</button>
      </div>
    </form>
  </div>
</template>

<style scoped>

#btn-create-product {
  float: right;
}
.btn-main-create {
  background-color: #3B5AD9 ; /* Green */
  border: none;
  color: white;
  padding: 2px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  margin: 5px;
  cursor: pointer;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.2s;
}

.btn-main-create {
  padding: 10px 20px;
  transition: box-shadow 0.3s ease-in-out;
}

.btn-main-create:hover {
  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
}
.btn-create-product:hover {
  box-shadow: 10px rgba(0, 0, 0, 0.24),0 17px 50px 0 rgba(0, 0, 0, 0.19);
}

.btn-main-edit {
  background-color: #82800a;
  border: none;
  color: white;
  padding:2px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  margin: 5px;
  cursor: pointer;
  -webkit-transition-duration: 0.4s;
  transition-duration: 0.2s;
}

.btn-edit-product {
  box-shadow: 10px rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
}

.btn-main-edit {
  padding: 10px 20px;
  transition: box-shadow 0.3s ease-in-out;
}

.btn-main-edit:hover {
  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
}

.btn-main-reset {
  background-color: #505514 ; 
  border: none;
  color: white;
  padding:2px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  margin: 5px;
  cursor: pointer;
  -webkit-transition-duration: 0.4s; 
  transition-duration: 0.2s;
}

.btn-reset-product {
  box-shadow: 10px rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
}

.btn-main-reset {
  padding: 10px 20px;
  transition: box-shadow 0.3s ease-in-out;
}

.btn-main-reset:hover {
  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
}

</style>