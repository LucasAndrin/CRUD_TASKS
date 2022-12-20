import { createRouter, createWebHistory } from 'vue-router'

import Login from '@/components/Login.vue'

import Tasks from '@/views/Tasks.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/tasks',
      name: 'home',
      component: Tasks
    },
  ]
})

export default router
