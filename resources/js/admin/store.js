import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";
import * as Cookies from "js-cookie";
import router from "./router";
import axios from "axios";
import hotel from "./modules/hotel";
import room from "./modules/room";
import booking from "./modules/booking";
import auth from "./modules/auth";

export default new Vuex.Store({
	state: {

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
	plugins: [createPersistedState({
		key: 'user',
		storage: {
			getItem: key => Cookies.get(key),
			setItem: (key, value) =>
				Cookies.set(key, value, { expires: 3, secure: true }),
			removeItem: key => Cookies.remove(key),
		},
	})],
});