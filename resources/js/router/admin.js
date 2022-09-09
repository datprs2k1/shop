const Admin = () => import("../admin/App.vue");
const Home = () => import("../admin/Home/Index.vue");

const routes = [
    {
        path: "/admin",
        component: Admin,
        children: [
            {
                path: "",
                component: Home,
                meta: {
                    title: "Admin",
                },
            },
        ],
    },
];

export default routes;
