import { createRouter, createWebHistory } from 'vue-router';
import Layout from '@/layout/Layout.vue';
import NavClient from "@/components/NavClient";
import Home from '@/views/Home.vue';
import Dashboard from '@/views/Dashboard.vue';
import Pizza from '@/views/Pizza.vue';
import Ingrediente from '@/views/Ingrediente.vue';
import Checkout from '@/views/Checkout.vue';
import Pedidos from '@/views/Pedidos.vue';
import utility from '@/utility';

const routes = [
  {
    path: '/dashboard',
    component: Layout,
    meta: { requiresAuth: true},
    children: [
      {
        path: '',
        name: 'dashboard',
        component: Dashboard,
      },
      {
        path: 'pizza',
        name: 'pizza',
        component: Pizza,
      },
      {
        path: 'ingrediente',
        name: 'ingrediente',
        component: Ingrediente,
      },
      {
        path: 'pedidos',
        name: 'pedidos',
        component: Pedidos,
      },
    ]
  },
  {
    path: '/',
    component: NavClient,
    children: [
      {
        path: '',
        name: 'home',
        component: Home,
      },
      {
        path: 'checkout',
        name: 'checkout',
        component: Checkout,
      },
    ]
    
  },
  
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});



router.beforeEach((to, from, next) => {
  const { payload, exist } = utility.getToken();
  if ( to.meta.requiresAuth && !exist ) {
    return next({ name: 'home'})
  } else if ( to.meta.requiresAuth && exist ) {
    if (payload.roles_id == 1) {
      return next()
    }
    return next({ name: 'home'})
  }
  return next()
})

export default router;
