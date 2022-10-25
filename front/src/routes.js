import Auth from "./views/Auth.vue"
import BoardsList from "./views/BoardsList.vue"

export default [
    {
        path: "/auth",
        component: Auth
    },
    {
        path: "/boards",
        component: BoardsList
    }
]