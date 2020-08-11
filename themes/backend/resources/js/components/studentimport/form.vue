<template>
  <div>
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
                {{ $t('studentimport.box.upload file') }}
              </h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-4 col-md-offset-4">
                  <el-form-item
                    :label="$t('studentimport.label.path')"
                    :class="{'el-form-item is-error': form.errors.has('file') }"
                  >
                    <el-upload
                      ref="import_file"
                      class="upload-demo"
                      drag
                      accept=".xls, .xlsx"
                      name="file"
                      :headers="{'Authorization': 'Bearer ' + user_token}"
                      :action="uploadUrl"
                      :auto-upload="false"
                      :on-change="() => hasFile = true"
                      :on-remove="() =>  hasFile = false"
                      :on-success="handleUploadSuccess"
                      :on-error="handleUploadError"
                    >
                      <i class="el-icon-upload" />
                      <div class="el-upload__text">
                        Drop file here or <em>click to upload</em>
                      </div>
                      <div slot="tip" class="el-upload__tip"><a href="/templates/Sample Account Register.xlsx" target="_blank">{{$t('studentimport.label.download sample file')}}</a> </div>

                    </el-upload>
                    <div
                      v-if="form.errors.has('file')"
                      class="el-form-item__error"
                      v-text="form.errors.first('file')"
                    />
                  </el-form-item>
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
              @click="submitUpload()"

              :disabled="!hasFile"
            >
              {{ $t('studentimport.label.btnUpload') }}
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
      hasFile: false,
      form: new Form(),

      loading: false,

      modelForm: {
        file: ''

      },
      uploadUrl: route('api.studentimport.store'),
      user_token: window.MonCMS.user_token

    }
  },
  computed: {


  },
  mounted () {

  },
  methods: {

    onCancel () {
      this.$confirm('Are you sure to cancel?', {
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        type: 'warning'
      }).then(() => {
        this.$router.push({ name: 'admin.studentimport.index' })
      }).catch(() => {

      })
    },

    getRoute () {
      if (this.$route.params.userId !== undefined) {
        return route('api.studentimport.update', { user: this.$route.params.userId })
      }
      return route('api.studentimport.store')
    },
    submitUpload () {
      this.loading = true
      this.$refs.import_file.submit()
    },
    handleUploadSuccess (response) {
      this.loading = false
      this.$router.push({ name: 'admin.studentimport.view', params: { studentimport: response.import_id } })

    },
    handleUploadError (err) {
      this.loading = false
      console.log(err)
    }

  }
}
</script>

<style>

  .el-dropdown-link {
    cursor: pointer;
    color: #409EFF;
  }
  .el-icon-arrow-down {
    font-size: 12px;
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
  .el-upload{
    width: 100%;
  }
</style>
