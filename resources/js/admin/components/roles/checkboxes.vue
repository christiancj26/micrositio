<template>
<div class="card card-primary card-outline">
	<div class="card-header with-border">
		<h3 class="card-title">Roles</h3>
	</div>
	<form @submit.prevent="sendForm">
		<div class="card-body">
			<div class="form-group">
				<label>Roles</label>
	       		<div class="checkbox" v-for="rol in roles">
					<label>
						<input :disabled="isAdmin"  type="checkbox" :id="rol.name" :value="rol.name" v-model="form.roles">
						{{ rol.display_name }}<br>
						<span class="font-weight-light font-italic ml-3">Permisos:</span>
						<small v-if="rol.name == 'Admin'" class="text-primary font-italic">Todos</small>
					    <small v-else class="text-primary font-italic" v-for="permiso in rol.permissions">
					        {{ permiso.name }}
					    </small>
					</label>
				</div>
	       	</div>
	       	<button v-show="!isAdmin" class="btn btn-primary btn-block" :disabled="working" >
				<span v-if="working">
					Editando...
				</span>
				<span v-else>
					Editar Roles
				</span>
			</button>
		</div>
	</form>
</div>
</template>

<script>
 export default {
 	data(){
		return{
			roles:[],
			selected_roles:[],
			form: {
				roles: [],
			},
			working: false,
		}
	},
	created(){
		this.getResults()
	},
	methods: {
		getResults(){
			axios.get('admin/users/' + this.$route.params.name + '/roles')
			.then(response => {
				this.roles = response.data.roles;
				for (var i = response.data.user.roles.length - 1; i >= 0; i--) {
					this.selected_roles[i] = response.data.user.roles[i].name
					this.form.roles = this.selected_roles
				}
			}).catch(error => {
				if (error.response.status === 403) {
		            this.$router.push('/error/403')
		        }
			});
		},
		sendForm(){
				this.working = true;
				this.$Progress.start();
				axios.put('/admin/users/' + this.$route.params.name + '/roles/update', this.form).then(response => {
					this.working = false;
					this.$Progress.finish();
					this.$mensaje("!Se editaron los roles del usuario correntamente¡", "success");
				}).catch(error => {
					if (error.response.status === 403) {
			            this.$router.push('/error/403')
			        }
					this.working = false;
					this.$Progress.fail();
				});
			},
	},
	computed:{
		isAdmin(){
			return !window.roles.includes('Admin')
		}
	}
}
</script>