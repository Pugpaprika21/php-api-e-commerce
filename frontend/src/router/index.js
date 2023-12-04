import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import ProductsHomeView from "../views/products/ProductsHomeView.vue";
import LoginView from "../views/user/LoginView.vue";
import RegisterView from "../views/user/RegisterView.vue";
import ProductListAllView from "../views/products/ProductListAllView.vue";

const router = createRouter({
    history: createWebHistory(
        import.meta.env.BASE_URL),
    routes: [{
            path: "/e-commerce/login",
            name: "login",
            component: LoginView,
        },
        {
            path: "/e-commerce/register",
            name: "register",
            component: RegisterView,
        },
        {
            path: "/e-commerce/home",
            name: "home",
            component: HomeView,
        },
        {
            path: "/e-commerce/product/home",
            name: "product-home",
            component: ProductsHomeView,
        },
        {
            path: "/e-commerce/product/all",
            name: "product-all",
            component: ProductListAllView,
        },
    ],
});

export default router;