<template>
<div>
	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Crear usuario</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/">Inicio</router-link></li>
              <li class="breadcrumb-item active">Crear usuario</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="row">
		<div class="col-md-6">
		<div class="card card-primary card-outline">
			<div class="card-header with-border">
				<h3 class="card-title">Datos de usuario</h3>
			</div>
			<div class="card-body">
				<form @submit.prevent="sendForm">
					<div class="form-group">
				        <label for="avatar" class="control-label">Foto de perfil</label>
				        <input type="file" id="avatar"  :class="classError(errores.avatar)" class="form-control">
				        <span v-if="errores.avatar" class="text-danger">{{ errores.avatar[0] }}</span>
			      	</div>
					<div class="form-group">
				        <label for="name" class="control-label">Nombre completo</label>
				        <input type="text" :class="classError(errores.name)" class="form-control" v-model="form.name" placeholder="Ingresa aquí tu nombre completo">
				        <span v-if="errores.name" class="text-danger">{{ errores.name[0] }}</span>
			       	</div>

			       	<div class="form-group">
				        <label for="email" class="control-label">Email</label>
				        <input  type="text" :class="classError(errores.email)" class="form-control" v-model="form.email"  placeholder="Ingresa aquí tu email">
				        <span v-if="errores.email" class="text-danger">{{ errores.email[0] }}</span>
			       	</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label>Roles</label>
				       		<div class="checkbox" v-for="rol in datos.roles">
							<label>
								<input  type="checkbox" :id="rol.name" :value="rol.name" v-model="form.roles">
								{{ rol.display_name }}<br>
								<small v-if="rol.name == 'Admin'" class="text-primary">Todos</small>
							    <small v-else class="text-primary" v-for="permiso in rol.permissions">
							        {{ permiso.name }}
							    </small>
							</label>
							</div>
				       	</div>
				       	<div class="form-group col-md-6">
							<label>Permisos</label>
							<div class="checkbox" v-for="permission in datos.permissions">
								<label>
									<input :id="permission.name" :value="permission.name" type="checkbox" v-model="form.permissions">
									{{ permission.name }}
								</label>
							</div>
						</div>
					</div>
					<div class="alert alert-light text-info" role="alert">La contraseña será generada y enviada al nuevo usuario via Email</div>

			       <button class="btn btn-primary btn-block" :disabled="working">
						<span v-if="working">
							Creando...
						</span>
						<span v-else>
							Crear usuario
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
				datos:{},
				form: {
					avatar: [],
					name: '',
					email: '',
					roles: [],
					permissions: []
				},
				working: false,
				errores:{}
			}
		},
        mounted() {
			this.getResults();
		},
		methods: {
			getResults() {
				axios.get('admin/users/create')
					.then(response => {
						this.datos = response.data;
					});
			},
			sendForm(){
				this.working = true;
				this.$Progress.start();
				let fileInput = document.querySelector( '#avatar' );
        		let formData = new FormData();
        		formData.append( 'avatar', fileInput.files[0] );
        		formData.append( 'name', this.form.name );
        		formData.append( 'email', this.form.email );
        		for (var i = 0; i < this.form.roles.length; i++) {
				    formData.append('roles[]', this.form.roles[i]);
				}
				for (var i = 0; i < this.form.permissions.length; i++) {
				    formData.append('permissions[]', this.form.permissions[i]);
				}
				axios.post('/admin/users', formData).then(response => {
					this.working = false;
					this.$Progress.finish();
					this.errores = {};
					this.$mensaje("!Se guardó el usuario correntamente¡", "success");
					this.$router.push({name: 'usuarios'})
				}).catch(error => {
					if (error.response.status === 403) {
			            this.$router.push('/error/403')
			        }
					this.errores = error.response.data.errors;
					this.working = false;
					this.$Progress.fail();
				});
			},
			classError(error){
				return error ? 'is-invalid' : ''
			},
		}
    }
</script>
