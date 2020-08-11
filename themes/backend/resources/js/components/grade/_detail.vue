<template>
  <div>
    <div class="box box-widget">
      <div
        class="box-body"
        style="padding: 0px"
      >
        <div class="row">
          <div class="col-md-12">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center">
                {{ grade.name }}
              </h3>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>CODE</b> <a class="pull-right badge" :style="'background-color:' + '#D81B60'">{{ grade.code }}</a>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('grade.label.course_id') }}</b> <a class="pull-right">{{ grade.course }}</a>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('grade.label.number_of_lesson') }}</b> <a class="pull-right">{{ grade.number_of_lesson }}</a>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('grade.label.place') }}</b> <a class="pull-right">{{ grade.place }}</a>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('grade.label.status') }}</b> <a class="pull-right badge" :style="'background-color:' + statusColor(grade)">{{ grade.status }}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: {
    grade: { default: {} }
  },

  data () {
    return {

    }
  },
  computed: {},
  mounted () {

  },
  methods: {
    statusColor (course) {
      if (course.status == 'active') {
        return '#00a65a'
      }
      return '#dd4b39'
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

    .tab-description >>> .el-tabs >>> .el-tabs__content {
        background-color: #fff !important;
    }

    .block-header-title {
        font-size: 14px !important;
        font-weight: bold;
    }
</style>
