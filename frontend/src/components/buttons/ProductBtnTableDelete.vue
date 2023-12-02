<script>
export default {
  props: {
    productId: {
      type: [Number, String],
      required: true,
    },
  },
  methods: {
    deleteProduct() {
      console.log("Deleting product with ID:", this.productId);
    },
  },
};
</script>
<template>
  <p><slot></slot></p>
</template>