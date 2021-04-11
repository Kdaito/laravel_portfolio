<template>
  <v-container>
    <v-card
      class="mx-auto pt-10 pb-4"
      max-width="500px"
    >
      <div class="d-flex justify-center align-center">
        <h2 class="d-inline-block post_title">投稿を編集する</h2>
      </div>
      <v-divider></v-divider>
      <v-container fluid>
        <v-form @submit.prevent="updatePost" v-model="isValid">
          <v-text-field
            :rules="titleRules"
            counter="25"
            hint="投稿のタイトルを入力しよう"
            label="タイトル"
            class="pb-5 px-2"
            v-model="title"
          ></v-text-field>
          <v-textarea
            name="input-7-1"
            hint="投稿の内容を入力しよう"
            :rules="textRules"
            filled
            label="投稿内容"
            auto-grow
            counter="150"
            v-model="text"
          ></v-textarea>
          <v-card-actions class="d-flex align-center justify-space-between px-md-14 px-8" >
            <v-btn
              fab
              dark
              color="teal"
              small
              @click="back"
            ><v-icon>mdi-arrow-left</v-icon></v-btn>
            <v-btn 
              class="info"
              type="submit"
              :disabled="!isValid"
              large
            >
            編集完了</v-btn>
            <v-btn
              fab
              dark
              color="red"
              small
              @click.stop="dialog = true"
            ><v-icon>mdi-delete</v-icon></v-btn>
          </v-card-actions>
        </v-form>
        <v-dialog
          v-model="dialog"
          max-width="400"
        >
          <v-card>
            <v-card-title >
              この投稿を削除しますか？
            </v-card-title>

            <v-card-text>
              「削除する」ボタンを押すとこの投稿を削除することができますが、削除した投稿は復元することができません。
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn
                color="green darken-1"
                text
                @click="dialog = false"
              >
                戻る
              </v-btn>

              <v-btn
                color="red darken-1"
                text
                @click="deletePost"
              >
                削除する
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-container>
    </v-card>
  </v-container>
</template>

<script>
export default {
  data() {
    return{
      dialog: false,
      title: '',
      text: '',
      isValid: false,
      titleRules: [
        v => !!v || '入力必須です',
        v => (!!v && 25 >= v.length) || `25文字以内で入力してください`
      ],
      textRules: [
        v => !!v || '入力必須です',
        v => (!!v && 150 >= v.length) || `150文字以内で入力してください`
      ]
    }
  },
  mounted(){
    axios.get('/api/posts/' + this.$route.params.id)
    .then(res => {
      this.title = res.data.post.title,
      this.text = res.data.post.text
    })
    .catch(err => {
      this.showConsoleLog(err)
    })
  },
  methods: {
    updatePost() {
      axios.put(`/api/posts/${this.$route.params.id}`, {
        title: this.title,
        text: this.text
      })
      .then(res => {
        this.$router.go(-1)
      })
      .catch(err => {
        this.showConsoleLog(err)
      })
    },
    back(){
      this.$router.go(-1)
    },
    deletePost(){
      axios.post(`/api/posts/deletePost`, {
        id: this.$route.params.id
      })
      .then(res => {
        this.$router.push({path: `/profile/${this.$store.state.auth.userId}`})
      })
      .catch(err => {
        this.showConsoleLog(err)
      })
    }
  }
}
</script>

<style>
  .post_title{
    border-bottom: 5px skyblue solid;
  }
</style>