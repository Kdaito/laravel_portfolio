<template>
  <div>
    <div v-if="!loading">
      <v-card max-width="500px" class="mx-auto pt-5" tile>
        <div class="d-flex align-center justify-space-between mb-0 pb-0">
            <div>
              <v-card-title class="pb-2 pt-0">{{user.name}}</v-card-title>
            </div>
            <div>
              <v-btn 
                v-show="user.id == $store.state.auth.userId"
                class="align-self-center mr-2" 
                outlined 
                rounded 
                @click="editProfile"
                color="info"
              >編集する</v-btn>
              <v-btn 
                class="align-self-center mr-2" 
                v-show="user.id !== $store.state.auth.userId && !user.follow"
                outlined 
                rounded 
                @click.stop="follow(user)"
                color="info"
              >フォローする</v-btn>
              <v-btn 
                class="align-self-center mr-2" 
                v-show="user.id !== $store.state.auth.userId && user.follow"
                dark
                rounded 
                @click.stop="unfollow(user)"
                color="info"
              >フォロー中</v-btn>
            </div>
          </div>
          <v-card-text class="pb-5">{{user.text}}</v-card-text>
              <v-card-subtitle class="pt-0">{{user.created_at}}から利用しています</v-card-subtitle>
          <v-divider class="py-0 my-0"></v-divider>
          <v-card-subtitle class="py-2 d-flex align-center mb-0">
            <router-link :to="`/following/${user.id}`" tag="p" class="m-0 p-0 mr-3">
              <v-btn text class="m-0 p-0">フォロー中: {{user.followingUser}}</v-btn>
            </router-link>
            <router-link :to="`/followed/${user.id}`" tag="p" class="m-0 p-0">
              <v-btn text class="m-0 p-0" >フォロワー: {{user.followedUser}}</v-btn>
            </router-link>
          </v-card-subtitle>
      </v-card>

      <v-card outlined max-width="500px" class="mx-auto" tile>
        <v-tabs fixed-tabs>
          <v-tab :to="{path: `/profile/${this.$route.params.id}/`}">投稿</v-tab>
          <v-tab :to="{path: `/profile/${this.$route.params.id}/likes`}">いいね</v-tab>
        </v-tabs>
      </v-card>
      <router-view></router-view>
    </div>
    <div class="d-flex justify-center align-center" v-if="loading">
      <v-progress-circular
        :size="70"
        :width="7"
        color="info"
        class="mt-5"
        indeterminate
      ></v-progress-circular>
    </div>
    <div class="d-sm-none">
      <router-link to="/post" tag="button">
        <v-btn
          class="mx-2 post-btn"
          fab
          dark
          x-large
          color="info"
          to="/post"
        >
          <v-icon dark>
            mdi-pencil
          </v-icon>
        </v-btn>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return {
      user: {},
      loading: false,
      posts: '/profile/' + this.$route.params.id,
      likePosts: '/profile/' + this.$route.params.id +'/likes',
      tab: null,
    }
  },
  mounted(){
    this.loading = true
    axios.post('/api/user', {
      id: this.$route.params.id,
      userId: this.$store.state.auth.userId
    })
    .then(res => {
      this.user = res.data
      this.user.created_at = this.convertCreatedAt(this.user.created_at)
      this.loading = false
    })
    .catch(err => this.showConsoleLog(err));
  },
  methods:{
    editProfile(){
      this.$router.push({name: 'edit-profile', params: {user: this.user}})
    },
    follow(user){
      user = this.mFollow(user)
    },
    unfollow(user){
      user = this.mUnfollow(user)
    },
  },
}
</script>

<style>
  .post-btn{
    position: fixed;
    bottom: 60px;
    right: 20px;
    z-index: 1000;
  }
</style>