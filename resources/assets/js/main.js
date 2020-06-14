window.Vue = require('vue');

Vue.component('todo-list', require('./components/TodoList.vue'));
Vue.component('share-list', require('./components/ShareList.vue'));
Vue.component('upload-image', require('./components/UploadImage.vue'));
Vue.component('complete-task', require('./components/CompleteTask.vue'));
Vue.component('remove-task', require('./components/RemoveTask.vue'));

window.auth_id = parseInt(document.querySelector('#app').dataset.userId);

window.app = new Vue({
    el: "#app"
});