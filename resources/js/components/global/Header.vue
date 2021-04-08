<template>
  <header>
    <v-app-bar
      app
      dark
      color="primary"
      class="px-6"
      fixed
      clipped-left
      clipped-right
    >
      <v-toolbar-title>title</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-app-bar-nav-icon @click="drawer = true" class="d-lg-none"></v-app-bar-nav-icon>



    </v-app-bar>

    <!-- left-side-bar -->
    <v-navigation-drawer
      app
      clipped
      left
      class="d-none d-md-block"
      width="25%"
    >
      <v-list nav>
        <v-list-item-group 
          active-class="primary--text text--accent-4"
          class="py-6 px-4"
        >
          <div v-show="$store.getters['auth/isLogin'] === true">
            <div
              v-for="navItem in navItems" 
              :key="navItem.title"
            >
              <router-link :to="navItem.link" tag="p">
                <v-list-item 
                  class="pl-10"
                >
                  <v-list-item-icon>
                    <v-icon>{{navItem.icon}}</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title>{{navItem.title}}</v-list-item-title>
                </v-list-item>
              </router-link>
            </div>
            <router-link :to="`/profile/${$store.state.auth.userId}`" tag="p">
              <v-list-item
                class="pl-10"
              >
                <v-list-item-icon>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-icon>
                <v-list-item-title>PROFILE</v-list-item-title>
              </v-list-item>
            </router-link>
            <v-list-item
              @click.stop="dialog = true"
              class="pl-10"
            >
              <v-list-item-icon>
                <v-icon>mdi-brightness-2</v-icon>
              </v-list-item-icon>
              <v-list-item-title>LOGOUT</v-list-item-title>
            </v-list-item>
          </div>

          <div v-show="$store.getters['auth/isLogin'] === false">
            <div 
              v-for="guestNavItem in guestNavItems" 
              :key="guestNavItem.index"
            >
              <router-link :to="guestNavItem.link" tag="p">
                <v-list-item>
                  <v-list-item-icon>
                    <v-icon>{{guestNavItem.icon}}</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title>{{guestNavItem.title}}</v-list-item-title>
                </v-list-item>
              </router-link>
            </div>
          </div>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <!-- right-side-bar -->
    <v-navigation-drawer
      app
      clipped
      right
      class="d-none d-md-block"
      width="25%"
    >
      <div v-show="$store.getters['auth/isLogin'] === true">
        <v-list-item class="mt-6 pl-8 pb-2">
          <v-list-item-content>
            <p class="subtitle-1 pb-2">ログインしているユーザー</p>
            <v-list-item-title class="display-1" v-text="$store.state.auth.userName"></v-list-item-title>
            <v-list-item-subtitle v-text="$store.state.auth.userEmail"></v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider></v-divider>
        <v-card elevation="0">
          <v-card-actions class="d-flex align-center flex-column">
            <router-link :to="`/following/${this.$store.state.auth.userId}`" tag="p">
              <v-btn large outlined rounded color="info" class="px-8 my-2">フォロー中</v-btn>
            </router-link>
            <router-link :to="`/followed/${this.$store.state.auth.userId}`" tag="p">
              <v-btn large outlined rounded color="info" class="px-8 my-2">フォロワー</v-btn>
            </router-link>
          </v-card-actions>
        </v-card>
      </div>
    </v-navigation-drawer>

    <!-- mobile-drawer -->
    <v-navigation-drawer
      v-model="drawer"
      fixed
      temporary
    >
      <v-list
       nav
      >
        <v-list-item-group 
          active-class="primary--text text--accent-4"
          class="py-6"
          v-show="$store.getters['auth/isLogin'] === true"
        >
          <v-list-item class="mt-6 pb-2 pl-4">
            <v-list-item-content>
              <p class="subtitle-2 pb-2">ログインしているユーザー</p>
              <v-list-item-title class="display-1" v-text="$store.state.auth.userName"></v-list-item-title>
              <v-list-item-subtitle v-text="$store.state.auth.userEmail"></v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider></v-divider>
          <div>
            <div 
              v-for="navItem in navItems" 
              :key="navItem.index"
            >
              <router-link :to="navItem.link" tag="p">
                <v-list-item class="pl-9">
                  <v-list-item-icon>
                    <v-icon>{{navItem.icon}}</v-icon>
                  </v-list-item-icon>
                  <v-list-item-title>{{navItem.title}}</v-list-item-title>
                </v-list-item>
              </router-link>
            </div>
            <router-link :to="`/profile/${$store.state.auth.userId}`" tag="p">
              <v-list-item
                class="pl-9"
              >
                <v-list-item-icon>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-icon>
                <v-list-item-title>PROFILE</v-list-item-title>
              </v-list-item>
            </router-link>
            <v-list-item
              @click.stop="dialog = true"
              class="pl-9 mt-5"
            >
              <v-list-item-icon>
                <v-icon>mdi-brightness-2</v-icon>
              </v-list-item-icon>
              <v-list-item-title>LOGOUT</v-list-item-title>
            </v-list-item>
          </div>
        </v-list-item-group>
        <v-list-item-group
          active-class="primary--text text--accent-4"
          class="py-16"
          v-show="$store.getters['auth/isLogin'] === false"
        >
          <div 
            v-for="guestNavItem in guestNavItems" 
            :key="guestNavItem.index"
          >
            <router-link :to="guestNavItem.link" tag="p">
              <v-list-item 
                class="pl-13 py-5"
              >
                <v-list-item-title>{{guestNavItem.title}}</v-list-item-title>
              </v-list-item>
            </router-link>
          </div>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <!-- dialog -->
    <v-dialog v-model="dialog" max-width="500">
      <v-card class="py-5">
        <p class="text-center text-h6 pt-5">ログアウトしますか？</p>
        <v-card-actions class="d-flex justify-center align-center">
          <v-btn
            color="green darken-1"
            class="pr-5"
            text
            @click="dialog = false"
          >
            戻る
          </v-btn>

          <v-btn
            color="red darken-1"
            text
            @click="logout()"
          >
            ログアウト
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </header>
</template>

<script>
export default {
  data() {
    return{
      drawer: false,
      dialog: false,
      navItems: [
        {
          title: 'HOME',
          link: '/',
          icon: 'mdi-home'
        },
        {
          title: 'SEARCH',
          link: '/search',
          icon: 'mdi-magnify'
        },
        {
          title: 'POST',
          link: '/post',
          icon: 'mdi-pencil'
        },
      ],
      guestNavItems: [
        {
          title: 'LOGIN',
          link: '/login'
        },
        {
          title: 'REGISTER',
          link: '/register'
        }
      ],
    }
  },
  methods: {
    logout(){
      this.dialog = false
      this.$store.dispatch('auth/logout')
    },
  }
}
</script>

<style>

</style>