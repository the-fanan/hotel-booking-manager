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
				<v-form v-on:submit.prevent="createPrice" syle="padding-top:10px;">
					<v-flex xs12 md4>
						<v-text-field
							v-model="newPrice.price"
							label="Price"
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
	</v-container>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";

export default {
	data() {
		return {
			newPrice: {price: "", description: ""},
			alert: { type: "error", show: false, message: null },
			priceLists: {},
		}
	},
	created() {
		this.checkAuthentication();
	},
	computed: {
    ...mapGetters({}),
    ...mapState(['apiRoot'])
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
				vm.priceLists = response.data;
			});
		},
		createPrice()
		{

		},
	}
}
</script>