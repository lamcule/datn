<template>
  <div>
    <el-dialog
      :title="$t('lesson.label.add_student')"
      :visible.sync="addStudentDialogVisible"
      width="30%"
      center
    >
      <el-form
        ref="addStudentForm"
        v-loading.body="loadingAddStudent"
        :model="modelForm"
        label-width="120px"
        label-position="top"
      >
        <el-form-item
          :label="$t('lesson.label.student')"
          :class="{'el-form-item is-error': addStudentForm.errors.has('student') }"
        >
          <el-select
            v-model="modelForm.student"
            filterable
            remote
            reserve-keyword
            :placeholder="$t('lesson.label.student search')"
            :remote-method="remoteSearchStudent"
            :loading="loadingAddStudent"
            style="width: 100%"
          >
            <el-option
              v-for="item in listStudent"
              :key="item.id"
              :label="item.name + ' - ' + item.phone"
              :value="item.id"
            />
          </el-select>
          <div
            v-if="addStudentForm.errors.has('student')"
            class="el-form-item__error"
            v-text="addStudentForm.errors.first('student')"
          />
        </el-form-item>
      </el-form>

      <span
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="addStudentDialogVisible = false">  {{ $t('mon.button.cancel') }}</el-button>
        <el-button
          type="primary"
          :loading="loadingAddStudent"
          @click="handleAddStudent"
        > {{ $t('mon.button.save') }}</el-button>
      </span>
    </el-dialog>
    <div
      class="row-left"
      style="padding-top: 10px; padding-bottom: 10px;"
    >
      <el-button
        type="danger"
        size="small"
        class="btn btn-flat"
        icon="el-icon-plus"
        @click="addStudentDialogVisible=true"
      >
        {{ $t('lesson.label.add_student') }}
      </el-button>
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
            style="width: 100%"
            @sort-change="handleSortChange"
          >
            <el-table-column
              type="index"
              width="50"
            />
            <el-table-column
              prop="username"
              :label="$t('student.label.username')"
              sortable="custom"
            />
            <el-table-column
              prop="name"
              :label="$t('student.label.name')"
              sortable="custom"
            />
            <el-table-column
              prop="email"
              :label="$t('student.label.email')"
              sortable="custom"
            />
            <el-table-column
              prop="profile.address"
              :label="$t('student.label.address')"
              sortable="custom"
            />
            <el-table-column
              prop="profile.phone"
              :label="$t('student.label.phone')"
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
      addStudentDialogVisible: false,
      addStudentForm: new Form(),
      loadingAddStudent: false,
      listStudent: [],
      modelForm: {
        student: ''
      },
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
      categoryArr: window.MonCMS.lessonListCategory,
      statusArr: window.MonCMS.lessonListStatus,
      filter: {
        status: '',
        locale: window.MonCMS.currentLocale || 'en'
      },
      listLocales: window.MonCMS.locales

    }
  },
  methods: {
    queryServer (customProperties) {
      const properties = {
        grade: this.$route.params.gradeId,
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery
      }

      axios.get(route('api.grade.student', _.merge(properties, customProperties)))
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
    handleAddStudent () {
      this.addStudentForm = new Form(this.modelForm)
      this.loadingAddStudent = true

      this.addStudentForm.post(route('api.grade.regist', { grade: this.$route.params.gradeId }))
        .then((response) => {
          this.loadingAddStudent = false
          this.addStudentDialogVisible = false
          this.$message({
            type: 'success',
            message: response.message
          })
          this.fetchData()
        })
        .catch((error) => {
          this.loading = false
          this.$notify.error({
            title: 'Error',
            message: this.getSubmitError(this.addStudentForm.errors)
          })
        })
    },
    remoteSearchStudent (query) {
      if (query !== '') {
        this.loadingAddStudent = true
        axios.get(route('api.student.index', { search: query }))
          .then((response) => {
            this.listStudent = response.data.data
          }).finally(_ => {
            this.loadingAddStudent = false
          })
      } else {
        this.listStudent = []
      }
    }

  },
  mounted () {
    this.fetchData()
  }
}
</script>

<style scoped>

</style>
