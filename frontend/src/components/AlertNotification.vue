<template>
    <div class="alert alert-float fade" :class="{'alert-success':!error,'alert-danger':error,'in':show}">
        <strong>{{message}}</strong>
    </div>
</template>

<script>
export default {
    props: {
        show: {
            default: false,
            type: Boolean
        },
        message: {
            default: '',
            type: String
        },
        error: {
            default: true,
            type: Boolean
        }
    }
}
</script>