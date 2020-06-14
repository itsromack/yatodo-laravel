<template>
    <div>
        <form class="form-inline">
          <div class="form-group">
            <input class="form-control" placeholder="{{ value }}" size="100" v-model="new_item"></input>
          </div>
          <button type="button" class="btn btn-primary" @click="addNewTask">
              <i class="fa fa-plus"></i>
              Add New Task
          </button>
        </form>
    </div>
</template>

<script>
window.axios = require('axios');

import TodoList from './TodoList.vue';

export default {
    data() {
        return {
            value: 'What needs to be done?',
            new_item: ''
        }
    },
    methods: {
        addNewTask() {
            window.axios.post('/api/tasks', {
                item: this.new_item
            })
            .then(response => {
                console.log(response);
                TodoList.tasks.push(response.task);
            });
        }
    },
    components: { TodoList }
}
</script>