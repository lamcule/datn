<template>
  <div>
    <div class="content-header">
      <h1 v-if="studentImport && studentImport.id">
        {{ 'ID: #' + studentImport.id }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{name: 'admin.studentimport.index'}">
          {{ $t('studentimport.label.header') }}
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ 'ID: #' + studentImport.id }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">
          {{ $t('studentimport.box.detail') }}
        </h3>
      </div>
      <div class="box-body">
        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>{{ $t('studentimport.label.status') }}</b> <a class="pull-right badge" :style="'background-color:' + statusColor(studentImport)">{{ studentImport.status }}</a>
          </li>
          <li class="list-group-item">
            <b>File</b> <a class="pull-right"  @click.prevent="downloadFile(studentImport.full_url)">{{ studentImport.path }}</a>
          </li>
          <li class="list-group-item">
            <b>{{ $t('studentimport.label.records') }}</b> <a class="pull-right">{{ studentImport.records }}</a>
          </li>
        </ul>
      </div>
    </div>
    <div
      v-if="studentImport && studentImport.status == 'Uploaded'"
      class="row"
    >
      <div class="col-md-12 row-action">
        <el-button
          type="warning"
          size="small"
          :loading="loading"
          class="btn btn-flat"
          icon="el-icon-upload2"
          @click="importStudent"
        >
          {{ $t('studentimport.label.import') }}
        </el-button>
      </div>
    </div>

    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">
          {{ $t('studentimport.box.records') }}
        </h3>
      </div>
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
            <el-table-column :label="$t('student.label.name')">
              <template slot-scope="scope">
                <span>{{ scope.row.content[1] + ' ' + scope.row.content[2]  }}</span>
              </template>
            </el-table-column>

            <el-table-column :label="$t('student.label.phone')">
              <template slot-scope="scope">
                <span>{{ scope.row.content[13] }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="status"
              :label="$t('studentimport.label.status')"
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
              prop="imported_description"
              :label="$t('studentimport.label.imported_description')"
              sortable="custom"
            />
            <el-table-column prop="actions">
              <template slot-scope="scope">
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
      studentImport: {},
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
      loading: false,
      columnsSearch: [],
      listFilterColumn: [],
      show_filter: true,
      filter: {

        status: ''
      }

    }
  },
  mounted () {
    this.fetchDetail()
  },
  methods: {
    queryServer (customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery,
        import_id: this.studentImport.id
      }

      axios.get(route('api.importdetail.index', _.merge(properties, customProperties)))
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
    fetchDetail () {
      let routeUri = ''
      this.loading = true
      routeUri = route('api.studentimport.find', { studentimport: this.$route.params.studentimport })
      axios.get(routeUri)
        .then((response) => {
          this.loading = false
          this.studentImport = response.data.data
          this.fetchData()
        })
    },
    importStudent () {
      this.loading = true
      axios.post(route('api.studentimport.import', { studentimport: this.$route.params.studentimport }))
        .then((response) => {
          this.loading = false
          this.fetchDetail()
        }).finally(_ => {
          this.loading = false
        })
    },
    fetchData () {
      this.tableIsLoading = true
      this.queryServer({ per_page: 25 })
    },
    statusColor (studentImport) {
      if (studentImport.status == 'Imported') {
        return '#ebb563'
      } else if (studentImport.status == 'Uploaded') {
        return '#409EFF'
      } else {
        return '#dd283b'
      }
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
    downloadFile(full_url) {
      window.open(full_url, '_blank');

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
    .el-upload{
        width: 100%;
    }
</style>
