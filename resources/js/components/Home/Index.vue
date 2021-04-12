<template>
  <div>
    <v-container>
      <v-card
        outlined
        tile
        v-for="post in posts"
        :key="post.id"
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
            @click="favorite(post);" 
            v-show="!post.hasFavorite"
          ><v-icon>mdi-heart</v-icon>{{post.heartCount}}</v-btn>
          <v-btn 
            icon 
            color="pink" 
            class="mx-md-7 mx-3" 
            @click="unfavorite(post)" 
            v-show="post.hasFavorite"
          ><v-icon>mdi-heart</v-icon>{{post.heartCount}}</v-btn>
          <div v-show="post.user.id === $store.state.auth.userId">
            <router-link :to="`/edit/${post.id}`" tag="p" class="mt-4">
              <v-btn 
                icon 
                color="gley" 
                class="mx-md-7 mx-3"
              ><v-icon>mdi-pencil</v-icon></v-btn>
            </router-link>
          </div>
        </v-card-actions>
      </v-card>
      <div class="d-flex justify-center align-center py-8">
        <v-btn
          color="primary"
          elevation="6"
          rounded
          x-large
          v-show="!loading && existMorePosts"
          @click="morePosts"
        >もっと見る</v-btn>
      </div>
    </v-container>
    <div class="d-flex justify-center align-center">
      <v-progress-circular
        :size="70"
        :width="7"
        color="info"
        indeterminate
        v-show="loading"
      ></v-progress-circular>
    </div>
    <div class="d-sm-none">
      <router-link to="/post" tag="p">
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
    return{
      posts: {},
      start: 0,
      loading: true,
      existMorePosts: true
    }
  },
  mounted(){
    this.getPosts()
  },
  methods: {
    getPosts() {
      axios.post(`/api/posts/showPosts`, {
        userId: this.$store.state.auth.userId,
        start: this.start,
      })
      .then(res => {
        this.posts = res.data.posts
        this.existMorePosts = res.data.morePosts
        this.start += 10
        this.loading = false
      })
      .catch(err => {
        this.showConsoleLog(err)
      })
    },
    favorite(post) {
      post = this.mFavorite(post)
    },
    unfavorite(post) {
      post = this.mUnfavorite(post)
    },
    morePosts(){
      this.loading = true
      axios.post('/api/posts/showPosts', {
        userId: this.$store.state.auth.userId,
        start: this.start,
      })
      .then(res => {
        this.posts = this.posts.concat(res.data.posts)
        this.existMorePosts = res.data.morePosts
        this.start += 10 
        this.loading = false
      })
      .catch(err => this.showConsoleLog(err))
    }
  }
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