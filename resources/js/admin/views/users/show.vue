<template>
<div>
	<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Perfil de usuario</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/">Inicio</router-link></li>
              <li class="breadcrumb-item active">Perfil de usuario</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
   <div class="row">
    <div class="col-md-4">
      <div class="card card-primary card-outline">
              <div class="card-body card-profile">
                <div class="text-center">
                  <img-fade :src="user.avatar"></img-fade>
                </div>
                <h3 class="profile-username text-center">{{ user.name }}</h3>
                <p class="text-muted text-center" v-for="rol in user.roles">{{ rol.display_name }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Email</b> <a href="" class="float-right">{{ user.email }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Publicaciones</b> <a href="" class="float-right"></a>
                  </li>
                  <li class="list-group-item">
                    <b>Roles</b> <a href="" class="float-right" v-for="rol in user.roles">{{ rol.display_name }}</a>
                  </li>
                </ul>
                <router-link :to="{name: 'usuarios.edit', params: {url: user.name }}" v-if="VerButton('Modificar usuarios')" class="btn btn-primary btn-block"><b>Editar</b></router-link>
              </div>
            </div>
    </div>
    <div class="col-md-4">
      <div class="card card-primary card-outline">
        <div class="card-header with-border">
          <h3 class="card-title">Roles</h3>
        </div>
        <div class="card-body">
            <div v-for="rol in user.roles" v-if="user.roles">
               <strong>{{ rol.display_name }}</strong>
              <br>
              Permisos:
              <small v-if="rol.name == 'Admin'" class="text-primary">Todos</small>
              <small v-else class="text-primary" v-for="permiso in rol.permissions">
                {{ permiso.name }}
              </small>

            </div>
            <small v-else class="text-muted">No tiene ningún rol asociado</small>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-primary card-outline">
        <div class="card-header with-border">
          <h3 class="card-title">Permisos Adicionales</h3>
        </div>
        <div class="card-body">
            <strong v-for="permiso in user.permissions" v-if="user.permissions">{{ permiso.name }}, </strong>
            <small class="text-muted" v-else>No tiene permisos adicionales</small>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-header with-border">
          <h3 class="card-title">Publucaciones</h3>
        </div>
        <div class="card-body">
           <div class="post" v-for="post in user.posts" v-if="user.posts">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" :src="user.avatar" alt="user image">
                        <span class="username">
                          <a href="#">{{ post.title }}</a>
                          <a href="#" class="float-right btn-tool"><i class="fa fa-times"></i></a>
                        </span>
                        <span class="description">Compartido públicamente - {{ post.published_at }}</span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                         {{ post.excerpt }}
                      </p>
            </div>
            <small v-else class="text-muted">No tiene ningúna publicación</small>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
 export default {
    data(){
      return{
        user:{},
      }
    },
    created() {
      this.getResults();
    },
    methods: {
      getResults() {
        axios.get(`/admin/users/${this.$route.params.name}`)
          .then(response => {
            this.user = response.data;
          });
      },
      VerButton(permission){
        if (this.$can(permission) || window.user.id === this.user.id) {
          return true
        }else{
          return false
        }
      }
    }
}
</script>