
require('./bootstrap');

window.Vue = require('vue');

import router from './routes';

require('./components');

require('./axios');

const app = new Vue({
    el: '#web',
    router
});
