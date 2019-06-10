<template>
<div>
	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Listar usuarios</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/">Inicio</router-link></li>
              <li class="breadcrumb-item active">Listado de usuarios</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  <div class="card card-primary card-outline">
      <div class="card-header">
        <!-- @can('create', new App\Post) -->
        <router-link v-if="$can('Crear usuarios')" :to="{name: 'usuarios.create'}" class="btn btn-primary float-right mb-2">
            Crear Usuario
        </router-link>
        <!-- @endcan -->
      </div>
       <!-- /.card-header -->
      <div class="card-body">
        <users-table></users-table>
        <!-- {{ $posts->links('vendor.pagination.bootstrap-4') }} -->
      </div>
      <!-- /.card-body -->
	 </div>
</div>
</template>