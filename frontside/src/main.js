import Vue from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify';

import basic from "./components/layouts/Basic.vue";
import login from "./components/layouts/Login.vue";
import 'material-design-icons-iconfont/dist/material-design-icons.css'

Vue.component('basic', basic);
Vue.component('login', login);

Vue.config.productionTip = false

new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
