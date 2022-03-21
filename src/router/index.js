import Vue from 'vue'
import VueRouter from 'vue-router'
import Meta from 'vue-meta'
import store from '@/store'

Vue.use(VueRouter)

  const routes = [
  {
    path: '*',
    meta: {
      name: '',
      requiresAuth: true
    },
    redirect: {
      path: '/dashboard'
    }
  },
  {
    path: '/',
    meta: {
      name: '',
      requiresAuth: false
    },
    component: () => import(`@/views/LoginView.vue`),
    beforeEnter: (to, from, next) => {
      if (store.getters['auth/authorized']) {
        next('/dashboard')
      }
      else {
        next()
      }
    },
    children: [
      {
        path: '',
        component: () => import(`@/components/login/LoginForm.vue`)
      }
    ]
  },
  {
    path: '/dashboard',
    meta: {
      name: 'Dashboard View',
      requiresAuth: true
    },
    component: () => import(`@/views/DashboardView.vue`),
    children: [
      {
        path: '',
        name: 'dashboard',
        component: () => import(`@/components/dashboard/Dashboard.vue`)
      },
      {
        path: 'pais',
        name: 'pais',
        meta: {
          name: 'pais',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Pais.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'nacionalidad',
        name: 'nacionalidad',
        meta: {
          name: 'nacionalidad',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Nacionalidad.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'ciudad',
        name: 'ciudad',
        meta: {
          name: 'ciudad',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Ciudad.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'barrio',
        name: 'barrio',
        meta: {
          name: 'barrio',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Barrio.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'categoria',
        name: 'categoria',
        meta: {
          name: 'categoria',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Categoria.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'presupuestado',
        name: 'presupuestado',
        meta: {
          name: 'presupuestado',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Presupuestado.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'dependencia',
        name: 'dependencia',
        meta: {
          name: 'dependencia',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Dependencia.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'funcional',
        name: 'funcional',
        meta: {
          name: 'funcional',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Funcional.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'jerarquia',
        name: 'jerarquia',
        meta: {
          name: 'jerarquia',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Jerarquia.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'estado',
        name: 'estado',
        meta: {
          name: 'estado',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Estado.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'turno',
        name: 'turno',
        meta: {
          name: 'turno',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Turno.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'institucion',
        name: 'institucion',
        meta: {
          name: 'institucion',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Institucion.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'rubro',
        name: 'rubro',
        meta: {
          name: 'rubro',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Rubro.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'descuento',
        name: 'descuento',
        meta: {
          name: 'descuento',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Descuento.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'planilla',
        name: 'planilla',
        meta: {
          name: 'planilla',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Planilla.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'desempeno',
        name: 'desempeno',
        meta: {
          name: 'desempeno',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Desempeno.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'universidad',
        name: 'universidad',
        meta: {
          name: 'universidad',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Universidad.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'facultad',
        name: 'facultad',
        meta: {
          name: 'facultad',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Facultad.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'carrera',
        name: 'carrera',
        meta: {
          name: 'carrera',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Carrera.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'titulo',
        name: 'titulo',
        meta: {
          name: 'titulo',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Titulo.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'centro',
        name: 'centro',
        meta: {
          name: 'centro',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Centro.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'vacancia',
        name: 'vacancia',
        meta: {
          name: 'vacancia',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Vacancia.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'empleado',
        name: 'empleado',
        meta: {
          name: 'empleado',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Empleado.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) && store.getters['auth/accesspage'].find( access => access.nombretabla.includes(to.name)).cons == 'SI' ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'cursos',
        name: 'cursos',
        meta: {
          name: 'cursos',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Cursos.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'academico',
        name: 'academico',
        meta: {
          name: 'academico',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Academico.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'beneficios',
        name: 'beneficios',
        meta: {
          name: 'beneficios',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Beneficios.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'evaluacion',
        name: 'evaluacion',
        meta: {
          name: 'evaluacion',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Evaluacion.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'sueldos',
        name: 'sueldos',
        meta: {
          name: 'sueldos',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Sueldos.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'aguinaldo',
        name: 'aguinaldo',
        meta: {
          name: 'aguinaldo',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Aguinaldo.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'usuarios',
        name: 'usuarios',
        meta: {
          name: 'usuarios',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Usuarios.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'perfil',
        name: 'perfil',
        meta: {
          name: 'perfil',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Perfil.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'permiso',
        name: 'permiso',
        meta: {
          name: 'permiso',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Permiso.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'acceso',
        name: 'acceso',
        meta: {
          name: 'acceso',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Acceso.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'legajo',
        name: 'legajo',
        meta: {
          name: 'legajo',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Legajo.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'liquidacion',
        name: 'liquidacion',
        meta: {
          name: 'liquidacion',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/LiquidacionSueldo.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'bonificacion',
        name: 'bonificacion',
        meta: {
          name: 'bonificacion',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/Bonificacion.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'evalpersonal',
        name: 'evalpersonal',
        meta: {
          name: 'evalpersonal',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/EvaluacionPersonal.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'liqaguinaldo',
        name: 'liqaguinaldo',
        meta: {
          name: 'liqaguinaldo',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/LiquidacionAguinaldo.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
      {
        path: 'listgeneral',
        name: 'listgeneral',
        meta: {
          name: 'listgeneral',
          requiresAuth: true
        },
        component: () => import(`@/components/dashboard/ListadoGeneral.vue`),
        beforeEnter: (to, from, next) => {
          if ( store.getters['auth/accesspage'].some( access => access.nombretabla.includes(to.name)) ) {
            next()
          }
          else {
            next('/unauthorized')
          }
        }
      },
    ]
  },
  {
    path: '/unauthorized',
    meta: {
      name: 'unauthorized',
      requiresAuth: true
    },
    component: () => import(`@/views/DashboardView.vue`),
    children: [
      {
        path: '',
        name: 'unauthorized',
        component: () => import(`@/components/unauthorized/Unauthorized.vue`)
      },
    ]
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters['auth/authorized']) {
      next()
      return
    }
    else {
      next('/')
    }
  }
  else {
    next()
  }
})

Vue.use(Meta)

export default router
