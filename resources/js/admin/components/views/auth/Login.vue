<template>
	<v-container fluid>
		<v-layout fill-height align-center justify-center column>
			<v-flex xs12>
				<v-form style="min-width: 400px;" v-on:submit.prevent="submitForm">
					<v-alert v-cloak :value="alert.show" :type="alert.type" dismissible>
						{{ alert.message }}
					</v-alert>

					<v-flex xs12>
						<v-text-field
							v-model="email"
							label="E-mail"
							required
							type="email"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12>
						<v-text-field
							v-model="password"
							label="Password"
							required
							type="password"
							outline
						></v-text-field>
					</v-flex>
					<v-flex xs12 sm6 md4>
						<v-btn large dark type="submit" color="info">Login</v-btn>
					</v-flex>
				</v-form>
			</v-flex>
		</v-layout>
	</v-container>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";
import axios from "axios";

export default {
	data() {
		return {
			alert: { type: "error", show: false, message: null },
			email: "",
			password: "",
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
		...mapMutations('auth', ['login', 'checkAuthentication']),
		...mapActions({}),
		submitForm()
		{
			let vm = this;
			axios.post(vm.apiRoot + '/auth/login', {email: vm.email, password: vm.password})
			.then(response => {
				vm.alert = {type: "success", show: true, message: response.data.message };
				this.login(response.data);
			})
			.catch(error => {
				
				if (error.response !== undefined) {
					console.log(error.response)
					vm.alert = {type: "error", show: true, message: error.response.data.message };
				} else {
					vm.alert = {type: "error", show: true, message: "An error occured. Refresh page and try again." };
				}
			});
		}
	}
}
</script>