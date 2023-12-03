import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import ProductsHomeView from "../views/products/ProductsHomeView.vue";

const router = createRouter({
    history: createWebHistory(
        import.meta.env.BASE_URL),
    routes: [{
            path: "/",
            name: "home",
            component: HomeView,
        },
        {
            path: "/product/home",
            name: "product-home",
            component: ProductsHomeView,
        },

        // {
        //     path: "/product/all",
        //     name: "product-all",
        //     component: ProductsHomeView,
        // },
    ],
});

export default router;