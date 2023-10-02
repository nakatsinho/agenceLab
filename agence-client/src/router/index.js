import { createRouter, createWebHistory } from 'vue-router'
// import AuthScopeVue from '../AuthScope.vue'
// import AppScopeVue from '../AppScope.vue'


import DashboardView from '../views/DashboardView.vue'

import ConsultantView from '../views/consultor/View.vue'
import ConsultantDetails from '../views/consultor/ConsultantDetails.vue'
import ConsultantPieDetails from '../views/consultor/PieDetails.vue'
import ConsultantBarDetails from '../views/consultor/BarDetails.vue'

import ClientView from '../views/cliente/View.vue'
import ClientDetails from '../views/cliente/ClientDetails.vue'
import ClientPieDetails from '../views/cliente/PieDetails.vue'
import ClientBarDetails from '../views/cliente/BarDetails.vue'

// const routes = [
//   {
//     path: '/',
//     component: AppScopeVue,
//     children: [
//       {
//         path: '',
//         name: 'dashboard',
//         component: DashboardView
//       }
//     ]
//   },
//   {
//     path: '/auth',
//     component: AuthScopeVue,
//     children: [
//       {
//         path: 'login',
//         name: 'login',
//         component: HomeView
//       }
//     ]
//   }
// ]
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: DashboardView
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: DashboardView
    },
    {
      path: '/consultant',
      name: 'consultant',
      component: ConsultantView
    },
    {
      path: '/consultant/:id',
      name: 'ConsultantDetails',
      component: ConsultantDetails,
    },
    {
      path: '/pie-chart/:id',
      name: 'ConsultantPieDetails',
      component: ConsultantPieDetails,
    },
    {
      path: '/bar-chart/:id',
      name: 'ConsultantBarDetails',
      component: ConsultantBarDetails,
    },
    {
      path: '/client',
      name: 'client',
      component: ClientView
    },
    {
      path: '/client/:id',
      name: 'ClientDetails',
      component: ClientDetails
    },
    {
      path: '/pie-chart-client/:id',
      name: 'ClientPieDetails',
      component: ClientPieDetails
    }
    ,
    {
      path: '/bar-chart-client/:id',
      name: 'ClientBarDetails',
      component: ClientBarDetails
    }
  ]
})

export default router
