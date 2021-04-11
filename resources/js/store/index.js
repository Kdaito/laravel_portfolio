import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import alert from './modules/alert';
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    auth, alert
  },
  plugins: [createPersistedState(
    { 
      key: 'postApp',

      paths: [
        'auth.token',
        'auth.userId',
        'auth.userName',
        'auth.userEmail',
      ],

      storage: window.sessionStorage
    }
  )]
})