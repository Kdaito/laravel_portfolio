<template>
<div>
 <v-card width="400px" class="mx-auto mt-16">
     <v-card-title class="d-flex justify-center align-center info white--text">
        <p class="display-1 my-0">ログイン</p>
     </v-card-title>
     <v-divider class="my-0"></v-divider>
     <v-card-text>
         <p v-text="$store.state.alert.message" class="red--text"></p>
         <v-form @submit.prevent="login" v-model="isValid">
            <v-text-field 
              prepend-icon="mdi-account-circle" 
              type="email" 
              label="メールアドレス" 
              v-model="email"
              :rules="emailRules"
            ></v-text-field>
            <v-text-field 
              v-model="password" 
              :type="showPassword ? 'text' : 'password'" 
              prepend-icon="mdi-lock" 
              :rules="passRules"
              :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" 
              label="パスワード" 
              @click:append="showPassword = !showPassword"
            ></v-text-field>
            <v-card-actions>
                <v-btn class="info" type="submit" :disabled="!isValid">ログイン</v-btn>
            </v-card-actions>
         </v-form>
         <router-link to="register">まだ登録していない方はこちら</router-link>
     </v-card-text>
 </v-card>
</div>
</template>
 
<script>
export default {
    data () {
        return {
            email: 'kdaito0620@gmail.com',
            password: 'password123',
            showPassword: false,
            isValid: false,
            errorMessage: this.$store.state.message,
            emailRules: [
                v => !!v || '必須項目です',
                v => /.+@.+\..+/.test(v) || '正しい形式で入力してください'
            ],
            passRules: [
                v => !!v || '必須項目です',
            ]
            
        }
    },
    methods: {
        login(){
            this.$store.dispatch('auth/login', {
                email: this.email,
                password: this.password
            })
        }
    }
}
</script>