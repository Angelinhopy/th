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
            title="Empleado"
            text="Lista de empleados"
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
                            ref="formEmpleado"
                            v-model="valid"
                            lazy-validation
                          >
                            <v-layout wrap>
                              <v-flex
                                xs12
                                sm6
                                md6>
                                <v-text-field
                                  v-model="editedItem.nombre"
                                  :rules="requiredRules.general"
                                  required
                                  label="Nombre" />
                              </v-flex>
                              <v-flex
                                xs12
                                sm6
                                md6>
                                <v-text-field
                                  v-model="editedItem.apellido"
                                  :rules="requiredRules.general"
                                  required
                                  label="Apellido" />
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md12>
                                <v-text-field
                                  v-model="editedItem.domicilio"
                                  label="Domicilio" />
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-text-field
                                  v-model="editedItem.ci"
                                  :rules="requiredRules.general"
                                  required
                                  label="Nro. Cédula" />
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-text-field
                                  v-model="editedItem.telefono"
                                  label="Teléfono" />
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-text-field
                                  v-model="editedItem.celular"
                                  label="Celular" />
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-autocomplete
                                  v-model="editedItem.idbarrio"
                                  :items="BarrioList"
                                  item-text="descripcion"
                                  item-value="idbarrio"
                                  label="Barrio"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-autocomplete
                                  v-model="editedItem.idciudad"
                                  :items="CiudadList"
                                  item-text="descripcion"
                                  item-value="idciudad"
                                  label="Ciudad"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-autocomplete
                                  v-model="editedItem.idnacional"
                                  :items="NacionalidadList"
                                  item-text="descripcion"
                                  item-value="idnacional"
                                  label="Nacionalidad"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <!--v-text-field
                                  v-model="editedItem.fecnac"
                                  hint="YYYY-MM-DD"
                                  label="Fecha Nacimiento" /-->
                                <v-menu
                                  v-model="calendarioFecNac"
                                  :close-on-content-click="false"
                                  :nudge-right="40"
                                  transition="scale-transition"
                                  offset-y
                                  min-width="auto"
                                >
                                  <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                      v-model="computedDateFormattedFecNac"
                                      label="Fecha Nacimiento"
                                      readonly
                                      v-bind="attrs"
                                      v-on="on"
                                    ></v-text-field>
                                  </template>
                                  <v-date-picker
                                    v-model="editedItem.fecnac"
                                    no-title
                                    @input="calendarioFecNac = false"
                                  ></v-date-picker>
                                </v-menu>
                              </v-flex>
                              <v-flex
                                xs12
                                sm8
                                md6>
                                <v-text-field
                                  v-model="editedItem.lugarnac"
                                  label="Lugar Nacimiento" />
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md2>
                                <v-select
                                  v-model="editedItem.sexo"
                                  :items="genero"
                                  item-text="sexo"
                                  item-value="val"
                                  label="Sexo"
                                  :append-icon="'mdi-plus'"
                                ></v-select>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-select
                                  v-model="editedItem.estcivil"
                                  :items="estadoCivil"
                                  item-text="estcivil"
                                  item-value="val"
                                  label="Estado Civil"
                                  :append-icon="'mdi-plus'"
                                ></v-select>
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md8>
                                <v-text-field
                                  v-model="editedItem.conyuge"
                                  label="Conyuge" />
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md12>
                                <v-text-field
                                  v-model="editedItem.email"
                                  label="Email" />
                              </v-flex>
                              <!--v-flex--
                                xs12
                                sm12
                                md12>
                                <v-file-input
                                  v-model="foto"
                                  accept="image/*"
                                  label="Foto"
                                  placeholder="Foto"
                                  prepend-icon="mdi-image"
                                />
                              </!--v-flex-->
                              <v-flex
                                xs12
                                sm12
                                md12
                              >
                                <h3>Documentación de Ingreso</h3>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <!--v-text-field
                                  v-model="editedItem.fec_ing"
                                  :rules="requiredRules.general"
                                  required
                                  hint="YYYY-MM-DD"
                                  label="Fecha Ingreso" /-->
                                <v-menu
                                  v-model="calendarioFechaIngreso"
                                  :close-on-content-click="false"
                                  :nudge-right="40"
                                  transition="scale-transition"
                                  offset-y
                                  min-width="auto"
                                >
                                  <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                      v-model="computedDateFormattedFechaIngreso"
                                      label="Fecha Ingreso"
                                      v-bind="attrs"
                                      v-on="on"
                                    ></v-text-field>
                                  </template>
                                  <v-date-picker
                                    v-model="editedItem.fec_ing"
                                    no-title
                                    @input="calendarioFechaIngreso = false"
                                  ></v-date-picker>
                                </v-menu>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-text-field
                                  v-model="editedItem.resingreso"
                                  label="Resolución Ing." />
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <!--v-text-field
                                  v-model="editedItem.fecresingreso"
                                  hint="YYYY-MM-DD"
                                  label="Fecha Resolución" /-->
                                <v-menu
                                  v-model="calendarioFechaResol"
                                  :close-on-content-click="false"
                                  :nudge-right="40"
                                  transition="scale-transition"
                                  offset-y
                                  min-width="auto"
                                >
                                  <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                      v-model="computedDateFormattedFechaResol"
                                      label="Fecha Resolución"
                                      readonly
                                      v-bind="attrs"
                                      v-on="on"
                                    ></v-text-field>
                                  </template>
                                  <v-date-picker
                                    v-model="editedItem.fecresingreso"
                                    no-title
                                    @input="calendarioFechaResol = false"
                                  ></v-date-picker>
                                </v-menu>
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md12
                              >
                                <h3>Datos de Movimiento</h3>
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md10>
                                <v-autocomplete
                                  v-model="editedItem.plla"
                                  :items="PlanillaList"
                                  item-text="descripcion"
                                  item-value="plla"
                                  label="Planilla"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md2>
                                <v-text-field
                                  v-model="editedItem.orden"
                                  label="Órden" />
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md12>
                                <v-autocomplete
                                  v-model="editedItem.lineapres"
                                  :items="VacanciaList"
                                  item-text="descrip"
                                  item-value="lineapres"
                                  label="Anexo"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <!--v-flex--
                                xs12
                                sm4
                                md4>
                                <v-autocomplete
                                  v-model="editedItem.idcargopres"
                                  :items="PresupuestadoList"
                                  item-text="descripcion"
                                  item-value="idcargopres"
                                  label="Cargo Presupuestado"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </!--v-flex-->
                              <v-flex
                                xs12
                                sm6
                                md5>
                                <v-autocomplete
                                  v-model="editedItem.idcategoria"
                                  :items="CategoriaList"
                                  item-text="categ"
                                  item-value="idcategoria"
                                  label="Categoría"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm6
                                md7>
                                <v-autocomplete
                                  v-model="editedItem.iddepen"
                                  :items="DependenciaList"
                                  item-text="descripcion"
                                  item-value="iddepen"
                                  label="Dependencia"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-autocomplete
                                  v-model="editedItem.idcargofun"
                                  :items="FuncionalList"
                                  item-text="descripcion"
                                  item-value="idcargofun"
                                  label="Cargo Funcional"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-autocomplete
                                  v-model="editedItem.idjerarquia"
                                  :items="JerarquiaList"
                                  item-text="descripcion"
                                  item-value="idjerarquia"
                                  label="Jerarquía"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-autocomplete
                                  v-model="editedItem.idestado"
                                  :items="EstadoList"
                                  item-text="descripcion"
                                  item-value="idestado"
                                  label="Estado"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-text-field
                                  v-model="editedItem.tipodoc"
                                  label="Tipo Doc." />
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-text-field
                                  v-model="editedItem.res_mov"
                                  label="Res. Mov." />
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <!--v-text-field
                                  v-model="editedItem.fecresmov"
                                  hint="YYYY-MM-DD"
                                  label="Fecha Res. Mov." /-->
                                <v-menu
                                  v-model="calendarioFechaResMov"
                                  :close-on-content-click="false"
                                  :nudge-right="40"
                                  transition="scale-transition"
                                  offset-y
                                  min-width="auto"
                                >
                                  <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                      v-model="computedDateFormattedFecResMov"
                                      label="Fecha Res. Mov."
                                      readonly
                                      v-bind="attrs"
                                      v-on="on"
                                    ></v-text-field>
                                  </template>
                                  <v-date-picker
                                    v-model="editedItem.fecresmov"
                                    no-title
                                    @input="calendarioFechaResMov = false"
                                  ></v-date-picker>
                                </v-menu>
                              </v-flex>
                              <v-flex
                                xs12
                                sm4
                                md4>
                                <v-autocomplete
                                  v-model="editedItem.idturno"
                                  :items="TurnoList"
                                  item-text="descrip"
                                  item-value="idturno"
                                  label="Turno"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm12
                                md8>
                                <v-autocomplete
                                  v-model="editedItem.idinstituestado"
                                  :items="InstitucionList"
                                  item-text="descripcion"
                                  item-value="idinstituestado"
                                  label="Institución Estado"
                                  :append-icon="'mdi-plus'"
                                  :rules="requiredRules.general"
                                  required
                                ></v-autocomplete>
                              </v-flex>
                              <v-flex
                                xs12
                                sm6
                                md6>
                                <!--v-text-field
                                  v-model="editedItem.fic"
                                  hint="YYYY-MM-DD"
                                  label="Fecha Inicio Contrato" /-->
                                <v-menu
                                  v-model="calendarioFic"
                                  :close-on-content-click="false"
                                  :nudge-right="40"
                                  transition="scale-transition"
                                  offset-y
                                  min-width="auto"
                                >
                                  <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                      v-model="computedDateFormattedFic"
                                      label="Fecha Inicio Contrato"
                                      readonly
                                      v-bind="attrs"
                                      v-on="on"
                                    ></v-text-field>
                                  </template>
                                  <v-date-picker
                                    v-model="editedItem.fic"
                                    no-title
                                    @input="calendarioFic = false"
                                  ></v-date-picker>
                                </v-menu>
                              </v-flex>
                              <v-flex
                                xs12
                                sm6
                                md6>
                                <!--v-text-field
                                  v-model="editedItem.ffc"
                                  hint="YYYY-MM-DD"
                                  label="Fecha Fin Contrato" /-->
                                <v-menu
                                  v-model="calendarioFfc"
                                  :close-on-content-click="false"
                                  :nudge-right="40"
                                  transition="scale-transition"
                                  offset-y
                                  min-width="auto"
                                >
                                  <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                      v-model="computedDateFormattedFfc"
                                      label="Fecha Fin Contrato"
                                      readonly
                                      v-bind="attrs"
                                      v-on="on"
                                    ></v-text-field>
                                  </template>
                                  <v-date-picker
                                    v-model="editedItem.ffc"
                                    no-title
                                    @input="calendarioFfc = false"
                                  ></v-date-picker>
                                </v-menu>
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
                          @click="close">Cancelar</v-btn>
                        <v-btn
                          color="blue darken-1"
                          text
                          :disabled="!valid"
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
              :items="EmpleadoList"
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

              <template v-slot:item.fecnac="props">
                {{ formatDate(props.item.fecnac) }}
              </template>

              <template v-slot:item.sexo="props">
                <template v-if="props.item.sexo == 1">
                  Masculino
                </template>
                <template v-else>
                  Femenino
                </template>
              </template>

              <template v-slot:item.estcivil="props">
                <template v-if="props.item.estcivil == 1">
                  Soltero/a
                </template>
                <template v-else-if="props.item.estcivil == 2">
                  Casado/a
                </template>
                <template v-else-if="props.item.estcivil == 3">
                  Divorciado/a
                </template>
                <template v-else-if="props.item.estcivil == 4">
                  Viudo/a
                </template>
              </template>

              <template v-slot:item.fec_ing="props">
                {{ formatDate(props.item.fec_ing) }}
              </template>

              <template v-slot:item.fecresingreso="props">
                {{ formatDate(props.item.fecresingreso) }}
              </template>

              <template v-slot:item.fecresmov="props">
                {{ formatDate(props.item.fecresmov) }}
              </template>

              <template v-slot:item.fic="props">
                {{ formatDate(props.item.fic) }}
              </template>

              <template v-slot:item.ffc="props">
                {{ formatDate(props.item.ffc) }}
              </template>

              <template v-slot:item.plla="props">
                {{ planilla(props.item.plla) }}
              </template>

              <template v-slot:item.sueldo_pres="props">
                {{ numberFormat.format(props.item.sueldo_pres) }}
              </template>

              <template v-slot:item.sueldo="props">
                {{ numberFormat.format(props.item.sueldo) }}
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
    EmpleadoList: [],
    buscando: false,
    dialog: false,
    search: '',
    headers: [
      { text: '---Acción---', value: 'accion', sortable: false },
      { text: 'Nombre', value: 'nombre' },
      { text: 'Apellido', value: 'apellido' },
      { text: 'Domicilio', value: 'domicilio'},
      { text: 'Barrio', value: 'barrio' },
      { text: 'Ciudad', value: 'ciudad' },
      { text: 'Teléfono', value: 'telefono' },
      { text: 'Celular', value: 'celular' },
      { text: 'Fec Nacim.', value: 'fecnac' },
      { text: 'Lugar Nacim.', value: 'lugarnac' },
      { text: 'Nacionalidad', value: 'nacionalidad' },
      { text: 'Nro. Cédula', value: 'ci' },
      { text: 'Sexo', value: 'sexo' },
      { text: 'Est. Civil', value: 'estcivil' },
      { text: 'Conyuge', value: 'conyuge' },
      { text: 'E-mail', value: 'email' },
      { text: 'Foto', value: 'foto' },
      { text: 'Fec Ingreso', value: 'fec_ing' },
      { text: 'Res. Ingreso', value: 'resingreso' },
      { text: 'Fec. Res. Ing.', value: 'fecresingreso' },
      { text: 'Planilla', value: 'plla' },
      { text: 'Órden', value: 'orden' },
      { text: 'Línea Pres.', value: 'linea_pres' },
      //{ text: 'Categ. Pres.', value: 'categoria_pres' },
      //{ text: 'Sueldo Pres.', value: 'sueldo_pres' },
      //{ text: 'Cantidad', value: 'cantidad' },
      //{ text: 'Total Mens.', value: 'totmensu' },
      //{ text: 'Anexo', value: 'vacancia' },
      { text: 'Categoría', value: 'categoria' },
      { text: 'Sueldo', value: 'sueldo' },
      //{ text: 'Cargo Pres.', value: 'cargo_pres' },
      { text: 'Dependencia', value: 'dependencia' },
      { text: 'Cargo Func.', value: 'cargo_func' },
      { text: 'Jerarquía', value: 'jerarquia' },
      { text: 'Estado', value: 'estado' },
      { text: 'Tipo Doc.', value: 'tipodoc' },
      { text: 'Res. Mov.', value: 'res_mov' },
      { text: 'Fecha Res. Mov.', value: 'fecresmov' },
      { text: 'Turno', value: 'turno' },
      { text: 'Entrada', value: 'entrada' },
      { text: 'Salida', value: 'salida' },
      { text: 'Institución Est.', value: 'institucion' },
      { text: 'Fecha Ini. Cont.', value: 'fic' },
      { text: 'Fecha Fin Cont.', value: 'ffc' },
    ],
    editedIndex: -1,
    editedItem: {
      idpersonal: '',
      nombre: '',
      apellido: '',
      domicilio: '',
      idbarrio: '',
      idciudad: '',
      telefono: '',
      celular: '',
      fecnac: '',
      lugarnac: '',
      idnacional: '',
      ci: '',
      sexo: '',
      estcivil: '',
      conyuge: '',
      email: '',
      foto: '',
      fec_ing: '',
      resingreso: '',
      fecresingreso: '',
      plla: '',
      orden: '',
      lineapres: '',
      idcategoria: '',
      //idcargopres: '',
      iddepen: '',
      idcargofun: '',
      idjerarquia: '',
      idestado: '',
      tipodoc: '',
      res_mov: '',
      fecresmov: '',
      idturno: '',
      idinstituestado: '',
      fic: '',
      ffc: '',
    },
    defaultItem: {
    },
    BarrioList: [],
    CiudadList: [],
    NacionalidadList: [],
    VacanciaList: [],
    CategoriaList: [],
    PresupuestadoList: [],
    DependenciaList: [],
    FuncionalList: [],
    JerarquiaList: [],
    EstadoList: [],
    TurnoList: [],
    InstitucionList: [],
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
    genero: [
      {sexo: 'S/D', val: '0'},
      {sexo: 'M', val: '1'},
      {sexo: 'F', val: '2'},
    ],
    estadoCivil: [
      {estcivil: 'S/D', val: '0'},
      {estcivil: 'Soltero/a', val: '1'},
      {estcivil: 'Casado/a', val: '2'},
      {estcivil: 'Divorciado/a', val: '3'},
      {estcivil: 'Viudo/a', val:'4'},
    ],
    valid: true,
    requiredRules: {
      general: [
        (v) => !!v || "Este campo es requerido"
      ],
    },
    numberFormat: new Intl.NumberFormat('es-ES'),
    calendarioFecNac: false,
    calendarioFechaIngreso: false,
    calendarioFechaResol: false,
    calendarioFechaResMov: false,
    calendarioFic: false,
    calendarioFfc: false,

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

    computedDateFormattedFecNac () {
      return this.formatDate(this.editedItem.fecnac)
    },

    computedDateFormattedFechaIngreso () {
      return this.formatDate(this.editedItem.fec_ing)
    },

    computedDateFormattedFechaResol () {
      return this.formatDate(this.editedItem.fecresingreso)
    },

    computedDateFormattedFecResMov () {
      return this.formatDate(this.editedItem.fecresmov)
    },

    computedDateFormattedFic () {
      return this.formatDate(this.editedItem.fic)
    },

    computedDateFormattedFfc () {
      return this.formatDate(this.editedItem.ffc)
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
  },

  // called when page is created before dom
  created() {
    this.getEmpleado()
    this.getBarrio()
    this.getCiudad()
    this.getNacionalidad()
    this.getVacancia()
    this.getCategoria()
    this.getPresupuestado()
    this.getDependencia()
    this.getFuncional()
    this.getJerarquia()
    this.getEstado()
    this.getTurno()
    this.getInstitucion()
  },

  methods: {
    ...mapActions({
      actTableList: 'getTableList',
      actProcesar: 'updateTableItem'
    }),

    ...mapGetters({
      getPermiso: 'auth/accesspage'
    }),

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
    
    getBarrio() {
      this.actTableList('barrio')
        .then( response => {
          this.BarrioList = response.data
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

    getNacionalidad() {
      this.actTableList('nacionalidad')
        .then( response => {
          this.NacionalidadList = response.data
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

    getCategoria() {
      this.actTableList('categoria')
        .then( response => {
          this.CategoriaList = response.data
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

    getDependencia() {
      this.actTableList('dependencia')
        .then( response => {
          this.DependenciaList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getFuncional() {
      this.actTableList('funcional')
        .then( response => {
          this.FuncionalList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getJerarquia() {
      this.actTableList('jerarquia')
        .then( response => {
          this.JerarquiaList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getEstado() {
      this.actTableList('estado')
        .then( response => {
          this.EstadoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getTurno() {
      this.actTableList('turno')
        .then( response => {
          this.TurnoList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    getInstitucion() {
      this.actTableList('institucion')
        .then( response => {
          this.InstitucionList = response.data
        })
        .catch( error => {
          console.log(error)
        })
    },

    planilla(id){
      return this.PlanillaList.find( planilla => planilla.plla.includes(id)).descripcion
    },

    formatDate (date) {
      if (!date) return null

      const [year, month, day] = date.split('-')
      return `${day}-${month}-${year}`
    },
    
    // object.assign fills in the empty object with the properties of item
    editItem(item, dbox = true) {
      this.editedIndex = this.EmpleadoList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = dbox
    },

    deleteItem(item) {
      const index = this.EmpleadoList.indexOf(item)
      this.$confirm('¿Está seguro que desea eliminar?')
        .then( res => {
          if(res) {
            this.editedItem = Object.assign({}, item)
            let endpoint = `empleado/delete/${this.editedItem.idpersonal}`
            let method = 'DELETE'
            this.callTableAction(endpoint, method)
            this.EmpleadoList.splice(index, 1)
          }
        })
    },

    callTableAction(endpoint, method) {
      let tableItem = this.editedItem
      this.actProcesar({endpoint, tableItem, method})
        .then( response => {
          this.getEmpleado()
          this.saveInline()
        })
        .catch(error => {
          console.log(error)
          this.cancelInline()
        })
    },

    save() {
      if( this.$refs.formEmpleado.validate() ){
        if(this.editedIndex > -1) {
          Object.assign(this.EmpleadoList[this.editedIndex], this.editedItem)
          let endpoint = `empleado/update/${this.editedItem.idpersonal}`
          let method = 'PATCH'
          this.callTableAction(endpoint, method)
        }
        else {
          let endpoint = `empleado/add`
          let method = 'POST'
          this.callTableAction(endpoint, method)
        }
        this.close()
      }
    },

    saveItem(item) {
      this.editedIndex = this.EmpleadoList.indexOf(item)
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