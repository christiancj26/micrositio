<template>
	<div >
		<vue-dropzone 	ref="myVueDropzone"
						id="dropzone"
						:options="dropzoneOptions"
						v-on:vdropzone-error="failed"
						v-on:vdropzone-success="success">

		</vue-dropzone>
	</div>
</template>
<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
export default {
  components: {
    vueDropzone: vue2Dropzone
  },
  data: function () {
    return {
      dropzoneOptions: {
          	url: `/admin/posts/${this.$route.params.url}/photos`,
          	acceptedFiles: 'image/*',
		   	paramName: 'photo',
          	headers: {
		   		'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
		   	},
	        dictDefaultMessage: "<i class='fas fa-images'></i>  Subir imagen",

      },
    }
  },
  methods:{
  		failed:function(file,message,xhr){
	      let response = xhr.response;
	      let parse = JSON.parse(response, (key, value)=>{
	        return value;
	      });
	      $('.dz-error-message:last span').text(parse.errors.photo[0]);
	    },
	    success(file, response){
	    	this.$store.dispatch('getPhotos', this.$route.params.url);
	        this.$refs.myVueDropzone.removeFile(file);
	    }
  }
}
</script>