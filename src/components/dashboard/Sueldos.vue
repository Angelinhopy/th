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
        md6
      >
        <material-card
          v-if="alta == 'SI'"
          color="general"
          title="Generar sueldos"
          text="Generar sueldos del periodo"
        >
          <v-card>
            <v-card-text>
              <v-container grid-list-md >
                <v-form
                  ref="formSueldos"
                  v-model="valid"
                  lazy-validation
                >
                  <v-layout wrap>
                    <v-flex
                      xs12
                      sm6
                      md5>
                      <!--v-autocomplete
                        v-model="editedItem.periodo"
                        :items="years"
                        item-text="desc"
                        item-value="value"
                        label="Periodo"
                        :append-icon="'mdi-plus'"
                      ></!--v-autocomplete-->
                      <v-text-field
                        v-model="editedItem.periodo"
                        label="Periodo"
                        :rules="[rules.required, rules.counterMax, rules.counterMin]"
                        minlength="4"
                      >
                      </v-text-field>
                    </v-flex>
                    <v-flex
                      xs12
                      sm6
                      md4>
                      <v-autocomplete
                        v-model="editedItem.mes"
                        :items="meses"
                        item-text="desc"
                        item-value="value"
                        label="Mes"
                        :append-icon="'mdi-plus'"
                        :rules="[rules.required]"
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
                :disabled="!valid || procesando"
                @click="save('gensueldos')">{{ (procesando) ? 'Procesando...' : 'Guardar' }}</v-btn>
            </v-card-actions>
          </v-card>
        </material-card>
      </v-flex>
      <v-flex
        md12
      >
        <div>          
          <material-card
            color="general"
            title="Sueldos"
            text="Lista de sueldos"
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
                            ref="formSueldo"
                            v-model="validOnly"
                            lazy-validation
                          >
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
                                  :rules="[rules.required]"
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm6
                                md7>
                                <!--v-select
                                  v-model="editedItem.periodo"
                                  :items="years"
                                  item-text="desc"
                                  item-value="value"
                                  label="Periodo"
                                  :append-icon="'mdi-plus'"
                                ></!--v-select-->
                                <v-text-field
                                  v-model="editedItem.periodo"
                                  label="Periodo"
                                  :rules="[rules.required, rules.counterMax, rules.counterMin]"
                                ></v-text-field>
                              </v-flex>
                              <v-flex
                                xs12
                                sm6
                                md5>
                                <v-autocomplete
                                  v-model="editedItem.mes"
                                  :items="meses"
                                  item-text="desc"
                                  item-value="value"
                                  label="Mes"
                                  :append-icon="'mdi-plus'"
                                  :rules="[rules.required]"
                                ></v-autocomplete>
                              </v-flex>
                              <!--v-flex
                                xs12
                                sm12
                                md12>
                                <v-autocomplete
                                  v-model="editedItem.idrubropres"
                                  :items="RubroList"
                                  item-text="descripcion"
                                  item-value="idrubropres"
                                  label="Rubro presupuestario"
                                ></v-autocomplete>
                              </!--v-flex-->
                              <!--v-flex
                                xs12
                                sm12
                                md12>
                                <v-autocomplete
                                  v-model="editedItem.pila"
                                  :items="PlanillaList"
                                  item-text="descripcion"
                                  item-value="idplanibene"
                                  label="Planilla"
                                ></v-autocomplete>
                              </!--v-flex-->
                              <!--v-flex
                                xs12
                                sm12
                                md12>
                                <v-autocomplete
                                  v-model="editedItem.lineapres"
                                  :items="VacanciaList"
                                  item-text="descripcion"
                                  item-value="lineapres"
                                  label="Linea Pres."
                                ></v-autocomplete>
                              </!--v-flex-->
                              <!--v-flex
                                xs12
                                sm12
                                md12>
                                <v-autocomplete
                                  v-model="editedItem.categoria"
                                  :items="CategoriaList"
                                  item-text="categoria"
                                  item-value="idcategoria"
                                  label="Categoría"
                                  @change="selectSueldo"
                                ></v-autocomplete>
                              </!--v-flex-->
                              <!--v-flex
                                xs12
                                sm12
                                md12>
                                <v-text-field
                                  v-model="editedItem.sueldo"
                                  label="Sueldo" />
                              </!--v-flex-->
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
                        <v-btn
                          color="blue darken-1"
                          text
                          :disabled="!validOnly"
                          @click="save('sueldos')">Guardar</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-flex>

                <v-spacer />

                <v-flex
                  xs12
                  sm2
                  md2
                >
                  <v-text-field
                    v-model="filters.nombre"
                    append-icon="mdi-magnify"
                    label="Nombre"
                    single-line
                    hide-details
                  />
                </v-flex>

                <v-flex
                  xs12
                  sm2
                  md2
                >
                  <v-text-field
                    v-model="filters.apellido"
                    append-icon="mdi-magnify"
                    label="Apellido"
                    single-line
                    hide-details
                  />
                </v-flex>

                <v-flex
                  xs12
                  sm2
                  md2
                >
                  <v-text-field
                    v-model="filters.ci"
                    append-icon="mdi-magnify"
                    label="Nro cédula"
                    single-line
                    hide-details
                  />
                </v-flex>

                <v-flex
                  xs12
                  sm2
                  md2
                >
                  <v-text-field
                    v-model="filters.periodo"
                    append-icon="mdi-magnify"
                    label="Periodo"
                    single-line
                    hide-details
                  />
                </v-flex>

                <v-flex
                  xs12
                  sm1
                  md2
                >
                  <v-autocomplete
                    v-model="filters.mes"
                    :items="meses"
                    item-text="desc"
                    item-value="value"
                    label="Mes"
                  ></v-autocomplete>
                </v-flex>

              </v-layout>
            </v-container>
            
            <v-data-table
              :headers="headers"
              :items="SueldosList"
              :single-expand="singleExpand"
              :expanded.sync="expanded"
              item-key="idsueldo"
              show-expand
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
                        @click="deleteItem(props.item, 'sueldos')">mdi-delete
                      </v-icon>
                    </v-btn>
                  </template>
                  <span>Eliminar</span>
                </v-tooltip>

              </template>

              <template v-slot:item.plla="props">
                {{ planilla(props.item.plla) }}
              </template>

              <template v-slot:item.mes="props">
                {{ mes(props.item.mes) }}
              </template>

              <template v-slot:item.sueldo="props">
                {{ numberFormat.format(props.item.sueldo) }}
              </template>

              <template v-slot:item.devengado="props">
                {{ numberFormat.format(props.item.devengado) }}
              </template>

              <template v-slot:expanded-item="{ headers, item }">

                <td :colspan="headers.length">
                  <v-dialog
                    v-model="dialogDet"
                    max-width="500px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        color="indigo"
                        dark
                        v-bind="attrs"
                        class="mb-2"
                        v-on="on"
                        @click="selectDetalles(item.idsueldo)"
                      >
                        <v-icon
                          medium
                          class="mr-2">mdi-pencil-plus
                        </v-icon>
                          Agregar detalle
                      </v-btn>
                    </template>

                    <v-card>
                      <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                      </v-card-title>
                      <v-card-text>
                        <v-container grid-list-md >
                          <v-layout wrap>
                            <!--v-flex
                              xs12
                              sm6
                              md4>
                              <v-text-field
                                v-model="editedDetItem.ci_det"
                                label="Cédula" />
                            </!--v-flex-->
                            <!--v-flex
                              xs12
                              sm6
                              md2>
                              <v-text-field
                                v-model="editedDetItem.periodo_det"
                                label="Periodo" />
                            </!--v-flex-->
                            <!--v-flex
                              xs12
                              sm6
                              md2>
                              <v-text-field
                                v-model="editedDetItem.mes_det"
                                label="Mes" />
                            </!--v-flex-->
                            <v-flex
                              xs12
                              sm12
                              md12>
                              <v-autocomplete
                                v-model="editedDetItem.idtipodescuento"
                                :items="TipoDescuentoList"
                                item-text="descripcion"
                                item-value="idtipodescuento"
                                label="Tipo descuento"
                              ></v-autocomplete>
                            </v-flex>
                            <v-flex
                              xs12
                              sm12
                              md12
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
                          @click="saveDetItem('det_sueldo')">Guardar</v-btn>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                  <v-simple-table>
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <th>---Acción---</th>
                          <!--th>Cédula</!--th-->
                          <th>Periodo</th>
                          <th>Mes</th>
                          <th>Tipo Descuento</th>
                          <th class="text-right">Monto</th>
                        </tr>
                      </thead>
                      <tbody>
                        <template v-if="item.detalle">
                          <tr v-for="(it, index) in item.detalle" :key="index">
                            <td>
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
                                      @click="deleteDetItem(it, item, index, 'det_sueldo')">mdi-delete
                                    </v-icon>
                                  </v-btn>
                                </template>
                                <span>Eliminar</span>
                              </v-tooltip>
                            </td>
                            <!--td>{{ it.ci_det }}</!--td-->
                            <td>{{ it.periodo_det }}</td>
                            <td>{{ mes(it.mes_det) }}</td>
                            <td>{{ it.tipo_descuento }}</td>
                            <td class="text-right">{{ numberFormat.format(it.monto) }}</td>
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
    SueldosList: [],
    buscando: false,
    dialog: false,
    dialogDet: false,
    filters: {
      nombre: '',
      apellido: '',
      ci: '',
      periodo: '',
      mes: '',
    },
    expanded: [],
    singleExpand: true,
    editedIndex: -1,
    editedDetIndex: -1,
    editedItem: {
      idsueldo: '',
      idpersonal: '',
      //ci: '',
      periodo: `${new Date().getFullYear()}`,
      mes: `${new Date().getMonth()+1}`,
      idrubropres: '',
      plla: '',
      lineapres: '',
      //cargo_pres: '',
      categoria: '',
      sueldo: '',
      //devengado: '',
      detalle: [],
    },
    editedDetItem: {
      iddetallesueldo: '',
      idsueldo: '',
      //ci_det: '',
      periodo_det: `${new Date().getFullYear()}`,
      mes_det: `${new Date().getMonth()+1}`,
      idtipodescuento: '',
      monto: '',
    },
    defaultItem: {
      idsueldo: '',
      idpersonal: '',
      //ci: '',
      periodo: `${new Date().getFullYear()}`,
      mes: `${new Date().getMonth()+1}`,
      idrubropres: '',
      plla: '',
      lineapres: '',
      //cargo_pres: '',
      categoria: '',
      sueldo: '',
      //devengado: '',
      detalle: [],
    },
    EmpleadoList: [],
    RubroList: [],
    VacanciaList: [],
    PresupuestadoList: [],
    CategoriaList: [],
    TipoDescuentoList: [],
    PlanillaList: [
      {plla: '0', descripcion: 'S/D'},
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
    valid: true,
    validOnly: true,
    rules: {
      required: (v) => !!v || "Este campo es requerido",
      counterMax: (value) => value.length <= 4 || "4 caracteres, formato YYYY",
      counterMin: (value) => value.length >= 4 || "4 caracteres, formato YYYY",
    },
    procesando: false,
  }),

  computed: {
    headers(){
      return [
      { text: '', value: 'data-table-expand' },
      { text: '---Acción---', value: 'accion', sortable: false },
      { text: 'Nombre Empleado', value: 'nombre', filter: this.nombreFilter },
      { text: 'Apellido', value: 'apellido', filter: this.apellidoFilter },
      { text: 'Nro. Cédula', value: 'ci', filter: this.ciFilter },
      { text: 'Periodo', value: 'periodo', filter: this.periodoFilter },
      { text: 'Mes', value: 'mes', filter: this.mesFilter },
      { text: 'Rubro', value: 'rubro_pres' },
      { text: 'Planilla', value: 'plla' },
      { text: 'Linea Pres', value: 'descrip_vac' },
      //{ text: 'Cargo Pres.', value: 'cargo_pres' },
      { text: 'Categoría', value: 'categoria_vac' },
      { text: 'Sueldo', value: 'sueldo', align: 'end' },
      { text: 'Devengado', value: 'devengado', align: 'end' },
    ]},

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
    this.getSueldos()
    this.getEmpleado()
    this.getRubro()
    this.getVacancia()
    this.getPresupuestado()
    this.getCategoria()
    this.getTipoDescuento()
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
      actProcesar: 'updateTableItem'
    }),
    
    ...mapGetters({
      getPermiso: 'auth/accesspage'
    }),

    getSueldos() {
      this.buscando = true
      this.actTableList('sueldos')
        .then( response => {
          this.buscando = false
          this.SueldosList = response.data
        })
        .catch( error => {
          this.buscando = false
          console.log(error)
        })
    },

    getEmpleado() {
      this.actTableList('empleado')
        .then( response => {
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

    getVacancia() {
      this.actTableList('vacancia')
        .then( response => {
          this.VacanciaList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getPresupuestado() {
      this.actTableList('presupuestado')
        .then( response => {
          this.PresupuestadoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getCategoria() {
      this.actTableList('categoria')
        .then( response => {
          this.CategoriaList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getTipoDescuento() {
      this.actTableList('descuento')
        .then( response => {
          this.TipoDescuentoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    planilla(id = 0){
      return this.PlanillaList.find( planilla => planilla.plla.includes(id)).descripcion
    },

    mes(id){
      return this.meses.find( mes => mes.value.includes(id)).desc
    },

    /*
    selectSueldo(){
      this.editedItem.sueldo = this.CategoriaList.find(categ => categ.idcategoria.includes(this.editedItem.categoria)).sueldo
    },
    */

    nombreFilter(value) {
      // If this filter has no value we just skip the entire filter.
      if (!this.filters.nombre) {
        return true;
      }

      // Check if the current loop value (The dessert name)
      // partially contains the searched word.
      return value
        .toLowerCase()
        .includes(this.filters.nombre.toLowerCase());
    },

    apellidoFilter(value) {
      // If this filter has no value we just skip the entire filter.
      if (!this.filters.apellido) {
        return true;
      }

      // Check if the current loop value (The dessert name)
      // partially contains the searched word.
      return value
        .toLowerCase()
        .includes(this.filters.apellido.toLowerCase());
    },

    ciFilter(value) {
      // If this filter has no value we just skip the entire filter.
      if (!this.filters.ci) {
        return true;
      }

      // Check if the current loop value (The dessert name)
      // partially contains the searched word.
      return value
        .toLowerCase()
        .includes(this.filters.ci.toLowerCase());
    },

    periodoFilter(value) {
      // If this filter has no value we just skip the entire filter.
      if (!this.filters.periodo) {
        return true;
      }

      // Check if the current loop value (The dessert name)
      // partially contains the searched word.
      return value
        .toLowerCase()
        .includes(this.filters.periodo.toLowerCase());
    },

    mesFilter(value) {
      // If this filter has no value we just skip the entire filter.
      if (!this.filters.mes) {
        return true;
      }

      // Check if the current loop value (The calories value)
      // equals to the selected value at the <v-select>.
      return value === this.filters.mes;
    },

    selectDetalles(idsueldo){
      this.editedDetItem.idsueldo = idsueldo
      this.editedDetItem.ci_det = this.SueldosList.find(sueldo => sueldo.idsueldo.includes(this.editedDetItem.idsueldo)).ci
      this.editedDetItem.periodo_det = this.SueldosList.find(sueldo => sueldo.idsueldo.includes(this.editedDetItem.idsueldo)).periodo
      this.editedDetItem.mes_det = this.SueldosList.find(sueldo => sueldo.idsueldo.includes(this.editedDetItem.idsueldo)).mes
    },
    
    // object.assign fills in the empty object with the properties of item
    editItem(item, dbox = true) {
      this.editedIndex = this.SueldosList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = dbox
    },

    editDetItem(it, item, index, dbox = true) {
      this.editedIndex = this.SueldosList.indexOf(item)
      this.editedDetIndex = index
      this.editedDetItem = Object.assign({}, it)
      this.dialogDet = dbox
    },

    deleteItem(item, dir) {
      const index = this.SueldosList.indexOf(item)
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedItem = Object.assign({}, item)
            let endpoint = `${dir}/delete/${this.editedItem.idsueldo}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method, dir)
            this.SueldosList.splice(index, 1)
            //setTimeout(() => {
              //this.getSueldos()
            //}, 1000) 
          }
        })
    },

    deleteDetItem(it, item, index, dir) {
      const indexItem = this.SueldosList.indexOf(item)
      const indexDet = index
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedDetItem = Object.assign({}, it)
            let endpoint = `${dir}/delete/${this.editedDetItem.iddetallesueldo}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method, dir)
            this.SueldosList[indexItem].detalle.splice(indexDet, 1)
            //setTimeout(() => {
              //this.getSueldos()
            //}, 1000)            
          }
        })
    },

    callTableAction(endpoint, method, dir) {
      let tableItem
      if( dir == 'sueldos' || dir == 'gensueldos' ){
        this.procesando = true
        tableItem = this.editedItem
      }
      else if( dir == 'det_sueldo' ) {
        tableItem = this.editedDetItem
      }

      this.actProcesar({endpoint, tableItem, method})
        .then( response => {
          this.procesando = false
          this.saveInline()
          this.getSueldos()
        })
        .catch(error => {
          if( error.response.status == 500 ){
            this.procesando = false
            this.snackText = 'Error interno. Codigo ' + error.response.status
          }
          else{
            this.procesando = false
            this.snackText = error.response.data.descrip
          }
          this.getSueldos()
          this.cancelInline()
        })
    },

    save(dir) {
      if( this.$refs.formSueldos.validate() || this.$refs.formSueldo.validate() ){
        if(this.editedIndex > -1) {
          Object.assign(this.SueldosList[this.editedIndex], this.editedItem)
          let endpoint = `${dir}/update/${this.editedItem.idsueldo}`
          let method = 'PATCH'
          this.callTableAction(endpoint, method, dir)
          //setTimeout(() => {
            //this.getSueldos()
          //}, 1000) 
        }
        else {
          let endpoint = `${dir}/add`
          let method = 'POST'
          this.callTableAction(endpoint, method, dir)
          //setTimeout(() => {
            //this.getSueldos()
          //}, 1000) 
        }
        this.close()
      }
    },

    saveDetItem(dir) {
      if(this.editedDetIndex > -1) {
        Object.assign(this.SueldosList[this.editedIndex].detalle[this.editedDetIndex], this.editedDetItem)
        let endpoint = `${dir}/update/${this.editedDetItem.iddetallesueldo}`
        let method = 'PATCH'
        this.callTableAction(endpoint, method, dir)
        //setTimeout(() => {
          //this.getSueldos()
        //}, 1000) 
      }
      else {
        let endpoint = `${dir}/add`
        let method = 'POST'
        this.callTableAction(endpoint, method, dir)
        //setTimeout(() => {
          //this.getSueldos()
        //}, 1000) 
      }
      this.close()
    },

    saveItem(item) {
      this.editedIndex = this.SueldosList.indexOf(item)
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
      //this.snackText = 'Ocurrio algun error'
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