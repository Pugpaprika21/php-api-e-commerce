<script>
import { RouterLink, RouterView } from "vue-router";

export default {
  data() {
    return {
      formLogin: {
        username: "",
        password: "",
      },
    };
  },
  methods: {
    formSubmitLogin: function () {
      this.$axios.post(`${process.env.VUE_BACKEND_URL}users/login.php`, {
          APP_API_KEY: process.env.APP_API_KEY,
          formLogin: {
            username: this.formLogin.username,
            password: this.formLogin.password,
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
                //this.$router.push({ name: "login" });
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

<template >
  <div class="container-fluid">
    <div class="card-main-login" style="margin-top: 200px">
      <div class="d-flex justify-content-center">
        <div class="card shadow-sm" style="width: 30rem">
          <div class="card-body">
            <p
              class="card-text text-center"
              style="text-align: center; font-size: 30px"
            >
              ระบบ
            </p>
            <form id="login-main" @submit.prevent="formSubmitLogin()">
              <div class="form-floating mb-4 mt-4">
                <input
                  type="text"
                  class="form-control"
                  v-model="formLogin.username"
                />
                <label for="username">ชื่อผู้ใช้</label>
              </div>
              <div class="form-floating mb-2 mt-4">
                <input
                  type="password"
                  class="form-control"
                  v-model="formLogin.password"
                />
                <label for="userpass">รหัสผ่าน</label>
              </div>
              <div class="register mb-2 mt-3">
                <RouterLink
                  class="link-offset-2 link-underline link-underline-opacity-0 text-secondary"
                  :to="{ name: 'register' }"
                  ><b>ลงทะเบียน</b></RouterLink
                >
              </div>
              <button type="submit" class="button btn-login btn-singin">
                เข้าสู่ระบบ
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.btn-login {
  background-color: #262382;
  border: none;
  color: white;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  -webkit-transition-duration: 0.4s;
  transition-duration: 0.4s;
  width: 100%;
}

.btn-singin:hover {
  box-shadow: 4px 2px 4px 2px rgba(0, 0, 0, 0.24),
    0 17px 50px 0 rgba(0, 0, 0, 0.19);
}
</style>