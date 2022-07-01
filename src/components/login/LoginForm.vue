<template>
  <v-main>
    <v-container
      fill-height
      fluid>
      <v-layout
        align-center
        justify-center>
        <v-flex
          xs12
          sm8
          md4>
          <v-card
            class="elevation-12">
            <v-toolbar
              color="general">
              <v-toolbar-title>TH</v-toolbar-title>
              <v-spacer/>
            </v-toolbar>
            <v-card-text>
              <v-form>
                
                <v-text-field
                  ref="username"
                  v-model="username"
                  :rules="[() => !!username || 'Este campo es requerido!']"
                  prepend-icon="mdi-account"
                  label="Usuario"
                  placeholder="Thanos"
                  required
                  autocomplete="off"
                />
                
                <v-text-field
                  ref="password"
                  v-model="password"
                  :rules="[() => !!password || 'Este campo es requerido!']"
                  :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                  :type="showPassword ? 'text' : 'password'"
                  prepend-icon="mdi-lock"
                  label="Contraseña"
                  placeholder="*********"
                  counter
                  required
                  @keydown.enter="login"
                  @click:append="showPassword = !showPassword"
                />

              </v-form>
            </v-card-text>
            
            <v-card-actions>
              <v-spacer/>
              <v-btn
                align-center
                justify-center
                color="general"
                @click="login"
              >
                Iniciar
              </v-btn>
            </v-card-actions>
            <v-snackbar
              v-model="snackbar"
              :color="color"
              bottom
              transition="fade-transition"
              rounded="pill"
            >
              {{ errorMessages }}
              <template v-slot:action="{ attrs }">
                <v-btn
                  icon 
                  v-bind="attrs">
                  <v-icon
                    medium
                    class="mr-2"
                    @click="snackbar = false">mdi-close
                  </v-icon>
                </v-btn>
              </template>
            </v-snackbar>
          </v-card>
        </v-flex>
      </v-layout>

    </v-container>
  </v-main>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data() {
    return {
      username: '',
      password: '',
      errorMessages: '',
      snackbar: false,
      color: 'error',
      showPassword: false
    }
  },

  methods: {
    ...mapActions({
      actLogin: 'auth/login'
    }),

    login() {
      this.actLogin({
        username: this.username,
        password: this.password
      })
        .then(response => {
          this.$router.push('/dashboard')
        })
        .catch(error => {
          this.errorMessages = error.response.data.message
          this.snackbar = true
        })
    }
  },

  metaInfo() {
    return {
      title: 'Sistema TH | Iniciar'
    }
  }
}
</script>
