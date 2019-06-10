<template>
<div>
	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Noticia</h1>
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
	<form @submit.prevent="sendForm">
	<div class="row">
			<div class="col-md-12">
				<div class="card card-primary card-outline">
				    <div class="card-body">
				    <div class="form-group">
				        <label for="title" class="control-label">Titulo de la publicación</label>

				        <input  type="text" class="form-control" :class="errores.title ? 'is-invalid' : ''" v-model="form.title"  placeholder="Ingresa aquí el titulo de la publicación">

				        <span v-if="errores.title" class="text-danger">{{ errores.title[0] }}</span>
			       	</div>
			       	<div class="row">
			       		<div class="col-md-4">
			       			<div class="form-group">
			                	<label for="body" class="control-label">Fecha de publicación</label>
				                  <datepicker  v-model="form.published_at" placeholder="Seleciona fecha de publicación" :format="format"  :language="languages[language]" input-class="form-control"></datepicker>
			              	</div>
			       		</div>
			       		<div class="col-md-4">
			       			<div class="form-group">
			                    <label for="category_id" class="control-label">Categoria</label>
			                    <select v-model="form.category_id" :class="classError(errores.category_id)" class="form-control" id="select-categoria">
			                    	<option value="">Elige una categoria</option>
			                    	<option :value="category.id" v-for="category in datos.categories">
			                    		{{ category.name }}
			                    	</option>
			                    </select>
			                    <span v-if="errores.category_id" class="text-danger">{{ errores.category_id[0] }}</span>
			                </div>
			       		</div>
			       		<div class="col-md-4">
			       			<div class="form-group">
			                    <label  for="tags" class="control-label">Etiquetas</label>
				                 <selectize  v-model="form.tags" multiple="multiple" :settings="settings" >
			                    	<option :value="tag.id" v-for="tag in datos.tags">
									  	{{ tag.name }}
									</option>
			                    </selectize>
								<span :class="errores.tags ? classErrorAdd() : classErrorEli()"></span>
				                <span v-if="errores.tags" class="text-danger">{{ errores.tags[0] }}</span>
			             	</div>
			       		</div>
			       	</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
				                <label for="body" class="control-label">Contenido embebido(iframe)</label>
				                <textarea v-model="form.iframe" class="form-control" placeholder="Ingresa el contenido embebido (iframe) de audio o video" rows="2"></textarea>
				            </div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
			                    <label for="excerpt" class="control-label">Extracto de la publicación</label>

			                	<textarea :class="classError(errores.excerpt)" v-model="form.excerpt" class="form-control" placeholder="IIngresa un extracto de la publicación" rows="2"></textarea>

								<span v-if="errores.excerpt" class="text-danger">{{ errores.excerpt[0] }}</span>
			                </div>
						</div>
					</div>
					<div class="form-group">
		              	<label for="body" class="control-label">Contenido de la publicación</label>
		              	<div :class="errores.body ? 'errorSelectize' : ''" style="padding-left:1px; padding-right:2px">
		               	<tinymce id="d1"  v-model="form.body" :toolbar1="toolbar1" :other_options="other_options"></tinymce>
		               	</div>
						<span v-if="errores.body" class="text-danger">{{ errores.body[0] }}</span>
		            </div>
		            <button class="btn btn-block btn-primary btn-flat" :disabled="working">
						<span v-if="working">
							Guardando...
						</span>
						<span v-else>
							Guardar Noticia
						</span>
					</button>
				    </div>
				</div>
			</div>
	</div>
	</form>
    <div class="card card-warning card-outline">
		<div class="card-body">
			<photos :photos="photos"></photos>
			<upload-photos></upload-photos>
		</div>
	</div>
</div>
</template>

<script>
import Selectize from 'vue2-selectize'
import Datepicker from 'vuejs-datepicker';
import * as lang from "vuejs-datepicker/src/locale";
import moment from 'moment';
import { mapState } from 'vuex';
	export default {
 		data(){
			return{
				datos:{},
				errores:{},
				form: {
					url: '',
					title: '',
					body: '',
					iframe: '',
					published_at: '',
					category_id: '',
					tags: {},
					excerpt: ''
				},
				language: "es",
				format: "d MMMM yyyy",
      			languages: lang,
      			working: false,
				settings: {
					plugins: ['remove_button'],
				    delimiter: ',',
				    create: function(input) {
				        return {
				            value: input,
				            text: input
				        }
				    },
				},
				toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor source code | link image media",
				other_options: {
					height: 350,
					file_browser_callback : function(field_name, type) {
				      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
				      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

				      var cmsURL = 'http://localhost:8000/' + 'laravel-filemanager?field_name=' + field_name;
				      if (type == 'image') {
				        cmsURL = cmsURL + "&type=Images";
				      } else {
				        cmsURL = cmsURL + "&type=Files";
				      }

				      tinyMCE.activeEditor.windowManager.open({
				        file : cmsURL,
				        title : 'Filemanager',
				        width : x * 0.8,
				        height : y * 0.8,
				        resizable : "yes",
				        close_previous : "no"
				      });
				    }
				}
			}
		},
		mounted() {
			this.cargarPost();
			this.$store.dispatch('getPhotos', this.$route.params.url);
		},
		methods: {
			cargarPost(){
				axios.get(`/admin/posts/${this.$route.params.url}/edit`)
				.then(response => {
					this.datos = response.data;
					this.form.title = this.datos.post.title;
					this.form.body = this.datos.post.body;
					this.form.iframe = this.datos.post.iframe;
					this.form.published_at = this.datos.post.published_at;
					this.form.category_id = this.datos.post.category_id;
					this.form.tags = this.datos.post_tags;
					this.form.excerpt = this.datos.post.excerpt;
					this.form.url = this.datos.post.url;
				}).catch(error => {
					if (error.response.status === 403) {
			            this.$router.push('/error/403')
			        }
				});
			},
			sendForm(){
				this.working = true;
				this.form.published_at = this.form.published_at ? moment(this.form.published_at).format('YYYY-MM-DD hh:mm:ss') : '';
				this.$Progress.start();
				axios.put(`/admin/posts/${this.form.url}`, this.form)
				.then(response => {
					this.working = false;
					this.$Progress.finish();
					this.errores = {};
					this.$mensaje("!Se guardó la noticia correntamente¡", "success");
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
			classErrorAdd(){
				$( ".selectize-input" ).addClass( "errorSelectize" );
			},
			classErrorEli(){
				$( ".selectize-input" ).removeClass( "errorSelectize" );
			},
		},
		computed: mapState([
		  'photos'
		]),
		components: {
		    Selectize,
		    Datepicker
		}
	}
</script>

<style>
.errorSelectize {
	border: 1px solid #f00;
}
</style>
