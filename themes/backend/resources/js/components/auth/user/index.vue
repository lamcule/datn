<template>
  <div>
    <div class="content-header">
      <h1>{{ $t('user.label.users') }}</h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('user.label.users') }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-md-12 row-action">
        <router-link :to="{name: 'admin.auth.users.create'}">
          <el-button
            type="primary"
            size="small"
            class="btn btn-flat"
            icon="el-icon-plus"
          >
            {{ $t('user.label.create_user') }}
          </el-button>
        </router-link>
      </div>
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
            :md="12"
          >
            <el-input
              v-model="searchQuery"
              prefix-icon="el-icon-search"
              @keyup.native="performSearch"
            />
          </el-col>
          <el-col
            :sm="12"
            :md="6"
          >
            <el-select
              v-model="filter.status"
              :placeholder="$t('user.label.status')"
              autocomplete
              filterable
              @change="queryServer"
            >
              <el-option
                v-for="item in listStatus"
                :key="'list_status'+ item.value"
                :label="item.label"
                :value="item.value"
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
              prop="id"
              :label="$t('user.label.id')"
              width="75"
              sortable="custom"
            />
            <el-table-column
              prop="username"
              :label="$t('user.label.username')"
              sortable="custom"
            />

            <el-table-column
              prop="email"
              :label="$t('user.label.email')"
              sortable="custom"
            />
            <el-table-column
              prop="name"
              :label="$t('user.label.name')"
              sortable="custom"
            />

            <el-table-column :label="$t('user.label.created_by')">
              <template slot-scope="scope">
                <span v-if="scope.row.createdBy && scope.row.createdBy.username"> {{ scope.row.createdBy.username }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="created_at"
              :label="$t('user.label.created_at')"
              sortable="custom"
            />

            <el-table-column
              prop="actions"
              width="180"
            >
              <template slot-scope="scope">
                <el-button
                  :class="{'btn-inactive': scope.row.status == 'inactive' , 'btn-active': scope.row.status == 'active' , }"
                  size="mini"
                  @click="updateStatus(scope.row)"
                >
                  <i class="far fa-play" />
                </el-button>

                <edit-button
                  :to="{name: 'admin.auth.users.edit', params: {userId: scope.row.id}}"
                />
                <delete-button
                  :scope="scope"
                  :rows="data"
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
      listFilterColumn: [],
      show_filter: true,
      filter: {

        status: ''
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
      ]
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
        status: this.filter.status
      }

      axios.get(route('api.auth.users.index', _.merge(properties, customProperties)))
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
    performSearch: _.debounce(function (query) {
      this.tableIsLoading = true
      this.queryServer({ search: query.target.value, page: this.meta.current_page })
    }, 300),
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
    updateStatus (user) {
      let message = ''
      if (user.status == 'active') {
        message = 'Bạn có muốn Inactive tài khoản này không'
      } else {
        message = 'Bạn có muốn Active tài khoản này không'
      }
      this.$confirm(message, 'Thông báo', {
        confirmButtonText: this.$t('mon.button.ok'),
        cancelButtonText: this.$t('mon.button.cancel'),
        type: 'warning',
        confirmButtonClass: 'el-button--danger'
      }).then(() => {
        const vm = this
        axios.post(route('api.auth.users.changeStatus', { user: user.id }))
          .then((response) => {
            if (response.data.errors) {
              this.$message({
                type: 'error',
                message: response.data.message
              })
            } else {
              user.status = response.data.status
              this.$message({
                type: 'success',
                message: response.data.message
              })
            }
          })
      }).catch(() => {

      })
    }

  },
  mounted () {
    this.fetchData()
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

</style>
