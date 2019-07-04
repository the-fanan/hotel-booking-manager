<template>
	<v-container fluid>
		<v-layout align-center justify-center row>
			<v-flex xs12>
				<h1 class="primary--text">Bookings</h1>
				<v-divider></v-divider>
			</v-flex>
		</v-layout>

		<v-layout row justify-center>
			<v-alert v-cloak :value="alert.show" :type="alert.type" dismissible>
				{{ alert.message }}
			</v-alert>
		</v-layout>

		<v-layout column fill-height justify-center>
			<v-flex xs12>
				<v-form v-on:submit.prevent="createBooking" style="padding-top:10px;">
					<v-flex xs12 md4>
						<v-text-field
							v-model="newBooking.customer_name"
							label="Customer Name"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12 md4>
						<v-text-field
							v-model="newBooking.customer_email"
							label="Customer Email"
							required
							type="email"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12 md4>
						<v-select
							v-model="newBooking.room_id"
							item-text="name"
							item-value="id"
							:items="rooms"
							label="Room"
							outline
						></v-select>
					</v-flex>

					<v-flex xs12 md4>
						<v-text-field
							v-model="newBooking.start_date"
							hint="MM/DD/YYYY format"
              persistent-hint
              prepend-icon="event"
							label="Start Date"
							required
							type="datetime-local"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12 md4>
						<v-text-field
							v-model="newBooking.end_date"
							hint="MM/DD/YYYY format"
              persistent-hint
              prepend-icon="event"
							label="End Date"
							required
							type="datetime-local"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12 sm6 md4>
						<v-btn large dark type="submit" color="info">Create Booking</v-btn>
					</v-flex>

				</v-form>
			</v-flex>
		</v-layout>

		<v-toolbar style="margin-top: 10px; margin-bottom:10px">
			<v-spacer></v-spacer>
			<v-toolbar-items>
				<v-btn flat @click="listStyle = true"><v-icon>list</v-icon></v-btn>
				<v-btn flat @click="listStyle = false"><v-icon>grid_on</v-icon></v-btn>
			</v-toolbar-items>
		</v-toolbar>

		<v-layout column fill-height justify-center v-show="listStyle">
			<v-data-table
			:headers="bookingsHeaders"
			:items="bookings">
				<template v-slot:headers="props">
					<tr>
						<th v-for="header in props.headers" :key="header.text">
							{{ header.text }}
						</th>
					</tr>
				</template>

				<template v-slot:items="props">
					<tr>
						<td>
							<v-text-field
							v-model="props.item.customer_name"
							label="Customer Name"
							required
							type="text"
							outline
							></v-text-field>
						</td>

						<td>
							<v-text-field
							v-model="props.item.customer_email"
							label="Customer Email"
							required
							type="email"
							outline
							></v-text-field>
						</td>

						<td>
							<v-select
							v-model="props.item.room_id"
							item-text="name"
							item-value="id"
							:items="rooms"
							label="Room"
							outline
							></v-select>
						</td>

						<td>
							<v-text-field
								v-model="props.item.start_date"
								hint="MM/DD/YYYY format"
								persistent-hint
								prepend-icon="event"
								label="Start Date"
								required
								type="datetime-local"
								outline
							></v-text-field>
						</td>

						<td>
							<v-text-field
								v-model="props.item.end_date"
								hint="MM/DD/YYYY format"
								persistent-hint
								prepend-icon="event"
								label="End Date"
								required
								type="datetime-local"
								outline
							></v-text-field>
						</td>

						<td><v-btn dark color="warning" @click="editBooking(props.item)">Edit Booking</v-btn> <v-btn dark color="error" @click="deleteBooking(props.item)">Delete Booking</v-btn></td>
					</tr>
				</template>
			</v-data-table>
		</v-layout>

		<v-layout column fill-height justify-center v-show="!listStyle">
			Calendar
		</v-layout>
	</v-container>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";

export default {
	data() {
		return {
			listStyle: true,
			newBooking: {customer_name: "", customer_email: "",room_id: "", start_date: "", end_date: ""},
			alert: { type: "error", show: false, message: null },
			bookings: [],
			rooms: [],
			bookingsHeaders: [
				{text: "Customer Name", value: "customer_name"},
				{text: "Customer Email", value: "customer_email"},
				{text: "Room", value: "room_id"},
				{text: "Start Data", value: "start_date"},
				{text: "End Date", value: "end_date"},
				{text: "Action", value: null},
			],
		}
	},
	created() {
		this.checkAuthentication();
		this.fetchRooms();
		this.fetchBookings();
	},
	computed: {
    ...mapGetters({}),
    ...mapState(['apiRoot']),
		...mapState('auth', ['token']),
	},
	methods: {
		...mapMutations('auth', ['checkAuthentication']),
		...mapActions({}),
		fetchRooms()
		{
			let vm = this;
			axios.get(vm.apiRoot + '/rooms', {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				vm.rooms = response.data;
				vm.rooms = vm.rooms.map(room => { room.new_image = null; return room; });//this is done to handle picture updates
			})
			.catch(error => {
				console.log(error);
			});
		},
		fetchBookings()
		{
			let vm = this;
			axios.get(vm.apiRoot + '/bookings', {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				vm.bookings = response.data;
			})
			.catch(error => {
				console.log(error);
			});
		},
		createBooking()
		{
			let vm = this;
			axios.post(vm.apiRoot + '/bookings', {customer_name: vm.newBooking.customer_name, customer_email: vm.newBooking.customer_email, room_id: vm.newBooking.room_id, start_date: vm.newBooking.start_date, end_date: vm.newBooking.end_date}, {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				vm.bookings.unshift(response.data.booking);
				vm.newBooking.customer_name = "";
				vm.newBooking.customer_email = "";
				vm.newBooking.room_id = "";
				vm.newBooking.start_date = "";
				vm.newBooking.end_date = "";
				vm.alert = {type: "success", show: true, message: response.data.message };
			})
			.catch(error => {
				if (error.response !== undefined) {
					console.log(error.response)
					vm.alert = {type: "error", show: true, message: error.response.data.message + ". " + error.response.data.validation_messages};
				} else {
					console.log(error)
					vm.alert = {type: "error", show: true, message: "An error occured. Refresh page and try again." };
				}
			});
		},
		editBooking(bookingDetails)
		{
			let vm = this;
			axios.post(vm.apiRoot + '/bookings/' + bookingDetails.id, {id: bookingDetails.id,customer_name: bookingDetails.customer_name, customer_email: bookingDetails.customer_email, room_id: bookingDetails.room_id, start_date: bookingDetails.start_date, end_date: bookingDetails.end_date}, {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				vm.alert = {type: "success", show: true, message: response.data.message };
			})
			.catch(error => {
				if (error.response !== undefined) {
					console.log(error.response)
					vm.alert = {type: "error", show: true, message: error.response.data.message + ". " + error.response.data.validation_messages};
				} else {
					console.log(error)
					vm.alert = {type: "error", show: true, message: "An error occured. Refresh page and try again." };
				}
			});
		},
		deleteBooking(bookingDetails)
		{
			let vm = this;
			axios.post(vm.apiRoot + '/bookings/delete/' + bookingDetails.id, {id: bookingDetails.id}, {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				var index = _.findIndex(vm.bookings, {id: bookingDetails.id});
				vm.bookings.splice(index, 1);
				vm.alert = {type: "success", show: true, message: response.data.message };
			})
			.catch(error => {
				if (error.response !== undefined) {
					console.log(error.response)
					vm.alert = {type: "error", show: true, message: error.response.data.message + ". " + error.response.data.validation_messages};
				} else {
					console.log(error)
					vm.alert = {type: "error", show: true, message: "An error occured. Refresh page and try again." };
				}
			});
		}
	}
}
</script>