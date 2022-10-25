import { createApp } from 'vue'
import './css/style-notes.css'
import './css/style-board-list.css'
import './css/style-auth.css'
import App from './App.vue'
import {createRouter, createWebHistory} from "vue-router";
import routes from "./routes.js";

const router = createRouter({
    history: createWebHistory(),
    routes,
})

createApp(App).use(router).mount('#app')
