import Auth from "./views/Auth.vue"
import Login from "./views/Login.vue"
import BoardsList from "./views/BoardsList.vue"

export default [
    {
        path: "/signup",
        component: Auth
    },

    {
        path: "/login",
        component: Login
    },

    {
        path: "/boards",
        component: BoardsList
    }
]