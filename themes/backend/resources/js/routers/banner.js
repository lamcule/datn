import BannerTable from './../components/banner/index'
import BannerForm from './../components/banner/form'

const currentLocale = '/' + window.MonCMS.currentLocale

export default [
  {
    path: '/admin/banner',
    name: 'admin.banner.index',
    component: BannerTable
  },
  {
    path: '/admin/banner/create',
    name: 'admin.banner.create',
    component: BannerForm,
    props: {
      pageTitle: 'banner.label.create_banner'
    }
  },

  {
    path: '/admin/banner/:bannerId/edit',
    name: 'admin.banner.edit',
    component: BannerForm,
    props: {
      pageTitle: 'banner.label.update_banner'
    }
  },
]
