import './assets/main.css' // axios

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import Swal from 'sweetalert2'
import axios from "axios";

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.config.globalProperties.$swal = Swal
app.config.globalProperties.$axios = axios;

app.mount('#app')