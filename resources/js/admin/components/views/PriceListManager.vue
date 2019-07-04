<template>
	<v-container fluid>
		<v-layout align-center justify-center row>
			<v-flex xs12>
				<h1 class="primary--text">Price List</h1>
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
				<v-form v-on:submit.prevent="createPrice" style="padding-top:10px;">
					<v-flex xs12 md4>
						<v-text-field
							v-model="newPrice.price"
							label="Price (USD)"
							required
							type="number"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12 md4>
						<v-text-field
							v-model="newPrice.description"
							label="Description"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12 sm6 md4>
						<v-btn large dark type="submit" color="info">Create New Price</v-btn>
					</v-flex>

				</v-form>
			</v-flex>
		</v-layout>

		<v-layout column fill-height justify-center>
			<v-data-table
			:headers="priceListHeaders"
			:items="priceList">
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
							v-model="props.item.price"
							label="Price"
							required
							type="number"
							outline
							></v-text-field>
						</td>

						<td>
							<v-text-field
							v-model="props.item.description"
							label="Description"
							required
							type="text"
							outline
							></v-text-field>
						</td>

						<td><v-btn dark color="warning" @click="editPrice(props.item)">Edit Price</v-btn> <v-btn dark color="error" @click="deletePrice(props.item)">Delete Price</v-btn></td>
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
			newPrice: {price: "", description: ""},
			alert: { type: "error", show: false, message: null },
			priceList: [],
			priceListHeaders: [
				{text: "Price (USD)", value: "price"},
				{text: "Description", value: "description"},
				{text: "Action", value: null}
			],
		}
	},
	created() {
		this.checkAuthentication();
		this.fetchPrices();
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
				vm.priceList = response.data;
			})
			.catch(error => {
				console.log(error);
			});
		},
		createPrice()
		{
			let vm = this;
			axios.post(vm.apiRoot + '/prices', {price: vm.newPrice.price, description: vm.newPrice.description}, {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				vm.priceList.unshift(response.data.price);
				vm.newPrice.price = "";
				vm.newPrice.description = "";
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
			})
		},
		editPrice(priceDetails)
		{
			let vm = this;
			axios.post(vm.apiRoot + '/prices/' + priceDetails.id, {id: priceDetails.id,price: priceDetails.price, description: priceDetails.description}, {
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
		deletePrice(priceDetails)
		{
			let vm = this;
			axios.post(vm.apiRoot + '/prices/delete/' + priceDetails.id, {id: priceDetails.id}, {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				var index = _.findIndex(vm.priceList, {id: priceDetails.id});
				vm.priceList.splice(index, 1);
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