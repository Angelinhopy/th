<template>
  <v-list dense>
    <v-list-group
      v-for="item in items"
      :key="item.title"
      v-model="item.active"
      :prepend-icon="item.action"
      no-action
    >
      <template v-slot:activator>
        <v-list-item-content>
          <v-list-item-title v-text="item.title"></v-list-item-title>
        </v-list-item-content>
      </template>

      <v-list-item
        v-for="child in item.items"
        :key="child.title"
        link :to="{name: child.table}"
      >
      <!-- :to="{name: 'granjas'}" -->
        <v-list-item-content>
          <v-list-item-title v-text="child.title"></v-list-item-title>
        </v-list-item-content>
        <v-list-item-icon>
          <v-icon>mdi-menu-right</v-icon>
        </v-list-item-icon>
      </v-list-item>
    </v-list-group>
  </v-list>
</template>

<script>
  export default {
    name: 'Navbar',
    data: () => ({
      items: [
        {
          action: 'mdi-account-tie',
          //active: true,
          items: [
            { title: 'Lista empleados', table: 'empleado' },
            { title: 'Categoría', table: 'categoria' },
            { title: 'Dependencia', table: 'dependencia' },
            { title: 'Jerarquía', table: 'jerarquia' },
          ],
          title: 'Empleado',
        },
        {
          action: 'mdi-map-marker',
          items: [
            { title: 'País', table: 'pais' },
            { title: 'Nacionalidad', table: 'nacionalidad' },
            { title: 'Ciudad', table: 'ciudad' },
            { title: 'Barrio', table: 'barrio' },
          ],
          title: 'Procedencia',
        },
        {
          action: 'mdi-cash-multiple',
          items: [
            { title: 'Sueldos', table: 'sueldos' },
            { title: 'Beneficios', table: 'beneficios' },
            { title: 'Aguinaldos', table: 'aguinaldo' },
            { title: 'Tipo descuento', table: 'descuento' },
            { title: 'Planilla beneficio', table: 'planilla' },
            { title: 'Rubro presupuestario', table: 'rubro' },
          ],
          title: 'Liquidación',
        },
        {
          action: 'mdi-school',
          items: [
            { title: 'Nivel académico', table: 'academico' },
            { title: 'Cursos', table: 'cursos' },
            { title: 'Evaluación', table: 'evaluacion' },
            { title: 'Tipo desempeño', table: 'desempeno' },
          ],
          title: 'Educación',
        },
        {
          action: 'mdi-book-education',
          items: [
            { title: 'Universidad', table: 'universidad' },
            { title: 'Facultad', table: 'facultad' },
            { title: 'Carrera', table: 'carrera' },
            { title: 'Centro educativo', table: 'centro' },
            { title: 'Título', table: 'titulo' },
          ],
          title: 'Académico',
        },
        {
          action: 'mdi-tag',
          items: [
            { title: 'Cargo presupuestado', table: 'presupuestado' },
            { title: 'Cargo funcional', table: 'funcional' },
            { title: 'Estado', table: 'estado' },
            { title: 'Turno', table: 'turno' },
            { title: 'Vacancia', table: 'vacancia' },
            { title: 'Institución estado', table: 'institucion' },
            ],
          title: 'Ocupación',
        },
        {
          action: 'mdi-chart-box',
          items: [
            { title: 'Datos legajo', table: 'legajo' },
            { title: 'Liquidación sueldo', table: 'liquidacion' },
            { title: 'Bonificación/gratificación', table: 'bonificacion' },
            { title: 'Evaluación del personal', table: 'evalpersonal' },
            { title: 'Liquidación aguinaldo', table: 'liqaguinaldo' },
            ],
          title: 'Informes',
        },
        {
          action: 'mdi-account-group',
          items: [
            { title: 'Lista usuarios', table: 'usuarios' },
            { title: 'Perfil', table: 'perfil' },
            { title: 'Permiso', table: 'permiso' },
            { title: 'Acceso', table: 'acceso' },
          ],
          title: 'Usuario',
        },
      ],
    })
  }
</script>