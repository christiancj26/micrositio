<template>
	<div>
		<table id="roles-table" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th width="10">ID</th>
          <th>Identificador</th>
          <th >Nombre</th>
          <th >Permisos</th>
          <th width="150">Acciones</th>
        </tr>
        </thead>
        <tbody>
        		<tr v-for="role in roles">
        			<td>{{ role.id }}</td>
        			<td>{{ role.name }}</td>
        			<td>{{ role.display_name }}</td>
        			<td>
                <span v-for="permission in role.permissions">{{ permission.name }}, </span>
              </td>
        			<td>
                    <role-buttons :role="role"  v-on:cargarRoles="getResults"></role-buttons>
        			</td>
        		</tr>
        </tbody>
      </table>
	</div>
</template>

<script>
 export default {
 		data(){
			return{
				roles:{}
      }
		},
    mounted() {
			this.getResults()
		},
		methods: {
			getResults() {
        this.$Progress.start();
				axios.get('admin/roles')
					.then(response => {
						this.roles = response.data;
            this.$Progress.finish();
					}).catch(errores =>{
            if (errores.response.status === 403) {
                  this.$router.push('/error/403')
              }
            this.$Progress.fail();
				});
			}
		}
    }
</script>