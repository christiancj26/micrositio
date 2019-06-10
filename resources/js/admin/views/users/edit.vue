<template>
<div>
	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Editar usuario</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/">Inicio</router-link></li>
              <li class="breadcrumb-item active">Editar usuario</li>
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
						<div class="text-center">
		                  <img-fade :src="form.avatar"></img-fade>
		                </div>
						<div class="form-group">
					        <label for="avatar" class="control-label">Foto de perfil</label>
					        <input type="file" id="avatar"  :class="classError(errors.avatar)" class="form-control">
					        <span v-if="errors.avatar" class="text-danger">{{ errors.avatar[0] }}</span>
				      	</div>
						<div class="form-group">
					        <label for="name" class="control-label" :class="{'text-danger': errors.has('name')}">Nombre completo</label>

					        <input type="text"
					        		:class="errors.has('name') ? 'is-invalid' : ''"
					        		class="form-control"
					        		v-model="form.name"
					        		v-validate="'required|min:3'"
					        		name="name"
					        		placeholder="Ingresa aquí tu nombre completo">

					        <span  class="text-danger">{{ errors.first('name') }}</span>
				       	</div>

				       	<div class="form-group">
					        <label for="email" :class="{'text-danger': errors.has('email')}" class="control-label">Email</label>

					        <input  type="text"
					        		:class="errors.has('email') ? 'is-invalid' : ''"
					        		class="form-control"
					        		v-validate="'required|email'"
					        		name="email"
					        		v-model="form.email"
					        		placeholder="Ingresa aquí tu email">

					        <span  class="text-danger">{{ errors.first('email') }}</span>
				       	</div>
				       	<div class="form-group">
					        <label for="password" :class="{'text-danger': errors.has('password')}" class="control-label">Contraseña</label>
					        <input type="password"
					        		class="form-control"
					        		:class="{'is-invalid': errors.has('password')}"
					        		v-model="form.password"
					        		v-validate="'min:6|max:35'"
					        		placeholder="Ingresa aquí tu Contraseña"
					        		name="password"
					        		ref="password">
					        <span v-show="errors.has('password')" class="text-danger">{{ errors.first('password') }}</span> <br>
					        <span class="text-info"><em>Dejar en blanco si no quieres cambiar la contraseña</em></span>
				       </div>

				       <div class="form-group">
					        <label for="password_confirmation" :class="{'text-danger': errors.has('password_confirmation')}" class="control-label">Confirmación de Contraseña</label>

					        <input type="password"
					        		class="form-control"
					        		name="password_confirmation"
					        		v-validate="'confirmed:password'"
					        		:class="{'is-invalid': errors.has('password_confirmation')}"
					        		placeholder="Confirma tu Contraseña"
					        		data-vv-as="password">

					        <span v-show="errors.has('password_confirmation')" class="text-danger">{{ errors.first('password_confirmation') }}</span>
				       </div>

				       <button class="btn btn-primary btn-block" :disabled="working">
							<span v-if="working">
								Editando...
							</span>
							<span v-else>
								Editar usuario
							</span>
						</button>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<!-- editar roles -->
			<roles></roles>
			<!-- editar permisos -->
			<permissions></permissions>
		</div>
	</div>
</div>
</template>

<script>
 export default {
 		data(){
			return{
				user:{},
				selected_permissions:[],
				form: {
					avatar: [],
					name: '',
					email: '',
					roles: [],
					permissions: []
				},
				working: false,
			}
		},
        mounted() {
			this.getResults();
		},
		methods: {
			getResults() {
				axios.get('admin/users/' + this.$route.params.name + '/edit')
					.then(response => {
						this.user = response.data;
						this.form.avatar = response.data.avatar
						this.form.name = response.data.name
						this.form.email = response.data.email
					}).catch(error => {
						if (error.response.status === 403) {
				            this.$router.push('/error/403')
				        }
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
        		if (this.form.password) {
        			formData.append( 'password', this.form.password );
        		}
				formData.append('_method', 'PUT');
				axios.post('/admin/users/' + this.$route.params.name, formData).then(response => {
					this.working = false;
					this.$Progress.finish();
					this.$mensaje("!Se editó el usuario correntamente¡", "success");
					this.getResults()
					this.$store.dispatch('getAvatar', this.form.name)
				}).catch(error => {
					if (error.response.status === 403) {
			            this.$router.push('/error/403')
			        }
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