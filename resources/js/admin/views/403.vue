<template>
	 <!-- Content Wrapper. Contains page content -->
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>403 Página de error</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link :to="{name: 'home'}">Inicio</router-link></li>
              <li class="breadcrumb-item active">403 Página de error</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-danger"> 403</h2>

        <div class="error-content">
          <h3><i class="fa fa-danger text-danger"></i> Ups! Pagina no autorizada.</h3>

          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="buscar">

              <div class="input-group-append">
                <button type="submit" name="enviar" class="btn btn-danger"><i class="fa fa-search"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          </form>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</template>