<?php

  class CalcSueldos {
    private static $sueldos;
    private static $sueldo;
    private static $empleado;
    private static $categoria;
    private static $cargo_pres;
    private static $aguinaldo;
    public static $respuesta;

    public static function Sueldos($empleado, $periodo, $mes){
      self::$sueldos = tabSueldos::where('idpersonal', '=', $empleado)->and_where('periodo', '=', $periodo)->and_where('mes', '=', $mes)->get();
    }

    public static function Empleado($empleado = 0){
      if( $empleado == 0 ){
        self::$empleado = tabEmpleado::all();
      }
      else{
        self::$empleado = tabEmpleado::find($empleado)->first();
      }
    }

    public static function Categoria($categoria){
      self::$categoria = tabCategoria::find($categoria)->first();
    }

    public static function CargoPres($cargo_pres){
      self::$cargo_pres = tabPresupuestado::find($cargo_pres)->first();
    }

    public static function Aguinaldo($empleado, $periodo){
      self::$aguinaldo = tabAguinaldo::where('idpersonal', '=', $empleado)->and_where('periodo', '=', $periodo)->first();
    }

    public static function CalculoSueldo($empleado, $periodo, $mes){
      $idrubropres = 111;
      $cargo = '';
      $categ = '';
      $cargo_pres_desc = "**S/D**";
      $sueldo = 0;
      $devengado = 0;
      $descuent_9 = 0.09;
      $descuent_16 = 0.16;
      $idtipodescuento = 0;
      $monto = 0;

      self::Sueldos($empleado, $periodo, $mes);

      if( self::getSueldos() ){
        return self::$respuesta = (object) array(
          'success' => false, 
          'descrip' => 'Periodo ya procesado'
        );
      }
      
      self::Empleado($empleado);
      $empl = self::getEmpleado();
      self::CargoPres($empl->idcargopres);
      self::Categoria($empl->idcategoria);
      
      if( $empl->plla == 1 || $empl->plla == 2 ){
        $idrubropres = 111;
      }
      elseif( $empl->plla == 3 || $empl->plla == 4 ) {
        $idrubropres = 144;
      }

      $cargo = self::getCargoPres();
      if( $cargo ){
        $cargo_pres_desc = $cargo->descripcion;
      }

      $categ = self::getCategoria();
      $sueldo = $categ->sueldo;
      $categoria = $categ->categoria;
      
      //calcular salario por fecha de ingreso
      list($anio_ing, $mes_ing, $dia_ing) = explode('-', $empl->fec_ing);
      
      if( $anio_ing == $periodo && $mes_ing == $mes){
        $cant_dias_mes = date('t', strtotime($empl->fec_ing));
        $cant_dias_trab = $cant_dias_mes - ($dia_ing-1);
        $devengado = ceil( ($sueldo / $cant_dias_mes) * $cant_dias_trab );
      }
      else {
        $devengado = $sueldo;
      }

      if( $empl->plla == 1 ){
        $idtipodescuento = 1;
        $monto = $devengado * $descuent_16;
      }
      else {
        $idtipodescuento = 2;
        $monto = $devengado * $descuent_9;
      }

      $added = tabSueldos::create(array(
        'idpersonal' => $empl->idpersonal,
        'ci' => $empl->ci,
        'periodo' => $periodo,
        'mes' => $mes,
        'idrubropres' => $idrubropres,
        'plla' => $empl->plla,
        'lineapres' => $empl->lineapres,
        'cargo_pres' => $cargo_pres_desc,
        'categoria' => $categoria,
        'sueldo' => $sueldo,
        'devengado' => $devengado,
        'total_desc_plla' => 0,
        'importe_neto_plla' => 0,
        'total_general_desc' => 0,
        'importe_neto_des' => 0
      ));

      if(is_array($added) || !$added){
        return self::$respuesta = (object) array(
          'success' => false, 
          'descrip' => 'Error al insertar sueldo'
        );
      }

      $addedDet = tabSueldosDet::create(array(
        'idsueldo' => $added,
        'ci' => $empl->ci,
        'periodo' => $periodo,
        'mes' => $mes,
        'idtipodescuento' => $idtipodescuento,
        'monto' => $monto
      ));

      if(is_array($addedDet) || !$addedDet){
        //$deleted = tabSueldos::find($added)->delete();
        
        return self::$respuesta = (object) array(
          'success' => false, 
          'descrip' => 'Error al insertar detalle sueldo'
        );
      }

      //Aguinaldo
      self::Aguinaldo($empl->idpersonal, $periodo);

      if( !self::getAguinaldo() ){
        if( $empl->plla == 1 || $empl->plla == 2 ){
          $idrubropres = 114;
        }
        else {
          $idrubropres = 144;
        }

        $addedAgui = tabAguinaldo::create(array(
          'idpersonal' => $empl->idpersonal,
          'ci' => $empl->ci,
          'periodo' => $periodo,
          'mes' => 12,
          'idrubropres' => $idrubropres
        ));

        if( is_array($addedAgui) || !$addedAgui ){
          //$deletedDet = tabSueldosDet::find($addedDet)->delete();
          //$deleted = tabSueldos::find($added)->delete();

          return self::$respuesta = (object) array(
            'success' => false, 
            'descrip' => 'Error al insertar aguinaldo'
          );
        }
      }
      else{
        $addedAgui = self::getAguinaldo()->idaguinaldo;
      }

      //insertar detalle
      
      $addedAguiDet = tabAguinaldoDet::create(array(
        'idaguinaldo' => $addedAgui,
        'ci' => $empl->ci,
        'periodo' => $periodo,
        'mes' => $mes,
        'idsueldo' => $added,
        'monto' => $devengado
      ));


      if( is_array($addedAguiDet) || !$addedAguiDet ){
        //$deleteAgui = tabAguinaldo::find($addedAgui)->delete();
        //$deletedDet = tabSueldosDet::find($addedDet)->delete();
        //$deleted = tabSueldos::find($added)->delete();

        return self::$respuesta = (object) array(
          'success' => false, 
          'descrip' => 'Error al insertar detalle aguinaldo'
        );
      }
      else {
        return self::$respuesta = (object) array(
          'success' => true, 
          'descrip' => 'Sueldo generado correctamente'
        );
      }
    }

    public static function GenerarSueldos($periodo, $mes){
      self::Empleado();
      
      foreach (self::getEmpleado() as $empleado) {
        $generado = self::CalculoSueldo($empleado->idpersonal, $periodo, $mes);

        if( !$generado->success ){
          return $generado;
        }
      }
      
      return $generado;
    }

    public static function getExtracto($calsueldo = ''){
      $control = '';
      $keya = -1;
      $keyb = -1;
      $resul = array();
      
      if(!$calsueldo) {
        $calsueldo = viewSueldos::all();
      }

      foreach ($calsueldo as $key => $value) {
        if( $control <> $value->idsueldo ){
          $control = $value->idsueldo;
          $keya++;
          $keyb = 0;

          $resul[$keya]["idsueldo"] = $value->idsueldo;
          $resul[$keya]["ci"] = $value->ci;
          $resul[$keya]["periodo"] = $value->periodo;
          $resul[$keya]["mes"] = $value->mes;
          $resul[$keya]["idrubropres"] = $value->idrubropres;
          $resul[$keya]["rubro_pres"] = $value->rubro_pres;
          $resul[$keya]["plla"] = $value->plla;
          $resul[$keya]["lineapres"] = $value->lineapres;
          $resul[$keya]["linea"] = $value->linea;
          $resul[$keya]["descrip_vac"] = $value->descrip_vac;
          $resul[$keya]["categoria_vac"] = $value->categoria_vac;
          $resul[$keya]["cantidad"] = $value->cantidad;
          $resul[$keya]["sueldo_vac"] = $value->sueldo_vac;
          $resul[$keya]["totmensu"] = $value->totmensu;
          $resul[$keya]["vacancia"] = $value->vacancia;
          $resul[$keya]["cargo_pres"] = $value->cargo_pres;
          $resul[$keya]["categoria"] = $value->categoria;
          $resul[$keya]["sueldo"] = $value->sueldo;
          $resul[$keya]["devengado"] = $value->devengado;
          $resul[$keya]["total_desc_plla"] = $value->total_desc_plla;
          $resul[$keya]["importe_neto_plla"] = $value->importe_neto_plla;
          $resul[$keya]["total_general_desc"] = $value->total_general_desc;
          $resul[$keya]["importe_neto_des"] = $value->importe_neto_des;
          $resul[$keya]["idpersonal"] = $value->idpersonal;
          $resul[$keya]["nomape"] = $value->nomape;
          $resul[$keya]["nombre"] = $value->nombre;
          $resul[$keya]["apellido"] = $value->apellido;
          $resul[$keya]["ci_emple"] = $value->ci_emple;

          if($value->iddetallesueldo <> '' || $value->iddetallesueldo <> null){
            $resul[$keya]["detalle"][$keyb]["iddetallesueldo"] = $value->iddetallesueldo;
            $resul[$keya]["detalle"][$keyb]["idsueldo"] = $value->idsueldo;
            $resul[$keya]["detalle"][$keyb]["ci_det"] = $value->ci_det;
            $resul[$keya]["detalle"][$keyb]["periodo_det"] = $value->periodo_det;
            $resul[$keya]["detalle"][$keyb]["mes_det"] = $value->mes_det;
            $resul[$keya]["detalle"][$keyb]["idtipodescuento"] = $value->idtipodescuento;
            $resul[$keya]["detalle"][$keyb]["tipo_descuento"] = $value->tipo_descuento;
            $resul[$keya]["detalle"][$keyb]["monto"] = $value->monto;
          }
        }
        else{
          if($value->iddetallesueldo <> '' || $value->iddetallesueldo <> null){
            $resul[$keya]["detalle"][$keyb]["iddetallesueldo"] = $value->iddetallesueldo;
            $resul[$keya]["detalle"][$keyb]["idsueldo"] = $value->idsueldo;
            $resul[$keya]["detalle"][$keyb]["ci_det"] = $value->ci_det;
            $resul[$keya]["detalle"][$keyb]["periodo_det"] = $value->periodo_det;
            $resul[$keya]["detalle"][$keyb]["mes_det"] = $value->mes_det;
            $resul[$keya]["detalle"][$keyb]["idtipodescuento"] = $value->idtipodescuento;
            $resul[$keya]["detalle"][$keyb]["tipo_descuento"] = $value->tipo_descuento;
            $resul[$keya]["detalle"][$keyb]["monto"] = $value->monto;
          }
        }
        $keyb++;
      }
      return $resul;
    }

    public static function searchSueldo($idpersonal, $periodo, $mes){
      self::$sueldo = viewSueldos::where('idpersonal', '=', $idpersonal)->and_where('periodo', '=', $periodo)->and_where('mes', '=', $mes)->get();

      if(self::$sueldo){
        return self::getExtracto(self::$sueldo);
      }
      else{
        return self::$sueldo = array(
          array(
            "idpersonal" => "",
            "devengado" => 0
          )
        );
      }  
    }
    
    public static function listSueldos($plla, $periodo, $mes){
      $listSueldos = viewSueldos::where('plla', '=', $plla)->and_where('periodo', '=', $periodo)->and_where('mes', '=', $mes)->get();
      
      if($listSueldos) {
        return $listSueldos;
      }
      else{
        return $listSueldos = array(
          array(
            "idpersonal" => "",
            "devengado" => 0,
            "sueldo" => 0,
            "monto" => 0
          )
        );
      }
    }

    public static function UpSueldo($id, $data){
      self::Sueldos($data->idpersonal, $data->periodo, $data->mes);

      if( self::getSueldos() ){
        return self::$respuesta = (object) array(
          'success' => false, 
          'descrip' => 'Periodo ya procesado'
        );
      }

      $updated = tabSueldos::find($id)->set(array(
        //'ci' => $data->ci,
        'periodo' => $data->periodo,
        'mes' => $data->mes
        //'idrubropres' => $data->idrubropres,
        //'plla' => $data->plla,
        //'lineapres' => $data->lineapres,
        //'cargo_pres' => $data->cargo_pres,
        //'categoria' => $data->categoria,
        //'sueldo' => $data->sueldo,
        //'devengado' => $data->devengado
      ));

      if(is_array($updated)){
        return self::$respuesta = (object) array(
          'success' => false, 
          'descrip' => 'Error al actualizar sueldo'
        );
      }

      return self::$respuesta = (object) array(
        'success' => true, 
        'descrip' => 'Sueldo actualizado correctamente'
      );
    }

    public static function getSueldos(){
      return self::$sueldos;
    }

    public static function getSueldo(){
      return self::$sueldo;
    }

    public static function getEmpleado(){
      return self::$empleado;
    }

    public static function getCategoria(){
      return self::$categoria;
    }

    public static function getCargoPres(){
      return self::$cargo_pres;
    }

    public static function getAguinaldo(){
      return self::$aguinaldo;
    }
  }
?>