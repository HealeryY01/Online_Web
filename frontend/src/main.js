import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import axios from "./plugins/axios";
// import axios from "axios";
import "./style.css";

const app = createApp(App);
app.use(createPinia()); // Sử dụng plugin persist trong Pinia
app.config.globalProperties.$axios = axios;
app.use(router);
app.use(store);
app.mount("#app");
