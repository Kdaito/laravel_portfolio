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
                @click.stop="follow(user.id); user.follow = true; user.followedUser++"
                color="info"
              >フォローする</v-btn>
              <v-btn 
                class="align-self-center mr-2" 
                v-show="user.id !== $store.state.auth.userId && user.follow"
                dark
                rounded 
                @click.stop="unfollow(user.id); user.follow = false; user.followedUser--"
                color="info"
              >フォロー中</v-btn>
            </div>
          </div>
          <v-card-text class="pb-5">{{user.text}}</v-card-text>
              <v-card-subtitle class="pt-0">{{user.created_at}}から利用しています</v-card-subtitle>
          <v-divider class="py-0 my-0"></v-divider>
          <v-card-subtitle class="py-2">
            <v-btn text class="m-0 p-0" @click="followingUsers(user.id)">フォロー中: {{user.followingUser}}</v-btn>
            <v-btn text class="m-0 p-0" @click="followedUsers(user.id)">フォロワー: {{user.followedUser}}</v-btn>
          </v-card-subtitle>
      </v-card>

      <v-card outlined max-width="500px" class="mx-auto" tile>
        <v-tabs fixed-tabs>
          <v-tab @click="post">投稿</v-tab>
          <v-tab @click="like">いいね</v-tab>
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
      this.user.created_at = this.user.created_at.split(' ')[0]
      const created_at = this.user.created_at.split('-')
      this.user.created_at = `${created_at[0]}年${created_at[1]}月${created_at[2]}日`
      this.loading = false
    })
    .catch(err => console.log(err));
  },
  methods:{
    editProfile(){
      this.$router.push({name: 'edit-profile', params: {user: this.user}})
    },
    post(){
      this.$router.push({path: `/profile/${this.$route.params.id}/`})
    },
    like(){
      this.$router.push({path: `/profile/${this.$route.params.id}/likes`})
    },
    follow(id){
      axios.post('/api/follow', {
        followedUserId: id,
        followingUserId: this.$store.state.auth.userId
      })
      .catch(err => console.log(err))
    },
    unfollow(id){
      axios.post('/api/unfollow', {
        followedUserId: id,
        followingUserId: this.$store.state.auth.userId
      })
      .catch(err => console.log(err))
    },
    followingUsers(id){
      this.$router.push({path: `/following/${id}`})
    },
    followedUsers(id){
      this.$router.push({path: `/followed/${id}`})
    }
  },
}
</script>

<style>

</style>