<template>
    <div>
        <div
            v-if="lesson && lesson.grade"
            class="content-header"
        >
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.course.index'}">
                    {{ $t('course.label.manage_course') }}
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.course.view', params: {courseId: lesson.course_id}}">
                    {{ lesson.grade.course_name }}
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.grade.view', params: {gradeId: lesson.grade_id}}">
                    {{ lesson.grade.name }}
                </el-breadcrumb-item>
                <el-breadcrumb-item>
                    {{ lesson.name }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div class="row">
            <div class=" col-md-12">
                <div class="box box-widget">
                    <div
                        class="box-body"
                        style="padding: 0px;display: flex;justify-content: space-around;"
                    >
                        <div style="display: flex;
    flex-direction: column;align-items: center;">
                            <p><label>{{ $t('lesson.label.checkin_qr') }}</label></p>
                            <el-button

                                type="primary"
                                icon="el-icon-printer"
                                @click="printQRCheckin"
                            >
                                In
                            </el-button>
                            <qrcode
                                :value="lesson.checkin_url"
                                :options="{ width: 120 }"
                            />
                        </div>
                        <div style="display: flex;
    flex-direction: column;align-items: center;">
                            <p><label>{{ $t('lesson.label.checkout_qr') }}</label></p>
                            <el-button

                                type="primary"
                                icon="el-icon-printer"
                                @click="printQRCheckout"
                            >
                                In
                            </el-button>
                            <qrcode
                                :value="lesson.checkout_url"
                                :options="{ width: 120 }"
                            />
                        </div>
                        <div style="display: flex;
    flex-direction: column;align-items: center;">
                            <p><label>{{ $t('lesson.label.review_qr') }}</label></p>
                            <el-button

                                type="primary"
                                icon="el-icon-printer"
                                @click="printQRReview"
                            >
                                In
                            </el-button>
                            <qrcode
                                :value="lesson.review_url"
                                :options="{ width: 120 }"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="row-left"
            style="padding-top: 10px; padding-bottom: 10px;"
        >
            <router-link
                :to="{name: 'admin.lesson.edit', params:{lessonId: lesson.id } ,query:{course: lesson.course_id, grade: lesson.grade_id}}">
                <el-button
                    type="primary"
                    size="small"
                    class="btn btn-flat"
                    icon="el-icon-edit"
                >
                    {{ $t('mon.button.update') }}
                </el-button>
            </router-link>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-widget">
                    <div
                        class="box-body"
                        style="padding: 0px"
                    >
                        <el-tabs
                            v-model="activeTab"
                            type="border-card home-tab-container"
                        >
                            <el-tab-pane
                                :label="$t('lesson.tabs.student')"
                                name="lesson"
                            >
                                <student-table/>
                            </el-tab-pane>
                            <el-tab-pane
                                :label="$t('lesson.tabs.detail')"
                                name="detail"
                            >
                                <lesson-detail :lesson="lesson"/>
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import lessonDetail from './_detail'
import StudentTable from './_student'

import VueQrcode from '@chenfengyuan/vue-qrcode'

export default {
    components: {
        lessonDetail,
        StudentTable,
        qrcode: VueQrcode
    },
    props: {
        locales: {default: null},
        pageTitle: {default: null, String}
    },
    data() {
        return {
            activeTab: 'lesson',
            sa: 0,
            lesson: {},
            tableIsLoading: false

        }
    },
    computed: {},
    mounted() {
        this.tableIsLoading = true
        axios.get(route('api.lesson.find', {lesson: this.$route.params.lessonId}))
            .then((response) => {
                this.tableIsLoading = false
                this.lesson = response.data.data
            })
    },
    methods: {
        printQRCheckin() {
            let url = route('admin.checkinqr', {lesson: this.$route.params.lessonId})
            window.open(url, "_blank");

        },
        printQRCheckout() {
            let url = route('admin.checkoutqr', {lesson: this.$route.params.lessonId})
            window.open(url, "_blank");
        },
        printQRReview() {
            let url = route('admin.reviewqr', {lesson: this.$route.params.lessonId})
            window.open(url, "_blank");
        }

    }
}
</script>

<style>
.el-tabs__nav {
    width: 100% !important;
}

/*.el-tabs__item {*/
/*width: 50% !important;*/
/*font-weight: bold !important;*/
/*}*/

.el-tabs__content {
    background-color: #ecf0f5;
}

.tab-description > > > .el-tabs > > > .el-tabs__content {
    background-color: #fff !important;
}

.block-header-title {
    font-size: 14px !important;
    font-weight: bold;
}
</style>
