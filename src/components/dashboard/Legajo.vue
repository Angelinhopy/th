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
              md6>
              <v-autocomplete
                v-model="EmpleadoSelect"
                :items="EmpleadoList"
                :return-object="true"
                item-text="nomape"
                item-value="idpersonal"
                label="Empleado"
                @change="FiltrarDatos"
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
                :paginate-elements-by-height="1000"
                filename="Legajo"
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
                    <h1>Legajo Personal</h1>
                  </section>

                  <section class="mb-1">
                    <h3>Datos Personales</h3>
                    <v-simple-table dense light>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th>ID Empleado: {{ EmpleadoSelect.idpersonal }}</th>
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
                                  {{ EmpleadoSelect.nombre }}
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
                                  {{ EmpleadoSelect.apellido }}
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
                                  <b>Domicilio:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.domicilio }}
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
                                  <b>Ciudad:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.idciudad }} - {{ EmpleadoSelect.ciudad }}
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
                                  <b>Barrio:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.idbarrio }} - {{ EmpleadoSelect.barrio }}
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
                                  <b>Fecha de Nacimiento:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ formatDate(EmpleadoSelect.fecnac) }}
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
                                  <b>Lugar de Nacimiento:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"                          
                                >
                                  {{ EmpleadoSelect.lugarnac }}
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
                                  <b>Nacionalidad:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.idnacional }} - {{ EmpleadoSelect.nacionalidad }}
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
                                  <b>Número de cédula:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.ci }}
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
                                  <b>Línea baja:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.telefono }}
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
                                  <b>Celular:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.celular }}
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
                                  <b>Sexo:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  <template v-if="EmpleadoSelect.sexo == 1">
                                    1 - MASCULINO
                                  </template>
                                  <template v-else-if="EmpleadoSelect.sexo == 2">
                                    2 - FEMENINO
                                  </template>
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
                                  <b>Estado Civil:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  <template v-if="EmpleadoSelect.estcivil == 1">
                                    1 - SOLTERO/A
                                  </template>
                                  <template v-else-if="EmpleadoSelect.estcivil == 2">
                                    2 - CASADO/A
                                  </template>
                                  <template v-else-if="EmpleadoSelect.estcivil == 3">
                                    3 - DIVORCIADO/A
                                  </template>
                                  <template v-else-if="EmpleadoSelect.estcivil == 4">
                                    4 - VIUDO/A
                                  </template>
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
                                  <b>Conyuge:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.conyuge }}
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
                                  <b>Email:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.email }}
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
                                  <b>Movimiento:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.res_mov }}
                                </v-col>
                              </v-row>
                            </td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </section>

                  <section class="mb-1">
                    <h3>Datos Laborales</h3>
                    <v-simple-table dense light>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th colspan="6">Documentación de Ingreso</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><b>Fecha de Ingreso:</b></td>
                            <td>{{ formatDate(EmpleadoSelect.fec_ing) }}</td>
                            <td><b>Resolución o Decreto N°:</b></td>
                            <td>{{ EmpleadoSelect.res_mov }}</td>
                            <td><b>Fecha Resolución:</b></td>
                            <td>{{ formatDate(EmpleadoSelect.fecresmov) }}</td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </section>
                  
                  <v-divider class="mb-2"></v-divider>

                  <section class="mb-1">
                    <v-simple-table dense light>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th>
                              Datos de Movimiento
                            </th>
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
                                  <b>Planilla:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.plla }} - {{ planilla(EmpleadoSelect.plla) }}
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
                                  <b>Orden:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.orden }}
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
                                  <b>Línea Presupuest.:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.linea_pres }}
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
                                  {{ EmpleadoSelect.categoria }}
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
                                  {{ numberFormat.format(EmpleadoSelect.sueldo) }}
                                </v-col>
                              </v-row>
                            </td>
                          </tr>
                          <!--tr>
                            <td>
                              <v-row no-gutters>
                                <v-col
                                  cols="12"
                                  sm="4"
                                >
                                  <b>Cargo Presupuest.:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.idcargopres }} - {{ EmpleadoSelect.cargo_pres }}
                                </v-col>
                              </v-row>
                            </td>
                          </!--tr-->
                          <tr>
                            <td>
                              <v-row no-gutters>
                                <v-col
                                  cols="12"
                                  sm="4"
                                >
                                  <b>Dependencia:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.iddepen }} - {{ EmpleadoSelect.dependencia }}
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
                                  <b>Cargo Funcional:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.idcargofun }} - {{ EmpleadoSelect.cargo_func }}
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
                                  <b>Jerarquía:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.idjerarquia }} - {{ EmpleadoSelect.jerarquia }}
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
                                  <b>Estado:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.idestado }} - {{ EmpleadoSelect.estado }}
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
                                  <b>Tipo Documento:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="1"
                                >
                                  {{ EmpleadoSelect.tipodoc }}
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="2"
                                >
                                  <b>Res/Dec N°:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="1"
                                >
                                  {{ EmpleadoSelect.resingreso }}
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="2"
                                >
                                  <b>Fecha Res.:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="2"
                                >
                                  {{ formatDate(EmpleadoSelect.fecresingreso) }}
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
                                  <b>Fecha Inicio Contrato:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ formatDate(EmpleadoSelect.fic) }}
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
                                  <b>Fecha Fin Contrato:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ formatDate(EmpleadoSelect.ffc) }}
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
                                  <b>Otras Instituciones:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.idinstituestado }} - {{ EmpleadoSelect.institucion }}
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
                                  <b>Turno:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ EmpleadoSelect.idturno }} - {{ EmpleadoSelect.turno }} <b>de:</b> {{ EmpleadoSelect.entrada }} <b>a:</b> {{ EmpleadoSelect.salida }} hs.
                                </v-col>
                              </v-row>
                            </td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </section>

                  <section class="mb-1">
                    <h3>Nivel Académico</h3>
                    <v-simple-table dense light>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th>ID Nivel Académico: {{ AcademicoSelect.idnivelacademico}}</th>
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
                                  <b>Ciclo Académico:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ AcademicoSelect.cicloacademico }} - {{ academic(AcademicoSelect.cicloacademico) }} |
                                  <template v-if="AcademicoSelect.completo == 'C'">
                                    <b>Completo</b>
                                  </template>
                                  <template v-else-if="AcademicoSelect.completo == 'I'">
                                    <b>Incompleto</b>
                                  </template>
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
                                  <b>Grado/Curso:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ AcademicoSelect.grado_curso }}
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
                                  <b>Centro Educativo:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ AcademicoSelect.idcolegio }} - {{ AcademicoSelect.colegio }}
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
                                  <b>Universidad:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ AcademicoSelect.iduniversidad }} - {{ AcademicoSelect.universidad }}
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
                                  <b>Facultad:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ AcademicoSelect.idfacultad }} - {{ AcademicoSelect.facultad }}
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
                                  <b>Carrera:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ AcademicoSelect.idcarrera }} - {{ AcademicoSelect.carrera }}
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
                                  <b>Título Obtenido:</b>
                                </v-col>
                                <v-col
                                  cols="12"
                                  sm="5"
                                >
                                  {{ AcademicoSelect.idtitulo }} - {{ AcademicoSelect.titulo }}
                                </v-col>
                              </v-row>
                            </td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </section>

                  <section class="mb-1">
                    <h3>Cursos</h3>
                    <v-simple-table dense light>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th>Nombre del Curso</th>
                            <th>Institución</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Nota</th>
                            <th>Rendimiento</th>
                            <th>Asistencia</th>
                            <th>Observación</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(cursos, index) in CursosSelect" :key="index">
                            <td>{{ cursos.nombrecurso }}</td>
                            <td>{{ cursos.institucion }}</td>
                            <td>{{ formatDate(cursos.fecha_inicio) }}</td>
                            <td>{{ formatDate(cursos.fecha_fin) }}</td>
                            <td>{{ cursos.nota }}</td>
                            <td>{{ cursos.rendimiento }}</td>
                            <td>{{ cursos.asistencia }}</td>
                            <td>{{ cursos.observacion }}</td>
                          </tr>
                        </tbody>
                      </template>
                    </v-simple-table>
                  </section>

                  <section class="mb-1">
                    <h3>Evaluación</h3>
                    <v-simple-table dense light>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th>Periodo</th>
                            <th>Mes</th>
                            <th>Tipo de Desempeño</th>
                            <th>Evaluación</th>
                          </tr>
                        </thead>
                        <tbody>
                          <template v-for="evaluac in EvaluacionSelect">
                            <tr v-for="(det, idx) in evaluac.detalle" :key="idx">
                              <td>{{ evaluac.periodo }}</td>
                              <td>{{ evaluac.mes }}</td>
                              <td>{{ det.tipo_desempeno }}</td>
                              <td>{{ det.evaluacion }}</td>
                            </tr>
                          </template>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="3"><b>TOTAL PROMEDIO:</b></td>
                            <td><b>{{ promedio }}</b></td>
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
    AcademicoList: [],
    AcademicoSelect: [],
    CursosList: [],
    CursosSelect: [],
    EvaluacionList: [],
    EvaluacionSelect: [{}],
    PlanillaList: [
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
    progress: 0,
    pdfDownloaded: false,
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
      { cilco: "25", descripcion: 'Educ. Superior'},
    ],
    numberFormat: new Intl.NumberFormat('es-ES'),
  }),

  // called when page is created before dom
  created() {
    this.getEmpleado()
    this.getAcademico()
    this.getCursos()
    this.getEvaluacion()
  },

  computed: {
    isGenerating () {
      return this.progress !== 0 && this.progress !== 100
    },

    promedio(){
      if(this.EvaluacionSelect[0].hasOwnProperty("detalle")){
        let sumatoria = this.EvaluacionSelect[0].detalle.reduce( (acumulador, siguienteValor) => 
          ({ evaluacion: parseInt(acumulador.evaluacion) + parseInt(siguienteValor.evaluacion) }), { evaluacion: 0}
        )

        let promedio = (sumatoria.evaluacion / this.EvaluacionSelect[0].detalle.length)

        return Math.round(promedio)
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

    getAcademico() {
      this.actTableList('academico')
        .then( response => {
          this.AcademicoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getCursos() {
      this.actTableList('cursos')
        .then( response => {
          this.CursosList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getEvaluacion() {
      this.actTableList('evaluacion')
        .then( response => {
          this.EvaluacionList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    planilla(id = 1){
      return this.PlanillaList.find( planilla => planilla.plla.includes(id)).descripcion
    },

    academic(id = 0){
      return this.CicloAcademicoList.find( academic => academic.ciclo.includes(id)).descripcion
    },

    FiltrarDatos() {
      this.AcademicoSelect = this.AcademicoList.find( personal => personal.idpersonal == this.EmpleadoSelect.idpersonal)
      this.CursosSelect = this.CursosList.filter( personal => personal.idpersonal == this.EmpleadoSelect.idpersonal)
      this.EvaluacionSelect = this.EvaluacionList.filter(personal => personal.idpersonal == this.EmpleadoSelect.idpersonal)
    },

    formatDate (date) {
      if (!date) return null

      const [year, month, day] = date.split('-')
      return `${day}-${month}-${year}`
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