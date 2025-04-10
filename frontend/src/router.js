import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from './views/dashboard.vue'

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
