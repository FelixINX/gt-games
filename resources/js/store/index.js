import Vue from 'vue'
import Vuex from 'vuex'
import user from './modules/user'
import scattGame from './modules/scattGame'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    user,
    scattGame
  },
})