import Vue from 'vue'
import VueRouter from 'vue-router';

import Home from './components/Home';
import Search from './components/Search';
import Post from './components/Post';
import EditPost from './components/EditPost';
import EditProfile from './components/EditProfile';
import CreateComment from './components/CreateComment';
import Profile from './components/Profile';
import LikePosts from './components/profile/LikePosts';
import UserPosts from './components/profile/UserPosts';
import ShowLikeUsers from './components/ShowLikeUsers';
import Login from './components/Auth/Login.vue';
import Register from './components/Auth/Register.vue';
import Detail from './components/PostDetail.vue';
import FollowedUser from './components/FollowedUser';
import FollowingUser from './components/FollowingUser';

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