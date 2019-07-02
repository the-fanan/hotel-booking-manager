import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from 'vuex-persistedstate';
import * as Cookies from 'js-cookie';
import router from "./router";
import axios from "axios";

export default new Vuex.Store({
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