<template>
    <div>

        <div class="content-header">

            <el-breadcrumb separator="/">
                <el-breadcrumb-item>
                    <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
                </el-breadcrumb-item>
                <el-breadcrumb-item :to="{name: 'admin.auth.users.index'}">{{ $t('user.label.users') }}
                </el-breadcrumb-item>
                <el-breadcrumb-item> {{ $t(pageTitle) }}
                </el-breadcrumb-item>
            </el-breadcrumb>

        </div>

        <data-form :locales="locales" :page-title="pageTitle"/>


    </div>

</template>

<script>
  import DataForm from './form';

  export default {
    props: {
      locales: {default: null},
      pageTitle: {default: null, String},
    },
    components: {
      DataForm
    },
    data() {
      return {};
    },
    methods: {},
    mounted() {


    },
    computed: {}
  }
</script>

<style scoped>

</style>