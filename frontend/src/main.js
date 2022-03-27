import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
// plugins
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

import '@vueform/multiselect/themes/default.css'

createApp(App)
  .use(VueToast)
  .use(store)
  .use(router)
  .mount("#app");
