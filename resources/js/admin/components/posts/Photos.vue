<template>
	<div class="col-md-12 m-1" v-if="photos.length">
         <div class="row">
              <div class="col-md-3" v-for="photo in photos">
                <button class="btn btn-danger btn-xs" style="position: absolute; border-radius: 0" v-on:click="confirmDelete(photo.id)">
                  <i class="fas fa-window-close"></i>
                </button>
                <img class="img-responsive" :src="photo.url" width="100%">
              </div>
        </div>
	</div>
</template>

<script>
	export default {
		props:['photos'],
		methods:{
			deletePhoto(photo){
				axios.delete(`/admin/photos/${photo}`)
				.then(response => {
					this.$store.dispatch('getPhotos', this.$route.params.url);
				}).catch(error => {
					console.log(error);
				});
			},
			confirmDelete(photo){
				this.$swal.fire({
				  title: '¿Estás seguro?',
				  text: "¡No podrás revertir esto!",
				  type: 'advertencia',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: '¡Sí, bórrala!'
				}).then((result) => {
				  if (result.value) {
				  	this.deletePhoto(photo);
				  }
				})
			}
		},
	}
</script>