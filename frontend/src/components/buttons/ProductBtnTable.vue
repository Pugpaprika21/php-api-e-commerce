<script>
export default {
  data() {
    return {
      isClicked: false,
      btnName: "",
      styleObject: {
        color: "red",
        fontSize: "13px",
      },
    };
  },
  props: {
    productId: {
      type: [Number, String],
      required: true,
    },
    action: {
      type: String,
      required: true,
    },
  },
  methods: {
    btnActionProduct: function (event) {
      this.btnName = this.action == "delete" ? "ลบ" : "แก้ไข";
      if (event) {
        if (this.action == "delete") {
          this.actionProductDelete(this.productId);
        } else {
          this.actionProductEdit(this.productId);
        }
      }
    },
    actionProductDelete: function (productId) {
      this.$axios
        .delete(`${process.env.VUE_BACKEND_URL}products/productDelete.php`, {
          data: {
            productId: parseInt(productId),
            APP_API_KEY: process.env.APP_API_KEY,
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
    actionProductEdit: function (productId) {
      this.$axios
        .get(`${process.env.VUE_BACKEND_URL}products/productEdit.php`, {
          params: {
            productId: parseInt(productId),
            APP_API_KEY: process.env.APP_API_KEY,
          },
        })
        .then((response) => {
          if (response.status == 200) {
            let productId = response.data.data.Data.Id;
            window.location.href =
              "/e-commerce/product/home?params=" + productId;
            return;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.btnActionProduct();
  },
};
</script>
<template>
  <button
    type="button"
    :class="[`btn-main-${action}`, `btn-${action}`]"
    @click="btnActionProduct($event)"
  >
    <slot></slot>
  </button>
</template>

<style>
.btn-main-delete {
  background-color: #d95f5f;
  border: none;
  color: white;
  padding: 5px 8px 5px 8px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  margin: 4px 2px;
  cursor: pointer;
  -webkit-transition-duration: 0.4s;
  transition-duration: 0.4s;
}

.btn-main-edit {
  background-color: rgb(249, 203, 19);
  border: none;
  color: white;
  padding: 5px 8px 5px 8px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 15px;
  margin: 4px 2px;
  cursor: pointer;
  -webkit-transition-duration: 0.4s;
  transition-duration: 0.4s;
}

.btn-delete:hover {
  box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24),
    0 17px 50px 0 rgba(0, 0, 0, 0.19);
}

.btn-edit:hover {
  box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24),
    0 17px 50px 0 rgba(0, 0, 0, 0.19);
}

@media screen and (max-width: 767px) {
  .btn-main-delete,
  .btn-main-edit,
  .btn-delete,
  .btn-edit {
    font-size: 12px;
    padding: 8px 12px;
  }
}

@media screen and (max-width: 575px) {
  .btn-main-delete,
  .btn-main-edit,
  .btn-delete,
  .btn-edit {
    font-size: 10px;
    padding: 6px 10px;
  }
}
</style>

<!-- <p><slot></slot></p> -->