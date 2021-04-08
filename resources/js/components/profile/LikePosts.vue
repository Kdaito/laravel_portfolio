<template>
  <div>
    <div>
      <v-card
        outlined
        tile
        v-for="post in posts"
        :key="post.index"
        max-width="500px"
        class="mx-auto"
      >
        <v-card-title class="text-5" v-text="post.title"></v-card-title>
        <v-card-subtitle v-text="post.user.name"></v-card-subtitle>
        <v-card-text class="text-h6" v-text="post.text"></v-card-text>
        <v-card-subtitle class="py-0" v-text="post.created_at"></v-card-subtitle>
        <v-card-actions class="d-flex align-center justify-center pb-6">
          <router-link :to="`/detail/${post.id}`" tag="p" class="mt-4">
            <v-btn icon color="gley" class="mx-md-7 mx-3"><v-icon>mdi-clipboard-text</v-icon></v-btn>
          </router-link>
          <router-link :to="`/createComment/${post.id}`" tag="p" class="mt-4">
            <v-btn icon color="gley" class="mx-md-7 mx-3"><v-icon>mdi-message-reply</v-icon></v-btn>
          </router-link>
          <v-btn 
            icon 
            color="gley" 
            class="mx-md-7 mx-3" 
            @click="favorite(post)" 
            v-show="!post.hasFavorite"
          ><v-icon>mdi-heart</v-icon>{{post.heartCount}}</v-btn>
          <v-btn 
            icon 
            color="pink" 
            class="mx-md-7 mx-3" 
            @click="unfavorite(post)" 
            v-show="post.hasFavorite"
          ><v-icon>mdi-heart</v-icon>{{post.heartCount}}</v-btn>
          <router-link :to="`/edit/${post.id}`" tag="p" class="mt-4">
            <v-btn 
              v-show="post.user.id === $store.state.auth.userId" 
              icon 
              color="gley" 
              class="mx-md-7 mx-3"
            ><v-icon>mdi-pencil</v-icon></v-btn>
          </router-link>
        </v-card-actions>
      </v-card>
      <div class="d-flex justify-center align-center py-8">
        <v-btn
          color="primary"
          elevation="6"
          rounded
          x-large
          v-if="!loading && existMorePosts"
          @click="morePosts"
        >もっと見る</v-btn>
      </div>
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
    return{
      posts: {},
      loading: false,
      start: 0,
      existMorePosts: false
    }
  },
  mounted(){
    this.loading = true
    axios.post('/api/posts/likePosts', {
      id: this.$route.params.id,
      userId: this.$store.state.auth.userId,
      start: this.start
    })
    .then(res => {
      this.posts = res.data.posts
      this.loading = false
      this.start += 10
      this.existMorePosts = res.data.morePosts
    })
    .catch(err => this.showConsoleLog(err))
  },
  methods:{
    favorite(post) {
      post = this.mFavorite(post)
    },
    unfavorite(post) {
      post = this.mUnfavorite(post)
    },
    morePosts(){
      this.loading = true
      axios.post('/api/posts/likePosts', {
        id: this.$route.params.id,
        userId: this.$store.state.auth.userId,
        start: this.start
      })
      .then(res => {
        this.posts = this.posts.concat(res.data.posts)
        this.start += 10
        this.existMorePosts = res.data.morePosts
        this.loading = false
      })
      .catch(err => this.showConsoleLog(err))
    }
  }
}
</script>

<style>

</style>