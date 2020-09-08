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
                                {{ $t('teacher.box.personal information') }}
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <el-form-item
                                        :label="$t('teacher.label.last_name')"
                                        :class="{'el-form-item is-error': form.errors.has('last_name') }"
                                    >
                                        <el-input v-model="modelForm.last_name"/>
                                        <div
                                            v-if="form.errors.has('last_name')"
                                            class="el-form-item__error"
                                            v-text="form.errors.first('last_name')"
                                        />
                                    </el-form-item>
                                </div>
                                <div class="col-md-6">
                                    <el-form-item
                                        :label="$t('teacher.label.first_name')"
                                        :class="{'el-form-item is-error': form.errors.has('first_name') }"
                                    >
                                        <el-input v-model="modelForm.first_name"/>
                                        <div
                                            v-if="form.errors.has('first_name')"
                                            class="el-form-item__error"
                                            v-text="form.errors.first('first_name')"
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
                                        :label="$t('teacher.label.address')"
                                        :class="{'el-form-item is-error': form.errors.has('address') }"
                                    >
                                        <el-input
                                            v-model="modelForm.address"
                                            autocomplete="off"
                                        />
                                        <div
                                            v-if="form.errors.has('address')"
                                            class="el-form-item__error"
                                            v-text="form.errors.first('address')"
                                        />
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <el-form-item
                                        :label="$t('teacher.label.birth_date')"
                                        :class="{'el-form-item is-error': form.errors.has('birth_date') }"
                                    >
                                        <el-date-picker
                                            v-model="modelForm.birth_date"
                                            value-format="yyyy-MM-dd"
                                            type="date"
                                            style="width: 100% !important"
                                            :placeholder="$t('teacher.label.birth_date')"
                                        />
                                        <div
                                            v-if="form.errors.has('birth_date')"
                                            class="el-form-item__error"
                                            v-text="form.errors.first('birth_date')"
                                        />
                                    </el-form-item>
                                </div>
                                <div class="col-md-6">
                                    <el-form-item
                                        :label="$t('teacher.label.gender')"
                                        :class="{'el-form-item is-error': form.errors.has('gender') }"
                                    >
                                        <el-select
                                            v-model="modelForm.gender"
                                            :placeholder="$t('teacher.label.gender')"
                                            style="width: 100% !important"
                                            filterable
                                        >
                                            <el-option
                                                v-for="item in listGender"
                                                :key="'type'+ item.value"
                                                :label="item.label"
                                                :value="item.value"
                                            />
                                        </el-select>

                                        <div
                                            v-if="form.errors.has('gender')"
                                            class="el-form-item__error"
                                            v-text="form.errors.first('gender')"
                                        />
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <single-media
                                        zone="user_photo"
                                        entity="user"
                                        hint="  "
                                        @singleFileSelected="selectSingleFile($event, 'modelForm')"
                                        @fileSorted="fileSorted($event, 'modelForm')"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                {{ $t('teacher.box.work information') }}
                            </h3>
                        </div>
                        <div class="box-body">
                            <el-form-item
                                :label="$t('teacher.label.email')"
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
                                :label="$t('teacher.label.phone')"
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
                                :label="$t('teacher.label.description')"
                                :class="{'el-form-item is-error': form.errors.has('description') }"
                            >
                                <el-input
                                    type="textarea"
                                    :rows="6"
                                    v-model="modelForm.description"
                                    autocomplete="off"
                                />
                                <div
                                    v-if="form.errors.has('description')"
                                    class="el-form-item__error"
                                    v-text="form.errors.first('description')"
                                />
                            </el-form-item>
                            <el-form-item
                                :label="$t('teacher.label.grade joined')"
                                :class="{'el-form-item is-error': form.errors.has('grade_ids') }"
                            >
                                <el-select
                                    v-model="modelForm.grade_ids"
                                    style="width: 100% !important"
                                    multiple
                                    filterable
                                    :placeholder="$t('teacher.label.grade joined')"
                                >
                                    <el-option
                                        v-for="item in grades"
                                        :key="'grade-'+ item.id"
                                        :label="item.name"
                                        :value="item.id"
                                    />
                                </el-select>
                                <div
                                    v-if="form.errors.has('grade_ids')"
                                    class="el-form-item__error"
                                    v-text="form.errors.first('grade_ids')"
                                />
                            </el-form-item>
                            <el-form-item
                                :label="$t('teacher.label.status')"
                                :class="{'el-form-item is-error': form.errors.has('status') }"
                            >
                                <el-select
                                    v-model="modelForm.status"
                                    filterable
                                    :placeholder="$t('teacher.label.status')"
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
    import SingleFileSelector from '../../mixins/SingleFileSelector'
    import SingleMedia from '../media/js/components/SingleMedia'

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
                    first_name: '',
                    middle_name: '',
                    last_name: '',
                    gender: '',
                    birth_date: '',
                    address: '',
                    company: '',
                    company_address: '',
                    categories: [],
                    personal_categories: [],
                    email: '',
                    position: '',
                    phone: '',
                    description: '',
                    username: '',
                    roles: [],
                    is_new: false,
                    status: 'active',
                    type: 'teacher',
                    province_id: null,
                    district_id: null,
                    phoenix_id: null,
                    grade_ids: null

                },
                roles: [],
                checkAll: false,
                isIndeterminate: true,
                changePassDialogVisible: false,
                categories: window.MonCMS.categories,
                personal_categories: window.MonCMS.personal_categories,
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
                listGender: [
                    {
                        value: 'male',
                        label: this.$t('student.label.male')
                    },
                    {
                        value: 'female',
                        label: this.$t('student.label.female')
                    },
                    {
                        value: 'other',
                        label: this.$t('student.label.other')
                    }
                ],
                provinces: [],
                districts: [],
                phoenixes: [],
                grades: []
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
            this.fetchData()
            this.fetchProvince()
            this.fetchDistrict()
            this.fetchPhoenix()
            this.fetchGrade()
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
                        this.$router.push({name: 'admin.teacher.index'})
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
                    this.$router.push({name: 'admin.teacher.index'})
                }).catch(() => {

                })
            },

            fetchData() {
                let routeUri = ''
                if (this.$route.params.userId !== undefined) {
                    this.loading = true
                    routeUri = route('api.teacher.find', {user: this.$route.params.userId})
                    axios.get(routeUri)
                        .then((response) => {
                            this.loading = false
                            this.modelForm = _.merge(response.data.data, response.data.data.profile)
                            this.modelForm.is_new = false
                        })
                } else {
                    this.modelForm.is_new = true
                }
            },

            getRoute() {
                if (this.$route.params.userId !== undefined) {
                    return route('api.teacher.update', {user: this.$route.params.userId})
                }
                return route('api.teacher.store')
            },
            handleCheckAllChange(val) {
                this.modelForm.roles = val ? this.roles.map(item => item.id) : []
                this.isIndeterminate = false
            },
            handleCheckedChange(value) {
                let checkedCount = value.length
                this.checkAll = checkedCount === this.roles.length
                this.isIndeterminate = checkedCount > 0 && checkedCount < this.roles.length
            },
            fetchProvince() {
                axios.get(route('api.province.index', {
                    page: 1,
                    per_page: 100000
                }))
                    .then((response) => {
                        this.provinces = response.data.data
                    })
            },
            fetchDistrict() {
                axios.get(route('api.district.index', {
                    page: 1,
                    per_page: 100000
                }))
                    .then((response) => {
                        this.districts = response.data.data
                    })
            },
            fetchPhoenix() {
                axios.get(route('api.phoenix.index', {
                    page: 1,
                    per_page: 100000
                }))
                    .then((response) => {
                        this.phoenixes = response.data.data
                    })
            },
            fetchGrade() {
                axios.get(route('api.grade.all'))
                    .then((response) => {
                        this.grades = response.data.data
                    })
            }
        }
    }
</script>

<style scoped>

</style>
