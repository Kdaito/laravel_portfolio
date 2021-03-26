
import axios from 'axios';
import router from '../../router';

const state = {
  token: '',
  userId: '',
  userName: '',
  userEmail: '',
};

const mutations = {
  login(state, payload) {
    state.token = payload;
  },
  userInfo(state,payload) {
    state.userId = payload.data.id
    state.userName = payload.data.name
    state.userEmail = payload.data.email
    router.push({path:'/'});
  },
  logout(state) {
    state.token = null;
    state.userId = null;
    state.userName = null;
    state.userEmail = null;
  },
};

const getters = {
  isLogin(state) {
    return state.token ? true : false;
  }
};

const actions = {
  login({commit}, payload) {
    axios.post('/api/login', {
      email: payload.email,
      password: payload.password
    }).then(res => {
      const token = res.data.access_token;
      axios.defaults.headers.common['Authorization'] = 'Bearer' + token;

      axios.get('/api/user')
      .then(res => {
        commit('userInfo', res)
      })

      commit('login', token);
      // router.push({path:'/'});
      commit('alert/setAlert', {'message':''},{root: true});
    }).catch(error => {
      console.log(error)
      commit('alert/setAlert', {'message':'ログインに失敗しました','type':'danger'},{root: true});
    });
  },
  logout({commit}) {
    axios.get('/api/logout').then(res => {
      console.log('success')
      axios.defaults.headers.common['Authorization'] = '';
      commit('logout');
      router.push({path: '/login'});
      commit('alert/setAlert', {'message': 'ログアウトしました'}, {root: true});
    }).catch(error => {
      console.log(error)
      commit('alert/setAlert', {'message': 'ログアウトに失敗しました'}, {root: true});
    });
  }
};

export default {
  namespaced: true,
  state,
  mutations, 
  getters,
  actions
};