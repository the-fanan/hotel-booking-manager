<template>
	<v-app>
		<v-navigation-drawer app v-model="drawer" v-if="isAuthenticated">
			 <v-toolbar flat>
				<v-list>
				<v-list-tile avatar>
					<v-list-tile-avatar>
						<img src="https://randomuser.me/api/portraits/men/85.jpg">
					</v-list-tile-avatar>

					<v-list-tile-content>
						<v-list-tile-title>Fanan Dala</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
			</v-list>
			</v-toolbar>

			<v-list class="pt-0" dense>
				<v-divider></v-divider>

				<v-list-tile
          v-for="(link,index) in adminLinks"
          :key="index"
					:to="link.to"
        >
          <v-list-tile-action>
            <v-icon>{{ link.icon }}</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>{{ link.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
			</v-list>
		</v-navigation-drawer>
		<v-toolbar app>
			<v-toolbar-side-icon @click="drawer = !drawer" v-if="isAuthenticated"></v-toolbar-side-icon>
    	<v-toolbar-title>Codeline Hotel Manager</v-toolbar-title>
			<v-spacer></v-spacer>
			<v-toolbar-items>
				<v-btn flat to="/login" class="primary--text" v-if="!isAuthenticated">Login</v-btn>
				<v-btn flat class="primary--text" v-if="isAuthenticated">Logout</v-btn>
    	</v-toolbar-items>
		</v-toolbar>
		<v-content>
			<v-container fluid>
				<router-view></router-view>
			</v-container>
		</v-content>
		
	</v-app>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";

export default {
	data() {
		return {
			adminLinks: [
				{title: "Dashboard", icon: "dashboard", to: "/dashboard"},
				{title: "Hotel", icon: "business", to: "/hotel-management"},
				{title: "Rooms", icon: "meeting_room", to: "/room-management"},
				{title: "Room Types", icon: "weekend", to: "/room-type-management"},
				{title: "Price List", icon: "list_alt", to: "/price-list-management"},
				{title: "Bookings", icon: "library_books", to: "/booking-management"},
			],
			drawer: null,
		}
	},
	created() {
	},
	computed: {
    ...mapGetters({}),
    ...mapState('auth', ['isAuthenticated'])
	},
	methods: {
		...mapMutations({}),
    ...mapActions({}),
	}
}
</script>