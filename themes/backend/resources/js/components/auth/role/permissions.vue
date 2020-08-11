<template>
  <div>
    <div
      v-if="type ==='add'"
      class="row"
    >
      <div class="col-md-12 row-action">
        <h3 class="row-left">
          {{ $t('role.label.list_permissions') }}
        </h3>

        <div class="row-right">
          <el-button
            type="primary"
            size="small"
            class="btn btn-flat"
            @click="storePermission('add')"
          >
            {{ $t('role.label.assign') }}
          </el-button>
        </div>
      </div>
    </div>

    <div
      v-if="type ==='remove'"
      class="row"
    >
      <div class="col-md-12 row-action">
        <h3 class="row-left">
          {{ $t('role.label.selected_permissions') }}
        </h3>

        <div class="row-right">
          <el-button
            type="danger"
            size="small"
            class="btn btn-flat"
            @click="storePermission('remove')"
          >
            {{ $t('role.label.remove') }}
          </el-button>
        </div>
      </div>
    </div>

    <div class="sc-table">
      <div
        class="tool-bar table-toolbar-container "
        style="padding-bottom: 20px;"
      >
        <div class="row">
          <div class=" col-sm-12">
            <el-input
              v-model="searchQuery"
              prefix-icon="el-icon-search"
              @keyup.native="performSearch"
            />
          </div>
        </div>
      </div>
      <el-table
        ref="permissionTable"
        v-loading.body="tableIsLoading"
        :data="data"
        stripe
        style="width: 100%"
        @selection-change="handleSelectionChange"
        @sort-change="handleSortChange"
      >
        <el-table-column
          type="selection"
          width="55"
        />
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
      </el-table>
      <div
        class="pagination-wrap"
        style="text-align: center; padding-top: 20px;"
      >
        <el-pagination
          :current-page.sync="meta.current_page"
          :page-sizes="[15, 20, 25, 50,100]"
          :page-size="parseInt(meta.per_page)"
          layout="total, sizes, prev, pager, next, jumper"
          :total="meta.total"
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
        />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import _ from 'lodash'

export default {
  props: ['type', 'roleId'],
  data () {
    return {
      data: [],
      meta: {
        current_page: 1,
        per_page: 15
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
      checkedPermissions: [],
      guards: [
        {
          value: 'api',
          label: 'api'
        },
        {
          value: 'web',
          label: 'web'
        }
      ],
      guard_name: 'web'

    }
  },
  methods: {
    reloadData () {
      this.meta.current_page = 1
      this.queryServer()
    },
    queryServer (customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery,
        role_id: this.roleId,
        guard_name: this.guard_name,
        in_role: (this.type === 'add') ? 0 : 1
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
      this.queryServer({ per_page: 15 })
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
    handleSelectionChange (val) {
      this.checkedPermissions = val
    },
    performSearch: _.debounce(function (query) {
      this.tableIsLoading = true
      this.queryServer({ search: query.target.value, page: this.meta.current_page })
    }, 300),

    storePermission (type) {
      this.tableIsLoading = true
      if (this.checkedPermissions.length) {
        const route = this.getRoute(type)
        let checkedIds = this.checkedPermissions.map(permission => permission.name)
        axios.post(route, { permissions: checkedIds })
          .then((response) => {
            this.$message({
              type: 'success',
              message: response.data.message
            })
            this.reloadData()
            this.$emit('reload-permissions')
          })
          .catch((error) => {
            this.loading = false
            this.$notify.error({
              title: 'Error',
              message: 'There are some errors in the form.'
            })
          }).finally(_ => this.tableIsLoading = false)
      }
    },

    getRoute (type) {
      if (type === 'add') {
        return route('api.auth.roles.assignPermissions', { role: this.$route.params.roleId })
      } else {
        return route('api.auth.roles.removePermissions', { role: this.$route.params.roleId })
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
