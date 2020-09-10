import StudentList from './../components/student/index'
import StudentCreateForm from './../components/student/create'
import StudentUpdateForm from './../components/student/update'
import StudentRegisterList from './../components/student_register/index'
import StudentRegisterCreateForm from './../components/student_register/create'
import StudentRegisterUpdateForm from './../components/student_register/update'

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
    },

    {
        path: '/admin/students/register',
        name: 'admin.student_register.index',
        component: StudentRegisterList
    },
    {
        path: '/admin/students/register/create',
        name: 'admin.student_register.create',
        component: StudentRegisterCreateForm,
        props: {
            pageTitle: 'student.label.create_record'
        }
    },

    {
        path: '/admin/students/register/:userId/edit',
        name: 'admin.student_register.edit',
        component: StudentRegisterUpdateForm,
        props: {
            pageTitle: 'student.label.update_record'
        }
    }

]
