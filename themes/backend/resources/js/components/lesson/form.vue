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
        <el-breadcrumb-item :to="{name: 'admin.grade.view', params: {gradeId: gradeId}}">
          {{ grade.name }}
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t(pageTitle) }}
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
                {{ $t('lesson.box.lesson information') }}
              </h3>
            </div>
            <div class="box-body">
              <el-form-item
                :label="$t('lesson.label.name')"
                :class="{'el-form-item is-error': form.errors.has('name') }"
              >
                <el-input v-model="modelForm.name" />
                <div
                  v-if="form.errors.has('name')"
                  class="el-form-item__error"
                  v-text="form.errors.first('name')"
                />
              </el-form-item>

              <el-form-item
                :label="$t('lesson.label.place')"
                :class="{'el-form-item is-error': form.errors.has('place') }"
              >
                <el-input v-model="modelForm.place" />
                <div
                  v-if="form.errors.has('place')"
                  class="el-form-item__error"
                  v-text="form.errors.first('place')"
                />
              </el-form-item>

              <el-form-item
                :label="$t('lesson.label.topic')"
                :class="{'el-form-item is-error': form.errors.has('topic') }"
              >
                <el-input v-model="modelForm.topic" />
                <div
                  v-if="form.errors.has('topic')"
                  class="el-form-item__error"
                  v-text="form.errors.first('topic')"
                />
              </el-form-item>

              <el-form-item
                :label="$t('lesson.label.course_id')"
                :class="{'el-form-item is-error': form.errors.has('course_id') }"
              >
                <el-select
                  v-model="modelForm.course_id"
                  filterable
                  :placeholder="$t('lesson.label.course_id')"
                >
                  <el-option
                    v-for="item in courses"
                    :key="'course_'+item.id"
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
              <el-form-item
                :label="$t('lesson.label.grade_id')"
                :class="{'el-form-item is-error': form.errors.has('grade_id') }"
              >
                <el-select
                  v-model="modelForm.grade_id"
                  filterable
                  :placeholder="$t('lesson.label.grade_id')"
                >
                  <el-option
                    v-for="item in gradeComputed"
                    :key="'grade_'+item.id"
                    :label="item.name"
                    :value="item.id"
                  />
                </el-select>
                <div
                  v-if="form.errors.has('grade_id')"
                  class="el-form-item__error"
                  v-text="form.errors.first('grade_id')"
                />
              </el-form-item>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">
                {{ $t('lesson.box.lesson content') }}
              </h3>
            </div>
            <div class="box-body">
              <el-form-item
                :label="$t('lesson.label.target')"
                :class="{'el-form-item is-error': form.errors.has('target') }"
              >

                <el-select
                        v-model="modelForm.target"
                        filterable
                        multiple
                        :placeholder="$t('lesson.label.target')"
                >
                  <el-option
                          v-for="item in listTargets"
                          :key="item.value"
                          :label="item.label"
                          :value="item.value"
                  />
                </el-select>
                <div
                  v-if="form.errors.has('target')"
                  class="el-form-item__error"
                  v-text="form.errors.first('target')"
                />
              </el-form-item>
              <el-form-item
                :label="$t('lesson.label.teacher')"
                :class="{'el-form-item is-error': form.errors.has('teacher') }"
              >
                <el-input v-model="modelForm.teacher" />
                <div
                  v-if="form.errors.has('teacher')"
                  class="el-form-item__error"
                  v-text="form.errors.first('teacher')"
                />
              </el-form-item>
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
              </div>


              <div class="row">
                <div class="col-md-6">
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
                <div class="col-md-6">
                  <el-form-item
                    :label="$t('lesson.label.end_time')"
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

        <div class="col-md-12">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3
                class="box-title"
                style="padding-right: 30px"
              >
                {{ $t('lesson.label.main_content') }}
              </h3>
              <el-button
                type="warning"
                icon="el-icon-circle-plus-outline"
                size="mini"
                @click="addContent"
              >
                {{ $t('lesson.label.add content') }}
              </el-button>
            </div>

            <div
              class="box-body"
              style="padding: 20px 10px"
            >
              <div
                class="row"

                style="padding-bottom: 15px"
              >
                <div class="col-sm-2  ">
                  {{ $t('lesson.label.time') }}
                </div>
                <div class="col-sm-9  ">
                  {{ $t('lesson.label.content') }}
                </div>
                <div class="col-sm-1 text-center" />
              </div>

              <div
                v-for="(item, idx) in modelForm.content"
                :key="'content-' + idx"
                class="row"
              >
                <div class="col-sm-2  ">
                  <el-form-item>
                    <el-input v-model="item.time" />
                  </el-form-item>
                </div>
                <div class="col-sm-9 ">
                  <el-form-item>
                    <el-input v-model="item.content" />
                  </el-form-item>
                </div>
                <div
                  class="col-sm-1"
                  style="padding-top: 10px;"
                >
                  <i
                    class="el-icon-circle-close"
                    style="font-size: 20px"
                    @click="removeContent(idx)"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3
                class="box-title"
                style="padding-right: 30px"
              >
                {{ $t('lesson.label.document') }}
              </h3>
            </div>

            <div
              class="box-body"
              style="padding: 20px 10px"
            >
              <div
                class="row"

                style="padding-bottom: 15px"
              >
                <div class="col-sm-12  ">
                  <multiple-media
                    zone="lesson_document"
                    entity="lesson"
                    hint="  "
                    :entity-id="$route.params.lessonId"
                    @multipleFileSelected="selectMultipleFile($event, 'modelForm')"
                    @fileSorted="fileSorted($event, 'modelForm')"
                  />
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
import MultipleFileSelector from '../../mixins/MultipleFileSelector.js'
import MultipleMedia from '../media/js/components/MultipleMedia'
export default {
  components: {
    MultipleMedia
  },
  mixins: [MultipleFileSelector],
  props: {
    locales: { default: null },
    pageTitle: { default: null, String }
  },
  data () {
    return {
      form: new Form(),
      changepassForm: new Form(),
      loading: false,
      loadingPassword: false,
      modelForm: {
        name: '',
        grade_id: '',
        course_id: '',
        content: [],
        topic: '',
        teacher: '',
        target: [],
        document: '',
        start_time: '',
        end_time: '',

        is_new: false,
        province_id: null,
        district_id: null,
        phoenix_id: null

      },
      courseId: 0,
      gradeId: 0,
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
      provinces: [],
      districts: [],
      phoenixes: [],
      courses: [],
      grades: [],
      course: {},
      grade: {},
      listTargets: [
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
      ]
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
    },
    gradeComputed: function () {
      if (this.modelForm.course_id) {
        return this.grades.filter(item => item.course_id == this.modelForm.course_id)
      }
      return this.grades.filter(item => true)
    }
  },
  mounted () {
    this.fetchData()
    this.fetchProvince()
    this.fetchDistrict()
    this.fetchPhoenix()
    this.fetchCourse()
    this.fetchGrade()
    if (this.$route.query.grade) {
      this.modelForm.grade_id = this.$route.query.grade
    }
    if (this.$route.query.course) {
      this.modelForm.course_id = this.$route.query.course
    }
  },
  methods: {
    onSubmit () {
      this.form = new Form(_.merge(this.modelForm, {}))
      this.loading = true

      this.form.post(this.getRoute())
        .then((response) => {
          this.loading = false
          this.$message({
            type: 'success',
            message: response.message
          })
          this.$router.push({ name: 'admin.grade.view', params: { gradeId: this.$route.query.grade } })
        })
        .catch((error) => {
          this.loading = false
          this.$notify.error({
            title: 'Error',
            message: this.getSubmitError(this.form.errors)
          })
        })
    },

    onCancel () {
      this.$confirm('Are you sure to cancel?', {
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        type: 'warning'
      }).then(() => {
        this.$router.push({ name: 'admin.grade.view', params: { gradeId: this.$route.query.grade } })
      }).catch(() => {

      })
    },
    fetchCourse () {
      axios.get(route('api.course.all'))
        .then((response) => {
          this.courses = response.data.data
        })
    },
    fetchGrade () {
      axios.get(route('api.grade.all'))
        .then((response) => {
          this.grades = response.data.data
        })
    },
    fetchData () {
      let routeUri = ''
      this.courseId = this.$route.query.course
      this.gradeId = this.$route.query.grade

      axios.get(route('api.course.find', { course: this.courseId }))
        .then((response) => {
          this.course = response.data.data
        })
      axios.get(route('api.grade.find', { grade: this.gradeId }))
        .then((response) => {
          this.grade = response.data.data
        })

      if (this.$route.params.lessonId !== undefined) {
        this.loading = true
        routeUri = route('api.lesson.find', { lesson: this.$route.params.lessonId })
        axios.get(routeUri)
          .then((response) => {
            this.loading = false
            this.modelForm = response.data.data
            if (this.modelForm.content == null || this.modelForm.content == '') {
              this.modelForm.content = []
            }
            this.modelForm.is_new = false
          })
      } else {
        this.modelForm.is_new = true
      }
    },

    getRoute () {
      if (this.$route.params.lessonId !== undefined) {
        return route('api.lesson.update', { lesson: this.$route.params.lessonId })
      }
      return route('api.lesson.store')
    },
    handleCheckAllChange (val) {
      this.modelForm.roles = val ? this.roles.map(item => item.id) : []
      this.isIndeterminate = false
    },
    handleCheckedChange (value) {
      let checkedCount = value.length
      this.checkAll = checkedCount === this.roles.length
      this.isIndeterminate = checkedCount > 0 && checkedCount < this.roles.length
    },
    removeContent (idx) {
      this.modelForm.content = this.modelForm.content.filter((item, index) => {
        return idx !== index
      })
    },
    addContent () {
      this.modelForm.content.push(Object.assign({}, {
        time: '',
        content: ''

      }))
    },
    fetchProvince () {
      axios.get(route('api.province.all'))
        .then((response) => {
          this.provinces = response.data.data
        })
    },
    fetchDistrict () {
      axios.get(route('api.district.all'))
        .then((response) => {
          this.districts = response.data.data
        })
    },
    fetchPhoenix () {
      axios.get(route('api.phoenix.all'))
        .then((response) => {
          this.phoenixes = response.data.data
        })
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
