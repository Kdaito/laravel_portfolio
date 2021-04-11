import Vue from 'vue'
import VueRouter from 'vue-router';

import Home from './components/Home/';
import Search from './components/Search/';
import Post from './components/Post/';
import Detail from './components/Post/Detail';
import EditPost from './components/Post/Edit';
import ShowLikeUsers from './components/Post/ShowLikeUsers';
import CreateComment from './components/Comment';
import Profile from './components/Profile/';
import LikePosts from './components/Profile/LikePosts';
import UserPosts from './components/Profile/UserPosts';
import EditProfile from './components/Profile/Edit';
import Login from './components/Auth/Login';
import Register from './components/Auth/Register';
import FollowedUser from './components/Follow/FollowedUser';
import FollowingUser from './components/Follow/FollowingUser';

import store from './store/index';

Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      component: Home,
      meta: {requiresAuth: true}
    },
    {
      path: '/search',
      component: Search,
      meta: {requiresAuth: true}
    },
    {
      path: '/post',
      component: Post,
      meta: {requiresAuth: true}
    },
    {
      path: '/showLikeUsers/:id',
      component: ShowLikeUsers,
      meta: {requiresAuth: true}
    },
    {
      path: '/edit/:id',
      component: EditPost,
      meta: {requiresAuth: true}
    },
    {
      path: '/editProfile',
      component: EditProfile,
      name: 'edit-profile',
      meta: {requiresAuth: true},
      props: true
    },
    {
      path: '/detail/:id',
      component: Detail,
      meta: {requiresAuth: true}
    },
    {
      path: '/following/:id',
      component: FollowingUser,
      meta: {requiresAuth: true}
    },
    {
      path: '/followed/:id',
      component: FollowedUser,
      meta: {requiresAuth: true}
    },
    {
      path: '/profile/:id',
      component: Profile,
      children:[
        {
          path: '',
          component: UserPosts
        },
        {
          path: 'likes',
          component: LikePosts
        },
      ],
      meta: {requiresAuth: true}
    },
    {
      path: '/createComment/:id',
      component: CreateComment,
      meta: {requiresAuth: true}
    },
    {
      path: '/login',
      component: Login,
    },
    {
      path: '/register',
      component: Register,
    },
    {
      path: '*',
      component: Home,
      meta: {requiresAuth: true}
    },
  ]
});

router.beforeEach((to, from, next) => {
  if (sessionStorage.getItem('postApp')) {
    const strageData = JSON.parse(sessionStorage.getItem('postApp'));
    if (strageData.auth.token) {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + strageData.auth.token;
    }
  }
  store.commit('alert/setAlert', {'message': ''});
  if(to.matched.some(record => record.meta.requiresAuth)) {
    if(store.getters['auth/isLogin'] === false) {
      next({
        path: '/login',
        query: {redirect: to.fullPath}
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router