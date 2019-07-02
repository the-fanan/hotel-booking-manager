<template>
	<h1>Hello</h1>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";

export default {
	data() {
		return {

		}
	},
	created() {
		alert("Login Created");
	},
	computed: {
    ...mapGetters({}),
    ...mapState({})
	},
	methods: {
		...mapMutations({}),
    ...mapActions({}),
	}
}
</script>