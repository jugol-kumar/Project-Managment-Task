import './bootstrap';

import Alpine from 'alpinejs';
import {createApp} from "vue";
import CreateProject from "./components/CreateProject.vue";
import ProjectList from "./components/ProjectList.vue";
import App from "./components/App.vue";
import UserApp from "./components/UserApp.vue";

window.Alpine = Alpine;

Alpine.start();

// Create a blank Vue app
const app = createApp(App);
app.mount('#create-vue');

const userApp = createApp(UserApp)
userApp.mount('#create-user')
