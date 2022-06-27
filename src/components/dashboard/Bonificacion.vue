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
            <v-flex
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
            </v-flex>
            <v-flex
              xs12
              sm12
              md2
            >
              <v-select
                v-model="period"
                :items="years"
                item-text="desc"
                item-value="value"
                label="Periodo"
                :append-icon="'mdi-plus'"
                :disabled="!isEmpleadoSelect"
              ></v-select>
            </v-flex>
            <v-flex
              xs12
              sm12
              md2
            >
              <v-select
                v-model="mess"
                :items="meses"
                item-text="desc"
                item-value="value"
                label="Mes"
                :append-icon="'mdi-plus'"
                @change="getBonificacion()"
                :disabled="!isPeriodo"
              ></v-select>
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
                :paginate-elements-by-height="1000"
                filename="Bonificacion"
                :pdf-quality="2"
                :manual-pagination="false"
                pdf-format="a4"
                pdf-orientation="portrait"
                pdf-content-width="800px"

                @progress="onProgress($event)"
                @hasDownloaded="hasDownloaded($event)"
                ref="html2Pdf"
              >
                <section slot="pdf-content" class="section-container">
                  <span>{{ fechayhora.toLocaleDateString() }}</span>
                  <section class="mb-1">
                    <h1>Bonificación/Gratificación</h1>
                  </section>

                  <section class="mb-1">
                    <h3>Datos de la Planilla</h3>
                    <v-simple-table dense light>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th>ID Empleado: {{ BonificacionSelect.idpersonal }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <v-row no-gutters>
                                <v-col
                                  cols="12"
                                  sm="4"
                                >
                                  <b>Nombre:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ BonificacionSelect.nombre }}
                                </v-col>
                              </v-row>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <v-row no-gutters>
                                <v-col
                                  cols="12"
                                  sm="4"
                                >
                                  <b>Apellido:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ BonificacionSelect.apellido }}
                                </v-col>
                              </v-row>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <v-row no-gutters>
                                <v-col
                                  cols="12"
                                  sm="4"
                                >
                                  <b>Nro. Cédula:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ BonificacionSelect.ci }} - {{ BonificacionSelect.plla }}
                                </v-col>
                              </v-row>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <v-row no-gutters>
                                <v-col
                                  cols="12"
                                  sm="4"
                                >
                                  <b>Planilla</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ planilla(BonificacionSelect.plla) }}
                                </v-col>
                              </v-row>
                            </td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </section>

                  <section class="mb-1">
                    <h3>Detalle:</h3>
                    <v-simple-table dense light>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th>Nro.</th>
                            <th>Periodo</th>
                            <th>Mes</th>
                            <th>Planilla</th>
                            <th>Rubro Pres.</th>
                            <th class="text-right">Monto</th>
                            <th>Tipo Descuento</th>
                            <th class="text-right">Monto Desc.</th>
                            <th class="text-right">Monto a Cobrar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(bonif, index) in BonificacionSelect.detalle" :key="index">
                            <td>{{ index+1 }}</td>
                            <td>{{ bonif.periodo }}</td>
                            <td>{{ mes(bonif.mes) }}</td>
                            <td>{{ bonif.planibene }}</td>
                            <td>{{ bonif.idrubropres }} - {{ bonif.rubro_pres }}</td>
                            <td class="text-right">{{ numberFormat.format(bonif.monto) }}</td>
                            <td>{{ bonif.tipo_desc }}</td>
                            <td class="text-right">{{ numberFormat.format(bonif.desc_jub) }}</td>
                            <td class="text-right">{{ numberFormat.format(bonif.monto_cobrar) }}</td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5"><b>TOTAL ............................GS:</b></td>
                            <td class="text-right"><b class="totales">{{ numberFormat.format(totalMonto) }}</b></td>
                            <td></td>
                            <td class="text-right"><b class="totales">{{ numberFormat.format(totalDescuento) }}</b></td>
                            <td class="text-right"><b class="totales">{{ numberFormat.format(totalMontoCobrar) }}</b></td>
                          </tr>
                        </tfoot>
                      </template>
                    </v-simple-table>
                  </section>

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
    EmpleadoList: [],
    EmpleadoSelect: [],
    BonificacionSelect: [],
    period: `${new Date().getFullYear()}`,
    mess: '',
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
    numberFormat: new Intl.NumberFormat('es-ES'),
    fechayhora: new Date(),
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
  }),

  // called when page is created before dom
  created() {
    this.getEmpleado()
  },

  computed: {
    isGenerating () {
      return this.progress !== 0 && this.progress !== 100
    },

    isEmpleadoSelect(){
      return Object.keys(this.EmpleadoSelect).length !== 0 ? true : false
    },

    isPeriodo() {
      return this.period !== '' ? true : false
    },

    totalMonto(){
      if(this.BonificacionSelect.hasOwnProperty("detalle")){
        return this.BonificacionSelect.detalle.reduce((sum, value) => (sum + parseInt(value.monto)), 0)
      }
      else{
        return 0
      }
    },

    totalDescuento(){
      if(this.BonificacionSelect.hasOwnProperty("detalle")){
        return this.BonificacionSelect.detalle.reduce((sum, value) => (sum + parseInt(value.desc_jub)), 0)
      }
      else{
        return 0
      }
    },    

    totalMontoCobrar(){
      if(this.BonificacionSelect.hasOwnProperty("detalle")){
        return this.BonificacionSelect.detalle.reduce((sum, value) => (sum + parseInt(value.monto_cobrar)), 0)
      }
      else{
        return 0
      }
    },

  },

  components: {
    VueHtml2pdf
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
    }),

    getEmpleado() {
      this.actTableList('empleado')
        .then( response => {
          this.EmpleadoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getBonificacion() {
      this.BonificacionSelect = []
      this.actTableList(`beneficio/${this.EmpleadoSelect.idpersonal}/${this.period}/${this.mess}`)
        .then( response => {
          this.BonificacionSelect = response.data[0]
        })
        .catch( error => {
          console.log(error)
        })
    },

    mes(id){
      return this.meses.find( mes => mes.value.includes(id)).desc
    },

    planilla(id = 0){
      return null || this.PlanillaList.find( planilla => planilla.plla.includes(id)).descripcion
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

  .section-container span {
    font-size: 14px;
    float: right;
    font-weight: bold;
  }

  .section-container .totales {
    font-size: 0.875rem;
  }
</style>