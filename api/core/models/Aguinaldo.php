<?php

  class Aguinaldo {
    public static $control = '';
    public static $keya = -1;
    public static $keyb = -1;
    public static $resul = array();

    public static function getAguinaldo($aguinaldo = ''){
      if(!$aguinaldo){
        $aguinaldo = viewAguinaldo::all();
      }

      foreach ($aguinaldo as $key => $value) {
        if(static::$control <> $value->idaguinaldo){
          static::$keya++;
          static::$keyb = 0;
          static::$control = $value->idaguinaldo;
          static::$resul[static::$keya]["idaguinaldo"] = $value->idaguinaldo;
          static::$resul[static::$keya]["idpersonal"] = $value->idpersonal;
          static::$resul[static::$keya]["nomape"] = $value->nomape;
          static::$resul[static::$keya]["nombre"] = $value->nombre;
          static::$resul[static::$keya]["apellido"] = $value->apellido;
          static::$resul[static::$keya]["ci"] = $value->ci;
          static::$resul[static::$keya]["periodo"] = $value->periodo;
          static::$resul[static::$keya]["mes"] = $value->mes;
          static::$resul[static::$keya]["idrubropres"] = $value->idrubropres;
          static::$resul[static::$keya]["rubro_pres"] = $value->rubro_pres;
          
          if($value->iddetalle_agui <> '' || $value->iddetalle_agui <> null){
            static::$resul[static::$keya]["detalle"][static::$keyb]["iddetalle_agui"] = $value->iddetalle_agui;
            static::$resul[static::$keya]["detalle"][static::$keyb]["ci_det"] = $value->ci_det;
            static::$resul[static::$keya]["detalle"][static::$keyb]["periodo_det"] = $value->periodo_det;
            static::$resul[static::$keya]["detalle"][static::$keyb]["mes_det"] = $value->mes_det;
            static::$resul[static::$keya]["detalle"][static::$keyb]["idsueldo"] = $value->idsueldo;
            static::$resul[static::$keya]["detalle"][static::$keyb]["monto"] = $value->monto;
          }
        }
        else{
          if($value->iddetalle_agui <> '' || $value->iddetalle_agui <> null){
            static::$resul[static::$keya]["detalle"][static::$keyb]["iddetalle_agui"] = $value->iddetalle_agui;
            static::$resul[static::$keya]["detalle"][static::$keyb]["ci_det"] = $value->ci_det;
            static::$resul[static::$keya]["detalle"][static::$keyb]["periodo_det"] = $value->periodo_det;
            static::$resul[static::$keya]["detalle"][static::$keyb]["mes_det"] = $value->mes_det;
            static::$resul[static::$keya]["detalle"][static::$keyb]["idsueldo"] = $value->idsueldo;
            static::$resul[static::$keya]["detalle"][static::$keyb]["monto"] = $value->monto;
          }
        }
        static::$keyb++;
      }

      return static::$resul;
    }

    public static function searchAguinaldo($idpersonal, $periodo){
      $aguinaldo = viewAguinaldo::where('idpersonal', '=', $idpersonal)->and_where('periodo', '=', $periodo)->get();

      if($aguinaldo){
        return self::getAguinaldo($aguinaldo);
      }
      else{
        return $aguinaldo = array(
          array(
            "idpersonal" => "",
            "devengado" => ""
          )
        );
      }  
    }
  }
?>