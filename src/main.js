import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import request from './services/request';

Vue.config.productionTip = false
Vue.prototype.$http = request;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app');
