<template>
    <div>
        <div class="content-header">
            <h1>
                {{ $t(pageTitle) }}<span
                    v-if="modelForm.name"
            >: &nbsp{{ modelForm.name }}</span>
            </h1>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.course.index'}">
                    {{ $t('course.label.manage_course') }}
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.course.view', params: {courseId: courseId}}">
                    {{ course.name }}
                </el-breadcrumb-item>
                <el-breadcrumb-item>
                    {{ $t(pageTitle) }} lớp học
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <el-form
                ref="form"
                v-loading.body="loading"
                :model="modelForm"
                label-width="120px"
                label-position="top"
        >
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                {{ $t('grade.box.grade information') }}
                            </h3>
                        </div>
                        <div class="box-body">
                            <el-form-item
                                    :label="$t('grade.label.name')"
                                    :class="{'el-form-item is-error': form.errors.has('name') }"
                            >
                                <el-input v-model="modelForm.name"/>
                                <div
                                        v-if="form.errors.has('name')"
                                        class="el-form-item__error"
                                        v-text="form.errors.first('name')"
                                />
                            </el-form-item>
                            <el-form-item
                                    :label="$t('grade.label.number_of_lesson')"
                                    :class="{'el-form-item is-error': form.errors.has('number_of_lesson') }"
                            >
                                <el-input-number v-model="modelForm.number_of_lesson"/>
                                <div
                                        v-if="form.errors.has('number_of_lesson')"
                                        class="el-form-item__error"
                                        v-text="form.errors.first('number_of_lesson')"
                                />
                            </el-form-item>

                            <el-form-item
                                    :label="$t('grade.label.course_id')"
                                    :class="{'el-form-item is-error': form.errors.has('course_id') }"
                            >
                                <el-select
                                        v-model="modelForm.course_id"
                                        filterable
                                        :placeholder="$t('grade.label.course_id')"
                                >
                                    <el-option
                                            v-for="item in listCourse"
                                            :key="item.id"
                                            :label="item.name"
                                            :value="item.id"
                                    />
                                </el-select>
                                <div
                                        v-if="form.errors.has('course_id')"
                                        class="el-form-item__error"
                                        v-text="form.errors.first('course_id')"
                                />
                            </el-form-item>
                            <div class="row">
                                <div class="col-md-6">
                                    <el-form-item
                                            :label="$t('grade.label.teacher')"
                                            :class="{'el-form-item is-error': form.errors.has('teacher') }"
                                    >
                                        <el-input v-model="modelForm.teacher"/>
                                        <div
                                                v-if="form.errors.has('teacher')"
                                                class="el-form-item__error"
                                                v-text="form.errors.first('teacher')"
                                        />
                                    </el-form-item>
                                </div>
                                <div class="col-md-3">
                                    <el-form-item
                                            label="Teacher type"
                                            :class="{'el-form-item is-error': form.errors.has('teacher_type') }"
                                    >
                                        <el-select
                                                v-model="modelForm.teacher_type"
                                                filterable

                                        >
                                            <el-option
                                                    v-for="item in listTeacherType"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="item.value"
                                            />
                                        </el-select>
                                        <div
                                                v-if="form.errors.has('teacher_type')"
                                                class="el-form-item__error"
                                                v-text="form.errors.first('teacher_type')"
                                        />
                                    </el-form-item>
                                </div>
                                <div class="col-md-3">
                                    <el-form-item
                                            label="Teacher organization"
                                            :class="{'el-form-item is-error': form.errors.has('teacher_company') }"
                                    >
                                        <el-input v-model="modelForm.teacher_company"/>
                                        <div
                                                v-if="form.errors.has('teacher_company')"
                                                class="el-form-item__error"
                                                v-text="form.errors.first('teacher_company')"
                                        />
                                    </el-form-item>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <el-form-item
                                            :label="$t('mon.label.province')"
                                            :class="{'el-form-item is-error': form.errors.has('province_id') }"
                                    >
                                        <el-select
                                                v-model="modelForm.province_id"
                                                filterable
                                                :placeholder="$t('mon.label.province')"
                                        >
                                            <el-option
                                                    v-for="item in provinces"
                                                    :key="'province_'+item.id"
                                                    :label="item.name"
                                                    :value="item.id"
                                            />
                                        </el-select>
                                        <div
                                                v-if="form.errors.has('province_id')"
                                                class="el-form-item__error"
                                                v-text="form.errors.first('province_id')"
                                        />
                                    </el-form-item>
                                </div>
                                <div class="col-md-2">
                                    <el-form-item
                                            :label="$t('mon.label.district')"
                                            :class="{'el-form-item is-error': form.errors.has('district_id') }"
                                    >
                                        <el-select
                                                v-model="modelForm.district_id"
                                                filterable
                                                :placeholder="$t('mon.label.district')"
                                        >
                                            <el-option
                                                    v-for="item in districtComputed"
                                                    :key="'district_id_'+item.id"
                                                    :label="item.name"
                                                    :value="item.id"
                                            />
                                        </el-select>
                                        <div
                                                v-if="form.errors.has('district_id')"
                                                class="el-form-item__error"
                                                v-text="form.errors.first('district_id')"
                                        />
                                    </el-form-item>
                                </div>
                                <div class="col-md-2">
                                    <el-form-item
                                            :label="$t('mon.label.phoenix')"
                                            :class="{'el-form-item is-error': form.errors.has('phoenix_id') }"
                                    >
                                        <el-select
                                                v-model="modelForm.phoenix_id"
                                                filterable
                                                :placeholder="$t('mon.label.phoenix')"
                                        >
                                            <el-option
                                                    v-for="item in phoenixComputed"
                                                    :key="'phoenix_id'+item.id"
                                                    :label="item.name"
                                                    :value="item.id"
                                            />
                                        </el-select>
                                        <div
                                                v-if="form.errors.has('phoenix_id')"
                                                class="el-form-item__error"
                                                v-text="form.errors.first('phoenix_id')"
                                        />
                                    </el-form-item>
                                </div>
                                <div class="col-md-6">
                                    <el-form-item
                                            :label="$t('grade.label.place')"
                                            :class="{'el-form-item is-error': form.errors.has('place') }"
                                    >
                                        <el-input v-model="modelForm.place"/>
                                        <div
                                                v-if="form.errors.has('place')"
                                                class="el-form-item__error"
                                                v-text="form.errors.first('place')"
                                        />
                                    </el-form-item>
                                </div>
                            </div>

                            <el-form-item
                                    :label="$t('grade.label.status')"
                                    :class="{'el-form-item is-error': form.errors.has('status') }"
                            >
                                <el-select
                                        v-model="modelForm.status"
                                        filterable
                                        :placeholder="$t('grade.label.status')"
                                >
                                    <el-option
                                            v-for="item in listStatus"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value"
                                    />
                                </el-select>
                                <div
                                        v-if="form.errors.has('status')"
                                        class="el-form-item__error"
                                        v-text="form.errors.first('status')"
                                />
                            </el-form-item>
                            <div class="row">
                                <div class="col-md-2">
                                    <el-form-item
                                            label="Hours"
                                            :class="{'el-form-item is-error': form.errors.has('hours') }"
                                    >
                                        <el-input-number v-model="modelForm.hours"/>
                                        <div
                                                v-if="form.errors.has('hours')"
                                                class="el-form-item__error"
                                                v-text="form.errors.first('hours')"
                                        />
                                    </el-form-item>
                                </div>
                                <div class="col-md-5">
                                    <el-form-item
                                            :label="$t('lesson.label.start_time')"
                                            :class="{'el-form-item is-error': form.errors.has('start_time') }"
                                    >
                                        <el-date-picker
                                                v-model="modelForm.start_time"
                                                style="width:100% !important"
                                                value-format="yyyy-MM-dd HH:mm:ss"
                                                type="datetime"
                                                placeholder="Select date and time"
                                        />
                                        <div
                                                v-if="form.errors.has('start_time')"
                                                class="el-form-item__error"
                                                v-text="form.errors.first('start_time')"
                                        />
                                    </el-form-item>
                                </div>
                                <div class="col-md-5">
                                    <el-form-item
                                            label="End time"
                                            :class="{'el-form-item is-error': form.errors.has('end_time') }"
                                    >
                                        <el-date-picker
                                                v-model="modelForm.end_time"
                                                style="width:100% !important"
                                                value-format="yyyy-MM-dd HH:mm:ss"
                                                type="datetime"
                                                placeholder="Select date and time"
                                        />
                                        <div
                                                v-if="form.errors.has('end_time')"
                                                class="el-form-item__error"
                                                v-text="form.errors.first('end_time')"
                                        />
                                    </el-form-item>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <div class="col-md-12 footer-action-contaner">
                    <el-button
                            type="primary"
                            size="small"
                            :loading="loading"
                            class="btn btn-flat "
                            @click="onSubmit()"
                    >
                        {{ $t('mon.button.save') }}
                    </el-button>
                    <el-button
                            class="btn btn-flat pull-right"
                            size="small"
                            @click="onCancel()"
                    >
                        {{
                        $t('mon.button.cancel') }}
                    </el-button>
                </div>
            </div>
        </el-form>
    </div>
</template>

<script>
  import axios from 'axios'
  import Form from 'form-backend-validation'

  export default {
    props: {
      locales: {default: null},
      pageTitle: {default: null, String}
    },
    data() {
      return {
        form: new Form(),
        changepassForm: new Form(),
        loading: false,
        loadingPassword: false,
        modelForm: {
          name: '',
          course_id: '',
          number_of_lesson: '',
          place: '',
          teacher: '',
          start_time: '',
          status: 'inactive',
          is_new: false,
          province_id: null,
          district_id: null,
          phoenix_id: null,
          teacher_type: '',
          teacher_company: '',
          hours: null,
          end_time: null
        },
        courseId: 0,
        course: {},
        checkAll: false,
        isIndeterminate: true,
        changePassDialogVisible: false,
        categories: window.MonCMS.categories,
        listStatus: [
          {
            value: 'active',
            label: 'active'
          },
          {
            value: 'inactive',
            label: 'inactive'
          }
        ],
        listTeacherType: [
          {
            value: 'Internal',
            label: 'Internal'
          },
          {
            value: 'External',
            label: 'External'
          }
        ],
        listCourse: [],
        provinces: [],
        districts: [],
        phoenixes: []
      }
    },
    computed: {
      districtComputed: function () {
        if (this.modelForm.province_id) {
          return this.districts.filter(item => item.province_id == this.modelForm.province_id)
        }
        return []
      },
      phoenixComputed: function () {
        if (this.modelForm.district_id) {
          return this.phoenixes.filter(item => item.district_id == this.modelForm.district_id)
        }
        return []
      }
    },
    mounted() {
      this.modelForm.course_id = this.$route.query.course
      this.fetchData()
      this.fetchProvince()
      this.fetchDistrict()
      this.fetchPhoenix()
    },
    methods: {
      onSubmit() {
        this.form = new Form(_.merge(this.modelForm, {}))
        this.loading = true

        this.form.post(this.getRoute())
          .then((response) => {
            this.loading = false
            this.$message({
              type: 'success',
              message: response.message
            })
            this.$router.push({name: 'admin.course.view', params: {courseId: this.$route.query.course}})
          })
          .catch((error) => {
            this.loading = false
            this.$notify.error({
              title: 'Error',
              message: this.getSubmitError(this.form.errors)
            })
          })
      },

      onCancel() {
        this.$confirm('Are you sure to cancel?', {
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
          type: 'warning'
        }).then(() => {
          this.$router.push({name: 'admin.course.view', params: {courseId: this.$route.query.course}})
        }).catch(() => {

        })
      },

      fetchData() {
        let routeUri = ''
        this.courseId = this.$route.query.course

        axios.get(route('api.course.find', {course: this.$route.query.course}))
          .then((response) => {
            this.course = response.data.data
          })

        axios.get(route('api.course.all'))
          .then((response) => {
            this.listCourse = response.data.data
          })

        if (this.$route.params.gradeId !== undefined) {
          this.loading = true
          routeUri = route('api.grade.find', {grade: this.$route.params.gradeId})
          axios.get(routeUri)
            .then((response) => {
              this.loading = false
              this.modelForm = response.data.data
              this.modelForm = _.merge(this.modelForm, response.data.data.profile)
              this.modelForm.is_new = false
            })
        } else {
          this.modelForm.is_new = true

        }
      },
      fetchProvince() {
        axios.get(route('api.province.all'))
          .then((response) => {
            this.provinces = response.data.data
          })
      },
      fetchDistrict() {
        axios.get(route('api.district.all'))
          .then((response) => {
            this.districts = response.data.data
          })
      },
      fetchPhoenix() {
        axios.get(route('api.phoenix.all'))
          .then((response) => {
            this.phoenixes = response.data.data
          })
      },
      getRoute() {
        if (this.$route.params.gradeId !== undefined) {
          return route('api.grade.update', {grade: this.$route.params.gradeId})
        }
        return route('api.grade.store')
      },
      handleCheckAllChange(val) {
        this.modelForm.roles = val ? this.roles.map(item => item.id) : []
        this.isIndeterminate = false
      },
      handleCheckedChange(value) {
        let checkedCount = value.length
        this.checkAll = checkedCount === this.roles.length
        this.isIndeterminate = checkedCount > 0 && checkedCount < this.roles.length
      }

    }
  }
</script>

<style scoped>
    .form--element__flex {
        display: flex;
        justify-content: space-between;
    }
</style>
