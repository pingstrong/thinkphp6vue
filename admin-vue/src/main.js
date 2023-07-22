import Vue from 'vue'
import App from './App.vue'
import ElementUI from 'element-ui';
import  'element-ui/lib/theme-chalk/index.css';
import 'font-awesome/css/font-awesome.min.css'
import router from "./router";
import store from "./store";
import adminauth from '@/common/adminauth';
import '@/common/dialog';
import './icons' // icon
import axios from 'axios'

Vue.prototype.$axios = axios
Vue.config.productionTip = false
Vue.use(ElementUI);

Vue.prototype.msgSuccess = function (msg) {
  this.$message({ showClose: true, message: msg, type: "success" });
}

Vue.prototype.msgError = function (msg) {
  this.$message({ showClose: true, message: msg, type: "error" });
}

new Vue({
	router,
	store,
  render: h => h(App),
}).$mount('#app')
