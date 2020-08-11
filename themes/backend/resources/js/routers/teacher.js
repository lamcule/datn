import TeacherList from './../components/teacher/index'
import TeacherCreateForm from './../components/teacher/create'
// import teacherUpdateForm from './../components/teacher/update'

const currentLocale = '/' + window.MonCMS.currentLocale

export default [
  {
    path: '/admin/teacher',
    name: 'admin.teacher.index',
    component: TeacherList
  },
  {
    path: '/admin/teacher/create',
    name: 'admin.teacher.create',
    component: TeacherCreateForm,
    props: {
      pageTitle: 'teacher.label.create_record'
    }
  },
  //
  // {
  //   path: '/admin/teacher/:userId/edit',
  //   name: 'admin.teacher.edit',
  //   component: teacherUpdateForm,
  //   props: {
  //     pageTitle: 'teacher.label.update_record'
  //   }
  // }

]
