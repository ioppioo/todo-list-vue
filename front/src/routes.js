import Auth from "./views/Auth.vue"
import Login from "./views/Login.vue"
import BoardsList from "./views/BoardsList.vue"
import TaskLists from "./views/TaskLists.vue"

export default [
    {
        path: '/signup',
        component: Auth
    },

    {
        path: '/login',
        component: Login
    },

    {
        path: '/boards',
        component: BoardsList
    },

    {
        path: '/logout',
        component: BoardsList
    },

    {
        path: '/boards/:id',
        component: TaskLists, BoardsList
    },


]