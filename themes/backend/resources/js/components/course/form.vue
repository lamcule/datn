<template>
  <div>
    <div class="content-header">
      <h1> {{ $t(pageTitle) }}<span
              v-if="modelForm.name"
      >: &nbsp{{ modelForm.name }}</span></h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{name: 'admin.course.index'}">
          {{ $t('course.label.manage_course') }}
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
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">
                {{ $t('course.box.course information') }}
              </h3>
            </div>
            <div class="box-body">
              <el-form-item
                      :label="$t('course.label.name')"
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
                      :label="$t('course.label.description')"
                      :class="{'el-form-item is-error': form.errors.has('description') }"
              >
                <el-input
                        v-model="modelForm.description"
                        type="textarea"
                        :rows="5"

                />
              </el-form-item>
            </div>
          </div>
        </div>


      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">
              {{ $t('course.box.course detail') }}
            </h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <el-form-item
                        :label="$t('course.label.type')"
                        :class="{'el-form-item is-error': form.errors.has('type') }"
                >
                  <el-select
                          v-model="modelForm.type"
                          :placeholder="$t('course.label.type')"
                          filterable
                          size="large"
                  >
                    <el-option
                            v-for="item in listTypes"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                    />
                  </el-select>

                  <div
                          v-if="form.errors.has('type')"
                          class="el-form-item__error"
                          v-text="form.errors.first('type')"
                  />
                </el-form-item>
              </div>
              <div class="col-md-6">
                <el-form-item
                        :label="$t('course.label.scale')"
                        :class="{'el-form-item is-error': form.errors.has('scale') }"
                >
                  <el-select
                          v-model="modelForm.scale"
                          filterable
                          :placeholder="$t('course.label.scale')"
                  >
                    <el-option
                            v-for="item in listScales"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                    />
                  </el-select>
                  <div
                          v-if="form.errors.has('scale')"
                          class="el-form-item__error"
                          v-text="form.errors.first('scale')"
                  />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <el-form-item
                        :label="$t('course.label.role')"
                        :class="{'el-form-item is-error': form.errors.has('role') }"
                >
                  <el-select
                          v-model="modelForm.role"
                          :placeholder="$t('course.label.role')"
                          filterable
                  >
                    <el-option
                            v-for="item in listRoles"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                    />
                  </el-select>

                  <div
                          v-if="form.errors.has('role')"
                          class="el-form-item__error"
                          v-text="form.errors.first('role')"
                  />
                </el-form-item>
              </div>
              <div class="col-md-6">
                <el-form-item
                        :label="$t('course.label.project')"
                        :class="{'el-form-item is-error': form.errors.has('project') }"
                >
                  <el-select
                          v-model="modelForm.project"
                          filterable
                          :placeholder="$t('course.label.project')"
                  >
                    <el-option
                            v-for="item in listProjects"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                    />
                  </el-select>
                  <div
                          v-if="form.errors.has('project')"
                          class="el-form-item__error"
                          v-text="form.errors.first('project')"
                  />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <el-form-item
                        :label="$t('course.label.frequency')"
                        :class="{'el-form-item is-error': form.errors.has('frequency') }"
                >
                  <el-select
                          v-model="modelForm.frequency"
                          :placeholder="$t('course.label.frequency')"
                          filterable
                  >
                    <el-option
                            v-for="item in listFrequency"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                    />
                  </el-select>

                  <div
                          v-if="form.errors.has('frequency')"
                          class="el-form-item__error"
                          v-text="form.errors.first('frequency')"
                  />
                </el-form-item>
              </div>
              <div class="col-md-6">
                <el-form-item
                        :label="$t('course.label.object')"
                        :class="{'el-form-item is-error': form.errors.has('object') }"
                >
                  <el-select
                          v-model="modelForm.object"
                          filterable
                          multiple
                          :placeholder="$t('course.label.object')"
                  >
                    <el-option
                            v-for="item in listObjects"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                    />
                  </el-select>
                  <div
                          v-if="form.errors.has('object')"
                          class="el-form-item__error"
                          v-text="form.errors.first('object')"
                  />
                </el-form-item>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <el-form-item
                        :label="$t('course.label.area')"
                        :class="{'el-form-item is-error': form.errors.has('area') }"
                >
                  <el-select
                          v-model="modelForm.area"
                          :placeholder="$t('course.label.area')"
                          filterable
                  >
                    <el-option
                            v-for="item in listArea"
                            :key="item.name"
                            :label="item.name"
                            :value="item.name"
                    />
                  </el-select>

                  <div
                          v-if="form.errors.has('area')"
                          class="el-form-item__error"
                          v-text="form.errors.first('area')"
                  />
                </el-form-item>
              </div>
              <div class="col-md-6">
                <el-form-item
                        :label="$t('course.label.status')"
                        :class="{'el-form-item is-error': form.errors.has('status') }"
                >
                  <el-select
                          v-model="modelForm.status"
                          filterable
                          :placeholder="$t('course.label.status')"
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
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <el-form-item
                        :label="$t('course.label.has_notification')"
                        :class="{'el-form-item is-error': form.errors.has('has_notification') }"
                >
                  <el-switch
                          v-model="modelForm.has_notification"
                          active-text="On"
                          inactive-text="Off">
                  </el-switch>

                  <div
                          v-if="form.errors.has('has_notification')"
                          class="el-form-item__error"
                          v-text="form.errors.first('has_notification')"
                  />
                </el-form-item>
              </div>
              <div class="col-md-3">
                <el-form-item
                        label="Has send email"
                        :class="{'el-form-item is-error': form.errors.has('has_email') }"
                >
                  <el-switch
                          v-model="modelForm.has_email"
                          active-text="On"
                          inactive-text="Off">
                  </el-switch>

                  <div
                          v-if="form.errors.has('has_email')"
                          class="el-form-item__error"
                          v-text="form.errors.first('has_email')"
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
        description: '',
        type: '',
        area: '',
        role: '',
        frequency: '',
        project: '',
        scale: '',
        object: [],
        teacher: '',
        status: 'inactive',
        is_new: false,
        has_notification: true,
        has_email: true,

      },
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
      ]
    }
  },
  computed: {},
  mounted () {
    this.fetchData()
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
          this.$router.push({ name: 'admin.course.index' })
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
        this.$router.push({ name: 'admin.course.index' })
      }).catch(() => {

      })
    },

    fetchData () {
      axios.get(route('api.province.all'))
        .then((response) => {
          this.listArea = response.data.data
        })
      let routeUri = ''
      if (this.$route.params.courseId !== undefined) {
        this.loading = true
        routeUri = route('api.course.find', { course: this.$route.params.courseId })
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

    getRoute () {
      if (this.$route.params.courseId !== undefined) {
        return route('api.course.update', { course: this.$route.params.courseId })
      }
      return route('api.course.store')
    },
    handleCheckAllChange (val) {
      this.modelForm.roles = val ? this.roles.map(item => item.id) : []
      this.isIndeterminate = false
    },
    handleCheckedChange (value) {
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
