<template>
  <div>
    <div v-if="!loading">
      <v-card
        outlined
        tile
        max-width="500px"
        class="mx-auto"
      >
        <v-card-title class="text-5"  v-text="post.title"></v-card-title>
        <v-card-subtitle v-if="post.user" v-text="post.user.name"></v-card-subtitle>
        <v-card-text class="text-h6" v-text="post.text"></v-card-text>
        <v-card-subtitle class="py-0 pb-2" v-text="post.created_at"></v-card-subtitle>
        <v-divider class="py-0 my-0"></v-divider>
        <v-card-subtitle class="py-2">
          <router-link :to="`/showLikeUsers/${post.id}`" tag="p" class="mb-0 pb-0">
            <v-btn text class="m-0 p-0">{{post.heartCount}}件のいいね</v-btn>
          </router-link>
        </v-card-subtitle>
        <v-divider class="py-0 my-0"></v-divider>
        <v-card-subtitle class="py-2">{{comments.length}}件のコメント</v-card-subtitle>
        <v-divider class="py-0 my-0"></v-divider>
        <v-card-actions class="d-flex align-center justify-center pb-6">
          <v-btn icon color="gley" class="mx-md-7 mx-3" @click="back"><v-icon>mdi-arrow-left</v-icon></v-btn>
          <router-link :to="`/createComment/${post.id}`" tag="p" class="mt-4">
            <v-btn icon color="gley" class="mx-md-7 mx-3"><v-icon>mdi-message-reply</v-icon></v-btn>
          </router-link>
          <v-btn 
            v-show="!post.hasFavorite" 
            icon 
            color="gley" 
            class="mx-md-7 mx-3"
            v-if="post.id"
            @click="favorite(post)"
          ><v-icon>mdi-heart</v-icon></v-btn>
          <v-btn 
            v-show="post.hasFavorite" 
            icon color="pink" 
            class="mx-md-7 mx-3"
            v-if="post.id"
            @click="unfavorite(post)"
          ><v-icon>mdi-heart</v-icon></v-btn>
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
      <v-card
        outlined
        tile
        v-for="comment in comments"
        :key="comment.index"
        max-width="500px"
        class="mx-auto"
      >
        <v-card-title class="text-5 pb-0" v-text="comment.user.name"></v-card-title>
        <v-card-text class="text-h6" v-text="comment.text"></v-card-text>
        <v-card-subtitle class="py-0 pb-2" v-text="comment.created_at"></v-card-subtitle>
      </v-card>
    </div>
    <div class="d-flex justify-center align-center" v-if="loading">
      <v-progress-circular
        :size="70"
        :width="7"
        color="info"
        indeterminate
      ></v-progress-circular>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      post: {},
      comments: {},
      loading: true
    }
  },
  mounted() {
    axios.post(`/api/posts/detailPost`, {
      postId: this.$route.params.id,
      userId: this.$store.state.auth.userId
    })
    .then(res => {
      this.post = res.data
      const data = {
        id: this.post.id
      }
      axios.post('/api/showComment', data)
      .then(res => {
        this.comments = res.data
        this.loading = false
      })
      .catch(err => this.showConsoleLog(err))
    })
    .catch(err => {
      this.showConsoleLog(err)
    })

  },
  methods: {
    back() {
      this.$router.go(-1)
    },
    favorite(post) {
      post = this.mFavorite(post)
    },
    unfavorite(post) {
      post = this.mUnfavorite(post)
    },
  }
}
</script>

<style>

</style>