<?php

  class Beneficios {
    public static $control = '';
    public static $keya = -1;
    public static $keyb = -1;
    public static $resul = array();

    public static function getBeneficios($beneficio = ''){
      if(!$beneficio){
        $beneficio = viewBeneficios::all();
      }
      
      foreach ($beneficio as $key => $value) {
        if(static::$control <> $value->idpersonal){
          static::$keya++;
          static::$keyb = 0;
          static::$control = $value->idpersonal;
          //////////////
          static::$resul[static::$keya]["idpersonal"] = $value->idpersonal;
          static::$resul[static::$keya]["nomape"] = $value->nomape;
          static::$resul[static::$keya]["nombre"] = $value->nombre;
          static::$resul[static::$keya]["apellido"] = $value->apellido;
          static::$resul[static::$keya]["ci"] = $value->ci;
          static::$resul[static::$keya]["plla"] = $value->plla;
                    
          static::$resul[static::$keya]["detalle"][static::$keyb]["id_benegratifi"] = $value->id_benegratifi;
          static::$resul[static::$keya]["detalle"][static::$keyb]["periodo"] = $value->periodo;
          static::$resul[static::$keya]["detalle"][static::$keyb]["mes"] = $value->mes;
          static::$resul[static::$keya]["detalle"][static::$keyb]["idrubropres"] = $value->idrubropres;
          static::$resul[static::$keya]["detalle"][static::$keyb]["rubro_pres"] = $value->rubro_pres;
          static::$resul[static::$keya]["detalle"][static::$keyb]["idplanibene"] = $value->idplanibene;
          static::$resul[static::$keya]["detalle"][static::$keyb]["planibene"] = $value->planibene;
          static::$resul[static::$keya]["detalle"][static::$keyb]["monto"] = $value->monto;
          static::$resul[static::$keya]["detalle"][static::$keyb]["idtipodescuento"] = $value->idtipodescuento;
          static::$resul[static::$keya]["detalle"][static::$keyb]["tipo_desc"] = $value->tipo_desc;
          static::$resul[static::$keya]["detalle"][static::$keyb]["desc_jub"] = $value->desc_jub;
          static::$resul[static::$keya]["detalle"][static::$keyb]["monto_cobrar"] = $value->monto_cobrar;
        }
        else{
          static::$resul[static::$keya]["detalle"][static::$keyb]["id_benegratifi"] = $value->id_benegratifi;
          static::$resul[static::$keya]["detalle"][static::$keyb]["periodo"] = $value->periodo;
          static::$resul[static::$keya]["detalle"][static::$keyb]["mes"] = $value->mes;
          static::$resul[static::$keya]["detalle"][static::$keyb]["idrubropres"] = $value->idrubropres;
          static::$resul[static::$keya]["detalle"][static::$keyb]["rubro_pres"] = $value->rubro_pres;
          static::$resul[static::$keya]["detalle"][static::$keyb]["idplanibene"] = $value->idplanibene;
          static::$resul[static::$keya]["detalle"][static::$keyb]["planibene"] = $value->planibene;
          static::$resul[static::$keya]["detalle"][static::$keyb]["monto"] = $value->monto;
          static::$resul[static::$keya]["detalle"][static::$keyb]["idtipodescuento"] = $value->idtipodescuento;
          static::$resul[static::$keya]["detalle"][static::$keyb]["tipo_desc"] = $value->tipo_desc;
          static::$resul[static::$keya]["detalle"][static::$keyb]["desc_jub"] = $value->desc_jub;
          static::$resul[static::$keya]["detalle"][static::$keyb]["monto_cobrar"] = $value->monto_cobrar;
        }
        static::$keyb++;
      }

      return static::$resul;
    }

    public static function searchBeneficio($idpersonal, $periodo, $mes){
      $beneficio = viewBeneficios::where('idpersonal', '=', $idpersonal)->and_where('periodo', '=', $periodo)->and_where('mes', '=', $mes)->get();

      if($beneficio){
        return self::getBeneficios($beneficio);
      }
      else{
        return $beneficio = array(
          array(
            "idpersonal" => ""
          ));
      }
    }
  }
?>