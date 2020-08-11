<template>
  <div>
    <div class="content-header">
      <h1>Course feedback report</h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          Course feedback report
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">
          {{ $t('report.student_activity.search_condition') }}
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
                  :md="8"
          >
            <el-select
                    v-model="filter.course"
                    :placeholder="$t('qrcode.label.course')"
                    @change ="()=> {filter.grade=null;filter.lesson=null}"
                    clearable
                    style="width: 100%"
            >
              <el-option
                      v-for="item in courses"
                      :key="'course'+item.id"
                      :label="item.name"
                      :value="item.id"
              />
            </el-select>
          </el-col>
          <el-col
                  :sm="12"
                  :md="8"
          >
            <el-select
                    style="width: 100%"
                    v-model="filter.grade"
                    :placeholder="$t('checkinout.label.grade')"
                    clearable
                    @change ="()=> { filter.lesson=null}"
            >
              <el-option
                      v-for="item in gradesFiltered"
                      :key="'grade'+item.id"
                      :label="item.name"
                      :value="item.id"
              />
            </el-select>
          </el-col>
          <el-col
                  :sm="12"
                  :md="8"
          >
            <el-select
                    style="width: 100%"
                    v-model="filter.lesson"
                    :placeholder="$t('checkinout.label.lesson')"
                    @change="fetchData"
                    clearable
            >
              <el-option
                      v-for="item in lessonsFiltered"
                      :key="'lesson'+item.id"
                      :label="item.name"
                      :value="item.id"
              />
            </el-select>
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
          v-if="filter.lesson"
        >
          {{ $t('report.label.download') }}
        </el-button>
      </div>
    </div>
    <div class="box box-success">
      <div class="box-body">
        <div class="sc-table">
          <el-table
            ref="dataTable"
            v-loading.body="tableIsLoading"
            :data="data"
            stripe
            style="width: 100%"
            @sort-change="handleSortChange"
          >
            <el-table-column
              type="index"
              width="50"
            />
            <el-table-column
              prop="username"
              :label="$t('report.student_lesson.username')"
              sortable="custom"
              width="120"
            />

            <el-table-column
                    prop="name"
                    :label="$t('report.student_lesson.name')"
                    sortable="custom"
                    width="150"
            />
            <el-table-column
                    prop="dob"
                    :label="$t('report.student_lesson.dob')"
                    sortable="custom"
                    width="200"
            />
            <el-table-column
                    prop="gender"
                    :label="$t('report.student_lesson.gender')"
                    sortable="custom"
                    width="120"
            />
            <el-table-column
                    prop="address"
                    :label="$t('report.student_lesson.address')"
                    sortable="custom"
                    width="150"
            />
            <el-table-column
                    prop="email"
                    :label="$t('report.student_lesson.email')"
                    sortable="custom"
                    width="150"
            />
            <el-table-column
                    prop="phone"
                    :label="$t('report.student_lesson.phone')"
                    sortable="custom"
                    width="120"
            />
            <el-table-column
                    prop="reg_at"
                    :label="$t('report.student_lesson.reg_at')"
                    sortable="custom"
                    width="150"
            />
            <el-table-column
                    prop="company"
                    :label="$t('report.student_lesson.company')"
                    sortable="custom"
                    width="150"
            />

            <el-table-column
                    prop="company_address"
                    :label="$t('report.student_lesson.company_address')"
                    sortable="custom"
                    width="200"
            />
            <el-table-column
                    prop="categories"
                    :label="$t('report.student_lesson.categories')"
                    sortable="custom"
                    width="150"
            />
            <el-table-column
                    prop="personal_categories"
                    :label="$t('report.student_lesson.personal_categories')"
                    sortable="custom"
                    width="150"
            />
            <el-table-column
                    prop="checkin_at"
                    :label="$t('report.student_lesson.checkin_at')"
                    sortable="custom"
                    width="200"
            />
            <el-table-column
                    prop="checkout_at"
                    :label="$t('report.student_lesson.checkout_at')"
                    sortable="custom"
                    width="200"
            />
            <el-table-column
                    prop="feedback"
                    :label="$t('report.student_lesson.feedback')"
                    sortable="custom"
                    width="200"
            />

          </el-table>
          <div
            v-if="data.length> 0"
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
      dialogUploadVisible: false,
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

      columnsSearch: [],
      listFilterColumn: [],
      show_filter: true,

      courses: [],
      grades: [],
      lessons: [],
      user_token: window.MonCMS.user_token,
      filter: {
        course: '',
        grade: '',
        lesson: '',

      },
    }
  },
  mounted () {
    this.fetchData()
    this.fetchCourses()
    this.fetchGrades()
    this.fetchLessons()
  },

  computed: {
    gradesFiltered: function () {
      if (this.filter.course) {
        return this.grades.filter(item => item.course_id == this.filter.course)
      }
      return this.grades.filter(item => true)
    },
    lessonsFiltered: function () {
      if (this.filter.grade) {
        return this.lessons.filter(item => item.grade_id == this.filter.grade)
      }
      return this.lessons.filter(item => true)
    }
  },
  methods: {
    performSearch: _.debounce(function (query) {
      this.tableIsLoading = true
      this.queryServer({ search: query.target.value, page: this.meta.current_page })
    }, 300),
    queryServer (customProperties) {
      if (!this.filter.lesson) {
        return
      }
      this.tableIsLoading = true
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,

        lesson_id: this.filter.lesson
      }

      axios.get(route('api.report.studentLesson', _.merge(properties, customProperties)))
        .then((response) => {
          this.tableIsLoading = false
          this.tableIsLoading = false
          this.data = response.data.data
          this.meta = response.data.meta
          this.links = response.data.links
          this.order_meta.order_by = properties.order_by
          this.order_meta.order = properties.order
        })
    },
    fetchData () {

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
    fetchCourses () {
      axios.get(route('api.course.all'))
              .then((response) => {
                this.courses = response.data.data
              })
    },
    fetchGrades () {
      axios.get(route('api.grade.all'))
              .then((response) => {
                this.grades = response.data.data
              })
    },
    fetchLessons () {
      axios.get(route('api.lesson.all'))
              .then((response) => {
                this.lessons = response.data.data
              })
    },
    download () {
      let url = route('admin.report.downloadStudentLesson', { lesson_id: this.filter.lesson })
      window.open(url, '_blank')
    }

  }
}
</script>

<style scoped>
    .el-row {
      margin-bottom: 20px;
      &:last-child {
         margin-bottom: 0;
       }
    }
    .filter-active {
        color: green
    }

    .btn-active {
        color: #FFF;
        background-color: green;
        border-color: green;
    }

    .btn-inactive {
        color: #FFF;
        background-color: red;
        border-color: red;
    }

    .demonstration {
        display: block;
        color: #8492a6;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .el-upload__input {
        display: none !important;
    }

    input[type=file] {
        display: none !important;
    }

    .el-upload-dragger {
        width: 100%;
    }

    .el-upload {
        width: 100%;
    }
</style>
