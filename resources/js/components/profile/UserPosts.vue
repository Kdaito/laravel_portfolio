<template>
  <div>
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
        <v-btn icon color="gley" class="mx-md-7 mx-3" @click="detailPost(post.id)"><v-icon>mdi-clipboard-text</v-icon></v-btn>
        <v-btn icon color="gley" class="mx-md-7 mx-3" @click="createComment(post.id)"><v-icon>mdi-message-reply</v-icon></v-btn>
        <v-btn 
          icon 
          color="gley" 
          class="mx-md-7 mx-3" 
          @click="favorite(post.id); post.hasFavorite = true; post.heartCount++" 
          v-show="!post.hasFavorite"
        ><v-icon>mdi-heart</v-icon>{{post.heartCount}}</v-btn>
        <v-btn 
          icon 
          color="pink" 
          class="mx-md-7 mx-3" 
          @click="unfavorite(post.id); post.hasFavorite = false; post.heartCount--" 
          v-show="post.hasFavorite"
        ><v-icon>mdi-heart</v-icon>{{post.heartCount}}</v-btn>
        <v-btn 
          v-show="post.user.id === $store.state.auth.userId" 
          @click="editPost(post.id)"
          icon 
          color="gley" 
          class="mx-md-7 mx-3"
        ><v-icon>mdi-pencil</v-icon></v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      posts: {}
    }
  },
  mounted(){
    axios.post('/api/posts/userPosts/', {
      id: this.$route.params.id,
      userId: this.$store.state.auth.userId,
    })
    .then(res => {
      this.posts = res.data
    })
    .catch(err => console.log(err))
  },
  methods:{
    detailPost(id) {
      this.$router.push({path: `/detail/${id}`})
    },
    editPost(id) {
      this.$router.push({path: `/edit/${id}`})
    },
    createComment(id) {
      this.$router.push({path: `/createComment/${id}`})
    },
    favorite(id) {
      axios.post('/api/posts/favorites', {
        postId: id,
        userId: this.$store.state.auth.userId,
      })
      .catch(err => console.log(err));
    },
    unfavorite(id) {
      axios.post('/api/posts/unfavorites', {
        postId: id,
        userId: this.$store.state.auth.userId,
      })
      .catch(err => console.log(err))
    }
  }
}
</script>

<style>

</style>