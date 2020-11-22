<template>
    <button class="btn" :class="{btnClass:btnClass, 'btn-loading':loading}" type="button" :disabled="loading">
        <slot/>
    </button>
</template>

<script>
export default {
    props: {
        btnText: {
            default: '',
            type: String
        },
        btnClass: {
            default: '',
            type: String
        },
        loading: {
            default: false,
            type: Boolean
        },
        height: String,
        width: String
    },
    methods: {

    }
}
</script>

<style lang="scss" scoped>


</style>