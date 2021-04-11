<template>
  <div v-show="$store.getters['auth/isLogin'] === true" class="d-sm-none">
    <router-link to="/post" tag="p">
      <v-btn
        class="mx-2"
        fab
        dark
        x-large
        color="info"
      >
        <v-icon dark>
          mdi-pencil
        </v-icon>
      </v-btn>
    </router-link>
  </div>
</template>

<script>
export default {

}
</script>

<style>

</style>