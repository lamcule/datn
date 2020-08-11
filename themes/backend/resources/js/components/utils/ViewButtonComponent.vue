<template>
    <el-button
            size="mini"
            @click.prevent="goToViewPage()">
        <i class="fa fa-eye"></i>
    </el-button>
</template>

<script>
    export default {
        props: {
            to: { type: Object, required: true },
        },
        methods: {
            goToViewPage() {
                this.$router.push(this.to);
            },
        },
    };
</script>
