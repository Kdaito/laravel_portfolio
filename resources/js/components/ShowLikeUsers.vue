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
              <p class="text-md-h6 text-subtitle-1 pt-2 text-center">いいねしているユーザー</p>
            </v-col>
            <v-col cols="2"></v-col>
          </v-row>
        </v-container>
      </v-toolbar>
      <p class="text-md-h6 text-subtitle-1 py-5 text-center" v-show="!userExist">いいねしているユーザーがいません</p>
      <div
        v-for="user in users"
        :key="user.index"
      >
        <router-link :to="`/profile/${user.id}`" tag="p">
          <v-card tile outlined >
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
                <v-card-subtitle class="pt-0">{{user.created}}から利用しています</v-card-subtitle>
            <v-divider class="py-0 my-0"></v-divider>
            <v-card-subtitle class="pb-0 d-flex justify-start align-center">
              <p class="pr-4">フォロー中:{{user.followingUser}}</p>
              <p>フォロワー:{{user.followedUser}}</p>
            </v-card-subtitle>
          </v-card>
        </router-link>
      </div>
    </v-card>
  </div>
</template>

<script>
export default {
  data(){
    return{
      users:{},
      userExist: true
    }
  },
  mounted(){
    axios.post('/api/showLikeUsers' ,{
      id: this.$route.params.id,
      userId: this.$store.state.auth.userId
    })
    .then(res => {
      this.users = res.data
      this.users.forEach(user => {
        const created = user.created.split('-')
        user.created = `${created[0]}年${created[1]}月${created[2]}日`
      });

      if(this.users.length === 0) {
        this.userExist = false
      }
    })
    .catch(err => this.showConsoleLog(err))
  },
  methods:{
    back() {
      this.$router.go(-1)
    },
    follow(user){
      user = this.mFollow(user)
    },
    unfollow(user){
      user = this.mUnfollow(user)
    },
  }

}
</script>

<style>

</style>