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
                                <el-input v-model="modelForm.name"/>
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
                                        :label="$t('course.label.tuition')"
                                        :class="{'el-form-item is-error': form.errors.has('tuition') }"
                                    >
                                        <el-input v-model="modelForm.tuition" type="number"/>
                                        <div
                                            v-if="form.errors.has('tuition')"
                                            class="el-form-item__error"
                                            v-text="form.errors.first('tuition')"
                                        />
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <el-form-item
                                        :label="$t('course.label.content')"
                                        :class="{'el-form-item is-error': form.errors.has('content') }"
                                    >
                                        <ckeditor :editor="editor" v-model="modelForm.content"
                                                  :config="editorConfig"></ckeditor>
                                        <div
                                            v-if="form.errors.has('content')"
                                            class="el-form-item__error"
                                            v-text="form.errors.first('content')"
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
                            $t('mon.button.cancel')
                        }}
                    </el-button>
                </div>
            </div>
        </el-form>
    </div>
</template>

<script>
import axios from 'axios'
import Form from 'form-backend-validation'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    props: {
        locales: {default: null},
        pageTitle: {default: null, String}
    },
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {},
            form: new Form(),
            changepassForm: new Form(),
            loading: false,
            loadingPassword: false,
            modelForm: {
                name: '',
                description: '',
                type: '',
                area: '',
                scale: '',
                status: 'active',
                is_new: false,
                has_notification: true,
                has_email: true,
                content: '',

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
        }
    },
    computed: {},
    mounted() {
        this.fetchData()
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
                    this.$router.push({name: 'admin.course.index'})
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
                this.$router.push({name: 'admin.course.index'})
            }).catch(() => {

            })
        },

        fetchData() {
            axios.get(route('api.province.all'))
                .then((response) => {
                    this.listArea = response.data.data
                })
            let routeUri = ''
            if (this.$route.params.courseId !== undefined) {
                this.loading = true
                routeUri = route('api.course.find', {course: this.$route.params.courseId})
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

        getRoute() {
            if (this.$route.params.courseId !== undefined) {
                return route('api.course.update', {course: this.$route.params.courseId})
            }
            return route('api.course.store')
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
.ck-editor__editable {
    min-height: 500px !important;
}

.form--element__flex {
    display: flex;
    justify-content: space-between;
}
</style>
