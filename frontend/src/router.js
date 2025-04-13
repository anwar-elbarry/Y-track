import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('./views/Home.vue'),
    // Add scrollBehavior to handle hash navigation
    meta: { scrollToTop: true }
  },
  {
    path: '/auth',
    name: 'Auth',
    component: () => import('./views/Auth.vue')
  },
  {
    path : '/dashboard',
    name : 'Dashboard',
    component : () => import('./views/dashboard.vue'),
    children : [
      {
        path : '',
        name : 'DashboardHome',
        component : () => import('./views/DashboardHome.vue')
      },
      {
        path : 'Goals',
        name : 'Goals',
        component : () => import('./views/Goals.vue')
      },
      {
        path : 'Incomes',
        name : 'Incomes',
        component : () => import('./views/incomes.vue')
      },
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth'
      }
    }
    if (savedPosition) {
      return savedPosition
    }
    return { top: 0 }
  }
})

export default router
