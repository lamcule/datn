<template>
    <div>
        <div class="content-header">
            <h1>
                {{ $t('course.label.manage_course') }}
            </h1>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/admin"><i class="fa fa-dashboard"/> {{ $t('mon.breadcrumb.home') }}</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item>
                    {{ $t('course.label.manage_course') }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div class="row">
            <div class="col-md-12 row-action" style="justify-content: unset">
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
                            v-model="filter.type"
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
                            v-model="filter.status"
                            :placeholder="$t('course.label.status')"
                            style="width: 100% !important"
                            filterable
                            @change="fetchData"
                        >
                            <el-option
                                v-for="item in listStatus"
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
                                    :to="{name: 'admin.course.edit', params: {courseId: props.row.id,locale: filter.locale}}"
                                >{{ props.row.name }}</a>
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
                        />

                        <el-table-column
                            prop="tuition"
                            :label="$t('course.label.tuition')"
                            sortable="custom"
                            width="120"
                        />

                        <el-table-column
                            prop="status"
                            :label="$t('course.label.status')"
                            sortable="custom"
                            width="120"
                        />
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
            show_filter: true,
            columnsSearch: [],
            listTypes: [
                {
                    value: 'Toeic',
                    label: 'Toeic'
                },
                {
                    value: 'Ielts',
                    label: 'Ielts'
                },
                {
                    value: 'Toefl',
                    label: 'Toefl'
                },
                {
                    value: 'Other',
                    label: 'Other'
                },
            ],
            listArea: [],

            currentLocale: window.MonCMS.currentLocale || 'en',
            categoryArr: window.MonCMS.courseListCategory,
            statusArr: window.MonCMS.courseListStatus,
            filter: {
                status: '',
                type: '',
                locale: window.MonCMS.currentLocale || 'en'
            },
            listLocales: window.MonCMS.locales

        }
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
        fetchData() {
            this.tableIsLoading = true
            this.queryServer({per_page: 25})
        },
        download() {
            let url = route('admin.course.download', {
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                type: this.type,
                status: this.filter.status,
                locale: this.filter.locale
            })
            window.open(url, '_blank')
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
        gotoLink(course) {
            window.location = course.view_url
        },
    },
    mounted() {
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
