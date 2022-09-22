const Admin = () => import("../admin/App.vue");
const Dashboard = () => import("../admin/Dashboard/Index.vue");
const Login = () => import("../admin/Login/Index.vue");

const routes = [
    {
        path: "/admin",
        component: Admin,
        children: [
            {
                path: "",
                component: Dashboard,
                meta: {
                    title: "Admin",
                },
            },
            {
                path: "login",
                component: Login,
                meta: {
                    title: "Login",
                },
            },
        ],
    },
];

export default routes;
