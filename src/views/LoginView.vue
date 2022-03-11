<template>
  <v-app
    id="login-view"
    dark>

    <v-main>
      <transition mode="out-in">
        <router-view/>
      </transition>
    </v-main>

  </v-app>
</template>

<script>
export default {
  name: 'LoginView',
}
</script>

<style>
</style>