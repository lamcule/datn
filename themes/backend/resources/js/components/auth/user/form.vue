<template>
  <div>
    <div class="row">
      <div class="col-md-12 row-action">
        <h3 class="row-left">
          {{ $t(pageTitle) }}<span v-if="modelForm.email">: &nbsp{{ modelForm.email }}</span>
        </h3>
        <el-button
          v-if="modelForm.id"
          type="danger"
          class="btn btn-flat btn-danger"
          @click="changePassDialogVisible = true"
        >
          {{ $t('user.label.change_password') }}
        </el-button>
      </div>
    </div>
    <el-dialog
      :title="($t('user.label.change_password') + ': ' + modelForm.email)"
      :visible.sync="changePassDialogVisible"
      width="30%"
      center
    >
      <el-form
        ref="changepassForm"
        v-loading.body="loadingPassword"
        :model="modelForm"
        label-width="120px"
        label-position="top"
      >
        <el-form-item
          :label="$t('user.label.password')"
          :class="{'el-form-item is-error': form.errors.has('password') }"
        >
          <el-input
            v-model="modelForm.password"
            autocomplete="off"
            type="password"
          />
          <div
            v-if="form.errors.has('password')"
            class="el-form-item__error"
            v-text="form.errors.first('password')"
          />
        </el-form-item>
        <el-form-item
          :label="$t('user.label.password_confirmation')"
          :class="{'el-form-item is-error': form.errors.has('password_confirmation') }"
        >
          <el-input
            v-model="modelForm.password_confirmation"
            autocomplete="off"
            type="password"
          />
          <div
            v-if="form.errors.has('password_confirmation')"
            class="el-form-item__error"
            v-text="form.errors.first('password_confirmation')"
          />
        </el-form-item>
      </el-form>

      <span
        slot="footer"
        class="dialog-footer"
      >
        <el-button @click="changePassDialogVisible = false">  {{ $t('mon.button.cancel') }}</el-button>
        <el-button
          type="primary"
          @click="changePassword"
        > {{ $t('mon.button.save') }}</el-button>
      </span>
    </el-dialog>

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
                {{ $t('user.tabs.data') }}
              </h3>
            </div>
            <div class="box-body">
              <el-form-item
                :label="$t('user.label.username')"
                :class="{'el-form-item is-error': form.errors.has('username') }"
              >
                <el-input v-model="modelForm.username" />
                <div
                  v-if="form.errors.has('username')"
                  class="el-form-item__error"
                  v-text="form.errors.first('username')"
                />
              </el-form-item>

              <el-form-item
                :label="$t('user.label.email')"
                :class="{'el-form-item is-error': form.errors.has('email') }"
              >
                <el-input
                  v-model="modelForm.email"
                  autocomplete="off"
                />
                <div
                  v-if="form.errors.has('email')"
                  class="el-form-item__error"
                  v-text="form.errors.first('email')"
                />
              </el-form-item>
              <el-form-item
                :label="$t('user.label.name')"
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
                :label="$t('user.label.phone')"
                :class="{'el-form-item is-error': form.errors.has('phone') }"
              >
                <el-input
                  v-model="modelForm.phone"
                  autocomplete="off"
                />
                <div
                  v-if="form.errors.has('phone')"
                  class="el-form-item__error"
                  v-text="form.errors.first('phone')"
                />
              </el-form-item>

              <el-form-item
                :label="$t('user.label.status')"
                :class="{'el-form-item is-error': form.errors.has('status') }"
              >
                <el-select
                  v-model="modelForm.status"
                  :placeholder="$t('user.label.status')"
                  filterable
                >
                  <el-option
                    v-for="item in listStatus"
                    :key="'type'+ item.value"
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

              <div v-if="modelForm.is_new">
                <el-form-item
                  :label="$t('user.label.password')"
                  :class="{'el-form-item is-error': form.errors.has('password') }"
                >
                  <el-input
                    v-model="modelForm.password"
                    autocomplete="off"
                    type="password"
                  />
                  <div
                    v-if="form.errors.has('password')"
                    class="el-form-item__error"
                    v-text="form.errors.first('password')"
                  />
                </el-form-item>
                <el-form-item
                  :label="$t('user.label.password_confirmation')"
                  :class="{'el-form-item is-error': form.errors.has('password_confirmation') }"
                >
                  <el-input
                    v-model="modelForm.password_confirmation"
                    autocomplete="off"
                    type="password"
                  />
                  <div
                    v-if="form.errors.has('password_confirmation')"
                    class="el-form-item__error"
                    v-text="form.errors.first('password_confirmation')"
                  />
                </el-form-item>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">
                {{ $t('user.tabs.roles') }}
              </h3>
              <el-checkbox
                v-model="checkAll"
                style="margin-bottom:20px"
                :indeterminate="isIndeterminate"
                border
                size="medium"
                @change="handleCheckAllChange"
              >
                {{ $t('mon.all') }}
              </el-checkbox>
            </div>
            <div class="box-body">
              <el-checkbox-group
                v-model="modelForm.roles"
                @change="handleCheckedChange"
              >
                <el-checkbox
                  v-for="item in roles"
                  :key="'role-'+ item.id"
                  :label="item.id"
                  border
                  size="medium"
                >
                  {{ item.name }}
                </el-checkbox>
              </el-checkbox-group>
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
        email: '',
        phone: '',
        username: '',
        roles: [1],
        is_new: false,
        status: 'active'

      },
      roles: [],
      checkAll: false,
      isIndeterminate: true,
      changePassDialogVisible: false,
      listStatus: [
        {
          value: 'active',
          label: 'active'
        },
        {
          value: 'inactive',
          label: 'inactive'
        }
      ]
    }
  },
  computed: {},
  mounted () {
    this.fetchData()
    this.fetchRoles()
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
          this.$router.push({ name: 'admin.auth.users.index' })
        })
        .catch((error) => {
          this.loading = false
          this.$notify.error({
            title: 'Error',
            message: this.getSubmitError(this.form.errors)
          })
        })
    },
    changePassword () {
      this.changepassForm = new Form({
        password: this.modelForm.password,
        password_confirmation: this.modelForm.password_confirmation
      })
      this.loadingPassword = true

      this.changepassForm.post(route('api.auth.users.change-password', { user: this.$route.params.userId }))
        .then((response) => {
          this.loadingPassword = false
          this.$message({
            type: 'success',
            message: response.message
          })
          this.changePassDialogVisible = false
        })
        .catch((error) => {
          console.log(error)
          this.loadingPassword = false
          this.$notify.error({
            title: 'Error',
            message: 'There are some errors in the form.'
          })
        })
    },
    onCancel () {
      this.$confirm('Are you sure to cancel?', {
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        type: 'warning'
      }).then(() => {
        this.$router.push({ name: 'admin.auth.users.index' })
      }).catch(() => {

      })
    },

    fetchData () {
      let routeUri = ''
      if (this.$route.params.userId !== undefined) {
        this.loading = true
        routeUri = route('api.auth.users.find', { user: this.$route.params.userId })
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

    fetchRoles () {
      axios.get(route('api.auth.roles.all'))
        .then((response) => {
          this.roles = response.data.data
        })
    },
    getRoute () {
      if (this.$route.params.userId !== undefined) {
        return route('api.auth.users.update', { user: this.$route.params.userId })
      }
      return route('api.auth.users.store')
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

</style>
