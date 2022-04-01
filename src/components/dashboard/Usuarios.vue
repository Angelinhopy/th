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
        md12
      >
        <div>
          <material-card
            color="general"
            title="Usuarios"
            text="Lista de usuarios"
          >
            <v-spacer/>

            <v-container 
              fluid
              grid-list-xl
              fill-height
            >
              <v-layout
                justify-center
                wrap
              >
                <v-flex
                  xs12
                  sm3
                  md2
                >
                  <v-dialog
                    v-model="dialog"
                    max-width="500px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        v-if="alta == 'SI'"
                        color="general"
                        dark
                        v-bind="attrs"
                        class="mb-2"
                        v-on="on"
                      >
                        <v-icon
                          medium
                          class="mr-2">mdi-pencil-plus
                        </v-icon>
                          Agregar
                      </v-btn>
                    </template>

                    <v-card>
                      <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                      </v-card-title>
                      <v-card-text>
                        <v-container grid-list-md >
                          <v-form
                            ref="formUsuario"
                            v-model="valid"
                            lazy-validation
                          >
                            <v-layout wrap>
                              <v-flex
                                xs12
                                sm12
                                md12>
                                <v-text-field
                                  :disabled="editedIndex > -1"
                                  v-model="editedItem.nombreusuario"
                                  :rules="requiredRules.general"
                                  required
                                  label="Usuario" />
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md12>
                                <v-text-field
                                  v-model="editedItem.pass"
                                  :rules="passwordRules"
                                  type="password"
                                  label="Contraseña"
                                  placeholder="*********"
                                  required
                                />
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md12>
                                <v-text-field
                                  v-model="editedItem.repass"
                                  :rules="[() => editedItem.pass == editedItem.repass || 'Las contraseñas no coinciden!']"
                                  type="password"
                                  label="Repetir contraseña"
                                  placeholder="*********"
                                  required
                                />
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md12>
                                <v-autocomplete
                                  v-model="editedItem.idperfil"
                                  :items="PerfilList"
                                  item-text="nombreperfil"
                                  item-value="idperfil"
                                  label="Perfil"
                                  required
                                  :rules="requiredRules.general"
                                ></v-autocomplete>
                              </v-flex>
                            </v-layout>
                          </v-form>
                        </v-container>
                      </v-card-text>

                      <v-card-actions>
                        <v-spacer/>
                        <v-btn
                          color="blue darken-1"
                          text
                          @click="close">Cancelar</v-btn>
                        <template v-if="editedIndex === -1">
                          <v-btn
                            color="blue darken-1"
                            text
                            :disabled="!checkAdd || !valid"
                            @click="save">Guardar</v-btn>
                        </template>
                        <template v-else-if="editedIndex > -1">
                          <v-btn
                            color="blue darken-1"
                            text
                            :disabled="!checkEdit || !valid"
                            @click="save">Guardar</v-btn>
                        </template>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-flex>

                <v-spacer />

                <v-flex
                  xs12
                  sm9
                  md10
                >
                  <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Buscar"
                    single-line
                    hide-details
                  />
                </v-flex>

              </v-layout>
            </v-container>
            
            <v-data-table
              :headers="headers"
              :items="UsuariosList"
              :search="search"
              class="elevation-1"
              no-data-text="Datos no disponibles"
              no-results-text="No se encontraron datos coincidentes"
              disable-sort
              :loading="buscando"
              loading-text="Cargando datos..."
              :footer-props="{
                itemsPerPageText: 'Item por página',
                itemsPerPageAllText: 'Todos',
              }"
            >
              <template v-slot:item.accion="props">

                <v-tooltip color="white" bottom>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn v-if="mod == 'SI'" icon v-bind="attrs" v-on="on">
                      <v-icon
                        medium
                        class="mr-2"
                        @click="editItem(props.item)">mdi-pencil
                      </v-icon>
                    </v-btn>
                  </template>
                  <span>Editar</span>
                </v-tooltip>

                <v-tooltip color="white" bottom>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn v-if="baja == 'SI'" icon v-bind="attrs" v-on="on">
                      <v-icon
                        medium
                        @click="deleteItem(props.item)">mdi-delete
                      </v-icon>
                    </v-btn>
                  </template>
                  <span>Eliminar</span>
                </v-tooltip>

              </template>

              <template v-slot:item.idperfil="props">
                <v-edit-dialog
                  :return-value.sync="props.item.idperfil"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.idperfil }}</div>
                  <template v-slot:input>
                    <v-autocomplete
                      v-model="props.item.idperfil"
                      :items="PerfilList"
                      item-text="nombreperfil"
                      item-value="idperfil"
                      label="Perfil"
                    ></v-autocomplete>
                  </template>
                </v-edit-dialog>
              </template>

              <template v-slot:footer.page-text="props">
                {{props.pageStart}} - {{props.pageStop}} de {{props.itemsLength}}
              </template>
              
            </v-data-table>

            <v-snackbar
              multi-line
              transition="fade-transition"
              rounded="pill"
              bottom
              v-model="snack"
              :timeout="3000"
              :color="snackColor"
            >
              {{ snackText }}
              <template v-slot:action="{ attrs }">
                <v-btn
                  icon 
                  v-bind="attrs">
                  <v-icon
                    medium
                    class="mr-2"
                    @click="snack = false">mdi-close
                  </v-icon>
                </v-btn>
              </template>
            </v-snackbar>

          </material-card>
        </div>
      </v-flex>

    </v-layout>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  data: () => ({
    snack: false,
    snackColor: 'error',
    snackText: '',
    max25chars: v => v.length <= 25 || 'Texto muy largo!',
    UsuariosList: [],
    PerfilList: [],
    buscando: false,
    dialog: false,
    search: '',
    headers: [
      { text: '---Acción---', value: 'accion', sortable: false },
      { text: 'Usuario', value: 'nombreusuario' },
      { text: 'Perfil', value: 'nombreperfil' },
    ],
    editedIndex: -1,
    editedItem: {
      idusuario: '',
      nombreusuario: '',
      idperfil: '',
      pass: '',
      repass: '',
    },
    defaultItem: {
    },
    passwordRules: [
      //v => !!v || 'El password es requerido',
      v => ( v && v.length >= 6) || 'Debe contener 6 caracteres como mínimo',
      v => /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/.test(v) || 'La contraseña debe contener minúscula, número, carácter especial y mayúscula ',
    ],
    valid: true,
    requiredRules: {
      general: [
        (v) => !!v || "Este campo es requerido"
      ],
    }
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? 'Agregar' : 'Editar'
    },

    alta(){
      return this.getPermiso().find( access => access.nombretabla.includes(this.$route.name)).alta
    },

    baja(){
      return this.getPermiso().find( access => access.nombretabla.includes(this.$route.name)).baja
    },  

    mod(){
      return this.getPermiso().find( access => access.nombretabla.includes(this.$route.name)).mod
    },

    checkAdd(){
      return this.editedItem.nombreusuario && this.editedItem.pass && this.editedItem.repass && this.editedItem.idperfil || 0
    },

    checkEdit(){
      return this.editedItem.nombreusuario && this.editedItem.idperfil || 0
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    }
  },

  // called when page is created before dom
  created() {
    this.getUsuarios()
    this.getPerfil()
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
      actProcesar: 'updateTableItem'
    }),
    
    ...mapGetters({
      getPermiso: 'auth/accesspage'
    }),

    getUsuarios() {
      this.buscando = true
      this.actTableList('usuarios')
        .then( response => {
          this.buscando = false
          this.UsuariosList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getPerfil() {
      this.actTableList('perfil')
        .then( response => {
          this.PerfilList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    // object.assign fills in the empty object with the properties of item
    editItem(item, dbox = true) {
      this.editedIndex = this.UsuariosList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = dbox
    },

    deleteItem(item) {
      const index = this.UsuariosList.indexOf(item)
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedItem = Object.assign({}, item)
            let endpoint = `usuario/delete/${this.editedItem.idusuario}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method)
            this.UsuariosList.splice(index, 1)
          }
        })
    },

    callTableAction(endpoint, method) {
      let tableItem = this.editedItem
      this.actProcesar({endpoint, tableItem, method})
        .then( response => {
          if(method === 'POST') {
            //this.UsuariosList.push(tableItem)
            this.getUsuarios()
          }
          this.saveInline()
        })
        .catch(error => {
          console.log(error)
          this.cancelInline()
        })
    },

    save() {
      if( this.$refs.formUsuario.validate() ){
        if(this.editedIndex > -1) {
          if(this.editedItem.pass !== this.editedItem.repass){
            this.cancelInline()
            return
          }
          Object.assign(this.UsuariosList[this.editedIndex], this.editedItem)
          let endpoint = `usuario/update/${this.editedItem.idusuario}`
          let method = 'PATCH'
          this.callTableAction(endpoint, method)
        }
        else {
          if(this.editedItem.pass !== this.editedItem.repass){
            this.cancelInline()
            return
          }
          let endpoint = `usuario/add`
          let method = 'POST'
          this.callTableAction(endpoint, method)
        }
        this.close()
      }
    },

    saveItem(item) {
      this.editedIndex = this.UsuariosList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.save()
    },

    // toasts/snackbar messages for actions
    saveInline() {
      this.snack = true
      this.snackColor = 'success'
      this.snackText = 'Datos guardados'
    },

    cancelInline() {
      this.snack = true
      this.snackColor = 'error'
      this.snackText = 'Ocurrio algun error'
    },

    close() {
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },
  }
}
</script>

<style scoped>
  table.v-table thead tr {
    color: red !important;
  }
  tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, .05);
  }
</style>