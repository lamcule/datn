<template>
  <div>
    <div class="content-header">
      <h1>{{ $t('report.student.header') }}</h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('report.student.header') }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

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
          :gutter="10"
        >
          <el-col
                  :sm="12"
                  :md="3"
          >
          <el-select
                  v-model="filter.course"
                  :placeholder="$t('qrcode.label.course')"
                  @change="fetchData"
                  clearable
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
                    @change="fetchData"
                    clearable
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
            <el-table-column type="expand">
              <template slot-scope="props">
                <div
                        class="row"
                        style="padding-left: 10px"
                >
                  <div class="col-md-3">
                    <p>{{ $t('student.label.username') }}: {{ props.row.username }}</p>
                    <p>{{ $t('student.label.birth_date') }}: {{ props.row.profile.birth_date }}</p>
                    <p>{{ $t('student.label.phone') }}: {{ props.row.profile.phone }}</p>
                    <p>{{ $t('student.label.gender') }}: <span
                            class="badge"
                            :style="'background-color:' + genderColor(props.row)"
                    >{{ props.row.profile.gender }}</span></p>
                    <p>{{ $t('student.label.email') }}: {{ props.row.email }}</p>
                    <p>{{ $t('student.label.created_at') }}: {{ props.row.created_at }}</p>
                    <p>
                      Lớp học đã đăng ký: <span class="badge bg-danger" v-if="props.row.grades.length > 0">
                        <ul>
                          <li
                                  v-for="grade in props.row.grades"
                                  :key="'grade'+grade.id"
                          >{{ grade.name }}</li>
                        </ul>
                      </span>
                    </p>
                  </div>
                  <div class="col-md-9">
                    <p v-if="props.row.profile">{{ $t('student.label.province_id') }}: {{ props.row.profile.province? props.row.profile.province.name : '' }}</p>
                    <p  v-if="props.row.profile">{{ $t('student.label.district_id') }}: {{ props.row.profile.district? props.row.profile.district.name : '' }}</p>
                    <p  v-if="props.row.profile">{{ $t('student.label.phoenix_id') }}: {{ props.row.profile.phoenix? props.row.profile.phoenix.name : '' }}</p>
                    <p  v-if="props.row.profile">{{ $t('student.label.address') }}: {{ props.row.profile.address }}</p>
                    <p  v-if="props.row.profile">{{ $t('student.label.company') }}: <span class="badge bg-aqua">{{ props.row.profile.company }}</span> </p>
                    <p  v-if="props.row.profile">{{ $t('student.label.position') }}: {{ props.row.profile.position }}</p>
                    <p  v-if="props.row.profile">{{ $t('student.label.company_address') }}: {{ props.row.profile.company_address }}</p>
                    <p  v-if="props.row.profile">{{ $t('student.label.categories') }}: <span class="badge bg-warning">{{ props.row.profile.categories.join(', ') }}</span> </p>
                    <p  v-if="props.row.profile">{{ $t('student.label.personal_categories') }}: <span class="badge bg-danger">{{ props.row.profile.personal_categories.join(', ') }}</span> </p>
                  </div>
                </div>
              </template>
            </el-table-column>
            <el-table-column
              type="index"
              width="50"
            />

            <el-table-column
                    prop="username"
                    :label="$t('student.label.username')"
                    sortable="custom"
            >
              <template slot-scope="props">
                <span class="badge bg-maroon" >{{ props.row.username }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="profile.full_name"
              :label="$t('student.label.name')"
              sortable="custom"
            />
            <el-table-column
                    prop="profile.birth_date"
                    :label="$t('student.label.birth_date')"
                    sortable="custom"
            >
              <template slot-scope="props">
                <span class="badge bg-aqua" >{{ props.row.profile.birth_date }}</span>
              </template>
            </el-table-column>
            <el-table-column
                    prop="email"
                    :label="$t('student.label.email')"
                    sortable="custom"
            >
              <template slot-scope="props">
                <span class="badge bg-warning" >{{ props.row.email }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="profile.phone"
              :label="$t('student.label.phone')"
              sortable="custom"
            />
            <el-table-column
                    prop="profile.gender"
                    :label="$t('student.label.gender')"
                    sortable="custom"
            >
              <template slot-scope="props">
                <span
                        class="badge"
                        :style="'background-color:' + genderColor(props.row)"
                >{{ props.row.profile.gender }}</span>
              </template>
            </el-table-column>

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
      filter: {
        course: '',
        status: '',
        grade: '',
        lesson: '',
      },
      listStatus: [
        {
          value: '',
          label: 'all'
        },
        {
          value: 'active',
          label: 'active'
        },
        {
          value: 'inactive',
          label: 'inactive'
        }
      ],
      courses: [],
      grades: [],
      lessons: [],
      uploadUrl: route('api.student.import'),
      user_token: window.MonCMS.user_token

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

    queryServer (customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery,
        status: this.filter.status,
        course_id: this.filter.course,
        grade_id: this.filter.grade,
        lesson_id: this.filter.lesson
      }

      axios.get(route('api.report.student', _.merge(properties, customProperties)))
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
    download () {
      let url = route('admin.report.downloadStudent',{ search: this.searchQuery,
        status: this.filter.status,
        course_id: this.filter.course,
        grade_id: this.filter.grade,
        lesson_id: this.filter.lesson})
      window.open(url, '_blank')
    },
    genderColor (student) {
      if (student.profile.gender == 'Nam') {
        return '#ff3d0c'
      }
      return '#0bb0ff'
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
    performSearch: _.debounce(function (query) {
      this.tableIsLoading = true
      this.queryServer({ search: query.target.value, page: 1 })
    }, 300),
  }
}
</script>

<style scoped>
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
    .el-upload{
        width: 100%;
    }
</style>
