import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import Swal from 'sweetalert2' // Import SweetAlert

const app = createApp(App)

app.use(createPinia())
app.use(router)

// Make Swal accessible globally
app.config.globalProperties.$swal = Swal

app.mount('#app')