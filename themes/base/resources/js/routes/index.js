import Home from '../components/home'
import Course from '../components/course'
import About from '../components/about'
import Contact from '../components/contact'

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

]
