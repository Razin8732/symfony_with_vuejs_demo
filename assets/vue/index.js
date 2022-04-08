import Vue from "vue";
import App from "./App";
import router from "./router";
import store from "./store";
import '../css/main.css'
import '../styles/app.scss';

// start the Stimulus application
import 'bootstrap';
import BootstrapVue from 'bootstrap-vue'
import moment from 'moment';

Vue.use(BootstrapVue);

Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('Do MMM YYYY')
  }
});


new Vue({
  components: { App },
  template: "<App/>",
  router,
  store
}).$mount("#app");