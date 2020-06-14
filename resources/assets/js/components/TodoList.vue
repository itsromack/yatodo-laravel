<template>
    <form class="form-inline">
        <div class="form-group">
            <input class="form-control" placeholder="{{ newTodoPlaceholder }}" size="100" v-model="newTodo"></input>
        </div>
        <button type="button" class="btn btn-primary" @click="addNewTask">
            <i class="fa fa-plus"></i>
            Add New Task
        </button>
    </form>

    <share-list></share-list>

    <div v-for="task in tasks" class="panel panel-default">
        <div class="panel-heading" v-show="task.is_completed">
                Task Completed
                <remove-task task-id="{{ task.id }}" v-show="task.is_completed"></remove-task>
        </div>
        <div class="panel-body">
            <button class="btn btn-success btn-xs pull-right complete-task" v-show="!task.is_completed" @click="completeTask(task.id)">
                <i class="fa fa-check"></i>
                Complete Task
            </button>
            <div class="pull-right">
                <div v-if="!task.image" v-show="!task.is_completed">
                    <p>Select an image</p>
                    <input type="file" @change="onFileChange" data-task-id="{{ task.id }}">
                </div>
                <div v-else>
                    <img :src="image" />
                </div>
            </div>
            {{ task.item }}
            <br>
            <small style="color: #ccc">
                Date Added: {{ task.created_at }}
            </small>
        </div>
    </div>
</template>

<script>

window.axios = require('axios');

export default {
    data() {
        this.getMyTasks();
        return {
            tasks: [],
            newTodo: '',
            newTodoPlaceholder: 'What needs to be done?'
        }
    },
    methods: {
        getMyTasks() {
            window.axios.get('/api/tasks/lists/' + window.auth_id)
                .then((response) => {
                    this.tasks = response.data.tasks;
                });
        },
        addNewTask() {
            window.axios.post('/api/tasks', {
                item: this.newTodo
            })
            .then(response => {
                var newTask = response.data.task;
                this.tasks.unshift(newTask);
                this.newTodo = ''; // clear
            });
        },
        completeTask(id) {
            window.axios.post('/api/tasks/complete', {
                task_id: id
            })
            .then(response => {
                this.tasks.forEach((item, i) => {
                    if (item.id == id) {
                        item.is_completed = response.data.task.is_completed;
                    }
                });
            });
        },
        onFileChange(e, id) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            var taskId = e.target.dataset.taskId;
            this.createImage(files[0], taskId);
        },
        createImage(file, id) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = (e) => {
                vm.image = e.target.result;
                vm.tasks.forEach((item, i) => {
                    if (item.id == id) {
                        item.image = e.target.result;
                    }
                });
            };
            reader.readAsDataURL(file);
        }
    }
};
</script>

<style>
img {
    width: 30%;
    margin: auto;
    display: block;
    margin-bottom: 10px;
}
</style>