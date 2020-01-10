// Vuetify
import vuetify from './vuetify'

// Vue Plugins
import router from './router'
import store from './store'

// App
import App from './App.vue'

// Vue itself
import Vue from 'vue'

// Axios
import axios from 'axios'
axios.defaults.baseURL = '/api'
axios.defaults.params = { api_token: window.userApiToken }
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
Vue.prototype.$axios = axios

// Echo
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
Vue.prototype.$echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER
})

// Vue comes to life!
window.vm = new Vue({
  el: '#app',
  vuetify,
  router,
  store,
  render: h => h(App)
})