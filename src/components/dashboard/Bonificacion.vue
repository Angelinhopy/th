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
                  <section class="mb-1">
                    <h1>Bonificación/Gratificación</h1>
                  </section>

                  <section class="mb-1">
                    <h3>Datos Personales</h3>
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
                                  {{ BonificacionSelect.ci }}
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
                            <th>Monto</th>
                            <th>Tipo Descuento</th>
                            <th>Monto Desc.</th>
                            <th>Monto a Cobrar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(bonif, index) in BonificacionSelect.detalle" :key="index">
                            <td>{{ index+1 }}</td>
                            <td>{{ bonif.periodo }}</td>
                            <td>{{ mes(bonif.mes) }}</td>
                            <td>{{ bonif.planibene }}</td>
                            <td>{{ bonif.idrubropres }} - {{ bonif.rubro_pres }}</td>
                            <td>{{ numberFormat.format(bonif.monto) }}</td>
                            <td>{{ bonif.tipo_desc }}</td>
                            <td>{{ numberFormat.format(bonif.desc_jub) }}</td>
                            <td>{{ numberFormat.format(bonif.monto_cobrar) }}</td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5"><b>TOTAL ............................GS:</b></td>
                            <td><b>{{ numberFormat.format(totalMonto) }}</b></td>
                            <td></td>
                            <td><b>{{ numberFormat.format(totalDescuento) }}</b></td>
                            <td><b>{{ numberFormat.format(totalMontoCobrar) }}</b></td>
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
    ],
    numberFormat: new Intl.NumberFormat('es-ES'),
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