<template>
  <div>
    <v-card class="mb-6 mt-5 mx-auto" max-width="500px">
      <v-container>
        <v-form class="d-flex align-center justify-center" @submit.prevent="search">
          <v-text-field 
              label="ユーザーを検索する" 
              v-model="keyword"
              class="pr-2"
          ></v-text-field>
          <v-btn color="info" fab dark small type="submit"><v-icon>mdi-magnify</v-icon></v-btn>
        </v-form>
      </v-container>
    </v-card>

    <v-card max-width="500px" class="mx-auto pt-5 mt-5" v-for="user in users" :key="user.index" @click.prevent="showProfile(user.id)">
      <div class="d-flex align-center justify-space-between mb-0 pb-0">
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
  </div>
</template>

<script>
export default {
  data(){
    return {
      keyword: '',
      users: {}
    }
  },
  methods:{
    search(){
      axios.post('/api/search', {
        keyword: this.keyword,
        userId: this.$store.state.auth.userId
      })
      .then(res => {
        this.users = res.data
        this.users.forEach(user => {
          const created = user.created_at.split(' ')[0].split('-')
          user.created_at = `${created[0]}年${created[1]}月${created[2]}日`
        })
      })
      .catch(err => console.log(err))
    },
    follow(id){
      axios.post('/api/follow', {
        followedUserId: id,
        followingUserId: this.$store.state.auth.userId
      })
      .then(res => console.log(res))
      .catch(err => console.log(err))
    },
    unfollow(id){
      axios.post('/api/unfollow', {
        followedUserId: id,
        followingUserId: this.$store.state.auth.userId
      })
      .then(res => console.log(res))
      .catch(err => console.log(err))
    },
    showProfile(id){
      this.$router.push({path: `/profile/${id}`})
    }
  },
}
</script>

<style>

</style>