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

    <div class="d-flex justify-center align-center" v-if="loading">
      <v-progress-circular
        :size="70"
        :width="7"
        color="info"
        indeterminate
      ></v-progress-circular>
    </div>

    <div
      v-for="user in users" 
      :key="user.index"
    >
      <router-link :to="`/profile/${user.id}`" tag="p">
        <v-card max-width="500px" class="mx-auto pt-5 mt-5">
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
            <v-card-subtitle class="pb-0 d-flex justify-start align-center">
              <p class="pr-4">フォロー中:{{user.followingUser}}</p>
              <p>フォロワー:{{user.followedUser}}</p>
            </v-card-subtitle>
        </v-card>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return {
      keyword: '',
      users: {},
      loading: false
    }
  },
  methods:{
    search(){
      this.users = {}
      this.loading = true
      axios.post('/api/search', {
        keyword: this.keyword,
        userId: this.$store.state.auth.userId
      })
      .then(res => {
        this.loading = false
        this.users = res.data
        this.users.forEach(user => {
          user.created_at = this.convertCreatedAt(user.created_at)
        })
      })
      .catch(err => this.showConsoleLog(err))
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

</style>