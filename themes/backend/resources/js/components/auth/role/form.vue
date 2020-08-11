<template>
  <div>
    <div class="content-header">
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{name: 'admin.auth.roles.index'}">
          {{ $t('role.label.roles') }}
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t('role.label.create_role') }}
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
    <el-form
      ref="form"
      v-loading.body="loading"
      :model="modelForm"
      label-width="120px"
      label-position="top"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="box box-widget">
            <div class="box-body">
              <el-tabs>
                <el-tab-pane>
                  <span slot="label">{{ $t('role.label.information') }}</span>
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
                  <div>
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
                </el-tab-pane>
                <el-tab-pane :disabled="!roleId">
                  <span slot="label">{{ $t('role.label.permissions') }}</span>
                  <div class="row">
                    <div class="col-md-6">
                      <div
                        class="box box-widget"
                        style="padding:0"
                      >
                        <div class="box-body">
                          <permission-table
                            ref="addTable"
                            type="add"
                            :role-id="roleId"
                            @reload-permissions="reloadRemoveTable"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div
                        class="box box-widget"
                        style="padding:0"
                      >
                        <div class="box-body">
                          <permission-table
                            ref="removeTable"
                            type="remove"
                            :role-id="roleId"
                            @reload-permissions="reloadAddTable"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </el-tab-pane>
              </el-tabs>
            </div>
          </div>
        </div>
      </div>
    </el-form>
  </div>
</template>

<script>
import axios from 'axios'
import Form from 'form-backend-validation'
import PermissionTable from './permissions'
export default {
  components: {
    PermissionTable
  },
  props: {
    locales: { default: null },
    pageTitle: { default: null, String }
  },
  data () {
    return {
      form: new Form(),
      loading: false,
      modelForm: {
        id: '',
        name: '',
        guard_name: 'web',
        description: ''

      },
      permissions: [],
      checkedPermissions: [],
      checkAll: false,
      isIndeterminate: true,
      roleId: null
    }
  },
  computed: {},
  created () {
    this.roleId = this.$route.params.roleId
  },
  mounted () {
    if (this.$route.params.roleId !== undefined) {
      this.fetchData()
    }
    this.fetchPermissions()
  },
  methods: {
    onSubmit () {
      this.form = new Form(_.merge(this.modelForm, { permissions: this.checkedPermissions }))
      this.loading = true

      this.form.post(this.getRoute())
        .then((response) => {
          this.loading = false
          this.$message({
            type: 'success',
            message: response.message
          })
          this.$router.push({ name: 'admin.auth.roles.index' })
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
        this.$router.push({ name: 'admin.auth.roles.index' })
      }).catch(() => {

      })
    },

    fetchData () {
      this.loading = true
      axios.get(route('api.auth.roles.find', { role: this.$route.params.roleId }))
        .then((response) => {
          this.loading = false
          this.modelForm = response.data.data
          this.checkedPermissions = this.modelForm.checkedPermissions
        })
    },
    fetchPermissions () {
      this.loading = true
      axios.get(route('api.auth.permissions.index', {
        per_page: 1000
      }))
        .then((response) => {
          this.loading = false
          this.permissions = response.data.data
        })
    },

    getRoute () {
      if (this.$route.params.roleId !== undefined) {
        return route('api.auth.roles.update', { role: this.$route.params.roleId })
      }
      return route('api.auth.roles.store')
    },

    handleCheckAllChange (val) {
      this.checkedPermissions = val ? this.permissions.map(item => item.id) : []
      this.isIndeterminate = false
    },
    handleCheckedPermissionsChange (value) {
      console.log(value)
      let checkedCount = value.length
      this.checkAll = checkedCount === this.permissions.length
      this.isIndeterminate = checkedCount > 0 && checkedCount < this.permissions.length
    },
    reloadRemoveTable () {
      this.$refs.removeTable.reloadData()
    },
    reloadAddTable () {
      this.$refs.addTable.reloadData()
    }

  }
}
</script>

<style scoped>
.box-permission-header {
    display: flex;
    align-content: center;

}
</style>
