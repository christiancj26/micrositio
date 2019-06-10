<template>
<div>
	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Crear Noticia <button class="btn btn-primary" @click="createNoticia">+</button></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/">Inicio</router-link></li>
              <li class="breadcrumb-item active">Formulario de noticia</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-target=".bd-example-modal-xl" aria-hidden="true">
	<form @submit.prevent="sendForm">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Agregar el titulo de la nueva noticia</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
	            <!--<label for="title" class="control-label">Titulo de la noticia</label>-->
	            <input id="title" type="text" class="form-control" :class="errores.title ? 'is-invalid' : ''" name="title" v-model="form.title" autofocus placeholder="Ingresa aquí el titulo de la noticia">
	            <span v-if="errores.title" class="invalid-feedback">{{ errores.title[0] }}</span>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" id="submit-contact" :disabled="working" class="btn btn-primary">
				<span v-if="working">
					Creando...
				</span>
				<span v-else>
					Crear noticia
				</span>
			</button>
	      </div>
	    </div>
	  </div>
	 </form>
	</div>
</div>
</template>

<script>
	export default {
		data() {
			return{
				form:{
					title: '',
				},
				working : false,
				errores:{}
			}
		},
		mounted() {
			this.createNoticia();
		},
		methods: {
			createNoticia(){
				$('#myModal').modal('show');
			},
			sendForm(){
				this.working = true;

				axios.post('/admin/posts', this.form)
				.then(response => {
					$('#myModal').modal('hide');
					this.working = false;
					console.log(response.data.url);

					this.$router.push({name:'noticias.edit', params: {url: response.data.url }})
				/*	this.$route.params.pathMatch // 'admin'*/
				}).catch(error => {
					if (error.response.status === 403) {
						$('#myModal').modal('hide');
			            this.$router.push('/error/403')
			        }else{
			        	this.errores = error.response.data.errors;
						this.working = false;
			        }
				});
			},
		}
	}
</script>