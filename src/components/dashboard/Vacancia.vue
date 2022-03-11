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
            title="Vacancia"
            text="Lista de vacancias"
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
                              <v-text-field
                                v-model="editedItem.linea"
                                label="Línea" />
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card-text>

                      <v-card-text>
                        <v-container grid-list-md >
                          <v-layout wrap>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-text-field
                                v-model="editedItem.descripcion"
                                label="Descripción" />
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card-text>

                      <v-card-text>
                        <v-container grid-list-md >
                          <v-layout wrap>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-text-field
                                v-model="editedItem.categoria"
                                label="Categoría" />
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card-text>

                      <v-card-text>
                        <v-container grid-list-md >
                          <v-layout wrap>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-text-field
                                v-model="editedItem.cantidad"
                                label="Cantidad" />
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card-text>

                      <v-card-text>
                        <v-container grid-list-md >
                          <v-layout wrap>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-text-field
                                v-model="editedItem.sueldo"
                                label="Sueldo" />
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card-text>

                      <v-card-text>
                        <v-container grid-list-md >
                          <v-layout wrap>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-text-field
                                v-model="editedItem.totmensu"
                                label="Total mensual" />
                            </v-flex>
                          </v-layout>
                        </v-container>
                      </v-card-text>

                      <v-card-text>
                        <v-container grid-list-md >
                          <v-layout wrap>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-text-field
                                v-model="editedItem.vacancia"
                                label="Vacancia" />
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
              :items="VacanciaList"
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

              <template v-slot:item.linea="props">
                <v-edit-dialog
                  :return-value.sync="props.item.linea"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.linea }}</div>
                  <template v-slot:input>
                    <v-text-field
                      v-model="props.item.linea"
                      :rules="[max25chars]"
                      label="Línea"
                      single-line
                      counter
                      autofocus
                    />
                  </template>
                </v-edit-dialog>
              </template>

              <template v-slot:item.descripcion="props">
                <v-edit-dialog
                  :return-value.sync="props.item.descripcion"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.descripcion }}</div>
                  <template v-slot:input>
                    <v-text-field
                      v-model="props.item.descripcion"
                      :rules="[max25chars]"
                      label="Descripción"
                      single-line
                      counter
                      autofocus
                    />
                  </template>
                </v-edit-dialog>
              </template>

              <template v-slot:item.categoria="props">
                <v-edit-dialog
                  :return-value.sync="props.item.categoria"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.categoria }}</div>
                  <template v-slot:input>
                    <v-text-field
                      v-model="props.item.categoria"
                      :rules="[max25chars]"
                      label="Categoría"
                      single-line
                      counter
                      autofocus
                    />
                  </template>
                </v-edit-dialog>
              </template>

              <template v-slot:item.cantidad="props">
                <v-edit-dialog
                  :return-value.sync="props.item.cantidad"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.cantidad }}</div>
                  <template v-slot:input>
                    <v-text-field
                      v-model="props.item.cantidad"
                      :rules="[max25chars]"
                      label="Cantidad"
                      single-line
                      counter
                      autofocus
                    />
                  </template>
                </v-edit-dialog>
              </template>

              <template v-slot:item.sueldo="props">
                <v-edit-dialog
                  :return-value.sync="props.item.sueldo"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.sueldo }}</div>
                  <template v-slot:input>
                    <v-text-field
                      v-model="props.item.sueldo"
                      :rules="[max25chars]"
                      label="Sueldo"
                      single-line
                      counter
                      autofocus
                    />
                  </template>
                </v-edit-dialog>
              </template>

              <template v-slot:item.totmensu="props">
                <v-edit-dialog
                  :return-value.sync="props.item.totmensu"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.totmensu }}</div>
                  <template v-slot:input>
                    <v-text-field
                      v-model="props.item.totmensu"
                      :rules="[max25chars]"
                      label="Total mensual"
                      single-line
                      counter
                      autofocus
                    />
                  </template>
                </v-edit-dialog>
              </template>

              <template v-slot:item.vacancia="props">
                <v-edit-dialog
                  :return-value.sync="props.item.vacancia"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.vacancia }}</div>
                  <template v-slot:input>
                    <v-text-field
                      v-model="props.item.vacancia"
                      :rules="[max25chars]"
                      label="Vacancia"
                      single-line
                      counter
                      autofocus
                    />
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
    VacanciaList: [],
    buscando: false,
    dialog: false,
    search: '',
    headers: [
      { text: '---Acción---', value: 'accion', sortable: false },
      { text: 'Línea', value: 'linea' },
      { text: 'Descripción', value: 'descripcion' },
      { text: 'Categoría', value: 'categoria' },
      { text: 'Cantidad', value: 'cantidad' },
      { text: 'Sueldo', value: 'sueldo' },
      { text: 'Total mensual', value: 'totmensu' },
      { text: 'Vacancia', value: 'vacancia' },
    ],
    editedIndex: -1,
    editedItem: {
      linea: '',
      descripcion: '',
      categoria: '',
      cantidad: '',
      sueldo: '',
      totmensu: '',
      vacancia: '',
    },
    defaultItem: {
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
    }
  },

  watch: {
    dialog(val) {
      val || this.close()
    }
  },

  // called when page is created before dom
  created() {
    this.getVacancia()
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
      actProcesar: 'updateTableItem'
    }),

    ...mapGetters({
      getPermiso: 'auth/accesspage'
    }),

    getVacancia() {
      this.buscando = true
      this.actTableList('vacancia')
        .then( response => {
          this.buscando = false
          this.VacanciaList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    // object.assign fills in the empty object with the properties of item
    editItem(item, dbox = true) {
      this.editedIndex = this.VacanciaList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = dbox
    },

    deleteItem(item) {
      const index = this.VacanciaList.indexOf(item)
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedItem = Object.assign({}, item)
            let endpoint = `vacancia/delete/${this.editedItem.lineapres}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method)
            this.VacanciaList.splice(index, 1)
          }
        })
    },

    callTableAction(endpoint, method) {
      let tableItem = this.editedItem
      this.actProcesar({endpoint, tableItem, method})
        .then( response => {
          if(method === 'POST') {
            //this.VacanciaList.push(tableItem)
            this.getVacancia()
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
        Object.assign(this.VacanciaList[this.editedIndex], this.editedItem)
        let endpoint = `vacancia/update/${this.editedItem.lineapres}`
        let method = 'PATCH'
        this.callTableAction(endpoint, method)
      }
      else {
        let endpoint = `vacancia/add`
        let method = 'POST'
        this.callTableAction(endpoint, method)
      }
      this.close()
    },

    saveItem(item) {
      this.editedIndex = this.VacanciaList.indexOf(item)
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