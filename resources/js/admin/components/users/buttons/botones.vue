<template>
	<div>
		<router-link :to="{name: 'usuarios.show', params: {name: user.name }}" v-if="VerButton('Ver usuarios')"  class="btn btn-outline-secondary btn-sm"><i class="fa fa-eye"></i></router-link>

		<router-link v-if="VerButton('Modificar usuarios')"  :to="{name: 'usuarios.edit', params: {name: user.name }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil-alt"></i></router-link>

        <button v-if="VerButton('Eliminar usuarios')" class="btn btn-outline-danger btn-sm" v-on:click="$confirmDelete"><i class="fa fa-trash"></i></button>
    </div>

</template>

<script>
	export default {
		props:['user'],
		data(){
			return{
				activo:0,
			}
		},
		methods: {
			VerButton(permission){
				if (this.$can(permission) || window.user.id === this.user.user_id) {
					return true
				}else{
					return false
				}
			},
			delete(){
				axios.delete(`/admin/users/${this.user.name}`)
				.then(response => {
				    this.$emit('cargarUsers')
				    this.$mensaje("!Se eliminó el usuario correctamente¡", "success");
				}).catch(error => {
					if (error.response.status === 403) {
			           this.$mensaje("!No tienes permiso para eliminar este usuario¡", "error");
			        }
				});
			},
		},
}
</script>