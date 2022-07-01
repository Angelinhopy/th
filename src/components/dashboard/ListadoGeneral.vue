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
        <v-container grid-list-md >
          <v-layout wrap>
            <!--v-flex
              xs12
              sm12
              md5>
              <v-autocomplete
                v-model="EmpleadoSelect"
                :items="EmpleadoList"
                :return-object="true"
                item-text="nomape"
                item-value="idpersonal"
                label="Empleado"
              ></v-autocomplete>
            </!--v-flex-->
            <v-flex
              xs12
              sm12
              md3>
              <v-autocomplete
                v-model="plla"
                :items="PlanillaList"
                item-text="descripcion"
                item-value="plla"
                label="Planilla"
                :append-icon="'mdi-plus'"
                required
              ></v-autocomplete>
            </v-flex>
            <v-flex
              xs12
              sm12
              md2
            >
              <v-autocomplete
                v-model="periodo"
                :items="years"
                item-text="desc"
                item-value="value"
                label="Periodo"
                :append-icon="'mdi-plus'"
                :disabled="!isPlanilla"
              ></v-autocomplete>
            </v-flex>
            <v-flex
              xs12
              sm12
              md2
            >
              <v-autocomplete
                v-model="mes"
                :items="meses"
                item-text="desc"
                item-value="value"
                label="Mes"
                :append-icon="'mdi-plus'"
                @change="getSueldo()"
                :disabled="!isPeriodo"
              ></v-autocomplete>
            </v-flex>
          </v-layout>
        </v-container>

        <v-container grid-list-md>
          <v-layout wrap>
            <v-flex
            xs12
            sm12
            md12
            >
              <vue-html2pdf
                :show-layout="true"
                :float-layout="false"
                :enable-download="true"
                :preview-modal="true"
                :paginate-elements-by-height="800"
                :pdf-quality="2"
                :manual-pagination="false"
                filename="ListaGeneral"
                pdf-format="a4"
                pdf-orientation="landscape"
                pdf-content-width="100%"

                @progress="onProgress($event)"
                @hasDownloaded="hasDownloaded($event)"
                ref="html2Pdf"
              >
                <section slot="pdf-content">
                  <h1 class="mt-1">Listado General</h1>
                  <v-simple-table
                    dense
                    light
                  >
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <th class="text-left">Legajo</th>
                          <th class="text-left">N° Cédula</th>
                          <th class="text-left">Nombre</th>
                          <th class="text-left">Apellido</th>
                          <th class="text-left">Planilla</th>
                          <th class="text-left">Periodo</th>
                          <th class="text-left">Mes</th>
                          <th class="text-left">Categoría</th>
                          <th class="text-left">Sueldo</th>
                          <th class="text-left">Devengado</th>
                          <th class="text-left">Aporte</th>
                          <th class="text-left">Multas</th>
                          <th class="text-left">Neto</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="item in SueldoSelect"
                          :key="item.idsueldo"
                        >
                          <td>{{ item.idpersonal }}</td>
                          <td>{{ item.ci }}</td>
                          <td>{{ item.nombre }}</td>
                          <td>{{ item.apellido }}</td>
                          <td>{{ planilla(item.plla) }}</td>
                          <td>{{ item.periodo }}</td>
                          <td>{{ mesElegido(item.mes) }}</td>
                          <td>{{ item.categoria }}</td>
                          <td>{{ numberFormat.format(item.sueldo) }}</td>
                          <td>{{ numberFormat.format(item.devengado) }}</td>
                          <td>{{ numberFormat.format(item.monto) }}</td>
                          <td>{{ numberFormat.format(item.multas)}}</td>
                          <td>{{ numberFormat.format(item.devengado - item.monto - item.multas) }}</td>
                        </tr>
                      </tbody>
                    </template>
                  </v-simple-table>
                </section>
              </vue-html2pdf>
              
              <v-btn
                :disabled="isGenerating"
                @click="generarPDF"
              >
                {{ isGenerating ? 'Cargando...' : 'Generar PDF' }}
              </v-btn>
            </v-flex>
          </v-layout>
        </v-container>
      </v-flex>

    </v-layout>
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'
import VueHtml2pdf from 'vue-html2pdf'
export default {
  data: () => ({
    //EmpleadoList: [],
    //EmpleadoSelect: [],
    SueldoSelect: [],
    plla: '',
    periodo: `${new Date().getFullYear()}`,
    mes: '',
    progress: 0,
    pdfDownloaded: false,
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
    numberFormat: new Intl.NumberFormat('es-ES'),
  }),

  // called when page is created before dom
  created() {
    //this.getEmpleado()
  },

  computed: {
    isGenerating () {
      return this.progress !== 0 && this.progress !== 100
    },

    /*isEmpleadoSelect(){
      return Object.keys(this.EmpleadoSelect).length !== 0 ? true : false
    },*/

    isPlanilla() {
      return this.plla !== '' ? true : false
    },

    isPeriodo() {
      return this.periodo !== '' ? true : false
    },

    totalDevengado(){
      return this.SueldoSelect.devengado || 0
    },

    totalDescuento(){
      if(this.SueldoSelect.hasOwnProperty("detalle")){
        return this.SueldoSelect.detalle.reduce((sum, value) => (sum + parseInt(value.monto)), 0)
      }
      else{
        return 0
      }
    },

    totalSueldo(){
      return this.totalDevengado - this.totalDescuento || 0
    }

  },

  components: {
    VueHtml2pdf
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
    }),

    /*getEmpleado() {
      this.actTableList('empleado')
        .then( response => {
          this.EmpleadoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },*/

    getSueldo() {
      this.SueldoSelect = []
      this.actTableList(`listsueldosmultas/${this.plla}/${this.periodo}/${this.mes}`)
        .then( response => {
          this.SueldoSelect = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    planilla(id = 0){
      return null || this.PlanillaList.find( planilla => planilla.plla.includes(id)).descripcion
    },

    mesElegido(id = 1){
      return this.meses.find( mes => mes.value.includes(id)).desc
    },

    onProgress(progress) {
      this.progress = progress;
      //console.log(`PDF generation progress: ${progress}%`)
    },

    hasDownloaded (blobPdf) {
      //console.log(`PDF has downloaded yehey`)
      this.pdfDownloaded = true
      //console.log(blobPdf)
    },

    generarPDF() {
      this.$refs.html2Pdf.generatePdf()
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

  .section-container {
    margin: 20px;
  }
</style>