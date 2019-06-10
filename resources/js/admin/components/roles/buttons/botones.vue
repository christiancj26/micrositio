<template>
	<div>

		<router-link v-if="VerButton('Modificar roles')"  :to="{name: 'roles.edit', params: {id: role.id }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil-alt"></i></router-link>

        <button v-if="VerButton('Eliminar roles')" class="btn btn-outline-danger btn-sm" v-on:click="$confirmDelete"><i class="fa fa-trash"></i></button>
    </div>

</template>

<script>
	export default {
		props:['role'],
		data(){
			return{
				activo:0,
			}
		},
		methods: {
			VerButton(permission){
				if (this.$can(permission)) {
					return true
				}else{
					return false
				}
			},
			delete(){
				axios.delete(`/admin/roles/${this.role.id}`)
				.then(response => {
				    this.$emit('cargarRoles')
				    this.$mensaje("!Se eliminó el Role correctamente¡", "success");
				}).catch(error => {
					if (error.response.status === 403) {
			           this.$mensaje(error.response.data.message, "error");
			        }
				});
			},
		},
}
</script>