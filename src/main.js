import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import service from './service';

Vue.config.productionTip = false
Vue.prototype.$http = service;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
