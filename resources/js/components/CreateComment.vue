<template>
  <v-card
        outlined
        tile
        max-width="500px"
        class="mx-auto"
      >
        <v-card-title class="text-5" v-text="post.title"></v-card-title>
        <v-card-subtitle v-if="post.user" v-text="post.user.name"></v-card-subtitle>
        <v-card-text class="text-h6" v-text="post.text"></v-card-text>
        <v-card-subtitle class="py-0 pb-2" v-text="post.created_at"></v-card-subtitle>
        <v-divider class="py-0 my-0"></v-divider>
        <v-card-subtitle class="py-2">{{heartCount}}件のいいね</v-card-subtitle>
        <v-divider class="py-0 my-0"></v-divider>
        <v-card-subtitle class="py-2">{{comments.length}}件のコメント</v-card-subtitle>
        <v-divider class="py-0 my-0"></v-divider>
        <v-container fluid>
        <v-form @submit.prevent="createComment" v-model="isValid">
          <v-textarea
            name="input-7-1"
            :rules="textRules"
            filled
            hint="コメントの内容を入力しよう"
            label="コメント内容"
            auto-grow
            counter="150"
            v-model="text"
          ></v-textarea>
          <v-card-actions class="d-flex justify-center align-center">
            <v-btn 
              color="teal"
              large
              dark
              @click="back"
            >
            戻る</v-btn>
            <v-btn 
              class="info"
              type="submit"
              :disabled="!isValid"
              large
            >
            投稿する</v-btn>
          </v-card-actions>
        </v-form>
      </v-container>
      </v-card>
</template>

<script>
export default {
  data(){
    return{
      post: {},
      heartCount: '',
      comments: '',
      isValid: false,
      text: '',
      textRules: [
        v => !!v || '入力必須です',
        v => (!!v && 150 >= v.length) || `150文字以内で入力してください`
      ]
    }
  },
  mounted(){
    axios.get('/api/posts/' + this.$route.params.id)
    .then(res => {
      this.post = res.data.post
      this.heartCount = res.data.count
      axios.post('/api/showComment', {
        id: this.$route.params.id
      })
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
    createComment(){
      axios.post('/api/createComment', {
        user_id: this.$store.state.auth.userId,
        post_id: this.$route.params.id,
        text: this.text
      })
      .then(res => {
        this.$router.push({path: `/detail/${this.$route.params.id}`})
      })
      .catch(err => {
        console.log(err)
      })
    },
    back(){
      this.$router.go(-1);
    }
  }
}
</script>

<style>

</style>