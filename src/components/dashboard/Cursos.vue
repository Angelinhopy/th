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
            title="Cursos"
            text="Lista de cursos"
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
                              md6>
                              <v-select
                                v-model="editedItem.tipocurso"
                                :items="[{tipo: '1', descripcion: 'En el País'},{tipo: '2', descripcion: 'En el Exterior'},]"
                                item-text="descripcion"
                                item-value="tipo"
                                label="Tipo Curso"
                              >
                              </v-select>
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md6>
                              <v-text-field
                                v-model="editedItem.nombrecurso"
                                label="Nombre Curso" />
                            </v-flex>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-text-field
                                v-model="editedItem.institucion"
                                label="Institución" />
                            </v-flex>
                            <v-flex
                              xs12
                              sm3
                              md3>
                              <!--v-text-field
                                v-model="editedItem.fecha_inicio"
                                hint="YYYY-MM-DD"
                                label="Fecha Inicio" /-->
                              <v-menu
                                  v-model="calendarioFecIni"
                                  :close-on-content-click="false"
                                  :nudge-right="40"
                                  transition="scale-transition"
                                  offset-y
                                  min-width="auto"
                                >
                                  <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                      v-model="editedItem.fecha_inicio"
                                      label="Fecha Inicio"
                                      v-bind="attrs"
                                      @blur="dateFecha_inicio = editedItem.fecha_inicio"
                                      v-on="on"
                                    ></v-text-field>
                                  </template>
                                  <v-date-picker
                                    v-model="dateFecha_inicio"
                                    @input="calendarioFecIni = false"
                                    locale="ES"
                                  ></v-date-picker>
                                </v-menu>
                            </v-flex>
                            <v-flex
                              xs12
                              sm3
                              md3>
                              <!--v-text-field
                                v-model="editedItem.fecha_fin"
                                hint="YYYY-MM-DD"
                                label="Fecha Fin" /-->
                              <v-menu
                                  v-model="calendarioFecFin"
                                  :close-on-content-click="false"
                                  :nudge-right="40"
                                  transition="scale-transition"
                                  offset-y
                                  min-width="auto"
                                >
                                  <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                      v-model="editedItem.fecha_fin"
                                      label="Fecha Fin"
                                      v-bind="attrs"
                                      @blur="dateFecha_fin = editedItem.fecha_fin"
                                      v-on="on"
                                    ></v-text-field>
                                  </template>
                                  <v-date-picker
                                    v-model="dateFecha_fin"
                                    @input="calendarioFecFin = false"
                                    locale="ES"
                                  ></v-date-picker>
                                </v-menu>
                            </v-flex>
                            <v-flex
                              xs12
                              sm3
                              md3>
                              <v-text-field
                                v-model="editedItem.nota"
                                label="Nota" />
                            </v-flex>
                            <v-flex
                              xs12
                              sm3
                              md3>
                              <v-text-field
                                v-model="editedItem.rendimiento"
                                label="Rendimiento" />
                            </v-flex>
                            <v-flex
                              xs12
                              sm4
                              md3>
                              <v-text-field
                                v-model="editedItem.asistencia"
                                label="Asistencia" />
                            </v-flex>
                            <v-flex
                              xs12
                              sm9
                              md9>
                              <v-text-field
                                v-model="editedItem.observacion"
                                label="Observación" />
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md6>
                              <v-autocomplete
                                v-model="editedItem.idciudad"
                                :items="CiudadList"
                                item-text="descripcion"
                                item-value="idciudad"
                                label="Ciudad"
                                :append-icon="'mdi-plus'"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md6>
                              <v-autocomplete
                                v-model="editedItem.idpais"
                                :items="PaisList"
                                item-text="descripcion"
                                item-value="idpais"
                                label="País"
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
              :items="CursosList"
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

              <template v-slot:item.tipocurso="props">
                <template v-if="props.item.tipocurso == 1">
                  En el País
                </template>
                <template v-else-if="props.item.tipocurso == 2">
                  En el Exterior
                </template>
              </template>

              <template v-slot:item.fecha_inicio="props">
                {{ formatDate(props.item.fecha_inicio) }}
              </template>

              <template v-slot:item.fecha_fin="props">
                {{ formatDate(props.item.fecha_fin) }}
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
    CursosList: [],
    buscando: false,
    dialog: false,
    search: '',
    headers: [
      { text: '---Acción---', value: 'accion', sortable: false },
      { text: 'Tipo Curso', value: 'tipocurso' },
      { text: 'Nombre Curso', value: 'nombrecurso' },
      { text: 'Institución', value: 'institucion'},
      { text: 'Fecha Inicio', value: 'fecha_inicio' },
      { text: 'Fecha Fin', value: 'fecha_fin' },
      { text: 'Nota', value: 'nota' },
      { text: 'Rendimiento', value: 'rendimiento' },
      { text: 'Asistencia', value: 'asistencia' },
      { text: 'Observación', value: 'observacion' },
      { text: 'Nombre Empleado', value: 'nombre' },
      { text: 'Apellido Empleado', value: 'apellido' },
      { text: 'Nro. Cédula', value: 'ci' },
      { text: 'Ciudad', value: 'ciudad' },
      { text: 'País', value: 'pais' },
    ],
    editedIndex: -1,
    editedItem: {
      tipocurso: '',
      nombrecurso: '',
      institucion: '',
      fecha_inicio: '',
      fecha_fin: '',
      nota: '',
      rendimiento: '',
      asistencia: '',
      observacion: '',
      idpersonal: '',
      idciudad: '',
      idpais: '',
    },
    defaultItem: {
    },
    EmpleadoList: [],
    CiudadList: [],
    PaisList: [],
    calendarioFecIni: false,
    calendarioFecFin: false,
    dateFecha_inicio: null,
    dateFecha_fin: null,
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

    computedDateFormattedFecIni () {
      return this.formatDate(this.editedItem.fecha_inicio)
    },

    computedDateFormattedFecFin () {
      return this.formatDate(this.editedItem.fecha_fin)
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },

    dateFecha_inicio(val){
      this.editedItem.fecha_inicio = this.dateFecha_inicio
    },

    dateFecha_fin(val){
      this.editedItem.fecha_fin = this.dateFecha_fin
    },
  },

  // called when page is created before dom
  created() {
    this.getCursos()
    this.getEmpleado()
    this.getCiudad()
    this.getPais()
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
      actProcesar: 'updateTableItem'
    }),

    ...mapGetters({
      getPermiso: 'auth/accesspage'
    }),

    getCursos() {
      this.actTableList('cursos')
        .then( response => {
          this.CursosList = response.data
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

    getCiudad() {
      this.actTableList('ciudad')
        .then( response => {
          this.CiudadList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getPais() {
      this.actTableList('pais')
        .then( response => {
          this.PaisList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },
    
    // object.assign fills in the empty object with the properties of item
    editItem(item, dbox = true) {
      this.editedIndex = this.CursosList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = dbox
    },

    deleteItem(item) {
      const index = this.CursosList.indexOf(item)
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedItem = Object.assign({}, item)
            let endpoint = `cursos/delete/${this.editedItem.idcurso}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method)
            this.CursosList.splice(index, 1)
          }
        })
    },

    callTableAction(endpoint, method) {
      let tableItem = this.editedItem
      this.actProcesar({endpoint, tableItem, method})
        .then( response => {
          this.getCursos()
          this.saveInline()
        })
        .catch(error => {
          console.log(error)
          this.cancelInline()
        })
    },

    formatDate (date) {
      if (!date) return null

      const [year, month, day] = date.split('-')
      return `${day}-${month}-${year}`
    },

    save() {
      if(this.editedIndex > -1) {
        Object.assign(this.CursosList[this.editedIndex], this.editedItem)
        let endpoint = `cursos/update/${this.editedItem.idcurso}`
        let method = 'PATCH'
        this.callTableAction(endpoint, method)
      }
      else {
        let endpoint = `cursos/add`
        let method = 'POST'
        this.callTableAction(endpoint, method)
      }
      this.close()
    },

    saveItem(item) {
      this.editedIndex = this.CursosList.indexOf(item)
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