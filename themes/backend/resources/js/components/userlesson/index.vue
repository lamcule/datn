<template>
  <div>
    <div class="content-header">
      <h1>
        {{ $t('checkinout.label.header') }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin"><i class="fa fa-dashboard" /> {{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('checkinout.label.header') }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-dialog
      :title="$t('checkinout.label.checkinout title')"
      :visible.sync="showCheckinoutDialog"
      width="30%"
      center
    >
      <el-form
        ref="checkinoutForm"
        v-loading.body="loading"
        :model="modelForm"
        label-width="120px"
        label-position="top"
      >
        <el-form-item
          :label="$t('checkinout.label.type check')"
          :class="{'el-form-item is-error': checkinoutForm.errors.has('type') }"
        >
          <el-radio-group v-model="modelForm.type">
            <el-radio-button label="Checkin" />
            <el-radio-button label="Checkout" />
          </el-radio-group>
          <div
            v-if="checkinoutForm.errors.has('type')"
            class="el-form-item__error"
            v-text="checkinoutForm.errors.first('type')"
          />
        </el-form-item>

        <el-form-item
          :label="$t('checkinout.label.course')"
          :class="{'el-form-item is-error': checkinoutForm.errors.has('course_id') }"
        >
          <el-select
            v-model="modelForm.course_id"
            :placeholder="$t('checkinout.label.course')"

            style="width: 100% !important"
          >
            <el-option
              v-for="item in courses"
              :key="'course'+item.id"
              :label="item.name"
              :value="item.id"
            />
          </el-select>
          <div
            v-if="checkinoutForm.errors.has('course_id')"
            class="el-form-item__error"
            v-text="checkinoutForm.errors.first('course_id')"
          />
        </el-form-item>
        <el-form-item
          :label="$t('checkinout.label.grade')"
          :class="{'el-form-item is-error': checkinoutForm.errors.has('grade_id') }"
        >
          <el-select
            v-model="modelForm.grade_id"
            :placeholder="$t('checkinout.label.grade')"

            style="width: 100% !important"
          >
            <el-option
              v-for="item in gradesFormFiltered"
              :key="'grade'+item.id"
              :label="item.name"
              :value="item.id"
            />
          </el-select>
          <div
            v-if="checkinoutForm.errors.has('grade_id')"
            class="el-form-item__error"
            v-text="checkinoutForm.errors.first('grade_id')"
          />
        </el-form-item>
        <el-form-item
          :label="$t('checkinout.label.lesson')"
          :class="{'el-form-item is-error': checkinoutForm.errors.has('lesson_id') }"
        >
          <el-select
            v-model="modelForm.lesson_id"
            :placeholder="$t('checkinout.label.lesson')"
            style="width: 100% !important"
          >
            <el-option
              v-for="item in lessonsFormFiltered"
              :key="'lesson'+item.id"
              :label="item.name"
              :value="item.id"
            />
          </el-select>
          <div
            v-if="checkinoutForm.errors.has('lesson_id')"
            class="el-form-item__error"
            v-text="checkinoutForm.errors.first('lesson_id')"
          />
        </el-form-item>

        <el-form-item
          :label="$t('checkinout.label.username')"
          :class="{'el-form-item is-error': checkinoutForm.errors.has('username') }"
        >
          <el-select
            v-model="modelForm.username"
            :placeholder="$t('checkinout.label.username')"
            filterable
            remote
            style="width: 100% !important"
          >
            <el-option
              v-for="item in students"
              :key="'student'+item.id"
              :label="item.username + ' - ' + item.phone"
              :value="item.username"
            />
          </el-select>
          <div
            v-if="checkinoutForm.errors.has('username')"
            class="el-form-item__error"
            v-text="checkinoutForm.errors.first('username')"
          />
        </el-form-item>
      </el-form>

      <span
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="showCheckinoutDialog = false">  {{ $t('mon.button.cancel') }}</el-button>
        <el-button
          type="primary"
          @click="submitCheckInOut"
        > {{ $t('mon.button.save') }}</el-button>
      </span>
    </el-dialog>

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">
          {{ $t('mon.label.search_condition') }}
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
          :gutter="20"
        >
          <el-col
            :sm="12"
            :md="3"
          >
            <el-select
              v-model="filter.course"
              :placeholder="$t('checkinout.label.course')"
              clearable
              @change="fetchData"
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
            :md="3"
          >
            <el-select
              v-model="filter.grade"
              :placeholder="$t('checkinout.label.grade')"
              clearable
              @change="fetchData"
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
            :md="3"
          >
            <el-select
              v-model="filter.lesson"
              :placeholder="$t('checkinout.label.lesson')"
              clearable
              @change="fetchData"
            >
              <el-option
                v-for="item in lessonsFiltered"
                :key="'lesson'+item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-col>
          <el-col
            :sm="12"
            :md="6"
          >
            <el-input
              v-model="filter.full_name"
              :placeholder="$t('checkinout.label.full_name')"
              prefix-icon="el-icon-search"
              @keyup.native="performSearch"
            />
          </el-col>
          <el-col
            :sm="12"
            :md="3"
          >
            <el-input
              v-model="filter.username"
              :placeholder="$t('checkinout.label.username')"
              prefix-icon="el-icon-search"
              @keyup.native="performSearch"
            />
          </el-col>
          <el-col
            :sm="12"
            :md="3"
          >
            <el-input
              v-model="filter.email"
              :placeholder="$t('checkinout.label.email')"
              prefix-icon="el-icon-search"
              @keyup.native="performSearch"
            />
          </el-col>
          <el-col
            :sm="12"
            :md="3"
          >
            <el-input
              v-model="filter.phone"
              :placeholder="$t('checkinout.label.phone')"
              prefix-icon="el-icon-search"
              @keyup.native="performSearch"
            />
          </el-col>
        </el-row>
      </div>
    </div>

    <div class="row">
      <div
        class="col-md-12 row-action"
        style="justify-content: flex-start;"
      >
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
              prop="course_id"
              :label="$t('checkinout.label.course')"
              sortable="custom"
            >
              <template slot-scope="scope">
                <span> {{ scope.row.course_name }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="grade_id"
              :label="$t('checkinout.label.grade')"
              sortable="custom"
            >
              <template slot-scope="scope">
                <span> {{ scope.row.grade_name }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="lesson_id"
              :label="$t('checkinout.label.lesson')"
              sortable="custom"
            >
              <template slot-scope="scope">
                <span> {{ scope.row.lesson_name }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="user_id"
              :label="$t('checkinout.label.user')"
              sortable="custom"
            >
              <template slot-scope="scope">
                <a
                  style="cursor: pointer"
                  @click.prevent="gotoUserLink(scope.row)"
                > {{ scope.row.user_name }}</a>
              </template>
            </el-table-column>
            <el-table-column
              prop="user_id"
              :label="$t('checkinout.label.full_name')"
              sortable="custom"
            >
              <template slot-scope="scope">
                <a
                  style="cursor: pointer"
                  @click.prevent="gotoUserLink(scope.row)"
                > {{ scope.row.user_fullname }}</a>
              </template>
            </el-table-column>
            <el-table-column
              prop="checkin_at"
              :label="$t('checkinout.label.checkin_at')"
              sortable="custom"
            />
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
import Form from 'form-backend-validation'

export default {
  data () {
    return {
      checkinoutForm: new Form(),
      loading: false,
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
      currentLocale: window.MonCMS.currentLocale || 'en',
      filter: {
        course: '',
        grade: '',
        lesson: '',
        full_name: '',
        username: '',
        email: '',
        phone: ''
      },
      modelForm: {
        course_id: '',
        grade_id: '',
        lesson_id: '',
        username: '',
        type: 'Checkin'

      },
      listLocales: window.MonCMS.locales,
      courses: [],
      grades: [],
      lessons: [],
      showCheckinoutDialog: false,
      students: []

    }
  },
  computed: {
    gradesFormFiltered: function () {
      if (this.modelForm.course_id) {
        return this.grades.filter(item => item.course_id == this.modelForm.course_id)
      }
      return this.grades.filter(item => true)
    },
    lessonsFormFiltered: function () {
      if (this.modelForm.grade_id) {
        return this.lessons.filter(item => item.grade_id == this.modelForm.grade_id)
      }
      return this.lessons.filter(item => true)
    },
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
    queryServer (customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        full_name: this.filter.full_name,
        username: this.filter.username,
        email: this.filter.email,
        phone: this.filter.phone,

        course_id: this.filter.course,
        grade_id: this.filter.grade,
        lesson_id: this.filter.lesson
      }

      axios.get(route('api.userlesson.index', _.merge(properties, customProperties)))
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
      this.queryServer({ per_page: 25 })
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
    fetchStudents () {
      axios.get(route('api.student.all'))
        .then((response) => {
          this.students = response.data.data
        })
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
      this.queryServer({})
    }, 300),
    download () {
      let url = route('admin.checkinout.download', {
        course_id: this.filter.course,
        grade_id: this.filter.grade,
        lesson_id: this.filter.lesson,
        full_name: this.filter.full_name,
        username: this.filter.username,
        email: this.filter.email,
        phone: this.filter.phone
      })
      window.open(url, '_blank')
    },
    submitCheckInOut () {
      this.checkinoutForm = new Form(this.modelForm)
      this.loading = true

      this.checkinoutForm.post(route('api.userlesson.checkinout'))
        .then((response) => {
          this.loading = false
          if (response.errors) {
            this.$message({
              type: 'success',
              message: response.message
            })
            this.showCheckinoutDialog = false
            this.fetchData()
          } else {
            this.$message({
              type: 'error',
              message: response.message
            })
          }
        })
        .catch((error) => {
          this.loading = false
          this.$notify.error({
            title: 'Error',
            message: this.getSubmitError(this.checkinoutForm.errors)
          })
        })
    },
    gotoUserLink (row) {
      window.location = row.user_link
    }
  },
  mounted () {
    this.fetchData()
    this.fetchCourses()
    this.fetchGrades()
    this.fetchLessons()
    this.fetchStudents()
  },
  created: function () {
    setInterval(function () {
      this.fetchData()
    }.bind(this), 10000)
  }
}
</script>

<style scoped>

</style>
