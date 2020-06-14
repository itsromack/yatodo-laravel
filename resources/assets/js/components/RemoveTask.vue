<template>
    <button class="btn btn-danger btn-xs pull-right">
        <i class="fa fa-trash"></i>
        {{ title }}
    </button>
</template>

<script>
export default {
    data() {
        return {
            title: 'Remove Task'
        }
    }
}
</script>