<template>
  <el-button
    type="danger"
    size="mini"
    @click="deleteRow"
  >
    <i class="fa fa-trash" />
  </el-button>
</template>

<script>
export default {
  props: {
    rows: { default: null },
    scope: { default: null }
  },
  data () {
    return {
      deleteMessage: '',
      deleteTitle: ''
    }
  },
  mounted () {
    this.deleteMessage = this.$t('mon.modal.confirmation-message')
    this.deleteTitle = this.$t('mon.modal.title')
  },
  methods: {
    deleteRow (event) {
      this.$confirm(this.deleteMessage, this.deleteTitle, {
        confirmButtonText: this.$t('mon.button.delete'),
        cancelButtonText: this.$t('mon.button.cancel'),
        type: 'warning',
        confirmButtonClass: 'el-button--danger'
      }).then(() => {
        const vm = this
        axios.delete(this.scope.row.urls.delete_url)
          .then((response) => {
            if (response.data.errors === false) {
              vm.$message({
                type: 'success',
                message: response.data.message
              })

              vm.rows.splice(vm.scope.$index, 1)
            } else {
              vm.$message({
                type: 'error',
                message: response.data.message
              })
            }
          })
          .catch((error) => {
            let msg = error.response.data.message;
            if ( error.response.status = 403) {
              msg = this.$t('mon.message.permission_denied')
            }

            vm.$message({
              type: 'error',
              message: msg
            })
          })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: this.$t('mon.delete cancelled')
        })
      })
    }
  }
}
</script>
