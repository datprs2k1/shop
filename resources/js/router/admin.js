const Admin = () => import("../admin/App.vue");
const Dashboard = () => import("../admin/Dashboard/Index.vue");
const Test = () => import("../admin/Test/Index.vue");

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
                path: "test",
                component: Test,
                meta: {
                    title: "Test",
                },
            },
        ],
    },
];

export default routes;
