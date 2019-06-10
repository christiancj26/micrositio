<template>
	<transition name="fade">
        <img class="profile-user-img img-fluid img-circle" v-bind:src="src" v-on:load="onLoaded" v-show="loaded">&nbsp;
     </transition>
</template>

<script>
	export default {
		props: ['src'],
		data: function() {
		    return {
		      loaded: false,
		    }
		},
		methods: {
		    onLoaded() {
		      this.loaded = true;
		    }
		},
	}
</script>

<style>
.fade-enter-active {
  transition: opacity 1s ease-in-out;
}

.fade-enter-to {
  opacity: 1;
}

.fade-enter {
  opacity: 0;
}
</style>