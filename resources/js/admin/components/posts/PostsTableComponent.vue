<template>
	<div>
		<table id="posts-table" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th width="10">ID</th>
          <th width="30%">Titulo</th>
          <th width="50%">Extracto</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        		<tr v-for="post in posts.data">
        			<td>{{ post.id }}</td>
        			<td>{{ post.title }}</td>
        			<td>{{ post.excerpt }}</td>
        			<td>
                        <post-buttons :post="post" v-on:cargarPosts="getResults"></post-buttons>
        			</td>
        		</tr>
        </tbody>
      </table>
		<pagination :data="posts"
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
				posts:{},
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
			     axios.get('admin/posts?page=' + page)
					.then(response => {
						this.posts = response.data;
                        this.$Progress.finish();
					}).catch(errores =>{
                        this.$Progress.fail();
						console.log(errores);
				});
			}
		}
    }
</script>