import StudentImportList from './../components/studentimport/index'
import StudentImportView from './../components/studentimport/view'
import StudentImportCreateForm from './../components/studentimport/create'

const currentLocale = '/' + window.MonCMS.currentLocale

export default [
  {
    path: '/admin/student-import',
    name: 'admin.studentimport.index',
    component: StudentImportList
  },
  {
    path: '/admin/student-import/create',
    name: 'admin.studentimport.create',
    component: StudentImportCreateForm,
    props: {
      pageTitle: 'studentimport.label.create_record'
    }
  },
  {
    path: '/admin/student-import/:studentimport',
    name: 'admin.studentimport.view',
    component: StudentImportView
  },

]
