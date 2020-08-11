<template>
  <div>
    <div class="content-header">
      <h1> Participant manager</h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          Participant manager
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-md-12 row-action">
        <router-link :to="{name: 'admin.student.create'}">
          <el-button
            type="primary"
            size="small"
            class="btn btn-flat"
            icon="el-icon-plus"
          >
            {{ $t('student.label.create_record') }}
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
            :md="4"
          >
            <el-input
              v-model="searchQuery"
              prefix-icon="el-icon-search"
              @keyup.native="performSearch"
            />
          </el-col>
          <el-col
            :sm="12"
            :md="4"
          >
            <el-select
              clearable
              v-model="filter.categories"
              style="width: 100% !important"
              @change="fetchData"
              filterable
              :placeholder="$t('student.label.categories')"
            >
              <el-option
                v-for="item in categories"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-col>
          <el-col
            :sm="12"
            :md="4"
          >
            <el-select
              clearable
              v-model="filter.personal_categories"
              @change="fetchData"
              filterable
              :placeholder="$t('student.label.personal_categories')"
              style="width: 100% !important"
            >
              <el-option
                v-for="item in personal_categories"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              />
            </el-select>
          </el-col>
          <el-col
            :sm="12"
            :md="4"
          >
            <el-input
              v-model="filter.company"
              autocomplete="off"
              :placeholder="$t('student.label.company')"
              @keyup.native="performSearchCompany"
            />
          </el-col>
          <el-col
            :sm="12"
            :md="4"
          >
            <el-select
              clearable
              v-model="filter.province_id"
              filterable
              :placeholder="$t('mon.label.province')"
              @change="fetchData"
            >
              <el-option
                v-for="item in provinces"
                :key="'province_'+item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-col>
          <el-col
            :sm="12"
            :md="2"
          >
            <el-select
              clearable
              v-model="filter.gender"
              :placeholder="$t('student.label.gender')"
              style="width: 100% !important"
              filterable
              @change="fetchData"
            >
              <el-option
                v-for="item in listGender"
                :key="'type'+ item.value"
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
            <el-table-column type="expand">
              <template slot-scope="props">
                <div
                  class="row"
                  style="padding-left: 10px"
                >
                  <div class="col-md-3">
                    <p>{{ $t('student.label.username') }}: {{ props.row.username }}</p>
                    <p>{{ $t('student.label.birth_date') }}: {{ props.row.profile.birth_date }}</p>
                    <p>{{ $t('student.label.phone') }}: {{ props.row.profile.phone }}</p>
                    <p>{{ $t('student.label.gender') }}: <span
                      class="badge"
                      :style="'background-color:' + genderColor(props.row)"
                    >{{ props.row.profile.gender }}</span></p>
                    <p>{{ $t('student.label.email') }}: {{ props.row.email }}</p>
                    <p>{{ $t('student.label.created_at') }}: {{ props.row.created_at }}</p>
                    <p>
                      {{ $t('student.label.course') }}: <span class="badge bg-danger"
                                                              v-if="props.row.grades.length > 0">
                        <ul>
                          <li
                            v-for="grade in props.row.grades"
                            :key="'grade'+grade.id"
                          >{{ grade.name }}</li>
                        </ul>
                      </span>
                    </p>
                  </div>
                  <div class="col-md-9">
                    <p v-if="props.row.profile">{{ $t('student.label.province_id') }}: {{ props.row.profile.province?
                      props.row.profile.province.name : '' }}</p>
                    <p v-if="props.row.profile">{{ $t('student.label.district_id') }}: {{ props.row.profile.district?
                      props.row.profile.district.name : '' }}</p>
                    <p v-if="props.row.profile">{{ $t('student.label.phoenix_id') }}: {{ props.row.profile.phoenix?
                      props.row.profile.phoenix.name : '' }}</p>
                    <p v-if="props.row.profile">{{ $t('student.label.address') }}: {{ props.row.profile.address }}</p>
                    <p v-if="props.row.profile">{{ $t('student.label.company') }}: <span class="badge bg-aqua">{{ props.row.profile.company }}</span>
                    </p>
                    <p v-if="props.row.profile">{{ $t('student.label.position') }}: {{ props.row.profile.position }}</p>
                    <p v-if="props.row.profile">{{ $t('student.label.company_address') }}: {{
                      props.row.profile.company_address }}</p>
                    <p v-if="props.row.profile">{{ $t('student.label.categories') }}: <span class="badge bg-warning">{{ props.row.profile.categories.join(', ') }}</span>
                    </p>
                    <p v-if="props.row.profile">{{ $t('student.label.personal_categories') }}: <span
                      class="badge bg-danger">{{ props.row.profile.personal_categories.join(', ') }}</span></p>
                  </div>
                </div>
              </template>
            </el-table-column>

            <el-table-column
              prop="username"
              :label="$t('student.label.username')"
              sortable="custom"
            >
              <template slot-scope="props">
                <span class="badge bg-maroon">{{ props.row.username }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="profile.full_name"
              :label="$t('student.label.name')"
              sortable="custom"
            />
            <el-table-column
              prop="profile.birth_date"
              :label="$t('student.label.birth_date')"
              sortable="custom"
            >
              <template slot-scope="props">
                <span class="badge bg-aqua">{{ props.row.profile.birth_date }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="email"
              :label="$t('student.label.email')"
              sortable="custom"
            >
              <template slot-scope="props">
                <span class="badge bg-warning">{{ props.row.email }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="profile.phone"
              :label="$t('student.label.phone')"
              sortable="custom"
            />
            <el-table-column
              prop="profile.gender"
              :label="$t('student.label.gender')"
              sortable="custom"
            >
              <template slot-scope="props">
                <span
                  class="badge"
                  :style="'background-color:' + genderColor(props.row)"
                >{{ props.row.profile.gender }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="deleted_at"
              label="Deleted at"
              sortable="custom"
            />
            <el-table-column prop="actions">
              <template slot-scope="scope">
                <edit-button
                  :to="{name: 'admin.student.edit', params: {userId: scope.row.id}}"
                />
                <reload-delete-button
                  :scope="scope"
                  :rows="data"
                  @delete-done="fetchData"
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

    data() {
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
        categories: window.MonCMS.categories,
        personal_categories: window.MonCMS.personal_categories,
        provinces: [],
        filter: {

          status: '',
          categories: '',
          personal_categories: '',
          gender: '',
          province_id: '',
          company: ''
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
        listGender: [
          {
            value: 'Male',
            label: 'Male',
          },
          {
            value: 'Female',
            label: 'Female',
          },
          {
            value: 'Other',
            label: 'Other',
          }
        ],
        uploadUrl: route('api.student.import'),
        user_token: window.MonCMS.user_token

      }
    },
    mounted() {
      this.fetchData()
      this.fetchProvince()
    },
    methods: {
      // submitUpload() {
      //   this.$refs.import_file.submit();
      //   this.$message({
      //     type: 'success',
      //     message: this.$t('student.messages.import success'),
      //   });
      //   this.dialogUploadVisible = false;
      //   this.queryServer();
      // },
      queryServer(customProperties) {
        const properties = {
          page: this.meta.current_page,
          per_page: this.meta.per_page,
          order_by: this.order_meta.order_by,
          order: this.order_meta.order,
          search: this.searchQuery,
          status: this.filter.status,
          categories: this.filter.categories,
          personal_categories: this.filter.personal_categories,
          gender: this.filter.gender,
          province_id: this.filter.province_id,
          company: this.filter.company,
        }

        axios.get(route('api.student.index', _.merge(properties, customProperties)))
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
      download() {
        let url = route('admin.report.downloadStudent', {
          search: this.searchQuery,
          status: this.filter.status,
          categories: this.filter.categories,
          personal_categories: this.filter.personal_categories,
          gender: this.filter.gender,
          province_id: this.filter.province_id,
          company: this.filter.company,
        })
        window.open(url, '_blank')
      },
      fetchProvince() {
        axios.get(route('api.province.index', {
          page: 1,
          per_page: 100000
        }))
          .then((response) => {
            this.provinces = response.data.data
          })
      },
      fetchData() {
        this.meta.current_page = 1
        this.tableIsLoading = true
        this.queryServer({per_page: 25})
      },
      genderColor(student) {
        if (student.profile.gender == 'Nam') {
          return '#ff3d0c'
        }
        return '#0bb0ff'
      },
      handleSizeChange(event) {
        this.tableIsLoading = true
        this.queryServer({per_page: event})
      },
      handleCurrentChange(event) {
        this.tableIsLoading = true
        this.queryServer({page: event})
      },
      handleSortChange(event) {
        this.tableIsLoading = true
        this.queryServer({order_by: event.prop, order: event.order})
      },
      performSearch: _.debounce(function (query) {
        this.tableIsLoading = true
        this.queryServer({search: query.target.value, page: this.meta.current_page})
      }, 300),
      performSearchCompany: _.debounce(function (query) {
        this.tableIsLoading = true
        this.queryServer({company: query.target.value, page: this.meta.current_page})
      }, 300),

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
