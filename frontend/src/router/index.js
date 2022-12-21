import { createRouter, createWebHistory } from 'vue-router'

import Authentication from '@/views/Authentication.vue'


import Tasks from '@/views/Tasks.vue'
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
    {
      path: '/tasks',
      name: 'home',
      component: Tasks
    },
  ]
})

export default router
