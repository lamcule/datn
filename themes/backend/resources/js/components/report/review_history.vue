<template>
    <div>
        <div class="content-header">
            <h1>{{ $t('report.review_history.header') }}</h1>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item>
                    {{ $t('report.review_history.header') }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{ $t('report.review_history.search_condition') }}
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
                        <el-select
                                v-model="filter.course"
                                :placeholder="$t('qrcode.label.course')"
                                @change="fetchData"
                                clearable
                                style="width: 100%"
                        >
                            <el-option
                                    v-for="item in courses"
                                    :key="'course'+item.id"
                                    :label="item.name"
                                    :value="item.id"
                            />
                        </el-select>
                    </el-col>
                    <el-col
                            :sm="12"
                            :md="6"
                    >
                        <el-select
                                style="width: 100%"
                                v-model="filter.grade"
                                :placeholder="$t('checkinout.label.grade')"
                                @change="fetchData"
                                clearable
                        >
                            <el-option
                                    v-for="item in gradesFiltered"
                                    :key="'grade'+item.id"
                                    :label="item.name"
                                    :value="item.id"
                            />
                        </el-select>
                    </el-col>
                    <el-col
                      :sm="12"
                      :md="6"
                    >
                        <el-select
                          v-model="filter.lesson"
                          :placeholder="$t('checkinout.label.lesson')"
                          @change="fetchData"
                          clearable
                        >
                            <el-option
                              v-for="item in lessonsFiltered"
                              :key="'lesson'+item.id"
                              :label="item.name"
                              :value="item.id"
                            />
                        </el-select>
                    </el-col>
                </el-row>
                <el-row
                        style="padding-top: 10px"
                        v-if="show_filter"
                        :gutter="10"
                >
                    <el-col
                            :md="12"
                    >
                        <el-input
                                v-model="filter.username"
                                placeholder="User ID"
                                @keyup.native="performSearch"
                        />
                    </el-col>
                    <el-col
                            :md="12"
                    >
                        <el-input
                                v-model="filter.name"
                                placeholder="Full name"
                                @keyup.native="performSearch"
                        />
                    </el-col>
                </el-row>
                <el-row
                        style="padding-top: 10px"
                        v-if="show_filter"
                        :gutter="10"
                >
                    <el-col
                            :md="12"
                    >
                        <el-input
                                v-model="filter.email"
                                placeholder="Email"
                                @keyup.native="performSearch"
                        />
                    </el-col>
                    <el-col
                            :md="12"
                    >
                        <el-input
                                v-model="filter.phone"
                                placeholder="Mobile phone"
                                @keyup.native="performSearch"
                        />
                    </el-col>
                </el-row>
                <el-row
                        style="padding-top: 10px"
                        v-if="show_filter"
                        :gutter="10"
                >
                    <el-col
                            :md="12"
                    >
                        <el-date-picker
                                v-model="filter.created_at"
                                style="width:100% !important"
                                value-format="yyyy-MM-dd"
                                type="date"
                                placeholder="Date of birth"
                                @change="queryServer({})"
                        />

                    </el-col>
                </el-row>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 row-action">
                <el-button
                        type="primary"
                        size="small"
                        class="btn btn-flat"
                        icon="el-icon-download"
                        @click="download"
                >
                    {{ $t('report.label.download') }}
                </el-button>
            </div>
        </div>
        <div class="box box-success">
            <div class="box-body">
                <div class="sc-table">
                    <el-table
                            ref="dataTable"
                            v-loading.body="tableIsLoading"
                            :summary-method="getAvg"
                            show-summary
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
                                prop="created_at"
                                :label="$t('report.review_history.created_at')"
                                width="200"
                        />
                        <el-table-column
                                prop="fullname"
                                :label="$t('report.review_history.fullname')"
                                width="200"
                        />
                        <el-table-column
                                prop="place"
                                :label="$t('report.review_history.place')"
                                width="200"
                        />
                        <el-table-column
                                prop="course"
                                :label="$t('report.review_history.course')"
                                width="200"
                        />
                        <el-table-column
                                prop="grade"
                                :label="$t('report.review_history.grade')"
                                width="200"
                        />
                        <el-table-column
                                prop="lesson"
                                :label="$t('report.review_history.lesson')"
                                width="200"
                        />
                        <el-table-column
                                v-for="(group, index) in question_groups"
                                :key="group.id"
                                :label="group.title"
                        >
                            <el-table-column
                                    v-for="(question, qindex) in group.questions"
                                    :key="'g'+index+'q'+question.id"
                                    :label="question.content"
                                    width="200"
                                    :prop="'question_' + question.id"
                            >
                                <template slot-scope="props">
                                    <span>{{ questionAnswer(props.row,question.id) }}</span>
                                </template>
                            </el-table-column>
                        </el-table-column>
                    </el-table>

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
					per_page: 10000
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
					course: '',
					grade: '',
            lesson: '',
					username: '',
					name: '',
					email: '',
					phone: '',
					company: '',
					category: '',
					created_at: ''
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
				courses: [],
				grades: [],
				lessons: [],
				question_groups: [],
				user_token: window.MonCMS.user_token

			}
		},
		computed: {
			gradesFiltered: function () {
				if (this.filter.course) {
					return this.grades.filter(item => item.course_id == this.filter.course)
				}
				return this.grades.filter(item => true)
			},
			lessonsFiltered: function () {
				if (this.filter.grade) {
					return this.lessons.filter(item => item.grade_id == this.filter.grade)
				}
				return this.lessons.filter(item => true)
			}
		},
		mounted() {
			this.fetchData()
			this.fetchCourses()
			this.fetchGrades()
			this.fetchLessons()
			this.fetchQuestionGroups()
		},
		methods: {

			queryServer(customProperties) {
				const properties = {
					page: this.meta.current_page,
					per_page: this.meta.per_page,
					order_by: this.order_meta.order_by,
					order: this.order_meta.order,
					username: this.filter.username,
					name: this.filter.name,
					email: this.filter.email,
					phone: this.filter.phone,
					created_at: this.filter.created_at,
					course_id: this.filter.course,
					grade_id: this.filter.grade,
            lesson_id: this.filter.lesson
				}

				axios.get(route('api.report.reviewHistory', _.merge(properties, customProperties)))
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
			fetchData() {
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
			download() {
				let url = route('admin.report.downloadReviewHistory', {
					username: this.filter.username,
					name: this.filter.name,
					email: this.filter.email,
					phone: this.filter.phone,
					created_at: this.filter.created_at,
					course_id: this.filter.course,
					grade_id: this.filter.grade,
				})
				window.open(url, '_blank')
			},

			fetchCourses() {
				axios.get(route('api.course.all'))
					.then((response) => {
						this.courses = response.data.data
					})
			},
			fetchGrades() {
				axios.get(route('api.grade.all'))
					.then((response) => {
						this.grades = response.data.data
					})
			},
			fetchLessons() {
				axios.get(route('api.lesson.all'))
					.then((response) => {
						this.lessons = response.data.data
					})
			},
			fetchQuestionGroups() {
				axios.get(route('api.questiongroup.all'))
					.then((response) => {
						this.question_groups = response.data.data
					})
			},
			performSearch: _.debounce(function (query) {
				this.tableIsLoading = true
				this.queryServer({search: query.target.value, page: this.meta.current_page})
			}, 300),
			questionAnswer(row, question_id) {
				let questions = row.questions.find(item => item.id === question_id)
				if (questions) {
					return questions.answer
				}
				return ''
			},
			getAvg(param) {
				const {columns, data} = param;
				console.log(data)
				const sums = [];
				columns.forEach((column, index) => {
					let colTotal = ''
					if (index <= 6) {

						return;
					}
					if (column.property.includes("question_")) {
						let rowTotal = 0;
						let question_id = column.property.replace('question_', '');
						console.log(question_id)
						data.forEach(row => {
							let question_answer = 0;
							if (row.questions && row.questions.length > 0) {
								let question = row.questions.find(item => item.id == question_id)
								if (question) {
									question_answer = question.answer
								}

							}
							console.log(question_answer)
							rowTotal += Number(question_answer)
						})
						colTotal = rowTotal / data.length;
					}
					sums[index] = isNaN(colTotal) ? '' : colTotal; //(colTotal > 0 ? colTotal.toFixed(2) : '');
				});
				sums[6] = 'Điểm trung bình tổng: ' + ((sums[7] + sums[8] + sums[9] + sums[10] + sums[11] + sums[12]+ sums[13] + sums[14] + sums[15] + sums[16]+ sums[17] + sums[18])/12).toFixed(2);
				sums[7] =  ((sums[7] + sums[8] + sums[9])/3).toFixed(2);
              sums[8] = '';
              sums[9] = '';
				sums[10] =  ((sums[10] + sums[11] + sums[12]+ sums[13])/4).toFixed(2);
              sums[11] = '';
              sums[12] = '';
              sums[13] = '';

				sums[14] =  ((sums[14] + sums[15] + sums[16]+ sums[17])/4).toFixed(2);
              sums[15] = '';
              sums[16] = '';
              sums[17] = '';

              return sums;
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

    .el-upload {
        width: 100%;
    }
</style>
