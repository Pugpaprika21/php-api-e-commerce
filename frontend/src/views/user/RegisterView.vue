<script>
import { RouterLink, RouterView } from "vue-router";

export default {
  data() {
    return {
      formRegister: {
        username: "",
        password: "",
        email: "",
        phone_number: "",
      },
    };
  },
  methods: {
    formRegisterUser: function () {
      this.$axios.post(`${process.env.VUE_BACKEND_URL}users/register.php`, {
          APP_API_KEY: process.env.APP_API_KEY,
          formRegister: {
            username: this.formRegister.username,
            password: this.formRegister.password,
            email: this.formRegister.email,
            phone_number: this.formRegister.phone_number,
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
                this.$router.push({ name: "login" });
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
  <div class="container-fluid">
    <div class="card-main-register" style="margin-top: 100px">
      <div class="d-flex justify-content-center">
        <div class="card shadow-sm" style="width: 30rem">
          <div class="card-body">
            <p
              class="card-text text-center"
              style="text-align: center; font-size: 30px"
            >
              ลงทะเบียน /
            </p>
            <form id="register-main" @submit.prevent="formRegisterUser()">
              <div class="form-floating mb-4 mt-4">
                <input
                  type="text"
                  class="form-control"
                  v-model="formRegister.username"
                />
                <label for="username">ชื่อผู้ใช้</label>
              </div>
              <div class="form-floating mb-4 mt-4">
                <input
                  type="password"
                  class="form-control"
                  v-model="formRegister.password"
                />
                <label for="userpass">รหัสผ่าน</label>
              </div>
              <div class="form-floating mb-4 mt-4">
                <input
                  type="text"
                  class="form-control"
                  id="userPhone"
                  v-model="formRegister.phone_number"
                />
                <label for="userPhone">มือถือ</label>
              </div>

              <div class="form-floating mb-4 mt-4">
                <input
                  type="text"
                  class="form-control"
                  v-model="formRegister.email"
                />
                <label for="userEmail">Email</label>
              </div>
              <button
                type="submit"
                class="button btn-register-main btn-register"
              >
                ลงทะเบียน
              </button>
              <br />

              <p class="lh-base text-center" style="margin-top: 30px">
                <RouterLink
                  class="link-offset-2 link-underline link-underline-opacity-0 text-secondary"
                  :to="{ name: 'login' }"
                  ><b>กลับสู่หน้าล๊อคอิน</b></RouterLink
                >
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.btn-register-main {
  background-color: #262382;
  border: none;
  color: white;
  padding: 15px 32px;
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

.btn-register:hover {
  box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24),
    0 17px 50px 0 rgba(0, 0, 0, 0.19);
}
</style>