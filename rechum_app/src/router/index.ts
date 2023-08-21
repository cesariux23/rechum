import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import SubContainer from '../components/SubContainer.vue'

//App
import AppLogin from '../components/site/AppLogin.vue'

// Personal
import ListaPersonal from '../components/personal/ListaPersonal.vue'
import RegistroPersonal from '../components/personal/RegistroPersonal.vue'
import DetallePersonal from '../components/personal/DetallePersonal.vue'
// sub rutas
import HistorialMovimientosView from "../components/personal/views/HistorialMovimientosView.vue"
import DatosPersonalesView from "../components/personal/views/DatosPersonalesView.vue"
import EditarPersonal from '../components/personal/EditarPersonal.vue'

// Nominas
import ListaNominas from '../components/nominas/ListaNominas.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  linkActiveClass: 'is-active',
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'AppLogin',
      component: AppLogin
    },
    {
      path: '/personal',
      component: SubContainer,
      children: [
        {
          path: '',
          name: 'ListaPersonal',
          component: ListaPersonal,
        },
        {
          path: 'registro',
          name: 'RegistroPersonal',
          component: RegistroPersonal
        },
        {
          path: ':rfc',
          name: 'DetallePersonal',
          component: DetallePersonal,
          children:[
            {
              path:'',
              name:'HistorialLaboral',
              component:HistorialMovimientosView,
              props: true
            },
            {
              path:'datospersonales',
              name:'DatosPersonales',
              component:DatosPersonalesView,
              props: true
            }
          ]
        },
        {
          path: ':rfc/editar',
          name: 'EditarPersonal',
          component: EditarPersonal
        },
      ]
    },
    {
      path: '/nominas',
      name: 'nominas',
      component: SubContainer,
      children: [
        {
          path: '',
          component: ListaNominas,
        },
      ],

    },
  ]
})

export default router
