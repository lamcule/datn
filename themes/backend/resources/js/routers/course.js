import CourseTable from './../components/course/index'
import CourseForm from './../components/course/form'
import CourseView from './../components/course/view'

const currentLocale = '/' + window.MonCMS.currentLocale

export default [
  {
    path: '/admin/course',
    name: 'admin.course.index',
    component: CourseTable
  },
  {
    path: '/admin/course/:courseId/view',
    name: 'admin.course.view',
    component: CourseView,
    props: {
      pageTitle: 'course.label.view'
    }
  },
  {
    path: '/admin/course/create',
    name: 'admin.course.create',
    component: CourseForm,
    props: {
      pageTitle: 'course.label.create_course'
    }
  },

  {
    path: '/admin/course/:courseId/edit',
    name: 'admin.course.edit',
    component: CourseForm,
    props: {
      pageTitle: 'course.label.update_course'
    }
  },
]
