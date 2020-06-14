<template>
    <div class="row">
        <button class="btn btn-warning pull-right" style="margin: 15px 15px">
            <i class="fa fa-share"></i>
            {{ title }}
        </button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: 'Share my tasks list'
        }
    }
}
</script>