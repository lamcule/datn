<template>
  <div>
    <div class="content-header">
      <h1>
        {{ $t('course.label.manage_course') }}
      </h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin"><i class="fa fa-dashboard" /> {{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('course.label.manage_course') }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-md-12 row-action">
        <router-link :to="{name: 'admin.course.create'}">
          <el-button
            type="primary"
            size="small"
            class="btn btn-flat"
            icon="el-icon-plus"
          >
            {{ $t('course.label.create_course') }}
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
            <el-select
              clearable
              v-model="type"
              :placeholder="$t('course.label.type')"
              @change="queryServer"
            >
              <el-option
                v-for="item in listTypes"
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
              v-model="role"
              :placeholder="$t('course.label.role')"
              @change="queryServer"
            >
              <el-option
                v-for="item in listRoles"
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
              v-model="frequency"
              :placeholder="$t('course.label.frequency')"
              @change="queryServer"
            >
              <el-option
                v-for="item in listFrequency"
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
              v-model="scale"
              :placeholder="$t('course.label.scale')"
              @change="queryServer"
            >
              <el-option
                v-for="item in listScales"
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
              v-model="object"
              :placeholder="$t('course.label.object')"
              @change="queryServer"
            >
              <el-option
                v-for="item in listObjects"
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
              prop="code"
              :label="'Code'"
              sortable="custom"
            />
            <el-table-column
              prop="name"
              :label="$t('course.label.name')"
              sortable="custom"
              width="200"
            >
              <template slot-scope="props">
                <a
                  style="cursor: pointer"
                  @click.prevent="gotoLink(props.row)"
                >{{ props.row.name }}</a>
              </template>
            </el-table-column>

            <el-table-column
              prop="description"
              :label="$t('course.label.description')"
              sortable="custom"
              width="200"
            >
              <template slot-scope="props">
                <span
                  class="description__style"
                >{{ props.row.description }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="created_at"
              :label="$t('course.label.created_at')"
              sortable="custom"
              width="150"
            />
            <el-table-column
              prop="type"
              :label="$t('course.label.type')"
              sortable="custom"
              width="150"
            >
              <template slot-scope="props">
                <span
                  class="badge"
                  :style="'background-color:' + typeColor(props.row)"
                >{{ props.row.type }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="area"
              :label="$t('course.label.area')"
              sortable="custom"
              width="120"
            />
            <el-table-column
              prop="role"
              :label="$t('course.label.role')"
              sortable="custom"
              width="150"
            >
              <template slot-scope="props">
                <span
                  class="badge"
                  :style="'background-color:' + roleColor(props.row)"
                >{{ props.row.role }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="frequency"
              :label="$t('course.label.frequency')"
              sortable="custom"
              width="120"
            >
              <template slot-scope="props">
                <span
                  class="badge"
                  :style="'background-color:' + frequencyColor(props.row)"
                >{{ props.row.frequency }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="project"
              :label="$t('course.label.project')"
              sortable="custom"
              width="120"
            >
              <template slot-scope="props">
                <span
                  class="badge"
                  :style="'background-color:' + projectColor(props.row)"
                >{{ props.row.project }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="scale"
              :label="$t('course.label.scale')"
              sortable="custom"
              width="120"
            >
              <template slot-scope="props">
                <span
                  class="badge"
                  :style="'background-color:' + scaleColor(props.row)"
                >{{ props.row.scale }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="object"
              :label="$t('course.label.object')"
              sortable="custom"
              width="200"
            >
              <template slot-scope="props">
                <span
                  class="badge"
                  :style="'background-color:' + objectColor(props.row)"
                >{{ props.row.object }}</span>
              </template>
            </el-table-column>

            <el-table-column
              prop="status"
              :label="$t('course.label.status')"
              sortable="custom"
              width="120"
            >
              <template slot-scope="props">
                <span
                  class="badge"
                  :style="'background-color:' + statusColor(props.row)"
                >{{ props.row.status }}</span>
              </template>
            </el-table-column>
            <el-table-column
              prop="created_by"
              :label="$t('course.label.created_by')"
              sortable="custom"
              width="120"
            />

            <el-table-column
              prop="actions"
              width="200"
            >
              <template slot-scope="scope">
                <view-button
                  :to="{name: 'admin.course.view', params: {courseId: scope.row.id}}"
                />

                <edit-button
                  :to="{name: 'admin.course.edit', params: {courseId: scope.row.id,locale: filter.locale}}"
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
      type: '',
      role: '',
      frequency: '',
      scale: '',
      object: '',
      tableIsLoading: false,
      show_filter: true,
      columnsSearch: [],
      listTypes: [
        {
          value: 'Event',
          label: 'Event'
        },
        {
          value: 'Workshop',
          label: 'Workshop'
        },
        {
          value: 'Consulting',
          label: 'Consulting'
        },
        {
          value: 'Mentoring',
          label: 'Mentoring'
        },
        {
          value: 'Other',
          label: 'Other'
        },
      ],
      listArea: [],
      listRoles: [
        {
          value: 'Organizer',
          label: 'Organizer'
        },
        {
          value: 'Co-Organizer',
          label: 'Co-Organizer'
        },
        {
          value: 'Accompany',
          label: 'Accompany'
        },
        {
          value: 'Media Support',
          label: 'Media Support'
        },
        {
          value: 'Content Support',
          label: 'Content Support'
        },
        {
          value: 'Expert Connector',
          label: 'Expert Connector'
        },
        {
          value: 'Startup Connector',
          label: 'Startup Connector'
        },
        {
          value: 'Other',
          label: 'Other'
        },

      ],
      listFrequency: [
        {
          value: 'once',
          label: this.$t('course.label.once')
        },
        {
          value: 'periodic',
          label: this.$t('course.label.periodic')
        },
        {
          value: 'series',
          label: this.$t('course.label.Series')
        }
      ],
      listScales: [
        {
          value: 'under_30',
          label: this.$t('course.label.under_30')
        },
        {
          value: 'under_50',
          label: this.$t('course.label.under_50')
        },
        {
          value: 'under_100',
          label: this.$t('course.label.under_100')
        },
        {
          value: 'over_100',
          label: this.$t('course.label.over_100')
        }
      ],
      listProjects: [
        {
          value: 'SVF_1601',
          label: 'SVF_1601'
        },
        {
          value: 'SVF_1602EDP',
          label: 'SVF_1602EDP'
        },
        {
          value: 'SVF_1603',
          label: 'SVF_1603'
        },
        {
          value: 'SVF_1704IE',
          label: 'SVF_1704IE'
        },
        {
          value: 'SVF_1706NISD',
          label: 'SVF_1706NISD'
        },
        {
          value: 'SVF_1708VNES',
          label: 'SVF_1708VNES'
        },
        {
          value: 'other',
          label: this.$t('course.label.other')
        }
      ],
      listObjects: [
        {
          value: 'Founder-Entrepreneur',
          label: 'Founder-Entrepreneur'
        },
        {
          value: 'mentor',
          label: this.$t('course.label.mentor')
        },
        {
          value: 'provincial',
          label: this.$t('course.label.provincial')
        },
        {
          value: 'student',
          label: this.$t('course.label.student')
        },
        {
          value: 'other',
          label: this.$t('course.label.other')
        },
        {
          value: 'investor',
          label: this.$t('course.label.investor')
        }
      ],
      currentLocale: window.MonCMS.currentLocale || 'en',
      categoryArr: window.MonCMS.courseListCategory,
      statusArr: window.MonCMS.courseListStatus,
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
        page: this.meta.current_page,
        per_page: this.meta.per_page,
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery,
        type: this.type,
        role: this.role,
        frequency: this.frequency,
        scale: this.scale,
        object: this.object,
        status: this.filter.status,
        locale: this.filter.locale
      }

      axios.get(route('api.course.index', _.merge(properties, customProperties)))
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
    download () {
      let url = route('admin.course.download',{
        order_by: this.order_meta.order_by,
        order: this.order_meta.order,
        search: this.searchQuery,
        type: this.type,
        role: this.role,
        frequency: this.frequency,
        scale: this.scale,
        object: this.object,
        status: this.filter.status,
        locale: this.filter.locale
      })
      window.open(url, '_blank')
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
    gotoLink (course) {
      window.location = course.view_url
    },
    statusColor (course) {
      if (course.status == 'active') {
        return '#00a65a'
      }
      return '#dd4b39'
    },
    typeColor (course) {
      if (course.type == 'class') {
        return '#ff851b'
      } else if (course.type == 'series') {
        return '#00c0ef'
      } else if (course.type == 'event') {
        return '#3c8dbc'
      } else {
        return '#39CCCC'
      }
    },
    roleColor (course) {
      if (course.role == 'co-organizer') {
        return '#605ca8'
      } else if (course.role == 'organizer') {
        return '#D81B60'
      } else {
        return '#f56954'
      }
    },
    frequencyColor (course) {
      if (course.frequency == 'once') {
        return '#00a65a'
      } else if (course.frequency == 'periodic') {
        return '#00c0ef'
      } else {
        return '#D81B60'
      }
    },
    projectColor (course) {
      if (course.project == 'NISD') {
        return '#00a65a'
      } else if (course.project == 'EDP') {
        return '#00c0ef'
      } else if (course.project == 'IE') {
        return '#f56954'
      } else {
        return '#D81B60'
      }
    },
    scaleColor (course) {
      if (course.scale == 'under_30') {
        return '#00a65a'
      } else if (course.scale == 'under_50') {
        return '#00c0ef'
      } else if (course.scale == 'under_100') {
        return '#f56954'
      } else {
        return '#D81B60'
      }
    },
    objectColor (course) {
      if (course.object == 'Founder-Entrepreneur') {
        return '#00a65a'
      } else if (course.object == 'mentor') {
        return '#00c0ef'
      } else if (course.object == 'provincial') {
        return '#ff851b'
      } else if (course.object == 'student') {
        return '#605ca8'
      } else {
        return '#D81B60'
      }
    }
  },
  mounted () {
    this.fetchData()
  }
}
</script>

<style scoped>
.description__style {
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  line-height: 16px;
  max-height: 48px;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
}
</style>
