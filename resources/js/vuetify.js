import Vue from 'vue'

import Vuetify from 'vuetify/lib'
import { Ripple } from 'vuetify/lib/directives'

import '@mdi/font/css/materialdesignicons.css'

Vue.use(Vuetify, {
  directives: {
    Ripple
  }
})

export default new Vuetify({
  theme: {
    themes: {
      light: {
        primary: '#002858',
        secondary: '#555961',
        accent: '#f26b50',
        error: '#e3342f',
        info: '#4f72b8',
        success: '#5f9f69',
        warning: '#ffdf01',
        purple: '#3b0633',
        green: '#003624',
        cyan: '#28aba9'
      }
    }
  },
  icons: {
    iconfont: 'mdi'
  }
})