import { createRouter, createWebHistory } from 'vue-router'
import Tasks from '@/views/Tasks.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Tasks
    },
  ]
})

export default router
