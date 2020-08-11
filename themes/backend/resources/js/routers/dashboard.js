import Dashboard from './../components/dashboard/index';
import ScheduleLesson from './../components/schedule/lesson';


export default [
  {
    path: '/admin',
    name: 'admin.index',
    component: Dashboard,
  },
  {
    path: '/admin/schedule/lessons',
    name: 'admin.schedule.lesson',
    component: ScheduleLesson,
  },


];
