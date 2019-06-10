
require('./bootstrap');

window.Vue = require('vue');

import store from './vuex';
import es from 'vee-validate/dist/locale/es';
import VeeValidate, { Validator } from 'vee-validate';
import Permissions from './mixins/Permissions';
import mensajes from './mixins/mensajes';
import router from './routes';
import VueProgressBar from 'vue-progressbar'
import tinymce from 'vue-tinymce-editor'
import VueSweetalert2 from 'vue-sweetalert2';


Vue.use(VeeValidate);
Validator.localize('es', es);

Vue.mixin(Permissions);
Vue.mixin(mensajes);
Vue.use(VueSweetalert2);
Vue.component('tinymce', tinymce)
Vue.use(VueProgressBar, {
  color: 'rgb(52,144,220)',
  failedColor: 'red',
  height: '2px'
})


require('./components');

require('./axios');

const app = new Vue({
    el: '#app',
    router,
    store
});
