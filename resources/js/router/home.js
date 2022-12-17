const App = () => import("../pages/App.vue");
const Home = () => import("../pages/Home/Index.vue");
const Login = () => import("../pages/Login/Index.vue");
const Category = () => import("../pages/Category/Index.vue");
const Product = () => import("../pages/Product/Index.vue");
const Cart = () => import("../pages/Cart/Index.vue");
const Order = () => import("../pages/Order/Index.vue");
const OrderDetail = () => import("../pages/Order/Detail.vue");
const Account = () => import("../pages/Account/index.vue");


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
                meta: {
                    requireAuth: true,
                },
            },
            {
                path: "order",
                name: "order",
                component: Order,
                meta: {
                    requireAuth: true,
                },
            },
            {
                path: "order/:id",
                name: "order-detail",
                component: OrderDetail,
                meta: {
                    requireAuth: true,
                },
            },
            {
                path: "account",
                name: "account",
                component: Account,
                meta: {
                    requireAuth: true,
                },
            }
        ],
    },
];

export default routes;
