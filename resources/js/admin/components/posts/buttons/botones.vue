<template>
	<div>
		<a href="" v-if="VerButton('Ver noticias')" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"></i></a>

		<router-link v-if="VerButton('Modificar noticias')"  :to="{name: 'noticias.edit', params: {url: post.url }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil-alt"></i></router-link>

        <button v-if="VerButton('Eliminar noticias')" class="btn btn-outline-danger btn-sm" v-on:click="$confirmDelete"><i class="fa fa-trash"></i></button>
    </div>
</template>

<script>
	export default {
		props:['post'],
		data(){
			return{
				activo:0,
			}
		},
		methods: {
			VerButton(permission){
				if (this.$can(permission) || window.user.id === this.post.user_id) {
					return true
				}else{
					return false
				}
			},
			delete(){
				axios.delete(`/admin/posts/${this.post.url}`)
				.then(response => {
				    this.$emit('cargarPosts')
				    this.$mensaje("!Se eliminó la noticia correctamente¡", "success");
				}).catch(error => {
					console.log(error);
				});
			},
		},
}
</script>