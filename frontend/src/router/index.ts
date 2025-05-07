import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import ToDoList from '../views/ToDoList.vue'


const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'home',
    component: ToDoList
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
