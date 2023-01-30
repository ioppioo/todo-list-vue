import Auth from "./views/Auth.vue"
import Login from "./views/Login.vue"
import BoardsList from "./views/BoardsList.vue"
import TaskLists from "./views/TaskLists.vue"
import EditBoard from "./views/EditBoard.vue"
import EditTaskList from "./views/EditTaskList.vue"

export default [
    {
        path: '/signup',
        component: Auth,
        name: 'SignUp'
    },

    {
        path: '/login',
        component: Login,
        name: 'Login'
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
        component: TaskLists,
    },

    {
        path: '/boards/create',
        component: EditBoard
    },

    {
        path: '/boards/:id/edit',
        component: EditBoard
    },

    {
        path: '/task-lists',
        component: TaskLists
    },

    {
        path: '/task-lists/create',
        component: EditTaskList
    },

    {
        path: '/task-lists/:id/edit',
        component: EditTaskList
    },

    {
        path: '/tasks',
        component: TaskLists
    },
]
