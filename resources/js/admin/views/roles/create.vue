<template>
	<div>
	<div class="content-header">
	     <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-6">
	            <h1 class="m-0 text-dark">Crear Role</h1>
	          </div><!-- /.col -->
	          <div class="col-sm-6">
	            <ol class="breadcrumb float-sm-right">
	              <li class="breadcrumb-item"><router-link to="/">Inicio</router-link></li>
	              <li class="breadcrumb-item active">Crear Role</li>
	            </ol>
	          </div><!-- /.col -->
	        </div><!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </div>
	    <div class="row">
		<div class="col-md-6">
			<div class="card card-primary card-outline">
				<div class="card-body">
				<form @submit.prevent="sendForm">
					<div class="form-group">
						<label for="name" class="control-label">Identificador</label>
							<input  type="text" :class="classError(errores.name)" class="form-control" v-model="form.name" placeholder="Ingresa nombre de identificador de role">
							<span v-if="errores.name" class="text-danger">{{ errores.name[0] }}</span>
					</div>

					<div class="form-group">
						<label for="display_name" class="control-label">Nombre</label>
						<input type="text" :class="classError(errores.display_name)" class="form-control"  v-model="form.display_name"  placeholder="Ingresa nombre de role">
						<span v-if="errores.display_name" class="text-danger">{{ errores.display_name[0] }}</span>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Permisos</label>
							<div class="checkbox" v-for="permission in permissions">
								<label>
									<input :disabled="isAdmin" :id="permission.name" :value="permission.name" type="checkbox" v-model="form.permissions">
									{{ permission.name }}
								</label>
							</div>
						</div>
					</div>
					<button class="btn btn-primary btn-block" :disabled="working">
						<span v-if="working">
							Creando...
						</span>
						<span v-else>
							Crear Role
						</span>
					</button>
				</form>
				</div>
			</div>
		</div>
	</div>
	</div>
</template>

<script>
 export default {
 	data(){
		return{
			permissions:[],
			form: {
				name:'',
				display_name:'',
				permissions: []
			},
			working: false,
			errores:{}
		}
	},
	created(){
		this.getResults()
	},
	methods: {
		getResults(){
			axios.get('admin/roles/create')
			.then(response => {
				this.permissions = response.data;
			}).catch(error => {
				if (error.response.status === 403) {
		            this.$router.push('/error/403')
		        }
			});
		},
		sendForm(){
				this.working = true;
				this.$Progress.start();
				axios.post('/admin/roles', this.form).then(response => {
					this.working = false;
					this.$Progress.finish();
					this.$mensaje("!Se guardó el role correntamente¡", "success");
					this.$router.push({name: 'roles'})
				}).catch(error => {
					if (error.response.status === 403) {
			            this.$router.push('/error/403')
			        }
			        this.errores = error.response.data.errors
					this.working = false
					this.$Progress.fail()
				});
			},
			classError(error){
				return error ? 'is-invalid' : ''
			},
	},
	computed:{
		isAdmin(){
			return !window.roles.includes('Admin')
		}
	}
}
</script>