<template>
  <v-container>
    <v-card max-width="500px" class="mx-auto pt-5" >
      <v-card-title class="pb-2 pt-0">{{user.name}}</v-card-title>
      <v-card-subtitle class="pb-4">{{user.created_at}}から利用しています</v-card-subtitle>
      <v-card-text class="pb-5">{{user.text}}</v-card-text>
      <v-divider></v-divider>
      <div class="d-flex justify-center align-center">
        <p class="d-inline-block post_title text-subtitle-1">プロフィールを編集する</p>
      </div>
      <v-container fluid>
        <v-form @submit.prevent="editProfile" v-model="isValid">
          <v-textarea
            name="input-7-1"
            :rules="textRules"
            filled
            hint="プロフィールの内容を入力しよう"
            label="プロフィール"
            auto-grow
            counter="150"
            v-model="text"
          ></v-textarea>
          <v-card-actions>
            <v-btn 
              color="green"
              dark
              @click="back"
              large
            >
            戻る</v-btn>
            <v-btn 
              class="info"
              type="submit"
              :disabled="!isValid"
              large
            >
            編集する</v-btn>
          </v-card-actions>
        </v-form>
      </v-container>
    </v-card>
  </v-container>
</template>

<script>
export default {
  props: {
    user: Object
  },
  data() {
    return{
      text: this.user.text,
      isValid: false,
      textRules: [
        v => (150 >= v.length) || `150文字以内で入力してください`
      ]
    }
  },
  methods: {
    back(){
      this.$router.go(-1)
    },
    editProfile(){
      axios.post('/api/editProfile/', {
        user_id: this.$store.state.auth.userId,
        text: this.text
      })
      .then(res => {
        this.$router.back()
      })
      .catch(err => console.log(err))
    }
  }
}
</script>

<style>
  .post_title{
    border-bottom: 5px skyblue solid;
  }
</style>