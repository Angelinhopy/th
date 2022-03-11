import Vue from 'vue'

// Components
import './components'

// Sync router with store
import { sync } from 'vuex-router-sync'

import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import axios from 'axios'

Vue.prototype.$http = axios
// Sets the default url used by all of this axios instance's requests
//axios.defaults.baseURL = 'http://localhost:8080/dev/th/api/v1'
axios.defaults.headers.get['Accept'] = 'application/json'

const token = localStorage.getItem('_token')
if (token) {
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

// Sync store with router
sync(store, router)

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
