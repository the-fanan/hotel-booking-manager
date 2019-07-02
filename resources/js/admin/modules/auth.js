import router from "../router";

const auth = {
	namespaced: true,
	state: {
		user: {},
		token: null,
		isAuthenticated: false,
	},
	getters: {

	},
	mutations: {
		login(state, payload)
		{
			state.user = payload.user;
			state.token = payload.token;
			state.isAuthenticated = true;
		},
		logout(state)
		{
			state.user = {};
			state.token = null;
			state.isAuthenticated = false;
			router.push({ path: "/" });
		}
	},
	actions: {
		
	}
}
export default auth;