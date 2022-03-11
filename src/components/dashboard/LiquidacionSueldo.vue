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
                v-model="periodo"
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
                v-model="mes"
                :items="meses"
                item-text="desc"
                item-value="value"
                label="Mes"
                :append-icon="'mdi-plus'"
                @change="getSueldo()"
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
                filename="Liquidacion"
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
                  <section class="mb-1">
                    <h1>Liquidación de Sueldo</h1>
                  </section>

                  <section class="mb-1">
                    <h3>Datos Personales</h3>
                    <v-simple-table dense light>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th>ID Empleado: {{ SueldoSelect.idpersonal }}</th>
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
                                  {{ SueldoSelect.nombre }}
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
                                  {{ SueldoSelect.apellido }}
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
                                  {{ SueldoSelect.ci }}
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
                                  <b>Planilla:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ SueldoSelect.pila }} - {{ SueldoSelect.planilla }}
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
                                  <b>Línea Pres.:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ SueldoSelect.linea }}
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
                                  <b>Cargo Pres.:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ SueldoSelect.cargo_pres }}
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
                                  <b>Categoría:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"                          
                                >
                                  {{ SueldoSelect.categoria }}
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
                                  <b>Sueldo:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ SueldoSelect.sueldo }}
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
                                  <b>Periodo:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ SueldoSelect.periodo }}
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
                                  <b>Mes:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ SueldoSelect.mes }}
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
                            <th>Descuento</th>
                            <th>Monto Desc.</th>
                            <th>Sueldo Devengado</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ totalDevengado }}</td>
                          </tr>
                          <tr v-for="(sueldo, index) in SueldoSelect.detalle" :key="index">
                            <td>{{ index+1 }}</td>
                            <td>{{ sueldo.tipo_descuento }}</td>
                            <td>{{ sueldo.monto }}</td>
                            <td></td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td>-</td>
                            <td><b>TOTAL ............................GS:</b></td>
                            <td><b>{{ totalDescuento }}</b></td>
                            <td><b>{{ totalSueldo }}</b></td>
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
    SueldoSelect: [],
    periodo: '',
    mes: '',
    progress: 0,
    pdfDownloaded: false,
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
    ]
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

    getEmpleado() {
      this.actTableList('empleado')
        .then( response => {
          this.EmpleadoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getSueldo() {
      this.SueldoSelect = []
      this.actTableList(`sueldo/${this.EmpleadoSelect.idpersonal}/${this.periodo}/${this.mes}`)
        .then( response => {
          this.SueldoSelect = response.data[0]
        })
        .catch( error => {
          console.log(error)
        })
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