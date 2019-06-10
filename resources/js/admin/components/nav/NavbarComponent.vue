<template>
<!-- Sidebar Menu -->
<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
  <li class="nav-item">
    <router-link :to="{name: 'home'}" class="nav-link">
      <i class="nav-icon fas fa-tachometer-alt" style="color:#5C96CF"></i>
      <p>
        INICIO
      </p>
    </router-link>
  </li>
  <li
  	class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-newspaper"></i>
      <p>
        Noticias
        <i class="right fa fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <router-link :to="{name: 'noticias'}" class="nav-link">
          <i class="fas fa-list-ol nav-icon"></i>
          <p>Listar Noticias</p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link v-if="$can('Crear noticias')" :to="{name: 'noticias.create'}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>Crear Noticia</p>
        </router-link>
      </li>
    </ul>
  </li>
  <li v-if="$can('Ver usuarios')" class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-users"></i>
      <p>
        Usuarios
        <i class="right fa fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <router-link :to="{name: 'usuarios'}" class="nav-link">
          <i class="fas fa-list-ol nav-icon"></i>
          <p>Listar usuarios</p>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link v-if="$can('Crear usuarios')" :to="{name: 'usuarios.create'}" class="nav-link">
          <i class="fas fa-plus nav-icon"></i>
          <p>Crear Usuario</p>
        </router-link>
      </li>
    </ul>
  </li>
  <li v-else class="nav-item">
    <router-link :to="{name: 'usuarios.show', params: {name: user.name }}" class="nav-link">
      <i class="nav-icon fas fa-user"></i>
      <p>
        Perfil
      </p>
    </router-link>
  </li>
  <li class="nav-item">
  <router-link v-if="$can('Ver roles')"  :to="{name: 'roles'}"  class="nav-link">
    <i class="nav-icon fas fa-pencil-ruler text-success"></i>
    <p>
      Roles
    </p>
  </router-link>
  </li>
  <li class="nav-item">
    <a  href="#" @click.prevent="logout" class="nav-link">
      <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
      <p>
        Cerrar sesión
      </p>
    </a>
  </li>
</ul>
</nav>
<!-- /.sidebar-menu -->
</template>

<script>
 export default {
    props:['user'],
    data: () => ({
     csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
		methods: {
			ActivarLink(path){
				return this.$route.path === path ? 'menu-open' : '';
			},
      logout:function(){
         axios.post('logout').then(response => {
            window.location.href = '/';
          }).catch(error => {
            window.location.reload();
        });
      },
		}
  }
</script>

<style>
  .display-none{
    display: none !important;
  }

  .display-block{
    display: none !important;
  }
</style>