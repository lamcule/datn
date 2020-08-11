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

                            <h3 class="profile-username text-center">{{ lesson.name }}</h3>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>{{ $t('lesson.label.content') }}</b>
                                    <div v-if="lesson.content">
                                        <ul>
                                            <li v-for="(item,idx) in lesson.content" :key="idx">
                                                <span style="margin-right: 10px">{{item.time}}:</span> <span>{{item.content}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ $t('lesson.label.topic') }}</b> <a class="pull-right">{{ lesson.topic }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ $t('lesson.label.target') }}</b> <a class="pull-right">{{ lesson.target }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ $t('lesson.label.document') }}</b> <a class="pull-right">{{ lesson.document }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ $t('lesson.label.start_time') }}</b> <a class="pull-right">{{ lesson.start_time }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ $t('lesson.label.end_time') }}</b> <a class="pull-right">{{ lesson.end_time }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{ $t('lesson.label.status') }}</b> <a class="pull-right badge"
                                                         :style="'background-color:' + statusColor(lesson)">{{
                                    lesson.status }}</a>
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
    props: ['lesson'],
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

<style scoped>

</style>
