<template>
	<div>
		<table id="users-table" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th width="10">ID</th>
          <td></td>
          <th >Nombre</th>
          <th >Correo</th>
          <th width="150">Acciones</th>
        </tr>
        </thead>
        <tbody>
        		<tr v-for="user in users.data">
        			<td>{{ user.id }}</td>
        			<td><img :src="user.avatar" class="rounded-circle" width="50"></td>
        			<td>{{ user.name }}</td>
        			<td>{{ user.email }}</td>
        			<td>
                    <user-buttons :user="user" v-on:cargarUsers="getResults"></user-buttons>
        			</td>
        		</tr>
        </tbody>
      </table>
		<pagination :data="users"
					@pagination-change-page="getResults"
					:limit="limit"
					:align="align"
					:show-disabled="showDisabled"
                    :size="size">
		</pagination>
	</div>
</template>

<script>
 export default {
 		data(){
			return{
				users:{},
				limit: 2,
	            align: 'right',
	            showDisabled: true,
            	size: 'small',
			}
		},
        mounted() {
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
                this.$Progress.start();
				axios.get('admin/users?page=' + page)
					.then(response => {
						this.users = response.data;
                        this.$Progress.finish();
					}).catch(errores =>{
                        this.$Progress.fail();
				});
			}
		}
    }
</script>