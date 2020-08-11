<template>
  <div>
    <div class="content-header">
      <h1>{{ $t('studentimport.label.header') }}</h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('studentimport.label.header') }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-md-12 row-action">
        <router-link :to="{name: 'admin.studentimport.create'}">
          <el-button
            type="success"
            size="small"
            class="btn btn-flat"
            icon="el-icon-plus"
          >
            {{ $t('studentimport.label.create_record') }}
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
            @sort-change="handleSortChange"
          >
            <el-table-column
                    type="index"
                    width="50"
            />

            <el-table-column
              prop="path"
              :label="$t('studentimport.label.path')"
              sortable="custom"
            />
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
                    prop="records"
                    :label="$t('studentimport.label.records')"
                    sortable="custom"
            />

            <el-table-column prop="actions">
              <template slot-scope="scope">
                <el-button size="mini"  icon="el-icon-download"   @click.prevent="downloadFile(scope.row)"></el-button>

                <view-button
                  :to="{name: 'admin.studentimport.view', params: {studentimport: scope.row.id}}"
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
      ],
      uploadUrl: route('api.studentimport.store'),
      user_token: window.MonCMS.user_token

    }
  },
  mounted () {
    this.fetchData()
  },
  methods: {
    // submitUpload() {
    //   this.$refs.import_file.submit();
    //   this.$message({
    //     type: 'success',
    //     message: this.$t('studentimport.messages.import success'),
    //   });
    //   this.dialogUploadVisible = false;
    //   this.queryServer();
    // },
    queryServer (customProperties) {
      const properties = {
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery,
        status: this.filter.status
      }

      axios.get(route('api.studentimport.index', _.merge(properties, customProperties)))
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
    statusColor (studentImport) {
      if (studentImport.status == 'Imported') {
        return '#ebb563'
      }
      return '#409EFF'
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
    downloadFile(row) {
      window.open(row.full_url, '_blank');

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
