<template>
  <div>
    <div class="content-header">
      <h1>{{ $t(pageTitle) }}</h1>
      <el-breadcrumb separator="/">
        <el-breadcrumb-item>
          <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
        </el-breadcrumb-item>
        <el-breadcrumb-item :to="{name: 'admin.studentimport.index'}">
          {{ $t('studentimport.label.header') }}
        </el-breadcrumb-item>
        <el-breadcrumb-item>
          {{ $t(pageTitle) }}
        </el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <data-form
      :locales="locales"
      :page-title="pageTitle"
    />
  </div>
</template>

<script>
import DataForm from './form'

export default {
  components: {
    DataForm
  },
  props: {
    locales: { default: null },
    pageTitle: { default: null, String }
  },
  data () {
    return {}
  },
  computed: {},
  mounted () {

  },
  methods: {}
}
</script>

<style scoped>

</style>
