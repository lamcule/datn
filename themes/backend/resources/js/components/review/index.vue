<template>
  <div>
    <div class="content-header">
      <h1>{{ $t('review.label.header') }}</h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('review.label.header') }}
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
    <div class="box box-success">
      <div class="box-body">
        <div class="sc-table">
          <el-table
            ref="dataTable"
            v-loading.body="tableIsLoading"
            :data="data"
            stripe
            style="width: 100%"
          >
            <el-table-column
              type="index"
              width="50"
            />

            <el-table-column
              prop="user_name"
              :label="$t('review.label.user_id')"
              sortable="custom"
            />
            <el-table-column
              prop="course_name"
              :label="$t('review.label.course_id')"
              sortable="custom"
            />
            <el-table-column
              prop="grade_name"
              :label="$t('review.label.grade_id')"
              sortable="custom"
            />
            <el-table-column
              prop="lesson_name"
              :label="$t('review.label.lesson_id')"
              sortable="custom"
            />
            <el-table-column
              prop="question_text"
              :label="$t('review.label.question_text')"
              sortable="custom"
            />
            <el-table-column
              prop="answer"
              :label="$t('review.label.answer')"
              sortable="custom"
            >
              <template slot-scope="props">
                <span v-if="props.row.question_type == 'text'">{{ props.row.answer }}</span>
                <star-rating
                  v-else
                  :rating="props.row.answer"
                  :show-rating="false"
                  :star-size="20"
                  :read-only="true"
                />
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
import StarRating from 'vue-star-rating'

export default {
  components: {
    StarRating
  },
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
        status: '',
        course: '',
        grade: '',
        lesson: ''
      },
      courses: [],
      grades: [],
      lessons: []
    }
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
  mounted () {
    this.fetchData()
    this.fetchCourses()
    this.fetchGrades()
    this.fetchLessons()
  },
  methods: {

    queryServer (customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        search: this.searchQuery,
        status: this.filter.status,
        course_id: this.filter.course,
        grade_id: this.filter.grade,
        lesson_id: this.filter.lesson,
        userreview:  this.$route.params.userreviewId
      }

      axios.get(route('api.review.index', _.merge(properties, customProperties)))
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
    handleSizeChange (event) {
      this.tableIsLoading = true
      this.queryServer({ per_page: event })
    },
    handleCurrentChange (event) {
      this.tableIsLoading = true
      this.queryServer({ page: event })
    },
    performSearch: _.debounce(function (query) {
      this.tableIsLoading = true
      this.queryServer({ search: query.target.value, page: this.meta.current_page })
    }, 300)
  }
}
</script>

<style scoped>

</style>
