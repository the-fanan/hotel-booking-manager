<template>
	<v-layout fill-height align-center justify-center column>
		<v-flex xs12>
			<v-form style="min-width: 400px;">
				<v-alert v-cloak :value="alert.show" :type="alert.type" dismissible>
					{{ alert.message }}
				</v-alert>

				<v-flex xs12 style="padding-top: 100px;">
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

			</v-form>
		</v-flex>
	</v-layout>
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
	},
	computed: {
    ...mapGetters({}),
    ...mapState({})
	},
	methods: {
		...mapMutations('auth', ['login']),
		...mapActions({}),
	}
}
</script>