<template>
  <v-container
    fill-height
    fluid
    grid-list-xl
  >
    <v-layout
      justify-center
      wrap
    >
      <v-flex
        md10
      >
        <div>
          <h1>No posee autorización</h1>
          <v-alert
            icon="mdi-shield-lock-outline"
            prominent
            text
            type="info"
          >
            <h3>Atención</h3>
            <div>La página en la que está tratando de acceder posee acceso restringido por el administrador. Necesita un rol de usuario con permisos especiales para poder ingresar.</div>
          </v-alert>
        </div>
      </v-flex>

    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'unauthorized',
  data: () => ({
  }),
}
</script>

<style>
</style>