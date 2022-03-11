<?php

  class Evaluacion {
    public static $control = '';
    public static $keya = -1;
    public static $keyb = -1;
    public static $resul = array();

    public static function getEvaluacion($evaluacion = ''){
      if(!$evaluacion){
        $evaluacion = viewEvaluacion::all();
      }
      foreach ($evaluacion as $key => $value) {
        if(static::$control <> $value->iddesempeno){
          static::$keya++;
          static::$keyb = 0;
          static::$control = $value->iddesempeno;
          static::$resul[static::$keya]["iddesempeno"] = $value->iddesempeno;
          static::$resul[static::$keya]["idpersonal"] = $value->idpersonal;
          static::$resul[static::$keya]["nomape"] = $value->nomape;
          static::$resul[static::$keya]["nombre"] = $value->nombre;
          static::$resul[static::$keya]["apellido"] = $value->apellido;
          static::$resul[static::$keya]["ci"] = $value->ci;
          static::$resul[static::$keya]["periodo"] = $value->periodo;
          static::$resul[static::$keya]["mes"] = $value->mes;
          
          if($value->iddetalledesem <> '' || $value->iddetalledesem <> null){
            static::$resul[static::$keya]["detalle"][static::$keyb]["iddetalledesem"] = $value->iddetalledesem;
            static::$resul[static::$keya]["detalle"][static::$keyb]["periodo_det"] = $value->periodo_det;
            static::$resul[static::$keya]["detalle"][static::$keyb]["mes_det"] = $value->mes_det;
            static::$resul[static::$keya]["detalle"][static::$keyb]["idtipodesempe"] = $value->idtipodesempe;
            static::$resul[static::$keya]["detalle"][static::$keyb]["tipo_desempeno"] = $value->tipo_desempeno;
            static::$resul[static::$keya]["detalle"][static::$keyb]["evaluacion"] = $value->evaluacion;
          }
        }
        else{
          if($value->iddetalledesem <> '' || $value->iddetalledesem <> null){
            static::$resul[static::$keya]["detalle"][static::$keyb]["iddetalledesem"] = $value->iddetalledesem;
            static::$resul[static::$keya]["detalle"][static::$keyb]["periodo_det"] = $value->periodo_det;
            static::$resul[static::$keya]["detalle"][static::$keyb]["mes_det"] = $value->mes_det;
            static::$resul[static::$keya]["detalle"][static::$keyb]["idtipodesempe"] = $value->idtipodesempe;
            static::$resul[static::$keya]["detalle"][static::$keyb]["tipo_desempeno"] = $value->tipo_desempeno;
            static::$resul[static::$keya]["detalle"][static::$keyb]["evaluacion"] = $value->evaluacion;
          }
        }
        static::$keyb++;
      }

      return static::$resul;
    }

    public static function searchEvaluacion($idpersonal, $periodo, $mes){
      $evaluacion = viewEvaluacion::where('idpersonal', '=', $idpersonal)->and_where('periodo', '=', $periodo)->and_where('mes', '=', $mes)->get();

      if($evaluacion){
        return self::getEvaluacion($evaluacion);
      }
      else{
        return $evaluacion = array(
          array(
            "idpersonal" => ""
          ));
      }
    }
  }
?>