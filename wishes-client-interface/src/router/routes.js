
const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('pages/Index.vue') }
    ]
  },

  {
    path: '/auth',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', alias: 'login', component: () => import('pages/Auth/LoginPage.vue') },
      { path: 'register', component: () => import('pages/Auth/RegisterPage.vue') }
    ]
  },

  {
    path: '/wishes',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', alias: 'self', component: () => import('pages/Wishes/Self/SelfPage.vue') },
      { path: 'self', component: () => import('pages/Wishes/Self/SelfPage.vue') }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
