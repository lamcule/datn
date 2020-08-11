<template>
  <div>
    <div class="row">
      <div class="col-md-12 row-action" v-if="data.length > 0">
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
              prop="username"
              :label="$t('report.grade.username')"
            />
            <el-table-column
              prop="user"
              :label="$t('student.label.name')"
            />
            <el-table-column
              prop="course"
              :label="$t('report.grade.course')"
            />
            <el-table-column
              prop="grade"
              :label="$t('report.grade.grade')"
            />
            <el-table-column
              prop="lesson"
              :label="$t('report.grade.lesson')"
            />
            <el-table-column
              v-for="(question, index) in count_question" :key="index"
              :label="$t('report.grade.question index') + ' ' + (index + 1)"
            >
              <el-table-column
                :label="$t('report.grade.question')"
              >
                <template slot-scope="props">
                  <span>{{ props.row.reviews[index].question }}</span>
                </template>
              </el-table-column>
              <el-table-column
                :label="$t('report.grade.answer')"
              >
                <template slot-scope="props">
                  <span>{{ props.row.reviews[index].answer }}</span>
                </template>
              </el-table-column>
            </el-table-column>
          </el-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: ['gradeId'],
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

      count_question: 0,
      listFilterColumn: [],
      show_filter: true,

      user_token: window.MonCMS.user_token

    }
  },
  computed: {},
  mounted () {
    this.queryServer()
  },
  methods: {

    queryServer (customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        grade: this.gradeId

      }

      axios.get(route('api.report.grade.reviewDetail', _.merge(properties, customProperties)))
        .then((response) => {
          this.tableIsLoading = false
          this.data = response.data.data
          this.count_question = response.data.count_question
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
      let url = route('admin.report.grade.downloadGradeReview', { grade: this.gradeId})
      window.open(url, '_blank')
    }
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

    .el-upload {
        width: 100%;
    }
</style>
