<template>
  <div>
    <div
      class="row-left"
      style="padding-top: 10px; padding-bottom: 10px;"
    >
      <router-link :to="{name: 'admin.lesson.create', query:{course: grade.course_id, grade: grade.id }}">
        <el-button
          type="danger"
          size="small"
          class="btn btn-flat"
          icon="el-icon-plus"
        >
          {{ $t('lesson.label.create_lesson') }}
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
                    prop="name"
                    :label="$t('lesson.label.name')"
                    sortable="custom"
            />

            <el-table-column
                    prop="place"
                    :label="$t('lesson.label.place')"
                    sortable="custom"
            />

            <el-table-column
                    prop="teacher"
                    :label="$t('lesson.label.teacher')"
                    sortable="custom"
            />

            <el-table-column
              prop="start_time"
              :label="$t('lesson.label.start_time')"
              sortable="custom"
            />

            <el-table-column
              prop="end_time"
              :label="$t('lesson.label.end_time')"
              sortable="custom"
            />

            <el-table-column
              prop="actions"
              width="200"
            >
              <template slot-scope="scope">
                <view-button
                  :to="{name: 'admin.lesson.view', params: {lessonId: scope.row.id}}"
                />
                <edit-button
                  :to="{name: 'admin.lesson.edit', params: {lessonId: scope.row.id,locale: filter.locale}, query:{course: grade.course_id, grade: grade.id}}"
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
  props: {
    grade: { default: {} }
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
        search: this.searchQuery,
        status: this.filter.status,
        locale: this.filter.locale
      }

      axios.get(route('api.lesson.index', _.merge(properties, customProperties)))
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
      let url = route('admin.lesson.download',{ search: this.searchQuery,
        grade: this.$route.params.gradeId,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
      })
      window.open(url, '_blank')
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
    }, 300)

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
