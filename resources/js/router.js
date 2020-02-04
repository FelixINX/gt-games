import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  routes: [
    {
      path: '/',
      component: () => import(/* webpackChunkName: 'home' */ './components/Home/Home.vue'),
      meta: { background: '/img/home.jpg' }
    },
    {
      path: '/leaderboard',
      component: () => import(/* webpackChunkName: 'leaderboard' */ './components/Leaderboard/Leaderboard.vue')
    },
    {
      path: '/profile',
      component: () => import(/* webpackChunkName: 'profile' */ './components/Profile/Profile.vue')
    },
    {
      path: '/scatt-game/:id',
      component: () => import(/* webpackChunkName: 'scatt' */ './components/Scatt/ScattGame.vue'),
      meta: { footer: 'scatt-footer' }
    },
    {
      path: '/scatt/create',
      component: () => import(/* webpackChunkName: 'scatt-create' */ './components/Scatt/ScattCreate.vue')
    },
    {
      path: '/scatt/categories',
      component: () => import(/* webpackChunkName: 'scatt-categories' */ './components/Scatt/ScattCategories.vue')
    },
    {
      path: '/scatt/all',
      component: () => import(/* webpackChunkName: 'scatt-all' */ './components/Scatt/ScattAll.vue')
    },
    {
      path: '/redirect/:method',
      component: () => import(/* webpackChunkName: 'redirect' */ './components/Redirect.vue')
    },
    {
      path: '/about/whats-new',
      component: () => import(/* webpackChunkName: 'about' */ './components/About/WhatsNew.vue')
    }
  ]
})

export default router