<template>
	<div>
		<router-view></router-view>
	</div>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";

export default {
	data() {
		return {

		}
	},
	created() {

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