const App = () => import("../pages/App.vue");
const Home = () => import("../pages/Home/Index.vue");
const Login = () => import("../pages/Login/Index.vue");
const Category = () => import("../pages/Category/Index.vue");
const Product = () => import("../pages/Product/Index.vue");
const Cart = () => import("../pages/Cart/Index.vue");

const routes = [
    {
        path: "/",
        component: App,
        children: [
            {
                path: "",
                name: "home",
                component: Home,
            },
            {
                path: "login",
                name: "login",
                component: Login,
            },
            {
                path: "category/:id",
                name: "category",
                component: Category,
            },
            {
                path: "product/:id",
                name: "product",
                component: Product,
            },
            {
                path: "cart",
                name: "cart",
                component: Cart,
                requireAuth: true,
            },
        ],
    },
];

export default routes;
