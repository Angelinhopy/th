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
            title="Beneficios/Gratificación"
            text="Lista de beneficios/gratificaciones"
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
                    v-model="dialogDet"
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
                                @change="selectCI"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm6
                              md6>
                              <v-select
                                v-model="editedDetItem.periodo"
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
                              md6>
                              <v-select
                                v-model="editedDetItem.mes"
                                :items="meses"
                                item-text="desc"
                                item-value="value"
                                label="Mes"
                                :append-icon="'mdi-plus'"
                              ></v-select>
                            </v-flex>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-autocomplete
                                v-model="editedDetItem.idrubropres"
                                :items="RubroList"
                                item-text="descrip"
                                item-value="idrubropres"
                                label="Rubro Pres."
                                :append-icon="'mdi-plus'"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm8
                              md8>
                              <v-autocomplete
                                v-model="editedDetItem.idplanibene"
                                :items="PlanillaList"
                                item-text="descripcion"
                                item-value="idplanibene"
                                label="Planilla Benef."
                                :append-icon="'mdi-plus'"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm4
                              md4>
                              <v-text-field
                                v-model="editedDetItem.monto"
                                @input="calcMonto"
                                label="Monto" />
                            </v-flex>
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-autocomplete
                                v-model="editedDetItem.idtipodescuento"
                                :items="DescuentoList"
                                item-text="descripcion"
                                item-value="idtipodescuento"
                                label="Tipo Descuento"
                                :append-icon="'mdi-plus'"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm4
                              md4>
                              <v-text-field
                                v-model="editedDetItem.desc_jub"
                                label="Descuento Jub." />
                            </v-flex>
                            <v-flex
                              xs12
                              sm8
                              md8>
                              <v-text-field
                                v-model="editedDetItem.monto_cobrar"
                                label="Monto a Cobrar" />
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
                          @click="saveDetItem">Guardar</v-btn>
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
              :items="BeneficiosList"
              :single-expand="singleExpand"
              :expanded.sync="expanded"
              item-key="idpersonal"
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

              <template v-slot:item.plla="props">
                {{ plani(props.item.plla) }}
              </template>
              <!--template v-slot:item.accion="props">

                <v-tooltip color="white" bottom>
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
                </v-tooltip>

                <v-tooltip color="white" bottom>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                      <v-icon
                        medium
                        @click="deleteItem(props.item, 'beneficios')">mdi-delete
                      </v-icon>
                    </v-btn>
                  </template>
                  <span>Eliminar</span>
                </v-tooltip>

              </!--template-->

              <template v-slot:expanded-item="{ headers, item }">

                <td :colspan="headers.length">
                  <v-simple-table>
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <th>---Acción---</th>
                          <th>Periodo</th>
                          <th>Mes</th>
                          <th>Planilla</th>
                          <th>Rubro Pres.</th>
                          <th>Monto</th>
                          <th>Tipo Descuento</th>
                          <th>Monto Descuento</th>
                          <th>Monto a Cobrar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <template v-if="item.detalle">
                          <tr v-for="(it, index) in item.detalle" :key="index">
                            <td>
                              <v-tooltip color="white" bottom>
                                <template v-slot:activator="{ on, attrs }">
                                  <v-btn v-if="alta == 'SI'" icon v-bind="attrs" v-on="on">
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
                                  <v-btn v-if="baja == 'SI'" icon v-bind="attrs" v-on="on">
                                    <v-icon
                                      medium
                                      @click="deleteDetItem(it, item, index)">mdi-delete
                                    </v-icon>
                                  </v-btn>
                                </template>
                                <span>Eliminar</span>
                              </v-tooltip>
                            </td>
                            <td>{{ it.periodo }}</td>
                            <td>{{ mes(it.mes) }}</td>
                            <td>{{ it.planibene }}</td>
                            <td>{{ it.rubro_pres }}</td>
                            <td>{{ numberFormat.format(it.monto) }}</td>
                            <td>{{ it.tipo_desc }}</td>
                            <td>{{ numberFormat.format(it.desc_jub) }}</td>
                            <td>{{ numberFormat.format(it.monto_cobrar) }}</td>
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
    BeneficiosList: [],
    buscando: false,
    //dialog: false,
    dialogDet: false,
    search: '',
    expanded: [],
    singleExpand: true,
    headers: [
      { text: '', value: 'data-table-expand' },
      //{ text: '---Acción---', value: 'accion', sortable: false },
      { text: 'Nombre Empleado', value: 'nombre' },
      { text: 'Apellido', value: 'apellido' },
      { text: 'Nro. Cédula', value: 'ci'},
      { text: 'Planilla', value: 'plla'},
    ],
    editedIndex: -1,
    editedDetIndex: -1,
    editedItem: {
      idpersonal: '',
      periodo: `${new Date().getFullYear()}`,
      mes: `${new Date().getMonth()}`,
      ci: '',
      plla: '',
    },
    editedDetItem: {
      id_benegratifi: '',
      idrubropres: '',
      idplanibene: '',
      idtipodescuento: '',
      periodo: `${new Date().getFullYear()}`,
      mes: `${new Date().getMonth()}`,
    },
    defaultItem: {
      idpersonal: '',
      periodo: `${new Date().getFullYear()}`,
      mes: `${new Date().getMonth()}`,
      ci: '',
      plla: '',
    },
    EmpleadoList: [],
    RubroList: [],
    PlanillaList: [],
    DescuentoList: [],
    years: [
      {desc : '2000', value: '2000'},
      {desc : '2001', value: '2001'},
      {desc : '2002', value: '2002'},
      {desc : '2003', value: '2003'},
      {desc : '2004', value: '2004'},
      {desc : '2005', value: '2005'},
      {desc : '2006', value: '2006'},
      {desc : '2007', value: '2007'},
      {desc : '2008', value: '2008'},
      {desc : '2009', value: '2009'},
      {desc : '2010', value: '2010'},
      {desc : '2011', value: '2011'},
      {desc : '2012', value: '2012'},
      {desc : '2013', value: '2013'},
      {desc : '2014', value: '2014'},
      {desc : '2015', value: '2015'},
      {desc : '2016', value: '2016'},
      {desc : '2017', value: '2017'},
      {desc : '2018', value: '2018'},
      {desc : '2019', value: '2019'},
      {desc : '2020', value: '2020'},
      {desc : '2021', value: '2021'},
      {desc : '2022', value: '2022'},
      {desc : '2023', value: '2023'},
      {desc : '2024', value: '2024'},
      {desc : '2025', value: '2025'},
      {desc : '2026', value: '2026'},
      {desc : '2027', value: '2027'},
      {desc : '2028', value: '2028'},
      {desc : '2029', value: '2029'},
      {desc : '2030', value: '2030'},
      {desc : '2031', value: '2031'},
      {desc : '2032', value: '2032'},
      {desc : '2033', value: '2033'},
      {desc : '2034', value: '2034'},
      {desc : '2035', value: '2035'},
      {desc : '2036', value: '2036'},
      {desc : '2037', value: '2037'},
      {desc : '2038', value: '2038'},
      {desc : '2039', value: '2039'},
      {desc : '2040', value: '2040'},
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
    PlaniList: [
      {plla: '1', descripcion: 'FISCAL'},
      {plla: '2', descripcion: 'IPS'},
      {plla: '3', descripcion: 'OBRERO'},
      {plla: '4', descripcion: 'CONTRATADO'},
      {plla: '5', descripcion: 'DIRECTORIO'},
      {plla: '6', descripcion: 'CONTRATADO-IVA'},
      {plla: '7', descripcion: 'COMISIONADO-FISCAL'},
      {plla: '8', descripcion: 'COMISIONADO-IPS'},
      {plla: '9', descripcion: 'SIN PLANILLA'},
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
    this.getBeneficios()
    this.getEmpleado()
    this.getRubro()
    this.getPlanilla()
    this.getDescuento()
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
      actProcesar: 'updateTableItem'
    }),
    
    ...mapGetters({
      getPermiso: 'auth/accesspage'
    }),

    getBeneficios() {
      this.actTableList('beneficios')
        .then( response => {
          this.BeneficiosList = response.data
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

    getRubro() {
      this.actTableList('rubro')
        .then( response => {
          this.RubroList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getPlanilla() {
      this.actTableList('planilla')
        .then( response => {
          this.PlanillaList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getDescuento() {
      this.actTableList('descuento')
        .then( response => {
          this.DescuentoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    selectCI(){
      this.editedItem.ci = this.EmpleadoList.find(personal => personal.idpersonal == this.editedItem.idpersonal).ci
      this.editedItem.plla = this.EmpleadoList.find(personal => personal.idpersonal == this.editedItem.idpersonal).plla
    },

    plani(id){
      return this.PlaniList.find( planilla => planilla.plla.includes(id)).descripcion
    },

    calcMonto(){
      if(this.editedItem.plla == 1){
        this.editedDetItem.desc_jub = this.editedDetItem.monto * 0.16
      }
      else{
        this.editedDetItem.desc_jub = this.editedDetItem.monto * 0.09
      }

      this.editedDetItem.monto_cobrar = this.editedDetItem.monto - this.editedDetItem.desc_jub
    },

    mes(id){
      return this.meses.find( mes => mes.value.includes(id)).desc
    },
      
    // object.assign fills in the empty object with the properties of item
    /*editItem(item, dbox = true) {
      this.editedIndex = this.BeneficiosList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = dbox
    },*/

    editDetItem(it, item, index, dbox = true) {
      this.editedIndex = this.BeneficiosList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.editedDetIndex = index
      this.editedDetItem = Object.assign({}, it)
      this.dialogDet = dbox
    },

    /*deleteItem(item, dir) {
      const index = this.BeneficiosList.indexOf(item)
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedItem = Object.assign({}, item)
            let endpoint = `${dir}/delete/${this.editedItem.id_benegratifi}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method, dir)
            this.BeneficiosList.splice(index, 1)
            setTimeout(() => {
              this.getBeneficios()
            }, 1000) 
          }
        })
    },*/

    deleteDetItem(it, item, index) {
      const indexItem = this.BeneficiosList.indexOf(item)
      const indexDet = index
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedDetItem = Object.assign({}, it)
            let endpoint = `beneficios/delete/${this.editedDetItem.id_benegratifi}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method)
            this.BeneficiosList[indexItem].detalle.splice(indexDet, 1)
            setTimeout(() => {
              this.getBeneficios()
            }, 1000)            
          }
        })
    },

    callTableAction(endpoint, method) {
      let tableItem = Object.assign(this.editedItem, this.editedDetItem)
      
      this.actProcesar({endpoint, tableItem, method})
        .then( response => {
          this.saveInline()
        })
        .catch(error => {
          console.log(error)
          this.cancelInline()
        })
    },

    /*save(dir) {
      if(this.editedIndex > -1) {
        Object.assign(this.BeneficiosList[this.editedIndex], this.editedItem)
        let endpoint = `${dir}/update/${this.editedItem.id_benegratifi}`
        let method = 'PATCH'
        this.callTableAction(endpoint, method, dir)
        setTimeout(() => {
          this.getBeneficios()
        }, 1000) 
      }
      else {
        let endpoint = `${dir}/add`
        let method = 'POST'
        this.callTableAction(endpoint, method, dir)
        setTimeout(() => {
          this.getBeneficios()
        }, 1000) 
      }
      this.close()
    },*/

    saveDetItem() {
      if(this.editedDetIndex > -1) {
        Object.assign(this.BeneficiosList[this.editedIndex].detalle[this.editedDetIndex], this.editedDetItem)
        let endpoint = `beneficios/update/${this.editedDetItem.id_benegratifi}`
        let method = 'PATCH'
        this.callTableAction(endpoint, method)
        setTimeout(() => {
          this.getBeneficios()
        }, 1000) 
      }
      else {
        let endpoint = 'beneficios/add'
        let method = 'POST'
        this.callTableAction(endpoint, method)
        setTimeout(() => {
          this.getBeneficios()
        }, 1000) 
      }
      this.close()
    },

    /*saveItem(item) {
      this.editedIndex = this.BeneficiosList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.save()
    },*/

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
      //this.dialog = false
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