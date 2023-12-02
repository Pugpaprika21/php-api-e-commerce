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
    formCreateProduct: function () {
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
          console.log(response.data);
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
      <div class="col-md-12">
        <p>เพิ่มสินค้า</p>
        <div class="create-product">
          <div class="mb-3">
            <input
              type="text"
              class="form-control"
              v-model="formProduct.name"
            />
          </div>
          <div class="mb-3">
            <textarea
              class="form-control"
              v-model="formProduct.description"
              rows="3"
            ></textarea>
          </div>

          <div class="mb-3">
            <input
              type="text"
              class="form-control"
              v-model="formProduct.price"
            />
          </div>

          <div class="mb-3">
            <input
              type="text"
              class="form-control"
              v-model="formProduct.stock_quantity"
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