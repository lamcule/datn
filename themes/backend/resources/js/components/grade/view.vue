<template>
  <div>
    <div class="content-header" v-if="grade">
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{name: 'admin.grade.index'}">
          {{ $t('grade.label.manage_grade') }}
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ grade.name }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>
    <div
            class="row-left"
            style="padding-top: 10px; padding-bottom: 10px;"
    >
      <router-link :to="{name: 'admin.grade.edit', params:{gradeId:this.$route.params.gradeId }, query:{course: grade.course_id}  }">
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
                :label="$t('grade.tabs.lesson')"
                name="grade"

              >
                <lesson-table :grade="grade"/>
              </el-tab-pane>
              <el-tab-pane
                      :label="$t('grade.tabs.students')"
                      name="student"
              >
                <student-table />
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
import gradeDetail from './_detail'
import LessonTable from './_lesson'
import StudentTable from './_student'

export default {
  components: {
    gradeDetail,
    LessonTable,
    StudentTable
  },
  props: {
    locales: { default: null },
    pageTitle: { default: null, String }
  },
  data () {
    return {
      activeTab: 'grade',
      sa: 0,
      courseId: 0,
      grade: {},
      loading: true
    }
  },
  computed: {},
  mounted () {
    this.fetchData()
  },
  methods: {
    fetchData () {
      let routeUri = ''
      this.loading = true
      routeUri = route('api.grade.find', { grade: this.$route.params.gradeId })
      axios.get(routeUri)
        .then((response) => {
          this.loading = false
          this.grade = response.data.data
        })
    }
  }
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

    .tab-description > > > .el-tabs > > > .el-tabs__content {
        background-color: #fff !important;
    }

    .block-header-title {
        font-size: 14px !important;
        font-weight: bold;
    }
</style>
