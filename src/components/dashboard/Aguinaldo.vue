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
            title="Aguinaldo"
            text="Lista de aguinaldos"
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
                <!--v-flex
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
                                item-text="nombre"
                                item-value="idpersonal"
                                label="Empleado"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md6>
                              <v-text-field
                                v-model="editedItem.ci_emple"
                                label="Nro. Cédula" />
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md3>
                              <v-text-field
                                v-model="editedItem.periodo"
                                label="Periodo" />
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md3>
                              <v-text-field
                                v-model="editedItem.mes"
                                label="Mes" />
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
                          @click="save('evaluacion')">Guardar</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-flex-->

                <v-spacer />

                <v-flex
                  xs12
                  sm12
                  md12
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
              :items="AguinaldoList"
              :single-expand="singleExpand"
              :expanded.sync="expanded"
              item-key="idaguinaldo"
              show-expand
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

                <!--v-tooltip color="white" bottom>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                      <v-icon
                        medium
                        class="mr-2"
                        @click="editItem(props.item)">mdi-pencil
                      </v-icon>
                    </v-btn>
                  </template>
                  <span>Editar</span>
                </!--v-tooltip-->

                <v-tooltip color="white" bottom>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn v-if="baja == 'SI'" icon v-bind="attrs" v-on="on">
                      <v-icon
                        medium
                        @click="deleteItem(props.item, 'aguinaldo')">mdi-delete
                      </v-icon>
                    </v-btn>
                  </template>
                  <span>Eliminar</span>
                </v-tooltip>

              </template>

              <template v-slot:item.mes="props">
                {{ mes(props.item.mes) }}
              </template>

              <template v-slot:expanded-item="{ headers, item }">

                <td :colspan="headers.length">
                  <v-dialog
                    v-model="dialogDet"
                    max-width="500px"
                  >
                    <!--template v-slot:activator="{ on, attrs }">
                      <v-btn
                        color="indigo"
                        dark
                        v-bind="attrs"
                        class="mb-2"
                        v-on="on"
                        @click="editedDetItem.idaguinaldo = item.idaguinaldo"
                      >
                        <v-icon
                          medium
                          class="mr-2">mdi-pencil-plus
                        </v-icon>
                          Agregar detalle
                      </v-btn>
                    </!--template-->

                    <v-card>
                      <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                      </v-card-title>
                      <v-card-text>
                        <v-container grid-list-md >
                          <v-layout wrap>
                            <v-flex
                              xs12
                              sm6
                              md4>
                              <v-select
                                v-model="editedDetItem.periodo_det"
                                :items="years"
                                item-text="desc"
                                item-value="value"
                                label="Periodo"
                                :append-icon="'mdi-plus'"
                              ></v-select>
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md4>
                              <v-select
                                v-model="editedDetItem.mes_det"
                                :items="meses"
                                item-text="desc"
                                item-value="value"
                                label="Mes"
                                :append-icon="'mdi-plus'"
                              ></v-select>
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md4
                            >
                              <v-text-field
                                v-model="editedDetItem.monto"
                                label="Monto" />
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
                          @click="saveDetItem('det_aguinaldo')">Guardar</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                  <v-simple-table>
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <!--th>---Acción---</!--th-->
                          <th>Periodo</th>
                          <th>Mes</th>
                          <th>Monto</th>
                        </tr>
                      </thead>
                      <tbody>
                        <template v-if="item.detalle">
                          <tr v-for="(it, index) in item.detalle" :key="index">
                            <!--td>
                              <v-tooltip color="white" bottom>
                                <template v-slot:activator="{ on, attrs }">
                                  <v-btn icon v-bind="attrs" v-on="on">
                                    <v-icon
                                      medium
                                      class="mr-2"
                                      @click="editDetItem(it, item, index)">mdi-pencil
                                    </v-icon>
                                  </v-btn>
                                </template>
                                <span>Editar</span>
                              </v-tooltip>

                              <v-tooltip color="white" bottom>
                                <template v-slot:activator="{ on, attrs }">
                                  <v-btn icon v-bind="attrs" v-on="on">
                                    <v-icon
                                      medium
                                      @click="deleteDetItem(it, item, index, 'det_aguinaldo')">mdi-delete
                                    </v-icon>
                                  </v-btn>
                                </template>
                                <span>Eliminar</span>
                              </v-tooltip>
                            <td-->
                            <td>{{ it.periodo_det }}</td>
                            <td>{{ mes(it.mes_det) }}</td>
                            <td>{{ numberFormat.format(it.monto) }}</td>
                          </tr>
                        </template>
                        <template v-else>
                          <tr>
                            <td colspan="4">No existen datos que mostrar...</td>
                          </tr>
                        </template>
                      </tbody>
                    </template>
                  </v-simple-table>
                </td>

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
    max25chars: v => v.length <= 25 || 'Texto demasiado largo!',
    AguinaldoList: [],
    buscando: false,
    dialog: false,
    dialogDet: false,
    search: '',
    expanded: [],
    singleExpand: true,
    headers: [
      { text: '', value: 'data-table-expand' },
      { text: '---Acción---', value: 'accion', sortable: false },
      { text: 'Nombre Empleado', value: 'nombre' },
      { text: 'Apellido', value: 'apellido' },
      { text: 'Nro. Cédula', value: 'ci_emple'},
      { text: 'Periodo', value: 'periodo' },
      { text: 'Mes', value: 'mes' },
      { text: 'Robro pres.', value: 'rubro_pres' },
    ],
    editedIndex: -1,
    editedDetIndex: -1,
    editedItem: {
      idaguinaldo: '',
      idpersonal: '',
      periodo: '',
      mes: '',
      ci: '',
      idrubropres: '',
      detalle: [],
    },
    editedDetItem: {
      iddetalle_agui: '',
      idaguinaldo: '',
      idsueldo: '',
      ci_det: '',
      periodo_det: '',
      mes_det: '',
      monto: '',
    },
    defaultItem: {
    },
    EmpleadoList: [],
    years: [
      {desc : '2021', value: '2021'},
      {desc : '2022', value: '2022'},
      {desc : '2023', value: '2023'},
      {desc : '2024', value: '2024'},
      {desc : '2025', value: '2025'},
    ],
    meses: [
      {desc: 'Enero', value: '1'},
      {desc: 'Febrero', value: '2'},
      {desc: 'Marzo', value: '3'},
      {desc: 'Abril', value: '4'},
      {desc: 'Mayo', value: '5'},
      {desc: 'Junio', value: '6'},
      {desc: 'Julio', value: '7'},
      {desc: 'Agosto', value: '8'},
      {desc: 'Setiembre', value: '9'},
      {desc: 'Octubre', value: '10'},
      {desc: 'Noviembre', value: '11'},
      {desc: 'Diciembre', value: '12'},
    ],
    numberFormat: new Intl.NumberFormat('es-ES'),
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
    this.getAguinaldo()
    //this.getEmpleado()
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
      actProcesar: 'updateTableItem'
    }),

    ...mapGetters({
      getPermiso: 'auth/accesspage'
    }),

    getAguinaldo() {
      this.buscando = true
      this.actTableList('aguinaldos')
        .then( response => {
          this.buscando = false
          this.AguinaldoList = response.data
        })
        .catch( error => {
          this.buscando = false
          console.log(error)
        })
    },
    /*
    getEmpleado() {
      this.actTableList('empleado')
        .then( response => {
          this.EmpleadoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },
    */

    mes(id){
      return this.meses.find( mes => mes.value.includes(id)).desc
    },
    // object.assign fills in the empty object with the properties of item
    editItem(item, dbox = true) {
      this.editedIndex = this.AguinaldoList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = dbox
    },

    editDetItem(it, item, index, dbox = true) {
      this.editedIndex = this.AguinaldoList.indexOf(item)
      this.editedDetIndex = index
      this.editedDetItem = Object.assign({}, it)
      this.dialogDet = dbox
    },

    deleteItem(item, dir) {
      const index = this.AguinaldoList.indexOf(item)
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedItem = Object.assign({}, item)
            let endpoint = `${dir}/delete/${this.editedItem.idaguinaldo}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method, dir)
            this.AguinaldoList.splice(index, 1)
            setTimeout(() => {
              this.getAguinaldo()
            }, 1000) 
          }
        })
    },

    deleteDetItem(it, item, index, dir) {
      const indexItem = this.AguinaldoList.indexOf(item)
      const indexDet = index
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedDetItem = Object.assign({}, it)
            let endpoint = `${dir}/delete/${this.editedDetItem.iddetalle_agui}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method, dir)
            this.AguinaldoList[indexItem].detalle.splice(indexDet, 1)
            setTimeout(() => {
              this.getAguinaldo()
            }, 1000)            
          }
        })
    },

    callTableAction(endpoint, method, dir) {
      let tableItem
      if( dir == 'aguinaldo' ){
        tableItem = this.editedItem
      }
      else if( dir == 'det_aguinaldo' ) {
        tableItem = this.editedDetItem
      }
      this.actProcesar({endpoint, tableItem, method})
        .then( response => {
          this.saveInline()
        })
        .catch(error => {
          console.log(error)
          this.cancelInline()
        })
    },

    save(dir) {
      if(this.editedIndex > -1) {
        Object.assign(this.AguinaldoList[this.editedIndex], this.editedItem)
        let endpoint = `${dir}/update/${this.editedItem.idaguinaldo}`
        let method = 'PATCH'
        this.callTableAction(endpoint, method, dir)
        setTimeout(() => {
          this.getAguinaldo()
        }, 1000) 
      }
      else {
        let endpoint = `${dir}/add`
        let method = 'POST'
        this.callTableAction(endpoint, method, dir)
        setTimeout(() => {
          this.getAguinaldo()
        }, 1000) 
      }
      this.close()
    },

    saveDetItem(dir) {
      if(this.editedDetIndex > -1) {
        Object.assign(this.AguinaldoList[this.editedIndex].detalle[this.editedDetIndex], this.editedDetItem)
        let endpoint = `${dir}/update/${this.editedDetItem.iddetalle_agui}`
        let method = 'PATCH'
        this.callTableAction(endpoint, method, dir)
        setTimeout(() => {
          this.getAguinaldo()
        }, 1000) 
      }
      else {
        let endpoint = `${dir}/add`
        let method = 'POST'
        this.callTableAction(endpoint, method, dir)
        setTimeout(() => {
          this.getEvaluacion()
        }, 1000) 
      }
      this.close()
    },

    saveItem(item) {
      this.editedIndex = this.AguinaldoList.indexOf(item)
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
      this.dialogDet = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedDetItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
        this.editedDetIndex = -1
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