<template>
<div>
	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Listar Noticias</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/">Inicio</router-link></li>
              <li class="breadcrumb-item active">Listado de noticias</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="card card-primary card-outline">
    <div class="card-header">
      <router-link v-if="$can('Crear noticias')" :to="{name: 'noticias.create'}" class="btn btn-primary float-right mb-2">
          Crear Noticia
      </router-link>
    </div>
    <div class="card-body">
      <posts-table></posts-table>
    </div>
	</div>
</div>
</template>

