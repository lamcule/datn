import Vue from 'vue'
import VueI18n from 'vue-i18n'
import VueLazyLoad from 'vue-lazyload'
import VueRouter from 'vue-router'
import mixin from './mixin/index.js'
import messages from './vue-i18n-locales.generated'
import routes from './routes'

require('./bootstrap')

Vue.use(VueI18n)
Vue.use(VueRouter)
Vue.mixin(mixin)
const i18n = new VueI18n({
    locale: window.MonCMS.locale,
    messages
    // fallbackLocale: 'vi',
})

const router = new VueRouter({
    mode: 'history',
    routes
})
Vue.use(VueLazyLoad, {
    preLoad: 1.3,
    lazyComponent: true
})

const app = new Vue({
    el: '#app',
    router,
    i18n,
})

