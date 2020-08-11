<template>
  <div>
    <div class="content-header">
      <h1>{{ $t('report.grade.header') }}</h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('report.grade.header') }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>
    <div class="box box-widget">
      <div class="box-header with-border">
        <h3 class="box-title">
          Summary Report
        </h3>

        <div class="box-tools pull-right">
          <i
            v-if="show_filter"
            class="far fa-chevron-up"
            style="cursor:pointer"
            @click="show_filter = !show_filter"
          />
          <i
            v-if="!show_filter"
            class="far fa-chevron-down"
            style="cursor:pointer"
            @click="show_filter = !show_filter"
          />
        </div>
        <!-- /.box-tools -->
      </div>
      <div class="box-body">
        <el-row
          v-if="show_filter"
          :gutter="10"
        >
          <el-col
            :sm="12"
            :md="6"
          >
            <el-input
              v-model="searchQuery"
              prefix-icon="el-icon-search"
              @keyup.native="performSearch"
            />
          </el-col>
        </el-row>
      </div>
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

    <div class="box box-widget">
      <div
        class="box-body"
        style="padding: 0px"
      >
        <div class="sc-table">
          <el-table
            ref="dataTable"
            v-loading.body="tableIsLoading"
            :data="data"
            stripe
          >
            <el-table-column
              type="index"
              width="50"
            />
            <el-table-column
              prop="start_day"
              :label="$t('report.grade.start_day')"
            />
            <el-table-column
              prop="start_month"
              :label="$t('report.grade.start_month')"
            />
            <el-table-column
              prop="start_year"
              :label="$t('report.grade.start_year')"
            />
            <el-table-column
              prop="course.name"
              :label="$t('report.grade.course_name')"
            />
            <el-table-column
                    prop="name"
                    :label="$t('report.grade.grade_name')"
            />


            <el-table-column
                    prop="course.type"
                    :label="$t('report.grade.course_type')"
            />
            <el-table-column
              prop="place"
              :label="$t('report.grade.address')"
              width="250"
            >
              <template slot-scope="scope">
                <span v-if="scope.row.place">{{ scope.row.place + ', '+ scope.row.phoenix.name + ', ' + scope.row.district.name + ', '+ scope.row.province.name }}</span>
                <span v-else>{{  scope.row.phoenix.name + ', ' + scope.row.district.name + ', '+  scope.row.province.name }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="course.project"
              :label="$t('report.grade.course_project')"
            />
            <el-table-column
              prop="course.object"
              :label="$t('report.grade.course_object')"
              width="250"
            />
<!--            <el-table-column-->
<!--                    prop="partner"-->
<!--                    :label="$t('report.grade.partner')"-->
<!--            />-->

            <el-table-column
              prop="number_of_lesson"
              :label="$t('report.grade.number_of_lesson')"
            />
            <el-table-column
              prop="number_of_participant"
              :label="$t('report.grade.number_of_participant')"
              width="200"
            />
            <el-table-column
              prop="teacher"
              :label="$t('report.grade.teacher')"
              width="150"
            />
            <el-table-column
              prop="course.description"
              :label="$t('report.grade.course_description')"
              width="250"
            />
<!--            <el-table-column-->
<!--              prop="course.tuition"-->
<!--              :label="$t('report.grade.tuition')"-->
<!--              width="250"-->
<!--            />-->
<!--            <el-table-column-->
<!--                    prop="tuition_partner"-->
<!--                    :label="$t('report.grade.tuition_partner')"-->
<!--                    width="250"-->
<!--            />-->

<!--            <el-table-column-->
<!--                    prop="tuition_svf"-->
<!--                    :label="$t('report.grade.tuition_svf')"-->
<!--                    width="250"-->
<!--            />-->

            <el-table-column
              prop="actions"
              width="80"
            >
              <template slot-scope="scope">
                <view-button
                  :to="{name: 'admin.report.grade.detail', params: {gradeId: scope.row.id}}"
                />
              </template>
            </el-table-column>
          </el-table>
          <div
            class="pagination-wrap"
            style="text-align: center; padding-top: 20px;"
          >
            <el-pagination
              :current-page.sync="meta.current_page"
              :page-sizes="[25, 50, 75, 100]"
              :page-size="parseInt(meta.per_page)"
              layout="total, sizes, prev, pager, next, jumper"
              :total="meta.total"
              @size-change="handleSizeChange"
              @current-change="handleCurrentChange"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {

  data () {
    return {
      message: 'Copy link đăng ký lớp học',
      data: [],
      meta: {
        current_page: 1,
        per_page: 25
      },
      order_meta: {
        order_by: '',
        order: ''
      },
      links: {},
      searchQuery: '',
      tableIsLoading: false,
      show_filter: true,
      columnsSearch: [],
      courseId: 0,

      currentLocale: window.MonCMS.currentLocale || 'en',
      categoryArr: window.MonCMS.gradeListCategory,
      statusArr: window.MonCMS.gradeListStatus,
      filter: {
        status: '',
        locale: window.MonCMS.currentLocale || 'en'
      },
      listLocales: window.MonCMS.locales

    }
  },
  methods: {
    copyLink (row) {
      this.$message({
        type: 'success',
        message: 'Đã copy link đăng ký lớp học'
      })
    },
    queryServer (customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery,
        status: this.filter.status,
        locale: this.filter.locale
      }

      axios.get(route('api.report.grades', _.merge(properties, customProperties)))
        .then((response) => {
          this.tableIsLoading = false
          this.data = response.data.data
          this.meta = response.data.meta
          this.links = response.data.links
          this.order_meta.order_by = properties.order_by
          this.order_meta.order = properties.order
        })
    },
    fetchData () {
      this.tableIsLoading = true
      this.queryServer({ per_page: 25 })
    },

    handleSizeChange (event) {
      this.tableIsLoading = true
      this.queryServer({ per_page: event })
    },
    handleCurrentChange (event) {
      this.tableIsLoading = true
      this.queryServer({ page: event })
    },
    handleSortChange (event) {
      this.tableIsLoading = true
      this.queryServer({ order_by: event.prop, order: event.order })
    },
    performSearch: _.debounce(function (query) {
      this.tableIsLoading = true
      this.queryServer({ search: query.target.value, page: this.meta.current_page })
    }, 300),
    statusColor (course) {
      if (course.status === 'active') {
        return '#00a65a'
      }
      return '#dd4b39'
    },
    download () {
      let url = route('admin.report.grade.downloadGradeSummary' )
      window.open(url, '_blank')
    }
  },
  mounted () {
    this.fetchData()
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

  .tab-description >>> .el-tabs >>> .el-tabs__content {
    background-color: #fff !important;
  }

  .block-header-title {
    font-size: 14px !important;
    font-weight: bold;
  }
</style>
