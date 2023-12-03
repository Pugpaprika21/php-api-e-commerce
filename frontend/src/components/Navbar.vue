<script>
import { RouterLink, RouterView } from "vue-router";
export default {
  data() {
    return {
      appName: ""
    }
  },
  mounted() {  
    this.appName = process.env.APP_NAME
  },
};
</script>
<template>
  <nav class="navbar navbar-expand-lg navbar-main">
    <div class="container-fluid">
      <RouterLink class="nav-link active" :to="{ name: 'home' }"><b>{{ appName }}</b></RouterLink>
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
          <li class="nav-item">
            <RouterLink class="nav-link active" :to="{ name: 'product-home' }"
              >จัดการสินค้า</RouterLink
            >
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<!--  #3ee0a2 -->
<style scoped>
.navbar-main {
  color: #FFFFFF;
  background-color: rgba(22, 157, 105, 0.486);
}
</style>