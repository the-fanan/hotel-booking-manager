import Vue from "vue";
import VueRouter from "vue-router";

//Errors
import Error404 from "./components/views/errors/404";
//Auth
import Login from "./components/views/auth/Login";
//Pages
import BookingManager from "./components/views/BookingManager";
import Dashboard from "./components/views/Dashboard";
import HotelManager from "./components/views/HotelManager";
import PriceListManager from "./components/views/PriceListManager";
import RoomManager from "./components/views/RoomManager";
import RoomTypeManager from "./components/views/RoomTypeManager";

Vue.use(VueRouter);

export default new VueRouter({
	routes: [
				{
					path: "/",
					alias: "/login",
					component: Login,
				},
				{
					path: "/booking-management",
					component: BookingManager,
				},
				{
					path: "/dashboard",
					component: Dashboard,
				},
				{
					path: "/hotel-management",
					component: HotelManager,
				},
				{
					path: "/price-list-management",
					component: PriceListManager
				},
				{
					path: "room-management",
					component: RoomManager,
				},
				{
					path: "/room-type-management",
					component: RoomTypeManager
				},
		{
			path: "*",
			component: Error404,
		}
	]
});