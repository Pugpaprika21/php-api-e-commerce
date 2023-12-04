<script>
import { RouterLink, RouterView } from "vue-router";
import { getProductById } from "../../utils/products";
import { checkUserLogin } from "../../utils/user";

export default {
  data() {
    return {
      appName: "",
      navbarRole: "",
    };
  },
  mounted() {
    checkUserLogin();
    this.appName = process.env.APP_NAME;
    this.navbarRole = localStorage.getItem("Roles");
  },
};
</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-main">
    <div class="container-fluid">
      <RouterLink class="nav-link active" :to="{ name: 'home' }"
        ><b>{{ appName }}</b></RouterLink
      >
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item" v-if="navbarRole.includes('2')">
            <!-- admin -->
            <RouterLink
              class="nav-link active"
              :to="{ name: 'product-home' }"
              style="color: #ffffff"
              >จัดการสินค้า</RouterLink
            >
          </li>

          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              style="color: #ffffff"
            >
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider" /></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" style="color: #ffffff">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" style="color: #ffffff">Pricing</a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link disabled"
              aria-disabled="true"
              style="color: #ffffff"
              >Disabled</a
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<!--  #3ee0a2 -->
<style scoped>
.navbar-main {
  color: #ffffff;
  background-color: #4c47bf;
}
</style>