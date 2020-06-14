<template>
    <button class="btn btn-success pull-right">
        <i class="fa fa-check"></i>
        {{ title }}
    </button>
</template>

<script>
export default {
    data() {
        return {
            title: 'Complete Task'
        }
    }
}
</script>