<template>
<div class="card card-primary card-outline">
	<div class="card-header with-border">
		<h3 class="card-title">Permisos</h3>
	</div>
	<form @submit.prevent="sendForm">
		<div class="card-body">
			<div class="form-group">
				<label>Permisos</label>
				<div class="checkbox" v-for="permission in permissions">
					<label>
						<input :disabled="isAdmin" :id="permission.name" :value="permission.name" type="checkbox" v-model="form.permissions">
						{{ permission.name }}
					</label>
				</div>
			</div>
			<button v-show="!isAdmin" class="btn btn-primary btn-block" :disabled="working">
				<span v-if="working">
					Editando...
				</span>
				<span v-else>
					Editar permisos
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
			permissions:[],
			selected_permissions:[],
			form: {
				permissions: [],
			},
			working: false,
		}
	},
	created(){
		this.getResults()
	},
	methods: {
		getResults(){
			axios.get('admin/users/' + this.$route.params.name + '/permissions')
			.then(response => {
				this.permissions = response.data.permissions;
				for (var i = response.data.user.permissions.length - 1; i >= 0; i--) {
					this.selected_permissions[i] = response.data.user.permissions[i].name
					this.form.permissions = this.selected_permissions
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
				axios.put('/admin/users/' + this.$route.params.name + '/permissions/update', this.form).then(response => {
					this.working = false;
					this.$Progress.finish();
					this.$mensaje("!Se editaron los permisos del usuario correntamente¡", "success");
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