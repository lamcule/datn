<template>
  <div>
    <div class="row-left" style="padding-top: 10px; padding-bottom: 10px;">
      <router-link :to="{name: 'admin.grade.create', query: {course: courseId}}">
        <el-button
                type="danger"
                size="small"
                class="btn btn-flat"
                icon="el-icon-plus"
        >
          {{ $t('grade.label.create_grade') }}
        </el-button>
      </router-link>
      <el-button
              type="warning"
              size="small"
              class="btn btn-flat"
              icon="el-icon-download"
              @click="download"
              style="margin-left: 20px"
      >
        {{ $t('report.label.download') }}
      </el-button>
    </div>
    <div class="box box-widget">
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
                    prop="code"
                    :label="'Code'"
                    sortable="custom"
            />
            <el-table-column
              prop="name"
              :label="$t('grade.label.name')"
              sortable="custom"
            />
            <el-table-column
              prop="place"
              :label="$t('grade.label.place')"
              sortable="custom"
            />
            <el-table-column
              prop="status"
              :label="$t('grade.label.status')"
              sortable="custom"
            >
              <template slot-scope="props">
                <span
                        class="badge"
                        :style="'background-color:' + statusColor(props.row)"
                >{{ props.row.status }}</span>
              </template>
            </el-table-column>

            <el-table-column
              prop="actions"
              width="230"
            >
              <template slot-scope="scope">

                <button type="button"
                        v-clipboard:copy="scope.row.register_url"
                        v-clipboard:success="copyLink" > <i class="fa fa-copy" ></i></button>
                <view-button
                        :to="{name: 'admin.grade.view', params: {gradeId: scope.row.id}}"
                />
                <edit-button
                  :to="{name: 'admin.grade.edit', params: {gradeId: scope.row.id,locale: filter.locale}, query:{course: courseId}}"
                />
                <delete-button
                  :scope="scope"
                  :rows="data"
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
    copyLink(row) {
      this.$message({
        type: 'success',
        message: "Đã copy link đăng ký lớp học"
      })

    },
    queryServer (customProperties) {
      const properties = {
        course: this.$route.params.courseId,
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery,
        status: this.filter.status,
        locale: this.filter.locale
      }

      axios.get(route('api.grade.index', _.merge(properties, customProperties)))
        .then((response) => {
          this.tableIsLoading = false
          this.data = response.data.data
          this.meta = response.data.meta
          this.links = response.data.links
          this.order_meta.order_by = properties.order_by
          this.order_meta.order = properties.order
        })
    },
    download () {
      let url = route('admin.grade.download',{ search: this.searchQuery,
        course: this.$route.params.courseId,
        status: this.filter.status,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
      })
      window.open(url, '_blank')
    },
    fetchData () {
      this.tableIsLoading = true
      this.courseId = this.$route.params.courseId
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
