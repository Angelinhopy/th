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
                @change="getEvaluacion()"
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
                filename="Evaluacion"
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
                    <h1>Evaluación Personal</h1>
                  </section>

                  <section class="mb-1">
                    <h3>Datos Personales</h3>
                    <v-simple-table dense light>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th>ID Empleado: {{ EvaluacionSelect.idpersonal }}</th>
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
                                  {{ EvaluacionSelect.nombre }}
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
                                  {{ EvaluacionSelect.apellido }}
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
                                  {{ EvaluacionSelect.ci }}
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
                                  {{ EvaluacionSelect.periodo }}
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
                                  {{ EvaluacionSelect.mes }}
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
                            <th>Tipo Desempeño</th>
                            <th>Evaluación</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(evaluac, index) in EvaluacionSelect.detalle" :key="index">
                            <td>{{ index+1 }}</td>
                            <td>{{ evaluac.tipo_desempeno }}</td>
                            <td>{{ evaluac.evaluacion }}</td>
                          </tr>
                        </tbody>
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
    EvaluacionSelect: [],
    period: '',
    mess: '',
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
      return this.period !== '' ? true : false
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

    getEvaluacion() {
      this.EvaluacionSelect = []
      this.actTableList(`evaluac/${this.EmpleadoSelect.idpersonal}/${this.period}/${this.mess}`)
        .then( response => {
          this.EvaluacionSelect = response.data[0]
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