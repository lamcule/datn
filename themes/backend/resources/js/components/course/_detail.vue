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
                {{ course.name }}
              </h3>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>CODE</b> <a
                    class="pull-right badge"
                    :style="'background-color:' + '#D81B60'"
                  >{{ course.code }}</a>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('course.label.description') }}</b>
                  <p>{{ course.description }}</p>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('course.label.type') }}</b>
                  <span
                    class="badge"
                    :style="'background-color:' + typeColor(course)"
                  >
                    {{ course.type }}
                  </span>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('course.label.area') }}</b> <a class="pull-right">{{ course.area }}</a>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('course.label.frequency') }}</b>
                  <span
                    class="badge"
                    :style="'background-color:' + frequencyColor(course)"
                  >
                    {{ course.frequency }}
                  </span>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('course.label.role') }}</b>
                  <span
                    class="badge"
                    :style="'background-color:' + roleColor(course)"
                  >
                    {{ course.role }}
                  </span>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('course.label.project') }}</b>
                  <span
                    class="badge"
                    :style="'background-color:' + projectColor(course)"
                  >
                    {{ course.project }}
                  </span>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('course.label.scale') }}</b>
                  <span
                    class="badge"
                    :style="'background-color:' + scaleColor(course)"
                  >
                    {{ course.scale }}
                  </span>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('course.label.object') }}</b>
                  <span
                    class="badge"
                    :style="'background-color:' + objectColor(course)"
                  >
                    {{ course.object }}
                  </span>
                </li>
                <li class="list-group-item">
                  <b>{{ $t('course.label.status') }}</b>
                  <span
                    class="badge"
                    :style="'background-color:' + statusColor(course)"
                  >
                    {{ course.status }}
                  </span>
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
import axios from 'axios'

export default {
  props: {
    locales: { default: null },
    pageTitle: { default: null, String },
    course: { default: {} }
  },

  data () {
    return {}
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
    },
    typeColor (course) {
      if (course.type == 'class') {
        return '#ff851b'
      } else if (course.type == 'series') {
        return '#00c0ef'
      } else if (course.type == 'event') {
        return '#3c8dbc'
      } else {
        return '#39CCCC'
      }
    },
    roleColor (course) {
      if (course.role == 'co-organizer') {
        return '#605ca8'
      } else if (course.role == 'organizer') {
        return '#D81B60'
      } else {
        return '#f56954'
      }
    },
    frequencyColor (course) {
      if (course.frequency == 'once') {
        return '#00a65a'
      } else if (course.frequency == 'periodic') {
        return '#00c0ef'
      } else {
        return '#D81B60'
      }
    },
    projectColor (course) {
      if (course.project == 'NISD') {
        return '#00a65a'
      } else if (course.project == 'EDP') {
        return '#00c0ef'
      } else if (course.project == 'IE') {
        return '#f56954'
      } else {
        return '#D81B60'
      }
    },
    scaleColor (course) {
      if (course.scale == 'under_30') {
        return '#00a65a'
      } else if (course.scale == 'under_50') {
        return '#00c0ef'
      } else if (course.scale == 'under_100') {
        return '#f56954'
      } else {
        return '#D81B60'
      }
    },
    objectColor (course) {
      if (course.object == 'Founder-Entrepreneur') {
        return '#00a65a'
      } else if (course.object == 'mentor') {
        return '#00c0ef'
      } else if (course.object == 'provincial') {
        return '#ff851b'
      } else if (course.object == 'student') {
        return '#605ca8'
      } else {
        return '#D81B60'
      }
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
