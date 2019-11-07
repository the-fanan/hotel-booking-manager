<template>
	<v-container fluid>
		<v-layout align-center justify-center row>
			<v-flex xs12>
				<h1 class="primary--text">Room Types</h1>
				<v-divider></v-divider>
			</v-flex>
		</v-layout>

		<v-layout row justify-center>
			<v-alert v-cloak v-model="alert.show" :type="alert.type" dismissible>
				{{ alert.message }}
			</v-alert>
		</v-layout>

		<v-layout column fill-height justify-center>
			<v-flex xs12>
				<v-form v-on:submit.prevent="createRoomType" style="padding-top:10px;">
					<v-flex xs12 md4>
						<v-text-field
							v-model="newRoomType.name"
							label="Name"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12 md4>
						<v-select
							v-model="newRoomType.price_list_id"
							item-text="description"
							item-value="id"
							:items="prices"
							label="Price Type"
							outline
						></v-select>
					</v-flex>

					<v-flex xs12 sm6 md4>
						<v-btn large dark type="submit" color="info">Create New Room Type</v-btn>
					</v-flex>

				</v-form>
			</v-flex>
		</v-layout>

		<v-layout column fill-height justify-center>
			<v-data-table
			:headers="roomTypesHeaders"
			:items="roomTypes">
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
							v-model="props.item.name"
							label="Name"
							required
							type="text"
							outline
							></v-text-field>
						</td>

						<td>
							<v-select
							v-model="props.item.price_list_id"
							item-text="description"
							item-value="id"
							:items="prices"
							label="Price Type"
							outline
						></v-select>
						</td>

						<td><v-btn dark color="warning" @click="editRoomType(props.item)">Edit Room Type</v-btn> <v-btn dark color="error" @click="deleteRoomType(props.item)">Delete Room Type</v-btn></td>
					</tr>
				</template>
			</v-data-table>
		</v-layout>
	</v-container>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";
import _ from "lodash";

export default {
	data() {
		return {
			newRoomType: {name: "", price_list_id: ""},
			alert: { type: "error", show: false, message: null },
			prices: [],
			roomTypes: [],
			roomTypesHeaders: [
				{text: "Name", value: "name"},
				{text: "Price", value: "price_list_id"},
				{text: "Action", value: null}
			],
		}
	},
	created() {
		this.checkAuthentication();
		this.fetchPrices();
		this.fetchRoomTypes();
	},
	computed: {
    ...mapGetters({}),
		...mapState(['apiRoot']),
		...mapState('auth', ['token']),
	},
	methods: {
		...mapMutations('auth', ['checkAuthentication']),
		...mapActions({}),
		fetchPrices()
		{
			let vm = this;
			axios.get(vm.apiRoot + '/prices', {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				vm.prices = response.data;
			})
			.catch(error => {
				console.log(error);
			});
		},
		fetchRoomTypes()
		{
			let vm = this;
			axios.get(vm.apiRoot + '/room-types', {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				vm.roomTypes = response.data;
			})
			.catch(error => {
				console.log(error);
			});
		},
		createRoomType()
		{
			let vm = this;
			axios.post(vm.apiRoot + '/room-types', {name: vm.newRoomType.name, price_list_id: vm.newRoomType.price_list_id}, {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				vm.roomTypes.unshift(response.data.roomType);
				vm.newRoomType.name = "";
				vm.newRoomType.price_list_id = "";
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
		editRoomType(roomTypeDetails)
		{
			let vm = this;
			axios.post(vm.apiRoot + '/room-types/' + roomTypeDetails.id, {id: roomTypeDetails.id,name: roomTypeDetails.name, price_list_id: roomTypeDetails.price_list_id}, {
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
		deleteRoomType(roomTypeDetails)
		{
			let vm = this;
			axios.post(vm.apiRoot + '/room-types/delete/' + roomTypeDetails.id, {id: roomTypeDetails.id}, {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				var index = _.findIndex(vm.roomTypes, {id: roomTypeDetails.id});
				vm.roomTypes.splice(index, 1);
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
	}
}
</script>