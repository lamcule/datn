<template>
  <div>
    <div class="content-header">
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{name: 'admin.auth.permissions.index'}">
          {{ $t('permission.label.permissions') }}
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('permission.label.create_permission') }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <div class="row">
      <div class="col-md-12 row-action">
        <h3 class="row-left">
          {{ $t(pageTitle) }}
        </h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="box box-widget">
          <div class="box-body">
            <el-form
              ref="form"
              v-loading.body="loading"
              :model="modelForm"
              label-width="120px"
              label-position="top"
            >
              <el-form-item
                :label="$t('permission.label.name')"
                :class="{'el-form-item is-error': form.errors.has( 'name') }"
              >
                <el-input
                  v-model="modelForm.name"
                  @focus="form.errors.clear('name')"
                />
                <div
                  v-if="form.errors.has('name')"
                  class="el-form-item__error"
                  v-text="form.errors.first('name')"
                />
              </el-form-item>

              <el-form-item
                :label="$t('permission.label.description')"
                :class="{'el-form-item is-error': form.errors.has( 'description') }"
              >
                <el-input v-model="modelForm.description" />
                <div
                  v-if="form.errors.has('description')"
                  class="el-form-item__error"
                  v-text="form.errors.first('description')"
                />
              </el-form-item>
            </el-form>
          </div>
          <div class="box-footer">
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
              {{ $t('mon.button.cancel') }}
            </el-button>
          </div>
        </div>
      </div>
    </div>
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
      loading: false,
      modelForm: {
        name: '',
        guard_name: 'web',
        description: ''

      }
    }
  },
  computed: {},
  mounted () {
    if (this.$route.params.permissionId !== undefined) {
      this.fetchData()
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
          this.$router.push({ name: 'admin.auth.permissions.index' })
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
        this.$router.push({ name: 'admin.auth.permissions.index' })
      }).catch(() => {

      })
    },

    fetchData () {
      this.loading = true
      axios.get(route('api.auth.permissions.find', { permission: this.$route.params.permissionId }))
        .then((response) => {
          this.loading = false
          this.modelForm = response.data.data
        })
    },

    getRoute () {
      if (this.$route.params.permissionId !== undefined) {
        return route('api.auth.permissions.update', { permission: this.$route.params.permissionId })
      }
      return route('api.auth.permissions.store')
    }

  }
}
</script>

<style scoped>

</style>
