import "./assets/main.css";
import "bulma/css/bulma.min.css";
import 'material-icons/iconfont/material-icons.css';
import 'vue3-toastify/dist/index.css';

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axios from './plugins/axios'
import Vue3Toasity, { type ToastContainerOptions } from 'vue3-toastify'
import { toast } from 'vue3-toastify'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(
    Vue3Toasity,
    {
      autoClose: 3000,
      position: toast.POSITION.BOTTOM_RIGHT,
      theme: toast.THEME.COLORED,
      clearOnUrlChange: false
    } as ToastContainerOptions
)

app.use(axios, {
    baseUrl: 'http://192.168.30.105:8000/api/',
})

app.mount('#app')
