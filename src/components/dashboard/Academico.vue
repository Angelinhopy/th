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
            title="Nivel Académico"
            text="Lista de nivel académico"
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
                                v-model="editedItem.idpersonal"
                                :items="EmpleadoList"
                                item-text="nomape"
                                item-value="idpersonal"
                                label="Empleado"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md5>
                              <v-autocomplete
                                v-model="editedItem.cicloacademico"
                                :items="CicloAcademicoList"
                                item-text="descripcion"
                                item-value="ciclo"
                                label="Ciclo Académico"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md3>
                              <v-text-field
                                v-model="editedItem.grado_curso"
                                label="Grado/Curso" />
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md4>
                              <v-select
                                v-model="editedItem.completo"
                                :items="[{compl: 'C', descripcion: 'Completa'},{compl: 'I', descripcion: 'Incompleta'}]"
                                item-text="descripcion"
                                item-value="compl"
                                label="Completa"
                              >
                              </v-select>
                            </v-flex>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-autocomplete
                                v-model="editedItem.idcolegio"
                                :items="ColegioList"
                                item-text="descripcion"
                                item-value="idcolegio"
                                label="Colegio"
                                :append-icon="'mdi-plus'"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-autocomplete
                                v-model="editedItem.iduniversidad"
                                :items="UniversidadList"
                                item-text="descripcion"
                                item-value="iduniversidad"
                                label="Universidad"
                                :append-icon="'mdi-plus'"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-autocomplete
                                v-model="editedItem.idfacultad"
                                :items="FacultadList"
                                item-text="descripcion"
                                item-value="idfacultad"
                                label="Facultad"
                                :append-icon="'mdi-plus'"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-autocomplete
                                v-model="editedItem.idcarrera"
                                :items="CarreraList"
                                item-text="descripcion"
                                item-value="idcarrera"
                                label="Carrera"
                                :append-icon="'mdi-plus'"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-autocomplete
                                v-model="editedItem.idtitulo"
                                :items="TituloList"
                                item-text="descripcion"
                                item-value="idtitulo"
                                label="Título"
                                :append-icon="'mdi-plus'"
                              ></v-autocomplete>
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
              :items="AcademicoList"
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

              <template v-slot:item.cicloacademico="props">
                {{ academic(props.item.cicloacademico) }}
              </template>

              <template v-slot:item.completo="props">
                <template v-if="props.item.completo == 'C'">
                  Completa
                </template>
                <template v-else-if="props.item.completo == 'I'">
                  Incompleta
                </template>
              </template>

              <!--template v-slot:item.galpon="props">

                <v-edit-dialog
                  :return-value.sync="props.item.galpon"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.galpon }}</div>
                  <template v-slot:input>
                    <v-text-field
                      v-model="props.item.galpon"
                      :rules="[max25chars]"
                      label="Galpón"
                      single-line
                      counter
                      autofocus
                    />
                  </template>
                </v-edit-dialog>

              </!--template-->

              <!--template v-slot:item.desc_galpon="props">
                <v-edit-dialog
                  :return-value.sync="props.item.desc_galpon"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.desc_galpon }}</div>
                  <template v-slot:input>
                    <v-text-field
                      v-model="props.item.desc_galpon"
                      :rules="[max25chars]"
                      label="Descripción"
                      single-line
                      counter
                      autofocus
                    />
                  </template>
                </v-edit-dialog>
              </!--template-->

              <!--template v-slot:item.granja="props">
                <v-edit-dialog
                  :return-value.sync="props.item.id_granja"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.granja }}</div>
                  <template v-slot:input>
                    <v-select
                      v-model="props.item.id_granja"
                      :items="GranjaList"
                      item-text="granja"
                      item-value="id_granja"
                      label="Granja"
                      :append-icon="'mdi-plus'"
                      single-line
                      autofocus
                    ></v-select>
                  </template>
                </v-edit-dialog>
              </!--template-->

              <!--template v-slot:item.estado="props">
                <v-edit-dialog
                  :return-value.sync="props.item.estado"
                  large
                  lazy
                  persistent
                  @save="saveItem(props.item)"
                  save-text="Guardar"
                  cancel-text="Cancelar"
                >
                  <div>{{ props.item.estado }}</div>
                  <template v-slot:input>
                    <v-select
                      v-model="props.item.estado"
                      :items="['AC','IN']"
                      label="Estado"
                      :append-icon="'mdi-plus'"
                      single-line
                      autofocus
                    ></v-select>
                  </template>
                </v-edit-dialog>
              </!--template-->

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
    max25chars: v => v.length <= 25 || 'Texto demasiado largo!',
    AcademicoList: [],
    buscando: false,
    dialog: false,
    search: '',
    headers: [
      { text: '---Acción---', value: 'accion', sortable: false },
      { text: 'Nombre Empleado', value: 'nombre' },
      { text: 'Apellido Empleado', value: 'apellido' },
      { text: 'Nro. Cédula', value: 'ci' },
      { text: 'Ciclo Acad.', value: 'cicloacademico' },
      { text: 'Completa', value: 'completo' },
      { text: 'Grado/Curso', value: 'grado_curso' },
      { text: 'Colegio', value: 'colegio'},
      { text: 'Universidad', value: 'universidad' },
      { text: 'Facultad', value: 'facultad' },
      { text: 'Carrera', value: 'carrera' },
      { text: 'Título', value: 'titulo' },
    ],
    editedIndex: -1,
    editedItem: {
      cicloacademico: '',
      completo: '',
      idcolegio: '',
      iduniversidad: '',
      idfacultad: '',
      idcarrera: '',
      grado_curso: '',
      idtitulo: '',
      idpersonal: '',
    },
    defaultItem: {
    },
    ColegioList: [],
    UniversidadList: [],
    FacultadList: [],
    CarreraList: [],
    TituloList: [],
    EmpleadoList: [],
    CicloAcademicoList: [
      { ciclo: "0", descripcion: '"S/D"'},
      { ciclo: "1", descripcion: 'Primario'},
      { ciclo: "3", descripcion: 'Ciclo Básico'},
      { ciclo: "4", descripcion: 'Secundario'},
      { ciclo: "6", descripcion: 'Universitario'},
      { ciclo: "21", descripcion: 'Educ. Inicial'},
      { ciclo: "22", descripcion: 'Educ. Escolar Media'},
      { ciclo: "23", descripcion: 'Educ. Media'},
      { ciclo: "24", descripcion: 'Educ. Técnica Superior'},
      { ciclo: "25", descripcion: 'Educ. Superior'},
    ],
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
    this.getAcademico()
    this.getColegio()
    this.getUniversidad()
    this.getFacultad()
    this.getCarrera()
    this.getTitulo()
    this.getEmpleado()
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
      actProcesar: 'updateTableItem'
    }),    

    ...mapGetters({
      getPermiso: 'auth/accesspage'
    }),

    getAcademico() {
      this.actTableList('academico')
        .then( response => {
          this.AcademicoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getColegio() {
      this.actTableList('centro')
        .then( response => {
          this.ColegioList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getUniversidad() {
      this.actTableList('universidad')
        .then( response => {
          this.UniversidadList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getFacultad() {
      this.actTableList('facultad')
        .then( response => {
          this.FacultadList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getCarrera() {
      this.actTableList('carrera')
        .then( response => {
          this.CarreraList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getTitulo() {
      this.actTableList('titulo')
        .then( response => {
          this.TituloList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getEmpleado() {
      this.buscando = true
      this.actTableList('empleado')
        .then( response => {
          this.buscando = false
          this.EmpleadoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    academic(id){
      return this.CicloAcademicoList.find( academic => academic.ciclo.includes(id)).descripcion
    },
    
    // object.assign fills in the empty object with the properties of item
    editItem(item, dbox = true) {
      this.editedIndex = this.AcademicoList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = dbox
    },

    deleteItem(item) {
      const index = this.AcademicoList.indexOf(item)
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedItem = Object.assign({}, item)
            let endpoint = `academico/delete/${this.editedItem.idnivelacademico}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method)
            this.AcademicoList.splice(index, 1)
          }
        })
    },

    callTableAction(endpoint, method) {
      let tableItem = this.editedItem
      this.actProcesar({endpoint, tableItem, method})
        .then( response => {
          this.getAcademico()
          this.saveInline()
        })
        .catch(error => {
          console.log(error)
          this.cancelInline()
        })
    },

    save() {
      if(this.editedIndex > -1) {
        Object.assign(this.AcademicoList[this.editedIndex], this.editedItem)
        let endpoint = `academico/update/${this.editedItem.idnivelacademico}`
        let method = 'PATCH'
        this.callTableAction(endpoint, method)
      }
      else {
        let endpoint = `academico/add`
        let method = 'POST'
        this.callTableAction(endpoint, method)
      }
      this.close()
    },

    saveItem(item) {
      this.editedIndex = this.AcademicoList.indexOf(item)
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