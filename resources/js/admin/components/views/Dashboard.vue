<template>
	<h1>Dashboard</h1>
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