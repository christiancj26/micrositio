import Vue from 'vue';
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
	routes: [
		{
			path: '/inicio',
			name: 'home',
			component: {
				template: '<div>Hola esto es inicio</div>'
			}
		},
		{
			path: '/noticias',
			name: 'noticias',
			component: require('./views/posts/index.vue').default
		},
		{
			path: '/noticias/create',
			name: 'noticias.create',
			component: require('./views/posts/create.vue').default
		},
		{
			path: '/noticias/edit/:url',
			name: 'noticias.edit',
			component: require('./views/posts/edit.vue').default
		},
		{
			path: '/usuarios',
			name: 'usuarios',
			component: require('./views/users/index.vue').default
		},
		{
			path: '/usuarios/:name/show',
			name: 'usuarios.show',
			component: require('./views/users/show.vue').default
		},
		{
			path: '/usuarios/create',
			name: 'usuarios.create',
			component: require('./views/users/create.vue').default
		},
		{
			path: '/usuarios/edit/:name',
			name: 'usuarios.edit',
			component: require('./views/users/edit.vue').default
		},
		{
			path: '/error/403',
			component: require('./views/403.vue').default
		},
		{
			path: '/roles',
			name: 'roles',
			component: require('./views/roles/index.vue').default
		},
		{
			path: '/roles/create',
			name: 'roles.create',
			component: require('./views/roles/create.vue').default
		},
		{
			path: '/roles/edit/:id',
			name: 'roles.edit',
			component: require('./views/roles/edit.vue').default
		},
		{
			path: '*',
			component: require('./views/404.vue').default
		},
	],
	linkExactActiveClass: 'active',
	linkActiveClass: 'active'
});
