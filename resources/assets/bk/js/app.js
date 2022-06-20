require('./bootstrap');
require('./routes');

import VueRouter from 'vue-router';
import axios from 'axios';
import Notifications from 'vue-notification'
import VueLocalStorage from 'vue-localstorage'

import VueAxios from 'vue-axios';
import App from './App.vue';
import VueRange from 'vue-for-range';

import { library } from '@fortawesome/fontawesome-svg-core'
import { faCoffee } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faEdit } from '@fortawesome/fontawesome-free-solid';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Notifications);
Vue.use(VueRange);

Vue.use(VueLocalStorage, {
  name: 'ls',
  bind: true
})

axios.defaults.baseURL = 'https://www.localhost.dev/tireshop/api';

Vue.prototype.base_url = 'https://www.localhost.dev/tireshop/';
Vue.prototype.AppName = 'TaskRabbit';

FontAwesomeIcon.config = {
  autoAddCss: false,
};

library.add(faCoffee)
library.add(faEdit)
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false


Vue.use(require('@websanova/vue-auth'), {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

App.router = Vue.router
new Vue(App).$mount('#app');