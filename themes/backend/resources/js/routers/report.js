import ReportStudent from './../components/report/student'
import ReportGrades from './../components/report/grades'
import ReportGradeDetail from './../components/report/grade_detail'
import ReportStudentActivity from './../components/report/student_activity'
import ReportReviewHistory from './../components/report/review_history'
import ReportStudentLesson from './../components/report/student_lesson'
import ReportCourseActivity from './../components/report/course_activity'

const currentLocale = '/' + window.MonCMS.currentLocale

export default [
  {
    path: '/admin/reports/student',
    name: 'admin.report.student',
    component: ReportStudent
  },
  {
    path: '/admin/reports/grades',
    name: 'admin.report.grades',
    component: ReportGrades
  },
  {
    path: '/admin/reports/grades/:gradeId',
    name: 'admin.report.grade.detail',
    component: ReportGradeDetail
  },
  {
    path: '/admin/reports/student-activity',
    name: 'admin.report.studentActivity',
    component: ReportStudentActivity
  },
  {
    path: '/admin/reports/review-history',
    name: 'admin.report.reviewHistory',
    component: ReportReviewHistory
  },
  {
    path: '/admin/reports/student-lesson',
    name: 'admin.report.studentLesson',
    component: ReportStudentLesson
  },
  {
    path: '/admin/reports/course-activity',
    name: 'admin.report.courseActivity',
    component: ReportCourseActivity
  },
]
