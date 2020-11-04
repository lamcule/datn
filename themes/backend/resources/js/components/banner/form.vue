<template>
    <div>
        <div class="content-header">
            <h1> {{ $t(pageTitle) }}</h1>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.banner.index'}">
                    {{ $t('banner.label.manage_banner') }}
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
                                {{ $t('banner.box.banner information') }}
                            </h3>
                        </div>
                        <div class="box-body">
                            <el-form-item
                                :label="$t('banner.label.title')"
                                :class="{'el-form-item is-error': form.errors.has('title') }"
                            >
                                <el-input v-model="modelForm.title"/>
                                <div
                                    v-if="form.errors.has('title')"
                                    class="el-form-item__error"
                                    v-text="form.errors.first('title')"
                                />
                            </el-form-item>
                            <el-form-item
                                :label="$t('banner.label.image')"
                                :class="{'el-form-item is-error': form.errors.has('image') }"
                            >
                                <single-media
                                    zone="banner"
                                    entity="banner"
                                    hint="  "
                                    @singleFileSelected="selectSingleFile($event, 'modelForm.image')"
                                    @fileSorted="fileSorted($event, 'modelForm.image')"
                                />
                                <div
                                    v-if="form.errors.has('image')"
                                    class="el-form-item__error"
                                    v-text="form.errors.first('image')"
                                />
                            </el-form-item>
                            <el-form-item
                                :label="$t('banner.label.link')"
                                :class="{'el-form-item is-error': form.errors.has('link') }"
                            >
                                <el-input v-model="modelForm.link"/>
                                <div
                                    v-if="form.errors.has('link')"
                                    class="el-form-item__error"
                                    v-text="form.errors.first('link')"
                                />
                            </el-form-item>
                            <el-form-item
                                :label="$t('banner.label.position')"
                                :class="{'el-form-item is-error': form.errors.has('position') }"
                            >
                                <el-input type="number" v-model="modelForm.position"/>
                                <div
                                    v-if="form.errors.has('position')"
                                    class="el-form-item__error"
                                    v-text="form.errors.first('position')"
                                />
                            </el-form-item>
                            <el-form-item
                                :label="$t('banner.label.status')"
                                :class="{'el-form-item is-error': form.errors.has('status') }"
                            >
                                <el-select
                                    v-model="modelForm.status"
                                    filterable
                                    :placeholder="$t('banner.label.status')"
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
import SingleMedia from '../media/js/components/SingleMedia'
import SingleFileSelector from '../../mixins/SingleFileSelector'

export default {
    components: {
        SingleMedia
    },
    mixins: [SingleFileSelector],
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
                title: '',
                image: '',
                link: '',
                position: 0,
                status: 'active',
                is_new: false,

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
                    this.$router.push({name: 'admin.banner.index'})
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
                this.$router.push({name: 'admin.banner.index'})
            }).catch(() => {

            })
        },

        fetchData() {
            let routeUri = ''
            if (this.$route.params.bannerId !== undefined) {
                this.loading = true
                routeUri = route('api.banner.find', {banner: this.$route.params.bannerId})
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
            if (this.$route.params.bannerId !== undefined) {
                return route('api.banner.update', {banner: this.$route.params.bannerId})
            }
            return route('api.banner.store')
        },

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
