<template>
  <div>
    <div class="content-header">
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{name: 'admin.course.index'}">
          {{ $t('course.label.manage_course') }}
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ course.name }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>
    <div
            class="row-left"
            style="padding-top: 10px; padding-bottom: 10px;"
    >
      <router-link :to="{name: 'admin.course.edit', params:{courseId:this.$route.params.courseId }  }">
        <el-button
                type="primary"
                size="small"
                class="btn btn-flat"
                icon="el-icon-edit"
        >
          {{ $t('mon.button.update') }}
        </el-button>
      </router-link>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-widget">
          <div
            class="box-body"
            style="padding: 0px"
          >
            <el-tabs
              v-model="activeTab"
              type="border-card home-tab-container"
            >
              <el-tab-pane
                :label="$t('course.tabs.grade')"
                name="grade"
              >
                <grade-table />
              </el-tab-pane>
              <el-tab-pane
                :label="$t('course.tabs.detail')"
                name="detail"
              >
                <course-detail :course="course"></course-detail>
              </el-tab-pane>
            </el-tabs>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import CourseDetail from './_detail'
import GradeTable from './_grade'
export default {
  components: {
    CourseDetail,
    GradeTable
  },
  props: {
    locales: { default: null },
    pageTitle: { default: null, String }
  },
  data () {
    return {
      activeTab: 'detail',
      course: {}
    }
  },
  computed: {},
  mounted () {
    axios.get(route('api.course.find', { course: this.$route.params.courseId }))
      .then((response) => {
        this.course = response.data.data
      })
  },
  methods: {}
}
</script>

<style>
    .el-tabs__nav {
        width: 100% !important;
    }

    /*.el-tabs__item {*/
        /*width: 50% !important;*/
        /*font-weight: bold !important;*/
    /*}*/

    .el-tabs__content {
        background-color: #ecf0f5;
    }

    .tab-description >>> .el-tabs >>> .el-tabs__content {
        background-color: #fff !important;
    }

    .block-header-title {
        font-size: 14px !important;
        font-weight: bold;
    }
</style>
