<template>
  <div>
    <div class="content-header">
      <h1>{{ $t('permission.label.permissions') }}</h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('permission.label.permissions') }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-md-12 row-action">
        <router-link :to="{name: 'admin.auth.permissions.create'}">
          <el-button
            type="primary"
            size="small"
            class="btn btn-flat"
            icon="el-icon-plus"
          >
            {{ $t('permission.label.create_permission') }}
          </el-button>
        </router-link>
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
              prop="id"
              :label="$t('permission.label.id')"
              width="75"
              sortable="custom"
            />
            <el-table-column
              prop="name"
              :label="$t('permission.label.name')"
              sortable="custom"
            />

            <el-table-column
              prop="description"
              :label="$t('permission.label.description')"
              sortable="custom"
            />
            <el-table-column
              prop="created_at"
              :label="$t('permission.label.created_at')"
              sortable="custom"
            />
            <el-table-column
              prop="updated_at"
              :label="$t('permission.label.updated_at')"
              sortable="custom"
            />

            <el-table-column prop="actions">
              <template slot-scope="scope">
                <edit-button
                  :to="{name: 'admin.auth.permissions.edit', params: {permissionId: scope.row.id}}"
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
      listFilterColumn: []

    }
  },
  mounted () {
    this.fetchData()
  },
  methods: {
    queryServer (customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery
      }

      axios.get(route('api.auth.permissions.index', _.merge(properties, customProperties)))
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
    }

  }
}
</script>

<style scoped>

</style>
