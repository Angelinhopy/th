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
            title="Acceso"
            text="Lista de accesos"
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
                          <v-layout wrap>
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
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-autocomplete
                                v-model="editedItem.idpermiso"
                                :items="PermisoList"
                                item-text="nombretabla"
                                item-value="idpermiso"
                                label="Permiso"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm3
                              md3>
                              <v-select
                                v-model="editedItem.alta"
                                :items="siono"
                                item-text="option"
                                item-value="val"
                                label="Alta"
                                :append-icon="'mdi-plus'"
                              ></v-select>
                            </v-flex>
                            <v-flex
                              xs12
                              sm3
                              md3>
                              <v-select
                                v-model="editedItem.baja"
                                :items="siono"
                                item-text="option"
                                item-value="val"
                                label="Baja"
                                :append-icon="'mdi-plus'"
                              ></v-select>
                            </v-flex>
                            <v-flex
                              xs12
                              sm3
                              md3>
                              <v-select
                                v-model="editedItem.mod"
                                :items="siono"
                                item-text="option"
                                item-value="val"
                                label="Modificación"
                                :append-icon="'mdi-plus'"
                              ></v-select>
                            </v-flex>
                            <v-flex
                              xs12
                              sm3
                              md3>
                              <v-select
                                v-model="editedItem.cons"
                                :items="siono"
                                item-text="option"
                                item-value="val"
                                label="Consulta"
                                :append-icon="'mdi-plus'"
                              ></v-select>
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card-text>

                      <v-card-actions>
                        <v-spacer/>
                        <v-btn
                          color="blue darken-1"
                          text
                          @click="close">Cancelar</v-btn>
                        <v-btn
                          color="blue darken-1"
                          text
                          @click="save">Guardar</v-btn>
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
              :items="AccesoList"
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

              <template v-slot:item.alta="props">
                <v-edit-dialog
                  :return-value.sync="props.item.alta"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.alta }}</div>
                  <template v-slot:input>
                    <v-select
                      v-model="props.item.alta"
                      :items="siono"
                      item-text="option"
                      item-value="val"
                      label="Alta"
                      :append-icon="'mdi-plus'"
                    ></v-select>
                  </template>
                </v-edit-dialog>
              </template>

              <template v-slot:item.baja="props">
                <v-edit-dialog
                  :return-value.sync="props.item.baja"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.baja }}</div>
                  <template v-slot:input>
                    <v-select
                      v-model="props.item.baja"
                      :items="siono"
                      item-text="option"
                      item-value="val"
                      label="Baja"
                      :append-icon="'mdi-plus'"
                    ></v-select>
                  </template>
                </v-edit-dialog>
              </template>

              <template v-slot:item.mod="props">
                <v-edit-dialog
                  :return-value.sync="props.item.mod"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.mod }}</div>
                  <template v-slot:input>
                    <v-select
                      v-model="props.item.mod"
                      :items="siono"
                      item-text="option"
                      item-value="val"
                      label="Modificación"
                      :append-icon="'mdi-plus'"
                    ></v-select>
                  </template>
                </v-edit-dialog>
              </template>

              <template v-slot:item.cons="props">
                <v-edit-dialog
                  :return-value.sync="props.item.cons"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.cons }}</div>
                  <template v-slot:input>
                    <v-select
                      v-model="props.item.cons"
                      :items="siono"
                      item-text="option"
                      item-value="val"
                      label="Consulta"
                      :append-icon="'mdi-plus'"
                    ></v-select>
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
    AccesoList: [],
    buscando: false,
    dialog: false,
    search: '',
    headers: [
      { text: '---Acción---', value: 'accion', sortable: false },
      { text: 'Nombre perfil', value: 'nombreperfil' },
      { text: 'Nombre tabla', value: 'nombretabla' },
      { text: 'Alta', value: 'alta' },
      { text: 'Baja', value: 'baja' },
      { text: 'Modificación', value: 'mod' },
      { text: 'Consulta', value: 'cons' },
    ],
    editedIndex: -1,
    editedItem: {
      idpermiso: '',
      idperfil: '',
      alta: 'SI',
      baja: 'SI',
      mod: 'SI',
      cons: 'SI',
    },
    defaultItem: {
      idpermiso: '',
      idperfil: '',
      alta: 'SI',
      baja: 'SI',
      mod: 'SI',
      cons: 'SI',
    },
    siono: [
      {option: 'SI', val: 'SI'},
      {option: 'NO', val: 'NO'},
    ],
    PerfilList: [],
    PermisoList: [],
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? 'Agregar' : 'Editar'
    },

    alta(){
      return this.getAccesopage().find( access => access.nombretabla.includes(this.$route.name)).alta
    },

    baja(){
      return this.getAccesopage().find( access => access.nombretabla.includes(this.$route.name)).baja
    },  

    mod(){
      return this.getAccesopage().find( access => access.nombretabla.includes(this.$route.name)).mod
    }
  },

  watch: {
    dialog(val) {
      val || this.close()
    }
  },

  // called when page is created before dom
  created() {
    this.getAcceso()
    this.getPerfil()
    this.getPermiso()
    this.getUsername()
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
      actProcesar: 'updateTableItem',
      actPermiso: 'auth/permisorenew',
    }),

    ...mapGetters({
      getUsername: 'auth/username',
      getAccesopage: 'auth/accesspage'
    }),

    getAcceso() {
      this.buscando = true
      this.actTableList('acceso')
        .then( response => {
          this.buscando = false
          this.AccesoList = response.data
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

    getPermiso() {
      this.actTableList('permiso')
        .then( response => {
          this.PermisoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    // object.assign fills in the empty object with the properties of item
    editItem(item, dbox = true) {
      this.editedIndex = this.AccesoList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = dbox
    },

    deleteItem(item) {
      const index = this.AccesoList.indexOf(item)
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedItem = Object.assign({}, item)
            let endpoint = `acceso/delete/${this.editedItem.idpermiso}/${this.editedItem.idperfil}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method)
            this.AccesoList.splice(index, 1)
          }
        })
    },

    callTableAction(endpoint, method) {
      let tableItem = this.editedItem
      this.actProcesar({endpoint, tableItem, method})
        .then( response => {
          if(method === 'POST' || method === 'PATCH') {
            this.getAcceso()
            this.actPermiso(this.getUsername().idperfil)
              .then( () => {})
              .catch( () => {})
          }
          this.saveInline()
        })
        .catch(error => {
          console.log(error)
          this.cancelInline()
        })
    },

    save() {
      if(this.editedIndex > -1) {
        Object.assign(this.AccesoList[this.editedIndex], this.editedItem)
        let endpoint = `acceso/update/${this.editedItem.idpermiso}/${this.editedItem.idperfil}`
        let method = 'PATCH'
        this.callTableAction(endpoint, method)
      }
      else {
        let endpoint = `acceso/add`
        let method = 'POST'
        this.callTableAction(endpoint, method)
      }
      this.close()
    },

    saveItem(item) {
      this.editedIndex = this.AccesoList.indexOf(item)
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