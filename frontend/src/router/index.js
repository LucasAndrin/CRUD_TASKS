import { createRouter, createWebHistory } from 'vue-router'

import Authentication from '@/views/Authentication.vue'


import Tasks from '@/views/Tasks.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Tasks',
      component: Tasks
    },
    {
      path: '/authentication',
      name: 'Authentication',
      component: Authentication
    },
    {
      path: '/tasks',
      name: 'home',
      component: Tasks
    },
  ]
})

export default router
