<template>
	<img :src="avatar" class="img-circle elevation-2" alt="User Image">
</template>

<script>
import { mapState } from 'vuex'

export default {
	props:['user'],
    mounted() {
		this.$store.dispatch('getAvatar', this.user.name);
	},
	computed: mapState([
	  'avatar'
	])
  }
</script>