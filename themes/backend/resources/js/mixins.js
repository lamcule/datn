import Vue from 'vue';

const mixin = {
    methods: {
        getSubmitError(error) {
            const firstPropValue = Object.values(error.errors)[0];
            return firstPropValue[0];
        },
    },
};
Vue.mixin(mixin);
