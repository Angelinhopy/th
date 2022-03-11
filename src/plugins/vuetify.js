import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import VuetifyConfirm from 'vuetify-confirm'

const vuetify = new Vuetify({
  theme: {
    themes: {
      dark: {
        primary: '#4caf50',
        secondary: '#4caf50',
        tertiary: '#495057',
        accent: '#82B1FF',
        error: '#f55a4e',
        info: '#00d3ee',
        success: '#5cb860',
        warning: '#ffa21a',
        general: '#2196F3'
      },
    },
    dark: true,
    icons: {
      iconfont: 'mdi',
    },
  },
})

Vue.use(Vuetify)
Vue.use(VuetifyConfirm, {
  vuetify,
  buttonTrueText: 'SI',
  buttonTrueColor: 'success',
  buttonTrueFlat: false,
  color: 'error',
  title: 'Atención'
})

export default vuetify
