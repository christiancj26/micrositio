import Vue from 'vue';
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
	routes: [
		{
			path: '/',
			name: 'home',
			component: require('./views/home.vue').default
		},
		{
			path: '*',
			component: require('./views/404.vue').default
		},
	],
	linkExactActiveClass: 'active',
	linkActiveClass: 'active'
});
