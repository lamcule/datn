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
        <el-breadcrumb-item :to="{name: 'admin.grade.index'}">
          {{ $t('grade.label.manage_grade') }}
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
                  <el-input v-model="modelForm.target" />
                <div
                  v-if="form.errors.has('target')"
                  class="el-form-item__error"
                  v-text="form.errors.first('target')"
                />
              </el-form-item>

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
      grades: [],
      course: {},
      grade: {},
    }
  },
  mounted () {
    this.fetchData()
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
  }
}
</script>

<style scoped>
    .form--element__flex {
        display: flex;
        justify-content: space-between;
    }
</style>
