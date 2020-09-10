import VueRouter from 'vue-router'
import Vue from 'vue'
import _ from 'lodash'
import {Message} from 'element-ui'
import AuthRouters from './authrouters'
import DashboardRouters from './dashboard'
import MediaRouters from './MediaRoutes'
import CourseRouters from './course'
import StudentRouters from './student'
import ReportsRouters from './report'
import ReviewRouters from './review'
import StudentImportRouters from './studentimport'
import TeacherRouters from './teacher'
import GradeRouters from './grade'
import BannerRouters from './banner'

Vue.use(VueRouter)
const currentLocale = window.MonCMS.currentLocale
const permissions = window.MonCMS.permissions
const multipleLanguage = window.MonCMS.multipleLanguage
const router = new VueRouter({
    mode: 'history',
    base: makeBaseUrl(),
    routes: [
        ...AuthRouters,
        ...MediaRouters,
        ...DashboardRouters,
        ...CourseRouters,
        ...StudentRouters,
        ...ReportsRouters,
        ...ReviewRouters,
        ...StudentImportRouters,
        ...TeacherRouters,
        ...GradeRouters,
        ...BannerRouters,

    ]
})

function makeBaseUrl() {
    return ''
    // if (multipleLanguage === 'true' || multipleLanguage === '1') {
    //     return `${currentLocale}`;
    // }
    // return '';
}

// router.beforeEach((to, from, next) => {
//     const routeName = to.name
//     if (_.find(permissions, function (permission) {
//         return permission.name === routeName
//     })) {
//
//         next()
//     } else {
//         Message({
//             type: 'error',
//             message: window.MonCMS.permissionDenied
//         })
//         next(false)
//     }
// })

export default router
