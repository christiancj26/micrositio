<template>
	<div>
	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Listado de roles</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/">Inicio</router-link></li>
              <li class="breadcrumb-item active">Listado de roles</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card card-primary card-outline">
      <div class="card-header">
        <!-- @can('create', new App\Post) -->
        <router-link v-if="$can('Crear roles')" :to="{name: 'roles.create'}" class="btn btn-primary float-right mb-2">
            Crear Role
        </router-link>
        <!-- @endcan -->
      </div>
       <!-- /.card-header -->
      <div class="card-body">
        <roles-table></roles-table>
        <!-- {{ $posts->links('vendor.pagination.bootstrap-4') }} -->
      </div>
      <!-- /.card-body -->
	 </div>
	</div>
</template>