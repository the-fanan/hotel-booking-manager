<template>
	<v-container fluid>
		<v-layout align-center justify-center row>
			<v-flex xs12>
				<h1 class="primary--text">Dashboard</h1>
				<v-divider></v-divider>
			</v-flex>
		</v-layout>

		<v-layout row fill-height justify-space-around>
			<v-flex xs12 md6>
				<v-hover>
					<v-card color="blue" class="white--text">
						<h2>Hotel</h2>
					</v-card>
				</v-hover>
			</v-flex>

			<v-flex xs12 md6>
				<v-hover>
					<v-card color="purple" class="white--text">
						<h2>Room</h2>
					</v-card>
				</v-hover>
			</v-flex>
		</v-layout>

		<v-layout row fill-height justify-space-around>
			<v-flex xs12 md6>
			</v-flex>

			<v-flex xs12 md6>
			</v-flex>
		</v-layout>
	</v-container>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";

export default {
	data() {
		return {

		}
	},
	created() {
		this.checkAuthentication();
	},
	computed: {
    ...mapGetters({}),
    ...mapState({})
	},
	methods: {
		...mapMutations('auth', ['checkAuthentication']),
    ...mapActions({}),
	}
}
</script>