import { createRouter, createWebHistory } from 'vue-router'
const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('./views/Home.vue'),
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
        path : 'Invoices',
        name : 'Invoices',
        component : () => import('./views/invoices.vue')
      },
      {
        path : 'notifications',
        name : 'Notifications',
        component : () => import('./views/notifications.vue')
      },
    ]
  },
  {
    path : '/admin',
    name : 'admin',
    meta : {requiresAdmin: true},
    component : () => import('./views/admin/dashboard.vue')
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

router.beforeEach(async (to, from, next) => {
  let user = null;
  const token = localStorage.getItem("token");
  const userStr = localStorage.getItem("user");
  
  if (userStr) {
    try {
      user = JSON.parse(userStr);
    } catch (e) {
      console.error("Error parsing user data", e);
    }
  }
  
  if (to.meta.requiresAdmin) {
    if (!user || !token) {
      next('/auth');
      return;
    }
    
    if (user.role !== 'admin') {
      console.log('Access denied: Admin role required');
      next('/dashboard');
      return;
    }
    
    next();
  }
  else if (to.meta.requiresAuth) {
    if (!user && !token) {
      next('/auth');
      return;
    }
    
    next();
  }
  else if (to.meta.requiresLogout) {
    if (user && token) {
      next('/dashboard');
    } else {
      next();
    }
  }
  else {
    next();
  }
});

export default router
