import Vue from 'vue'

import 'normalize.css/normalize.css'// A modern alternative to CSS resets
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/en' // lang i18n

import '~sass/app.scss' // global css

import App from './App.vue'
import router from './router'
import store from './store'

import '~/icons' // icon
import '~/permission' // permission control
// only import the icons you use to reduce bundle size
import 'vue-awesome/icons/flag'

// or import all icons if you don't care about bundle size
import 'vue-awesome/icons'

/* Register component with one of 2 methods */

import Icon from 'vue-awesome/components/Icon'

// globally (in your main .js file)
Vue.component('icon', Icon)

import Vue2TouchEvents from 'vue2-touch-events'

Vue.use(Vue2TouchEvents)
Vue.use(ElementUI, { locale })

Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
