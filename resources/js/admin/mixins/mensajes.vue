<script>
  export default {
    methods: {
	      $mensaje(title, type) {
	        const Toast = this.$swal.mixin({
			  toast: true,
			  position: 'top-end',
			  showConfirmButton: false,
			  background: '#526571',
			  timer: 4000,
			})
			Toast.fire({
			  type: type,
			  html:"<span style='color:#fafafa'>" + title + "</span>"
			})
	      },
	      $confirmDelete(){
			this.$swal.fire({
			  title: '¿Estás seguro?',
			  text: "¡No podrás revertir esto!",
			  type: 'advertencia',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: '¡Sí, eliminar!'
			}).then((result) => {
			  if (result.value) {
			  	this.delete();
			  }
			})
		},
    },
  };
</script>