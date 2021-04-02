<template>
  <div>
    <v-card max-width="500px" class="mx-auto">
      <v-toolbar color="info" dark class="pt-2">
        <v-container class="p-0 m-0">
          <v-row>
            <v-col cols="2">
              <v-btn icon color="gley" @click="back"><v-icon>mdi-arrow-left</v-icon></v-btn>
            </v-col>
            <v-col cols="8">
              <p class="text-md-h6 text-subtitle-1 pt-2 text-center">フォローしているユーザー</p>
            </v-col>
            <v-col cols="2"></v-col>
          </v-row>
        </v-container>
      </v-toolbar>
      <p class="text-md-h6 text-subtitle-1 py-5 text-center" v-show="!userExist">フォローしているユーザーがいません</p>
      <v-card v-for="user in users" :key="user.index" @click.prevent="showProfile(user.id)" tile outlined >
        <div class="d-flex align-center justify-space-between mb-0 pb-0 pt-3">
          <div>
            <v-card-title class="pb-2 pt-0">{{user.name}}</v-card-title>
          </div>
          <div>
            <v-btn 
              class="align-self-center mr-2" 
              v-show="user.id !== $store.state.auth.userId && !user.follow"
              outlined 
              rounded 
              @click.stop="follow(user.id); user.follow = true"
              color="info"
            >フォローする</v-btn>
            <v-btn 
              class="align-self-center mr-2" 
              v-show="user.id !== $store.state.auth.userId && user.follow"
              dark
              rounded 
              @click.stop="unfollow(user.id); user.follow = false"
              color="info"
            >フォロー中</v-btn>
          </div>
        </div>
        <v-card-text class="pb-5">{{user.text}}</v-card-text>
            <v-card-subtitle class="pt-0">{{user.created_at}}から利用しています</v-card-subtitle>
        <v-divider class="py-0 my-0"></v-divider>
        <v-card-subtitle class="pb-0 d-flex justify-start align-center">
          <p class="pr-4">フォロー中:{{user.followingUser}}</p>
          <p>フォロワー:{{user.followedUser}}</p>
        </v-card-subtitle>
      </v-card>
    </v-card>
  </div>
</template>

<script>
export default {
  data(){
    return{
      users: {},
      userExist: true
    }
  },
  mounted(){
    axios.post('/api/user/follow' ,{
      id: this.$route.params.id,
      userId: this.$store.state.auth.userId,
    })
    .then(res => {
      console.log(res)
      this.users = res.data
      this.users.forEach(user => {
        const created = user.created_at.split(' ')[0].split('-')
        user.created_at = `${created[0]}年${created[1]}月${created[2]}日`
      });
      if(this.users.length === 0) {
        this.userExist = false
      }
    })
    .catch(err => console.log(err))
  },
  methods:{
    back() {
      this.$router.go(-1)
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
    showProfile(id){
      this.$router.push({path: `/profile/${id}`})
    },
  }
}
</script>

<style>

</style>