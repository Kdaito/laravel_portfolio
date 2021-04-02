<template>
  <v-container>
    <v-card
      class="mx-auto pt-10 pb-4"
      max-width="500px"
    >
      <div class="d-flex justify-center align-center">
        <h2 class="d-inline-block post_title">投稿を作成する</h2>
      </div>
      <v-divider></v-divider>
      <v-container fluid>
        <v-form @submit.prevent="createPost" v-model="isValid">
          <v-text-field
            :rules="titleRules"
            counter="20"
            hint="投稿のタイトルを入力しよう"
            label="タイトル"
            class="pb-5 px-2"
            v-model="title"
          ></v-text-field>
          <v-textarea
            name="input-7-1"
            :rules="textRules"
            filled
            hint="投稿の内容を入力しよう"
            label="投稿内容"
            auto-grow
            counter="150"
            v-model="text"
          ></v-textarea>
          <v-card-actions>
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
  </v-container>
</template>

<script>
export default {
  data() {
    return{
      title: '',
      text: '',
      isValid: false,
      titleRules: [
        v => !!v || '入力必須です',
        v => (!!v && 20 >= v.length) || `20文字以内で入力してください`
      ],
      textRules: [
        v => !!v || '入力必須です',
        v => (!!v && 150 >= v.length) || `150文字以内で入力してください`
      ]
    }
  },
  methods: {
    createPost(){
      axios.post('/api/posts', {
        user_id: this.$store.state.auth.userId,
        title: this.title,
        text: this.text,
      }).then(res => {
        this.$router.push('/');
      }).catch(err => {
        console.log('unable to created post')
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