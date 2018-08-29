import Vue from 'vue'
import App from './App'
import router from './router'
import VueResource from 'vue-resource'
import SuiVue from 'semantic-ui-vue'
import moment from 'moment'
import VueMomentJS from "vue-momentjs";
import VCalendar from "v-calendar";
import 'v-calendar/lib/v-calendar.min.css';
import { library } from '@fortawesome/fontawesome-svg-core'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import 'vue-awesome/icons'
import GSignInButton from 'vue-google-signin-button'
import FBSignInButton from 'vue-facebook-signin-button'
import * as VueGoogleMaps from 'vue2-google-maps'
import VueI18n from 'vue-i18n' //needed for calendar locale
import Icon from 'vue-awesome/components/Icon'
import 'vue-event-calendar/dist/style.css' //^1.1.10, CSS has been extracted as one file, so you can easily update it.
import vueEventCalendar from 'vue-event-calendar'
Vue.use(vueEventCalendar, {locale: 'en'})

library.add(fab)

Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('icon', Icon)

Vue.config.productionTip = false;
Vue.use(VueResource);
Vue.use(SuiVue);
Vue.use(VueMomentJS, moment);
Vue.use(VCalendar);
Vue.use(GSignInButton)
Vue.use(FBSignInButton)
Vue.use(VueI18n);
Vue.use(VueGoogleMaps, {
    load: {
      key: 'key=AIzaSyBPzXAXjAyEIcluDJSMgRRBffUCrbNq1',
      libraries: 'places'
    },
    installComponents: false,
})
Vue.component('google-map', VueGoogleMaps.Map);
/* eslint-disable no-new */
new Vue({

    el: '#app',
    http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    // i18n,
    router,
    render: h => h(App)
})
