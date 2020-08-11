<template>
  <div v-if="grade">
    <div

      class="content-header"
    >
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{name: 'admin.report.grades'}">
          {{ $t('report.grade.header') }}
        </el-breadcrumb-item>

        <el-breadcrumb-item>
          {{ $t('report.grade.header detail') }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>
    <div class="row">
      <div class="col-md-12 row-action">
        <el-button
                type="primary"
                size="small"
                class="btn btn-flat"
                icon="el-icon-download"
                @click="download"
        >
          {{ $t('report.label.download') }}
        </el-button>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="box box-widget">
          <div
            class="box-header with-border"
            style="padding: 10px"
          >
            <h3 class="box-title">
              Thông tin chương trình
            </h3>
          </div>
          <div
            class="box-body"
            style="padding: 10px"
          >
            <div class="row">
              <div class="col-md-6">
                <div class="box box-widget">
                  <div
                    class="box-body"
                    style="padding: 10px"
                  >
                    <ul class="list-group list-group-unbordered">
                      <li class="list-group-item">
                        <b> Ngày</b> <span class="pull-right">{{ grade.start_time }}</span>
                      </li>
                      <li class="list-group-item">
                        <b> Thời lượng</b> <span class="pull-right">{{ grade.hours }}</span>
                      </li>
                      <li class="list-group-item">
                        <b> Phân loại </b> <span class="pull-right">{{ grade.course.type }}</span>
                      </li>
                      <li class="list-group-item">
                        <b> Chủ đề </b> <span class="pull-right">{{ grade.course.name }} </span>
                      </li>
                      <li class="list-group-item">
                        <b> Đối tác </b> <span class="pull-right"> </span>
                      </li>
                      <li class="list-group-item">
                        <b> Đối tượng tham dự </b> <span class="pull-right">{{ grade.course.object }}</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="box box-widget">
                  <div
                    class="box-body"
                    style="padding: 10px"
                  >
                    <ul class="list-group list-group-unbordered">
                      <li class="list-group-item">
                        <template v-if="grade.place">
                          <b>Địa điểm</b> <span class="pull-right">{{ grade.place+ ', ' + grade.phoenix.name + ', ' + grade.district.name + ', ' + grade.province.name }}</span>
                        </template>
                        <template v-else>
                          <b>Địa điểm</b> <span class="pull-right">{{ grade.phoenix.name + ', ' + grade.district.name + ', ' + grade.province.name }}</span>
                        </template>
                      </li>
                      <li class="list-group-item">
                        <b>Giá trị</b> <span class="pull-right">{{ grade.course.tuition }}</span>
                      </li>
                      <li class="list-group-item">
                        <b>Chương trình </b> <span class="pull-right">{{ grade.name }} </span>
                      </li>
                      <li class="list-group-item">
                        <b>Dự án thực hiện</b> <span class="pull-right">{{ grade.course.project }}</span>
                      </li>
                      <li class="list-group-item">
                        <b>Giảng viên</b> <span class="pull-right">{{ grade.teacher }}</span>
                      </li>
                      <li class="list-group-item">
                        <b>Quy mô </b> <span class="pull-right">{{grade.number_of_participant}}</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div
          v-for="group in reviews"
          :key="'g'+ group.id"
        >
          <div class="box box-widget">
            <div
              class="box-header with-border"
              style="padding: 10px"
            >
              <h3 class="box-title">
                {{ group.name }}
              </h3>
            </div>
            <div
              class="box-body"
              style="padding: 10px"
            >
              <ul class="list-group list-group-unbordered">
                <li
                  v-for="question in group.questions"
                  :key="'question-' + group.id + question.id"
                  class="list-group-item"
                  style="border: none;"
                >
                  <b> {{ question.question }}</b> <span
                    class="pull-right"
                  >{{ question.rate_avg }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="box box-widget">
          <div
            class="box-header with-border"
            style="padding: 10px"
          >
            <div class="row">
              <div class="col-md-6">
                <h3 class="box-title">
                  CẢM NHẬN VỀ CHƯƠNG TRÌNH
                </h3>
              </div>
              <div class="col-md-6">
                <button
                  class="btn btn-danger pull-right btn-block btn-sm"
                  @click="showDetail=true"
                >
                  XEM CHI TIẾT
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <el-dialog
      title="BẢNG CÂU TRẢ LỜI REVIEW"
      :visible.sync="showDetail"
      width="90%"
    >
      <GradeReview :grade-id="$route.params.gradeId" />
    </el-dialog>
  </div>
</template>

<script>
import axios from 'axios'
import GradeReview from './grade_review'
export default {
  components: {
    GradeReview
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
      loading: true,
      reviews: [],
      showDetail: false
    }
  },
  computed: {},
  mounted () {
    this.fetchData()
    this.fetchReview()
  },
  methods: {
    fetchData () {
      let routeUri = ''
      this.loading = true
      routeUri = route('api.report.grade.detail', { grade: this.$route.params.gradeId })
      axios.get(routeUri)
        .then((response) => {
          this.loading = false
          this.grade = response.data.data
        })
    },
    fetchReview () {
      let routeUri = ''
      routeUri = route('api.report.grade.review', { grade: this.$route.params.gradeId })
      axios.get(routeUri)
        .then((response) => {
          this.reviews = response.data
        })
    },
    download () {
      let url = route('admin.report.grade.downloadGradeDetail', { grade: this.$route.params.gradeId } )
      window.open(url, '_blank')
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
