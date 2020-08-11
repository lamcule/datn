import StudentList from './../components/student/index'
import StudentCreateForm from './../components/student/create'
import StudentUpdateForm from './../components/student/update'

const currentLocale = '/' + window.MonCMS.currentLocale

export default [
  {
    path: '/admin/students',
    name: 'admin.student.index',
    component: StudentList
  },
  {
    path: '/admin/students/create',
    name: 'admin.student.create',
    component: StudentCreateForm,
    props: {
      pageTitle: 'student.label.create_record'
    }
  },

  {
    path: '/admin/students/:userId/edit',
    name: 'admin.student.edit',
    component: StudentUpdateForm,
    props: {
      pageTitle: 'student.label.update_record'
    }
  }

]
