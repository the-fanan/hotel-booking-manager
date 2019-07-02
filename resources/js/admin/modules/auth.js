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
			router.push({ path: "/hotel-management" });
		},
		logout(state)
		{
			state.user = {};
			state.token = null;
			state.isAuthenticated = false;
			router.push({ path: "/" });
		},
		checkAuthentication(state)
		{
			if (state.isAuthenticated && (router.currentRoute.path == "/" || router.currentRoute.path == "/login")) {
				router.push({path: "/hotel-management"});
			} else if (!state.isAuthenticated && (router.currentRoute.path != "/" || router.currentRoute.path != "/login")) {
				router.push({path: "/login"});
			}
		}
	},
	actions: {
		
	}
}
export default auth;