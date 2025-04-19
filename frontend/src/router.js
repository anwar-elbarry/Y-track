import { createRouter, createWebHistory } from 'vue-router'
import auth from './stores/auth'
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
    meta : {requiresLogout : true},
    component: () => import('./views/Auth.vue')
  },
  {
    path : '/dashboard',
    name : 'Dashboard',
    meta : {requiresAuth : true},
    component : () => import('./views/dashboard.vue'),
    children : [
      {
        path : 'DashboardHome',
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
      {
        path : 'Expences',
        name : 'Expences',
        component : () => import('./views/Expences.vue')
      },
      {
        path : 'Bills',
        name : 'Bills',
        component : () => import('./views/Bills.vue')
      },
      {
        path : 'Transactions_History',
        name : 'Transactions_History',
        component : () => import('./views/Transictions_History.vue')
      },
      {
        path : 'Clients',
        name : 'Clients',
        component : () => import('./views/Clients.vue')
      },
      {
        path : 'ProfileSettings',
        name : 'ProfileSettings',
        component : () => import('./views/profile_settings.vue')
      },
      {
        path : 'Taxes',
        name : 'Taxes',
        component : () => import('./views/Taxes.vue')
      },
      {
        path : 'Invoices',
        name : 'Invoices',
        component : () => import('./views/invoices.vue')
      },
      {
        path : 'Reports',
        name : 'Reports',
        component : () => import('./views/reports.vue')
      },
      {
        path : 'notifications',
        name : 'notifications',
        component : () => import('./views/notifications.vue')
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

router.beforeEach(async (to,from,next) => {
  const user = localStorage.getItem("user");
      const token = localStorage.getItem("token");
  if(to.meta.requiresAuth){
    try{
      

      if (!user && !token){
        throw new Error("no user");
      }

      next()
    }catch(error){
      const {logout} = auth();
      logout();
      next('/auth')

    }
  }
  else if(to.meta.requiresLogout){
    if(user &&  token){
      next('/dashboard');
    }else{
      next();
    }
  }
  else{
    next()
  }
})

export default router
