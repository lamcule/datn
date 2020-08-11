<template>
    <div>
        <full-calendar :config="config" :events="events" @event-selected="eventSelected"/>
        <el-dialog
                :title="lessonDialogContent.title"
                :visible.sync="showLessonDialog"
                width="30%">

        <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="showLessonDialog=false">close</el-button>
        </span>
        </el-dialog>
    </div>

</template>

<script>
  import moment from 'moment'


  export default {

    props: {
      locales: {default: null},
      pageTitle: {default: null, String},
    },
    data() {
      return {
        showLessonDialog: false,
        lessonDialogContent: {},
        config: {
          defaultView: 'month',
           
        },
        events: [
          {
            title: 'test',
            allDay: true,
            start: moment(),
            end: moment().add(1, 'd'),
          },
          {
            title: 'another test',
            start: moment().add(2, 'd'),
            end: moment().add(2, 'd').add(2, 'h'),
          },
        ],
      };
    },
    methods: {
      eventSelected: function(event) {
        this.showLessonDialog = true
        this.lessonDialogContent = event
      }
    },
    mounted() {


    },
    computed: {}
  }
</script>

<style scoped>

</style>