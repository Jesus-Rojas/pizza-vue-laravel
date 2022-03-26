import { createRouter, createWebHistory } from "vue-router";
import Home from "@/views/Home.vue";
import Dashboard from "@/views/Dashboard.vue";
import Pizza from "@/views/Pizza.vue";
import Ingrediente from "@/views/Ingrediente.vue";
import Layout from "@/layout/Layout.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
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
