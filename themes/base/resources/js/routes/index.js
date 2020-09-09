import Home from '../components/home'
import Course from '../components/course'
import About from '../components/about'
import Contact from '../components/contact'
import Teacher from '../components/teacher'

export default [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/course',
        name: 'course',
        component: Course
    },
    {
        path: '/about-us',
        name: 'about',
        component: About
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact
    },
    {
        path: '/teacher',
        name: 'teacher',
        component: Teacher
    },

]
