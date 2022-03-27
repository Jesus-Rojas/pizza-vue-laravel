import { createRouter, createWebHistory } from "vue-router";
import Layout from "@/layout/Layout.vue";
import Home from "@/views/Home.vue";
import Dashboard from "@/views/Dashboard.vue";
import Pizza from "@/views/Pizza.vue";
import Ingrediente from "@/views/Ingrediente.vue";
import Checkout from "@/views/Checkout.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
  },
  {
    path: "/checkout",
    name: "checkout",
    component: Checkout,
  },
  {
    path: "/dashboard",
    component: Layout,
    children: [
      {
        path: "",
        name: "dashboard",
        component: Dashboard,
      },
      {
        path: "pizza",
        name: "pizza",
        component: Pizza,
      },
      {
        path: "ingrediente",
        name: "ingrediente",
        component: Ingrediente,
      },
    ]
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
