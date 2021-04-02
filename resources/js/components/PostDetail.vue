<template>
  <div>
    <v-card
        outlined
        tile
        max-width="500px"
        class="mx-auto"
        v-if="post"
      >
        <v-card-title class="text-5" v-text="post.title"></v-card-title>
        <v-card-subtitle v-text="post.user.name"></v-card-subtitle>
        <v-card-text class="text-h6" v-text="post.text"></v-card-text>
        <v-card-subtitle class="py-0 pb-2" v-text="post.created_at"></v-card-subtitle>
        <v-divider class="py-0 my-0"></v-divider>
        <v-card-subtitle class="py-2">
          <v-btn @click="like(post.id)" text class="m-0 p-0">{{heartCount}}件のいいね</v-btn>
        </v-card-subtitle>
        <v-divider class="py-0 my-0"></v-divider>
        <v-card-subtitle class="py-2">{{comments.length}}件のコメント</v-card-subtitle>
        <v-divider class="py-0 my-0"></v-divider>
        <v-card-actions class="d-flex align-center justify-center pb-6">
          <v-btn icon color="gley" class="mx-md-7 mx-3" @click="back"><v-icon>mdi-arrow-left</v-icon></v-btn>
          <v-btn icon color="gley" class="mx-md-7 mx-3" @click="createComment(post.id)"><v-icon>mdi-message-reply</v-icon></v-btn>
          <v-btn 
            v-show="!hasHeart" 
            icon 
            color="gley" 
            class="mx-md-7 mx-3"
            @click="favorite(post.id)"
          ><v-icon>mdi-heart</v-icon></v-btn>
          <v-btn 
            v-show="hasHeart" 
            icon color="pink" 
            class="mx-md-7 mx-3"
            @click="unfavorite(post.id)"
          ><v-icon>mdi-heart</v-icon></v-btn>
          <v-btn 
            v-show="post.user.id === $store.state.auth.userId" 
            @click="editPost(post.id)"
            icon 
            color="gley" 
            class="mx-md-7 mx-3"
          ><v-icon>mdi-pencil</v-icon></v-btn>
        </v-card-actions>
      </v-card>
      <v-card
        outlined
        tile
        v-for="comment in comments"
        :key="comment.index"
      >
        <v-card-title class="text-5 pb-0" v-text="comment.user.name"></v-card-title>
        <v-card-text class="text-h6" v-text="comment.text"></v-card-text>
        <v-card-subtitle class="py-0 pb-2" v-text="comment.created_at"></v-card-subtitle>
      </v-card>
  </div>
</template>

<script>
export default {
  data(){
    return{
      post: {},
      comments: {},
      heartCount: '',
      hasHeart: false
    }
  },
  mounted() {
    axios.get(`/api/posts/${this.$route.params.id}`)
    .then(res => {
      this.post = res.data.post
      this.heartCount = res.data.count
      const data = {
        id: this.post.id
      }
      axios.post('/api/posts/hasFavorites',{
        postId: this.post.id,
        userId: this.$store.state.auth.userId
      })
      .then(res => {
        this.hasHeart = res.data.result
      })
      .catch(err => console.log(err))
      axios.post('/api/showComment', data)
      .then(res => {
        this.comments = res.data
      })
      .catch(err => console.log(err))
    })
    .catch(err => {
      console.log(err)
    })

  },
  methods: {
    editPost(id){
      this.$router.push({path: `/edit/${id}`})
    },
    back() {
      this.$router.go(-1)
    },
    createComment(id){
      this.$router.push({path: `/createComment/${id}`})
    },
    favorite(id) {
      axios.post('/api/posts/favorites', {
        postId: id,
        userId: this.$store.state.auth.userId
      })
      .then(res => {
        this.hasHeart = res.data.result
        this.heartCount = res.data.count
      })
    },
    unfavorite(id) {
      axios.post('/api/posts/unfavorites', {
        postId: id,
        userId: this.$store.state.auth.userId
      })
      .then(res => {
        this.hasHeart = res.data.result
        this.heartCount = res.data.count
      })
      .catch(err =>console.log(err))
    },
    like(id){
      this.$router.push({path: `/showLikeUsers/${id}`})
    }
  }
}
</script>

<style>

</style>