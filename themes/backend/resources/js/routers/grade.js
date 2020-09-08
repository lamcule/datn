import GradeTable from './../components/grade/index'
import GradeForm from './../components/grade/form'
import GradeView from './../components/grade/view'
import LessonForm from './../components/lesson/form'
import LessonView from './../components/lesson/view'
import QrView from './../components/lesson/qr'
import ListQRCode from './../components/lesson/list_qrcode'
import Checkinout from './../components/userlesson/index'

const currentLocale = '/' + window.MonCMS.currentLocale

export default [
    {
        path: '/admin/grade',
        name: 'admin.grade.index',
        component: GradeTable,
    },

    {
        path: '/admin/grade/create',
        name: 'admin.grade.create',
        component: GradeForm,
        props: {
            pageTitle: 'grade.label.create_grade'
        }
    },

    {
        path: '/admin/grade/:gradeId/edit',
        name: 'admin.grade.edit',
        component: GradeForm,
        props: {
            pageTitle: 'grade.label.update_grade'
        }
    },

    {
        path: '/admin/grade/:gradeId/view',
        name: 'admin.grade.view',
        component: GradeView,
        props: {
            pageTitle: 'grade.label.view'
        }
    },

    {
        path: '/admin/lesson/create',
        name: 'admin.lesson.create',
        component: LessonForm,
        props: {
            pageTitle: 'lesson.label.create_lesson'
        }
    },

    {
        path: '/admin/lesson/:lessonId/edit',
        name: 'admin.lesson.edit',
        component: LessonForm,
        props: {
            pageTitle: 'lesson.label.update_lesson'
        }
    },

    {
        path: '/admin/lesson/:lessonId/view',
        name: 'admin.lesson.view',
        component: LessonView,
        props: {
            pageTitle: 'lesson.label.view'
        }
    },
    {
        path: '/checkin-qr/:lessonId',
        name: 'admin.checkinqr',
        component: QrView
    },
    {
        path: '/checkout-qr/:lessonId',
        name: 'admin.checkoutqr',
        component: QrView
    },
    {
        path: '/admin/qrcode',
        name: 'admin.lesson.qrcode',
        component: ListQRCode
    },
    {
        path: '/admin/checkinout',
        name: 'admin.checkinout.index',
        component: Checkinout
    }
]
