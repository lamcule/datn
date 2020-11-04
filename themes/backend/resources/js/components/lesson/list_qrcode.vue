<template>
  <div>
    <div class="content-header">
      <h1>
        {{ $t('qrcode.label.header') }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin"><i class="fa fa-dashboard" /> {{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('qrcode.label.header') }}
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
          :gutter="20"
        >
          <el-col
                  :sm="12"
                  :md="6"
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
                  :md="6"
          >
          <el-select
            v-model="filter.grade"
            :placeholder="$t('qrcode.label.grade')"
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
            @sort-change="handleSortChange"
          >
            <el-table-column
              type="index"
              width="50"
            />
            <el-table-column
              prop="course_id"
              :label="$t('qrcode.label.course')"
              sortable="custom"
            >
              <template slot-scope="scope">
                <span> {{ scope.row.course_name }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="grade_id"
              :label="$t('qrcode.label.grade')"
              sortable="custom"
            >
              <template slot-scope="scope">
                <span> {{ scope.row.grade_name }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="name"
              :label="$t('qrcode.label.lesson')"
              sortable="custom"
            >
              <template slot-scope="scope">
                <span> {{ scope.row.name }}</span>
              </template>
            </el-table-column>

            <el-table-column
              prop="name"
              :label="$t('qrcode.label.checkin')"
              sortable="custom"
            >
              <template slot-scope="scope">
                <div style="display: flex; align-items: center">
                  <qrcode
                    :value="scope.row.checkin_url"
                    :options="{ width: 100 }"
                  />
                  <el-button
                    style="height: 40px; margin-left: 10px"
                    type="primary"
                    icon="el-icon-printer"
                    @click="printQRCheckin(scope.row)"
                  />
                </div>
              </template>
            </el-table-column>

            <el-table-column
                    prop="name"
                    :label="$t('qrcode.label.review')"
                    sortable="custom"
            >
              <template slot-scope="scope">
                <div style="display: flex; align-items: center">
                  <qrcode
                          :value="scope.row.review_url"
                          :options="{ width: 100 }"
                  />
                  <el-button
                          style="height: 40px; margin-left: 10px"
                          type="danger"
                          icon="el-icon-printer"
                          @click="printQRReview(scope.row)"
                  />
                </div>
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
import VueQrcode from '@chenfengyuan/vue-qrcode'

export default {
  components: {
    qrcode: VueQrcode
  },
  data () {
    return {
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
        lesson: ''
      },
      listLocales: window.MonCMS.locales,
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
  methods: {
    queryServer (customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery,

        course_id: this.filter.course,
        grade_id: this.filter.grade,
        lesson_id: this.filter.lesson
      }

      axios.get(route('api.lesson.qrcode', _.merge(properties, customProperties)))
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
    printQRCheckin (lesson) {
      window.open(lesson.checkin_url, '_blank')
    },
    printQRCheckout (lesson) {
      window.open(lesson.checkout_url, '_blank')
    },
    printQRReview (lesson) {
      window.open(lesson.review_url, '_blank')
    },
    fetchLessons () {
      axios.get(route('api.lesson.all'))
      .then((response) => {
        this.lessons = response.data.data
      })
    },
  },
  mounted () {
    this.fetchData()
    this.fetchCourses()
    this.fetchGrades()
    this.fetchLessons()
  }
}
</script>

<style scoped>

</style>
