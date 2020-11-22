<template>
    <div v-if="(alertMessage != '')" class="alert mt-2" :class="alertClass">{{alertMessage}}</div>
</template>

<script>
export default {
    props: {
        alertClass: String,
        alertMessage: String
    }
}
</script>