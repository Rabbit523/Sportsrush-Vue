import Vue from 'vue'
import App from './App'
import router from './router'
import VueResource from 'vue-resource'
import SuiVue from 'semantic-ui-vue'
import moment from 'moment'
import VueMomentJS from "vue-momentjs";
import { library } from '@fortawesome/fontawesome-svg-core'
import { faCoffee } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faCoffee)

Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false;
Vue.use(VueResource);
Vue.use(SuiVue);
Vue.use(VueMomentJS, moment);

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  render: h => h(App)
})
