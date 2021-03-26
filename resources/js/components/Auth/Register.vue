<template>
  <div>
    <v-card width="400" class="mt-16 mx-auto">
      <v-card-title class="d-flex justify-center align-center info">
        <p class="display-1 my-0 white--text">アカウント登録</p>
      </v-card-title>
      <v-divider class="my-0"></v-divider>
      <v-card-text>
        <div v-show="isError === true" class="red--text my-0">
          <p class="mb-0 subtitle-1">アカウント登録に失敗しました。</p>
          <p class="my-0">※メールアドレスを変えてもう1度試してみてください</p>
        </div>
        <v-form @submit.prevent="register" v-model="isValid">
            <v-text-field 
              label="ユーザー名を入力" 
              prepend-icon="mdi-account-circle"
              :counter="max"
              v-model="name"
              :rules="nameRules"
            ></v-text-field>
            <v-text-field 
              type="email" 
              prepend-icon="mdi-email"
              label="メールアドレスを入力" 
              v-model="email"
              :rules="emailRules"
            ></v-text-field>
            <v-text-field 
              prepend-icon="mdi-lock"
              v-model="password" 
              :rules="passRules"
              :counter="passMax"
              :type="showPassword ? 'text' : 'password'" 
              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" 
              @click:append="showPassword = !showPassword"
              label="パスワードを入力"></v-text-field>
            <v-card-actions>
                <v-btn class="info" type="submit" :disabled="!isValid">登録する</v-btn>
            </v-card-actions>
        </v-form>
        <router-link to="login">ログイン画面へ</router-link>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  data(){
    const max = 30;
    const min = 8;
    const passMax = 20
    return{
      name: '',
      email: '',
      password: '',
      isValid: false,
      isError: false,
      max,
      passMax,
      showPassword: false,
      nameRules: [
        v => !!v || '必須項目です',
        v => (!!v && max >= v.length) || `${max}文字以内で入力してください`
      ],
      emailRules: [
        v => !!v || '必須項目です',
        v => /.+@.+\..+/.test(v) || '正しくメールアドレスを入力してください' 
      ],
      passRules: [
        v => !!v || '必須項目です',
        v => /^[\w-]{8,72}$/.test(v) || `${min}文字以上。半角英数字、ハイフン、アンダーバーが使えます`,
        v => (!!v && 20 >= v.length) || `20文字以内で入力してください`
      ]
    }
  },
  methods: {
    register() {
      axios.post('/api/register', {
        name: this.name,
        email: this.email,
        password: this.password
      }).then(res => {
        console.log(res)
        this.isError = false
        this.$router.push({path: '/login'});
      }).catch(res => {
        console.log(res)
        this.isError = true
      })
    }
  }
}
</script>