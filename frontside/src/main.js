import Vue from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify'
import store from './vuex/store'
import basic from "./components/layouts/Basic.vue"
import login from "./components/layouts/Login.vue"
import 'material-design-icons-iconfont/dist/material-design-icons.css'

Vue.component('basic', basic);
Vue.component('login', login);

//global local storage plugin
import persistentState from 'vue-persistent-state'
const initialState = {
   collapsedProducts: {newProds: []},
   userData: {fullName:'', id: ''},
   timers: {disableReloadTimer: 0},
};
Vue.use(persistentState, initialState);

/*cut string filter*/
var filter = function (text, length, clamp) {
  clamp = clamp || '...';
  var node = document.createElement('div');
  node.innerHTML = text;
  var content = node.textContent;
  return content.length > length ? content.slice(0, length) + clamp : content;
};
Vue.filter('truncate', filter);


Vue.config.productionTip = false

new Vue({
  store,
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
