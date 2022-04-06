import Vue from "vue";
import App from "./App";
import router from "./router";
import store from "./store";
import '../css/main.css'
import '../styles/app.scss';

// start the Stimulus application
import 'bootstrap';


new Vue({
  components: { App },
  template: "<App/>",
  router,
  store
}).$mount("#app");