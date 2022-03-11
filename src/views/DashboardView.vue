<template>
  <v-app id="dashboard-view">
    <v-navigation-drawer
      v-model="drawer"
      app
      :clipped="clipped"
      overflow
    >
      <v-list height="64">
        <v-list-item>
          <v-list-item-avatar color="grey">
            <v-icon large>{{ letra }}</v-icon>
          </v-list-item-avatar>
          <v-list-item-title class="title">{{ getUser().nombreusuario }}</v-list-item-title>
        </v-list-item>
      </v-list>
      
      <v-divider />

      <navbar />

    </v-navigation-drawer>

    <v-app-bar
      app
      :clipped-left="clipped"
      color="blue darken-3"
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Administración</v-toolbar-title>

      <v-spacer></v-spacer>  

      <v-tooltip color="white" left>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on" @click="logout">
            <v-icon>mdi-power</v-icon>
          </v-btn>
        </template>
        <span>Cerrar sesión</span>
      </v-tooltip>
    </v-app-bar>

    <v-main>
      <v-fade-transition mode="out-in">
        <router-view />
      </v-fade-transition>
    </v-main>

    <v-footer app inset>
      <span>&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'
  import navbar from '@/components/layout/navbar'
  export default {
  components: { navbar },
    name: 'DashboardView',
    metaInfo() {
      return {
        title: 'Administración TH'
      }
    },
    data: () => ({
      drawer: null,
      clipped: false,
    }),
    created () {
    },
    computed: {
      letra () {
        return `mdi-alpha-${this.getUser().nombreusuario.charAt(0).toLowerCase()}`
      }
    },
    methods: {
      ...mapActions ({
        actLogout: 'auth/logout'
      }),
      
      ...mapGetters ({
        getUser: 'auth/username'
      }),

      logout () {
        this.actLogout()
          .then(() => {
            this.$router.push('/')
          })
      }
    },
  }
</script>