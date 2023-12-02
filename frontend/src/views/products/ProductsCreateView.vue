<script>
import axios from "axios";
export default {
  data() {
    return {
      formProduct: {
        name: "",
        description: "",
        price: 0,
        stock_quantity: 0,
      },
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
      axios
        .post(`${process.env.VUE_BACKEND_URL}products/productCreate.php`, {
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
  },
};
</script>

<template>
  <div class="row" id="product-create">
    <form method="post" @submit.prevent="formCreateProduct()">
      <p>
        <span class="badge rounded-pill text-bg-primary">เพิ่มสินค้า</span>
      </p>
      <div class="row">
        <div class="col-md-2">ชื่อสินค้า</div>
        <div class="col-md-10">
          <div class="mb-3">
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
          <div class="mb-3">
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
          <div class="mb-3">
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
          <div class="mb-3">
            <input
              type="text"
              class="form-control"
              v-model="formProduct.stock_quantity"
              @input="handleNumericInput('stock_quantity')"
            />
          </div>
        </div>
      </div>
      <div id="btn-create-product">
        <button class="button btn-create-product">บันทึก</button>
      </div>
    </form>
  </div>
</template>

<style scoped>
.button {
  background-color: #3ee0a2; /* Green */
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

#btn-create-product {
  float: right;
}

.button {
  padding: 10px 20px;
  transition: box-shadow 0.3s ease-in-out;
}

.button:hover {
  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.2);
}
.btn-create-product:hover {
  box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24),
    0 17px 50px 0 rgba(0, 0, 0, 0.19);
}
</style>