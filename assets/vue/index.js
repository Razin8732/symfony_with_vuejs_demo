import Vue from "vue";
import App from "./App";
import router from "./router";
import store from "./store";
import '../css/main.css'
import '../styles/app.scss';

// start the Stimulus application
import 'bootstrap';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'


Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
new Vue({
  components: { App },
  template: "<App/>",
  router,
  store
}).$mount("#app");