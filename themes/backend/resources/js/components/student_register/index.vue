<template>
    <div>
        <div class="content-header">
            <h1> {{ $t('student.label.manage_student') }}</h1>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item>
                    {{ $t('student.label.manage_student') }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div class="row">
            <div class="col-md-12 row-action">
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
                            prop="profile.full_name"
                            :label="$t('student.label.name')"
                            sortable="custom"
                        />
                        <el-table-column
                            prop="email"
                            :label="$t('student.label.email')"
                            sortable="custom"
                        >
                            <template slot-scope="props">
                                <span>{{ props.row.email }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="profile.phone"
                            :label="$t('student.label.phone')"
                            sortable="custom"
                        />

                        <el-table-column
                            prop="created_at"
                            :label="$t('student.label.created_at')"
                            sortable="custom"
                        />

                        <el-table-column prop="actions">
                            <template slot-scope="scope">
                                <edit-button
                                    :to="{name: 'admin.student_register.edit', params: {userId: scope.row.id}}"
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
                type: 'guest'
            },
            uploadUrl: route('api.student.import'),
            user_token: window.MonCMS.user_token

        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        queryServer(customProperties) {
            const properties = {
                page: this.meta.current_page,
                per_page: this.meta.per_page,
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                type: this.filter.type,
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
                type: this.filter.type,
            })
            window.open(url, '_blank')
        },
        fetchData() {
            this.meta.current_page = 1
            this.tableIsLoading = true
            this.queryServer({per_page: 25})
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
