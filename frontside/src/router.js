import Vue from 'vue'
import Router from 'vue-router'
/*login page*/
import Login from './views/Login.vue'

Vue.use(Router)
export default new Router({
  routes: [
    {
      path: '/',
      name: 'newprods',
      meta: { label: "Новые товары" },
      component: () => import('./views/Newprods.vue')
    },
    {
      path: '/list-prods',
      name: 'listprods',
      meta: { label: "Список товаров" },
      component: () => import('./views/Listprods.vue')
    },
    {
      path: '/sections',
      name: 'sections',
      meta: { label: "Разделы" },
      component: () => import('./views/Sections.vue')
    },
    {
      path: '/brands',
      name: 'brands',
      meta: { label: "Бренды" },
      component: () => import('./views/Brands.vue')
    },
    {
      path: '/prod-form',
      name: 'form',
      meta: { label: "Форма выпуска" },
      component: () => import('./views/Form.vue')
    },
    {
      path: '/mnn',
      name: 'mnn',
      meta: { label: "МНН" },
      component: () => import('./views/Mnn.vue')
    },
    {
      path: '/description',
      name: 'description',
      meta: { label: "Описания" },
      component: () => import('./views/Description.vue')
    },

    /*login layout*/
    {
      path: '/login',
      name: 'login',
      meta: { label: "Логин", layout: "login" },
      component: Login,
    },
  ]
})
