import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
import hotel from "./modules/hotel";
import room from "./modules/room";
import booking from "./modules/booking";
import auth from "./modules/auth";

Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		apiRoot: "http://localhost:8000/api/admin"
	},
	getters: {

	},
	mutations: {

	},
	actions: {

	},
	modules: {
		auth,
		hotel,
		room,
		booking,
	},
	plugins: [createPersistedState()],
});