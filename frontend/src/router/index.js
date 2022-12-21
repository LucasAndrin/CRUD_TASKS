import { createRouter, createWebHistory } from 'vue-router'

import Authentication from '@/views/Authentication.vue'

import Home from '@/views/Home.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/authentication',
      name: 'Authentication',
      component: Authentication
    },
    {
      path: '/',
      name: 'Home',
      component: Home
    },
  ]
})

export default router
