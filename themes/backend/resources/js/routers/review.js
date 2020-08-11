import Review from './../components/review/index'
import UserReview from './../components/userreview/index'

const currentLocale = '/' + window.MonCMS.currentLocale

export default [
  {
    path: '/admin/review',
    name: 'admin.userreview.index',
    component: UserReview
  },
  {
    path: '/admin/review/:userreviewId',
    name: 'admin.review.index',
    component: Review
  }

]
