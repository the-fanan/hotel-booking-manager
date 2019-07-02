require('./admin-bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import Vuetify from 'vuetify';
import router from "./router";
import store from "./store";
import App from "./components/App";

Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(Vuetify);

new Vue({
	render: h => h(App),
  router,
  store
}).$mount("#admin-app");