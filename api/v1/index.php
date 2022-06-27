<?php
  /**
   * 
   * @About:      API Interfase TH
   * @File:       index.php
   * @Date:       $Date:$ Ago-2021
   * @Version:    $Rev:$ 1.0
   * @Developer:  **
   * 
   */
  
  /* Declaramos los Headers para controlar los accesos desde otros dominios (CORS) a nuestra REST API o desde un cliente remoto vía HTTP */
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: X-Requested-With");
  header('Content-Type: application/json; charset=utf-8');
  header("P3P: CP='IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA'");

  /* Requerimos el framework Flight para crear y configurar las rutas HTTP */
  require '../core/flight/Flight.php';

  /* Seteamos autoloader de clases */
  Flight::path('../core/models/');

  /* Incluímos el connect para gestionar las conexión*/
  include_once "../core/connect.php";

  /* Ruta login */
  Flight::route('POST /login', function(){
    $data = Flight::request()->data;
    $login = User::login($data->username, $data->password);

    if($login){
      Flight::json(User::genToken());
    }
    else{
      Flight::halt(401);
      Flight::stop();
    }
  });

  /* Ruta pais */
  Flight::route('GET /pais', function(){
    Flight::json(tabPais::all());
  });

  /* Ruta pais ADD */
  Flight::route('POST /pais/add', function(){
    $data = Flight::request()->data;
    
    $added = tabPais::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta pais UPDATE */
  Flight::route('PATCH /pais/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabPais::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

   /* Ruta pais DELETE */
   Flight::route('DELETE /pais/delete/@id:[0-9]+', function($id){
    $deleted = tabPais::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta nacionalidad */
  Flight::route('GET /nacionalidad', function(){
    Flight::json(tabNacionalidad::all());
  });

  /* Ruta nacionalidad ADD */
  Flight::route('POST /nacionalidad/add', function(){
    $data = Flight::request()->data;
    
    $added = tabNacionalidad::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta nacionalidad UPDATE */
  Flight::route('PATCH /nacionalidad/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabNacionalidad::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta nacionalidad DELETE */
  Flight::route('DELETE /nacionalidad/delete/@id:[0-9]+', function($id){
    $deleted = tabNacionalidad::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta ciudad */
  Flight::route('GET /ciudad', function(){
    Flight::json(tabCiudad::all());
  });

   /* Ruta ciudad ADD */
   Flight::route('POST /ciudad/add', function(){
    $data = Flight::request()->data;
    
    $added = tabCiudad::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta ciudad UPDATE */
  Flight::route('PATCH /ciudad/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabCiudad::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta ciudad DELETE */
  Flight::route('DELETE /ciudad/delete/@id:[0-9]+', function($id){
    $deleted = tabCiudad::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta barrio */
  Flight::route('GET /barrio', function(){
    Flight::json(tabBarrio::all());
  });

   /* Ruta barrio ADD */
   Flight::route('POST /barrio/add', function(){
    $data = Flight::request()->data;
    
    $added = tabBarrio::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta barrio UPDATE */
  Flight::route('PATCH /barrio/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabBarrio::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta barrio DELETE */
  Flight::route('DELETE /barrio/delete/@id:[0-9]+', function($id){
    $deleted = tabBarrio::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta categoria */
  Flight::route('GET /categoria', function(){
    Flight::json(viewCategoria::all());
  });

   /* Ruta categoria ADD */
   Flight::route('POST /categoria/add', function(){
    $data = Flight::request()->data;
    
    $added = tabCategoria::create(array(
      'categoria' => $data->categoria,
      'sueldo' => $data->sueldo
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta categoria UPDATE */
  Flight::route('PATCH /categoria/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabCategoria::find($id)->set(array(
      'categoria' => $data->categoria,
      'sueldo' => $data->sueldo
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta categoria DELETE */
  Flight::route('DELETE /categoria/delete/@id:[0-9]+', function($id){
    $deleted = tabCategoria::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta presupuestado */
  Flight::route('GET /presupuestado', function(){
    Flight::json(tabPresupuestado::all());
  });

   /* Ruta presupuestado ADD */
   Flight::route('POST /presupuestado/add', function(){
    $data = Flight::request()->data;
    
    $added = tabPresupuestado::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta presupuestado UPDATE */
  Flight::route('PATCH /presupuestado/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabPresupuestado::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta presupuestado DELETE */
  Flight::route('DELETE /presupuestado/delete/@id:[0-9]+', function($id){
    $deleted = tabPresupuestado::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta dependencia */
  Flight::route('GET /dependencia', function(){
    Flight::json(tabDependencia::all());
  });

   /* Ruta dependencia ADD */
   Flight::route('POST /dependencia/add', function(){
    $data = Flight::request()->data;
    
    $added = tabDependencia::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta dependencia UPDATE */
  Flight::route('PATCH /dependencia/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabDependencia::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta dependencia DELETE */
  Flight::route('DELETE /dependencia/delete/@id:[0-9]+', function($id){
    $deleted = tabDependencia::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta funcional */
  Flight::route('GET /funcional', function(){
    Flight::json(tabFuncional::all());
  });

   /* Ruta funcional ADD */
   Flight::route('POST /funcional/add', function(){
    $data = Flight::request()->data;
    
    $added = tabFuncional::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta funcional UPDATE */
  Flight::route('PATCH /funcional/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabFuncional::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta funcional DELETE */
  Flight::route('DELETE /funcional/delete/@id:[0-9]+', function($id){
    $deleted = tabFuncional::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta jerarquia */
  Flight::route('GET /jerarquia', function(){
    Flight::json(tabJerarquia::all());
  });

   /* Ruta jerarquia ADD */
   Flight::route('POST /jerarquia/add', function(){
    $data = Flight::request()->data;
    
    $added = tabJerarquia::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta jerarquia UPDATE */
  Flight::route('PATCH /jerarquia/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabJerarquia::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta jerarquia DELETE */
  Flight::route('DELETE /jerarquia/delete/@id:[0-9]+', function($id){
    $deleted = tabJerarquia::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta estado */
  Flight::route('GET /estado', function(){
    Flight::json(tabEstado::all());
  });

   /* Ruta estado ADD */
   Flight::route('POST /estado/add', function(){
    $data = Flight::request()->data;
    
    $added = tabEstado::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta estado UPDATE */
  Flight::route('PATCH /estado/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabEstado::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta estado DELETE */
  Flight::route('DELETE /estado/delete/@id:[0-9]+', function($id){
    $deleted = tabEstado::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta turno */
  Flight::route('GET /turno', function(){
    Flight::json(viewTurno::all());
  });

   /* Ruta turno ADD */
   Flight::route('POST /turno/add', function(){
    $data = Flight::request()->data;
    
    $added = tabTurno::create(array(
      'descripcion' => $data->descripcion,
      'entrada' => $data->entrada,
      'salida' => $data->salida
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta turno UPDATE */
  Flight::route('PATCH /turno/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabTurno::find($id)->set(array(
      'descripcion' => $data->descripcion,
      'entrada' => $data->entrada,
      'salida' => $data->salida
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta turno DELETE */
  Flight::route('DELETE /turno/delete/@id:[0-9]+', function($id){
    $deleted = tabTurno::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta institucion */
  Flight::route('GET /institucion', function(){
    Flight::json(tabInstitucion::all());
  });

   /* Ruta institucion ADD */
   Flight::route('POST /institucion/add', function(){
    $data = Flight::request()->data;
    
    $added = tabInstitucion::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta institucion UPDATE */
  Flight::route('PATCH /institucion/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabInstitucion::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta institucion DELETE */
  Flight::route('DELETE /institucion/delete/@id:[0-9]+', function($id){
    $deleted = tabInstitucion::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta rubro */
  Flight::route('GET /rubro', function(){
    Flight::json(viewRubro::all());
  });

   /* Ruta rubro ADD */
   Flight::route('POST /rubro/add', function(){
    $data = Flight::request()->data;
    
    $added = tabRubro::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta rubro UPDATE */
  Flight::route('PATCH /rubro/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabRubro::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta rubro DELETE */
  Flight::route('DELETE /rubro/delete/@id:[0-9]+', function($id){
    $deleted = tabRubro::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta descuento */
  Flight::route('GET /descuento', function(){
    Flight::json(tabDescuento::all());
  });

   /* Ruta descuento ADD */
   Flight::route('POST /descuento/add', function(){
    $data = Flight::request()->data;
    
    $added = tabDescuento::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta descuento UPDATE */
  Flight::route('PATCH /descuento/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabDescuento::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta descuento DELETE */
  Flight::route('DELETE /descuento/delete/@id:[0-9]+', function($id){
    $deleted = tabDescuento::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta planilla */
  Flight::route('GET /planilla', function(){
    Flight::json(tabPlanilla::all());
  });

   /* Ruta planilla ADD */
   Flight::route('POST /planilla/add', function(){
    $data = Flight::request()->data;
    
    $added = tabPlanilla::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta planilla UPDATE */
  Flight::route('PATCH /planilla/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabPlanilla::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta planilla DELETE */
  Flight::route('DELETE /planilla/delete/@id:[0-9]+', function($id){
    $deleted = tabPlanilla::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta desempeno */
  Flight::route('GET /desempeno', function(){
    Flight::json(tabDesempeno::all());
  });

   /* Ruta desempeno ADD */
   Flight::route('POST /desempeno/add', function(){
    $data = Flight::request()->data;
    
    $added = tabDesempeno::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta desempeno UPDATE */
  Flight::route('PATCH /desempeno/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabDesempeno::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta desempeno DELETE */
  Flight::route('DELETE /desempeno/delete/@id:[0-9]+', function($id){
    $deleted = tabDesempeno::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta universidad */
  Flight::route('GET /universidad', function(){
    Flight::json(tabUniversidad::all());
  });

   /* Ruta universidad ADD */
   Flight::route('POST /universidad/add', function(){
    $data = Flight::request()->data;
    
    $added = tabUniversidad::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta universidad UPDATE */
  Flight::route('PATCH /universidad/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabUniversidad::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta universidad DELETE */
  Flight::route('DELETE /universidad/delete/@id:[0-9]+', function($id){
    $deleted = tabUniversidad::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta facultad */
  Flight::route('GET /facultad', function(){
    Flight::json(tabFacultad::all());
  });

   /* Ruta facultad ADD */
   Flight::route('POST /facultad/add', function(){
    $data = Flight::request()->data;
    
    $added = tabFacultad::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta facultad UPDATE */
  Flight::route('PATCH /facultad/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabFacultad::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta facultad DELETE */
  Flight::route('DELETE /facultad/delete/@id:[0-9]+', function($id){
    $deleted = tabFacultad::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta carrera */
  Flight::route('GET /carrera', function(){
    Flight::json(tabCarrera::all());
  });

   /* Ruta carrera ADD */
   Flight::route('POST /carrera/add', function(){
    $data = Flight::request()->data;
    
    $added = tabCarrera::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta carrera UPDATE */
  Flight::route('PATCH /carrera/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabCarrera::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta carrera DELETE */
  Flight::route('DELETE /carrera/delete/@id:[0-9]+', function($id){
    $deleted = tabCarrera::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta titulo */
  Flight::route('GET /titulo', function(){
    Flight::json(tabTitulo::all());
  });

   /* Ruta titulo ADD */
   Flight::route('POST /titulo/add', function(){
    $data = Flight::request()->data;
    
    $added = tabTitulo::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta titulo UPDATE */
  Flight::route('PATCH /titulo/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabTitulo::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta titulo DELETE */
  Flight::route('DELETE /titulo/delete/@id:[0-9]+', function($id){
    $deleted = tabTitulo::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta centro */
  Flight::route('GET /centro', function(){
    Flight::json(tabCentro::all());
  });

   /* Ruta centro ADD */
   Flight::route('POST /centro/add', function(){
    $data = Flight::request()->data;
    
    $added = tabCentro::create(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta centro UPDATE */
  Flight::route('PATCH /centro/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabCentro::find($id)->set(array(
      'descripcion' => $data->descripcion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta centro DELETE */
  Flight::route('DELETE /centro/delete/@id:[0-9]+', function($id){
    $deleted = tabCentro::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta vacancia */
  Flight::route('GET /vacancia', function(){
    Flight::json(viewVacancia::all());
  });

   /* Ruta vacancia ADD */
   Flight::route('POST /vacancia/add', function(){
    $data = Flight::request()->data;
    
    $added = tabVacancia::create(array(
      'linea' => $data->linea,
      'descripcion' => $data->descripcion,
      'categoria' => $data->categoria,
      'cantidad' => $data->cantidad,
      'sueldo' => $data->sueldo,
      'totmensu' => $data->totmensu,
      'vacancia' => $data->vacancia
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta vacancia UPDATE */
  Flight::route('PATCH /vacancia/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabVacancia::find($id)->set(array(
      'linea' => $data->linea,
      'descripcion' => $data->descripcion,
      'categoria' => $data->categoria,
      'cantidad' => $data->cantidad,
      'sueldo' => $data->sueldo,
      'totmensu' => $data->totmensu,
      'vacancia' => $data->vacancia
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta vacancia DELETE */
  Flight::route('DELETE /vacancia/delete/@id:[0-9]+', function($id){
    $deleted = tabVacancia::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta empleado */
  Flight::route('GET /empleado', function(){
    Flight::json(viewEmpleado::all());
  });

   /* Ruta empleado ADD */
   Flight::route('POST /empleado/add', function(){
    $data = Flight::request()->data;
    
    $added = tabEmpleado::create(array(
      'nombre' => $data->nombre,
      'apellido' => $data->apellido,
      'domicilio' => $data->domicilio,
      'idbarrio' => $data->idbarrio,
      'idciudad' => $data->idciudad,
      'telefono' => $data->telefono,
      'celular' => $data->celular,
      'fecnac' => $data->fecnac,
      'lugarnac' => $data->lugarnac,
      'idnacional' => $data->idnacional,
      'ci' => $data->ci,
      'sexo' => $data->sexo,
      'estcivil' => $data->estcivil,
      'conyuge' => $data->conyuge,
      'email' => $data->email,
      'foto' => $data->foto,
      'fec_ing' => $data->fec_ing,
      'resingreso' => $data->resingreso,
      'fecresingreso' => $data->fecresingreso,
      'plla' => $data->plla,
      'orden' => $data->orden,
      'lineapres' => $data->lineapres,
      'idcategoria' => $data->idcategoria,
      'idcargopres' => 1, // $data->idcargopres,
      'iddepen' => $data->iddepen,
      'idcargofun' => $data->idcargofun,
      'idjerarquia' => $data->idjerarquia,
      'idestado' => $data->idestado,
      'tipodoc' => $data->tipodoc,
      'res_mov' => $data->res_mov,
      'fecresmov' => $data->fecresmov,
      'idturno' => $data->idturno,
      'idinstituestado' => $data->idinstituestado,
      'fic' => $data->fic,
      'ffc' => $data->ffc
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta empleado UPDATE */
  Flight::route('PATCH /empleado/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabEmpleado::find($id)->set(array(
      'nombre' => $data->nombre,
      'apellido' => $data->apellido,
      'domicilio' => $data->domicilio,
      'idbarrio' => $data->idbarrio,
      'idciudad' => $data->idciudad,
      'telefono' => $data->telefono,
      'celular' => $data->celular,
      'fecnac' => $data->fecnac,
      'lugarnac' => $data->lugarnac,
      'idnacional' => $data->idnacional,
      'ci' => $data->ci,
      'sexo' => $data->sexo,
      'estcivil' => $data->estcivil,
      'conyuge' => $data->conyuge,
      'email' => $data->email,
      'foto' => $data->foto,
      'fec_ing' => $data->fec_ing,
      'resingreso' => $data->resingreso,
      'fecresingreso' => $data->fecresingreso,
      'plla' => $data->plla,
      'orden' => $data->orden,
      'lineapres' => $data->lineapres,
      'idcategoria' => $data->idcategoria,
      'idcargopres' => 1, // $data->idcargopres,
      'iddepen' => $data->iddepen,
      'idcargofun' => $data->idcargofun,
      'idjerarquia' => $data->idjerarquia,
      'idestado' => $data->idestado,
      'tipodoc' => $data->tipodoc,
      'res_mov' => $data->res_mov,
      'fecresmov' => $data->fecresmov,
      'idturno' => $data->idturno,
      'idinstituestado' => $data->idinstituestado,
      'fic' => $data->fic,
      'ffc' => $data->ffc
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta empleado DELETE */
  Flight::route('DELETE /empleado/delete/@id:[0-9]+', function($id){
    $deleted = tabEmpleado::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta cursos */
  Flight::route('GET /cursos', function(){
    Flight::json(viewCursos::all());
  });

   /* Ruta cursos ADD */
   Flight::route('POST /cursos/add', function(){
    $data = Flight::request()->data;
    
    $added = tabCursos::create(array(
      'tipocurso' => $data->tipocurso,
      'nombrecurso' => $data->nombrecurso,
      'institucion' => $data->institucion,
      'fecha_inicio' => $data->fecha_inicio,
      'fecha_fin' => $data->fecha_fin,
      'nota' => $data->nota,
      'rendimiento' => $data->rendimiento,
      'asistencia' => $data->asistencia,
      'observacion' => $data->observacion,
      'idpersonal' => $data->idpersonal,
      'idciudad' => $data->idciudad,
      'idpais' => $data->idpais
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta cursos UPDATE */
  Flight::route('PATCH /cursos/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabCursos::find($id)->set(array(
      'tipocurso' => $data->tipocurso,
      'nombrecurso' => $data->nombrecurso,
      'institucion' => $data->institucion,
      'fecha_inicio' => $data->fecha_inicio,
      'fecha_fin' => $data->fecha_fin,
      'nota' => $data->nota,
      'rendimiento' => $data->rendimiento,
      'asistencia' => $data->asistencia,
      'observacion' => $data->observacion,
      'idpersonal' => $data->idpersonal,
      'idciudad' => $data->idciudad,
      'idpais' => $data->idpais
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta cursos DELETE */
  Flight::route('DELETE /cursos/delete/@id:[0-9]+', function($id){
    $deleted = tabCursos::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta academico */
  Flight::route('GET /academico', function(){
    Flight::json(viewAcademico::all());
  });

   /* Ruta academico ADD */
   Flight::route('POST /academico/add', function(){
    $data = Flight::request()->data;
    
    $added = tabAcademico::create(array(
      'cicloacademico' => $data->cicloacademico,
      'completo' => $data->completo,
      'idcolegio' => $data->idcolegio,
      'iduniversidad' => $data->iduniversidad,
      'idfacultad' => $data->idfacultad,
      'idcarrera' => $data->idcarrera,
      'grado_curso' => $data->grado_curso,
      'idtitulo' => $data->idtitulo,
      'idpersonal' => $data->idpersonal
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta academico UPDATE */
  Flight::route('PATCH /academico/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabAcademico::find($id)->set(array(
      'cicloacademico' => $data->cicloacademico,
      'completo' => $data->completo,
      'idcolegio' => $data->idcolegio,
      'iduniversidad' => $data->iduniversidad,
      'idfacultad' => $data->idfacultad,
      'idcarrera' => $data->idcarrera,
      'grado_curso' => $data->grado_curso,
      'idtitulo' => $data->idtitulo,
      'idpersonal' => $data->idpersonal
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta academico DELETE */
  Flight::route('DELETE /academico/delete/@id:[0-9]+', function($id){
    $deleted = tabAcademico::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta beneficios */
  Flight::route('GET /beneficios', function(){
    Flight::json(Beneficios::getBeneficios());
  });

  /* Ruta beneficio */
  Flight::route('GET /beneficio/@id:[0-9]+/@pediodo:[0-9]+/@mes:[0-9]+', function($id, $periodo, $mes){
    Flight::json(Beneficios::searchBeneficio($id, $periodo, $mes));
  });

   /* Ruta beneficios ADD */
   Flight::route('POST /beneficios/add', function(){
    $data = Flight::request()->data;
    
    $added = tabBeneficios::create(array(
      'idpersonal' => $data->idpersonal,
      'ci' => $data->ci,
      'periodo' => $data->periodo,
      'mes' => $data->mes,
      'idrubropres' => $data->idrubropres,
      'idplanibene' => $data->idplanibene,
      'monto' => $data->monto,
      'idtipodescuento' => $data->idtipodescuento,
      'desc_jub' => $data->desc_jub,
      'monto_cobrar' => $data->monto_cobrar
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta beneficios UPDATE */
  Flight::route('PATCH /beneficios/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabBeneficios::find($id)->set(array(
      'idpersonal' => $data->idpersonal,
      'ci' => $data->ci,
      'periodo' => $data->periodo,
      'mes' => $data->mes,
      'idrubropres' => $data->idrubropres,
      'idplanibene' => $data->idplanibene,
      'monto' => $data->monto,
      'idtipodescuento' => $data->idtipodescuento,
      'desc_jub' => $data->desc_jub,
      'monto_cobrar' => $data->monto_cobrar
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta beneficios DELETE */
  Flight::route('DELETE /beneficios/delete/@id:[0-9]+', function($id){
    $deleted = tabBeneficios::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta evaluacion */
  Flight::route('GET /evaluacion', function(){
    Flight::json(Evaluacion::getEvaluacion());
  });

  /* Ruta evaluac */
  Flight::route('GET /evaluac/@id:[0-9]+/@periodo:[0-9]+/@mes:[0-9]+', function($id, $periodo, $mes){
    Flight::json(Evaluacion::searchEvaluacion($id, $periodo, $mes));
  });

   /* Ruta evaluacion ADD */
   Flight::route('POST /evaluacion/add', function(){
    $data = Flight::request()->data;
    $tipodesemp = tabDesempeno::all();
    
    $added = tabEvaluacion::create(array(
      'idpersonal' => $data->idpersonal,
      'periodo' => $data->periodo,
      'mes' => $data->mes,
      'ci' => $data->ci
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      foreach ($tipodesemp as $key => $value) {
        $addedDet = tabEvaluacionDet::create(array(
          'iddesempeno' => $added,
          'periodo' => $data->periodo,
          'mes' => $data->mes,
          'idtipodesempe' => $value->idtipodesempe,
          'evaluacion' => 0
        ));

        if(is_array($addedDet)){
          Flight::json($added, 400);
          Flight::stop();
        }
      }
      
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta evaluacion UPDATE */
  Flight::route('PATCH /evaluacion/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabEvaluacion::find($id)->set(array(
      'idpersonal' => $data->idpersonal,
      'periodo' => $data->periodo,
      'mes' => $data->mes,
      'ci' => $data->ci
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta evaluacion DELETE */
  Flight::route('DELETE /evaluacion/delete/@id:[0-9]+', function($id){
    $deleted = tabEvaluacion::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta evaluacion detalle */
  Flight::route('GET /det_evaluacion', function(){
    Flight::json(viewEvaluacion::all());
  });

   /* Ruta evaluacion detalle ADD */
   Flight::route('POST /det_evaluacion/add', function(){
    $data = Flight::request()->data;
    
    $added = tabEvaluacionDet::create(array(
      'iddesempeno' => $data->iddesempeno,
      'periodo' => $data->periodo_det,
      'mes' => $data->mes_det,
      'idtipodesempe' => $data->idtipodesempe,
      'evaluacion' => $data->evaluacion
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta evaluacion detalle UPDATE */
  Flight::route('PATCH /det_evaluacion/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabEvaluacionDet::find($id)->set(array(
      /*'iddesempeno' => $data->iddesempeno,*/
      'periodo' => $data->periodo_det,
      'mes' => $data->mes_det,
      'idtipodesempe' => $data->idtipodesempe,
      'evaluacion' => $data->evaluacion
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta evaluacion detalle DELETE */
  Flight::route('DELETE /det_evaluacion/delete/@id:[0-9]+', function($id){
    $deleted = tabEvaluacionDet::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta usuarios */
  Flight::route('GET /usuarios', function(){
    Flight::json(viewUsuario::all());
  });

   /* Ruta usuario ADD */
   Flight::route('POST /usuario/add', function(){
    $data = Flight::request()->data;
    
    $added = tabUsuario::create(array(
      'nombreusuario' => $data->nombreusuario,
      'contrasena1' => Hash::make($data->pass),
      'contrasena2' => Hash::make($data->pass),
      'idperfil' => $data->idperfil
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta usuario UPDATE */
  Flight::route('PATCH /usuario/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;

    if( $data->pass ){
      $updated = tabUsuario::find($id)->set(array(
        'nombreusuario' => $data->nombreusuario,
        'contrasena1' => Hash::make($data->pass),
        'contrasena2' => Hash::make($data->pass),
        'idperfil' => $data->idperfil
      ));
    }
    else {
      $updated = tabUsuario::find($id)->set(array(
        'idperfil' => $data->idperfil
      ));
    }
    
    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta usuario DELETE */
  Flight::route('DELETE /usuario/delete/@id:[0-9]+', function($id){
    $deleted = tabUsuario::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta perfil */
  Flight::route('GET /perfil', function(){
    Flight::json(tabPerfil::all());
  });

   /* Ruta perfil ADD */
   Flight::route('POST /perfil/add', function(){
    $data = Flight::request()->data;
    
    $added = tabPerfil::create(array(
      'nombreperfil' => $data->nombreperfil
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta perfil UPDATE */
  Flight::route('PATCH /perfil/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabPerfil::find($id)->set(array(
      'nombreperfil' => $data->nombreperfil
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta perfil DELETE */
  Flight::route('DELETE /perfil/delete/@id:[0-9]+', function($id){
    $deleted = tabPerfil::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta permiso */
  Flight::route('GET /permiso', function(){
    Flight::json(tabPermiso::all());
  });

  /* Ruta permiso renew */
  Flight::route('POST /permisorenew/@id:[0-9]+', function($id){
    Flight::json(array('permiso' => viewPermiso::where('idperfil', '=', $id)->get()));
  });

   /* Ruta permiso ADD */
   Flight::route('POST /permiso/add', function(){
    $data = Flight::request()->data;
    
    $added = tabPermiso::create(array(
      'nombretabla' => $data->nombretabla
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta permiso UPDATE */
  Flight::route('PATCH /permiso/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabPermiso::find($id)->set(array(
      'nombretabla' => $data->nombretabla
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta permiso DELETE */
  Flight::route('DELETE /permiso/delete/@id:[0-9]+', function($id){
    $deleted = tabPermiso::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta acceso */
  Flight::route('GET /acceso', function(){
    Flight::json(viewPermiso::all());
  });

   /* Ruta acceso ADD */
   Flight::route('POST /acceso/add', function(){
    $data = Flight::request()->data;
  
    $added = tabAcceso::create(array(
      'idpermiso' => $data->idpermiso,
      'idperfil' => $data->idperfil,
      'alta' => $data->alta,
      'baja' => $data->baja,
      'mod' => $data->mod,
      'cons' => $data->cons
    ));

    if(is_array($added)){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta acceso UPDATE */
  Flight::route('PATCH /acceso/update/@id:[0-9]+/@idx:[0-9]+', function($id, $idx){
    $data = Flight::request()->data;
    
    $updated = tabAcceso::where('idpermiso', '=', $id)->and_where('idperfil', '=', $idx)->set(array(
      'idpermiso' => $data->idpermiso,
      'idperfil' => $data->idperfil,
      'alta' => $data->alta,
      'baja' => $data->baja,
      'mod' => $data->mod,
      'cons' => $data->cons
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta acceso DELETE */
  Flight::route('DELETE /acceso/delete/@id:[0-9]+/@idx:[0-9]+', function($id, $idx){
    $deleted = tabAcceso::where('idpermiso', '=', $id)->and_where('idperfil', '=', $idx)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta sueldos */
  Flight::route('GET /sueldos', function(){
    Flight::json(CalcSueldos::getExtracto());
  });

  /* Ruta sueldo */
  Flight::route('GET /sueldo/@id/@periodo:[0-9]+/@mes:[0-9]+', function($id, $periodo, $mes){
    Flight::json(CalcSueldos::searchSueldo($id, $periodo, $mes));
  });

   /* Ruta sueldos ADD */
   Flight::route('POST /sueldos/add', function(){
    $data = Flight::request()->data;
    
    $added = CalcSueldos::CalculoSueldo($data->idpersonal, $data->periodo, $data->mes);
    
    if( !$added->success ){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added->descrip
      ));
    }
  });

  /* Ruta sueldos UPDATE */
  Flight::route('PATCH /sueldos/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;

    $updated = CalcSueldos::UpSueldo($id ,$data);
    
    if( !$updated->success ){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated->descrip
      ));
    }
  });

  /* Ruta sueldos DELETE */
  Flight::route('DELETE /sueldos/delete/@id:[0-9]+', function($id){
    //eliminar aguinaldo
    $deletedDetAgui = tabAguinaldoDet::where('idsueldo', '=', $id)->delete();

    if(is_array($deletedDetAgui)){
      Flight::json($deletedDetAgui, 400);
      Flight::stop();
    }
    
    $deleted = tabSueldos::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta sueldo detalle */
  Flight::route('GET /det_sueldo', function(){
    Flight::json(viewSueldos::all());
  });

   /* Ruta sueldo detalle ADD */
   Flight::route('POST /det_sueldo/add', function(){
    $data = Flight::request()->data;
    
    $added = tabSueldosDet::create(array(
      'idsueldo' => $data->idsueldo,
      'ci' => $data->ci_det,
      'periodo' => $data->periodo_det,
      'mes' => $data->mes_det,
      'idtipodescuento' => $data->idtipodescuento,
      'monto' => $data->monto
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta sueldo detalle UPDATE */
  Flight::route('PATCH /det_sueldo/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabSueldosDet::find($id)->set(array(
      //'idsueldo' => $data->idsueldo,
      'ci' => $data->ci_det,
      'periodo' => $data->periodo_det,
      'mes' => $data->mes_det,
      'idtipodescuento' => $data->idtipodescuento,
      'monto' => $data->monto
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta sueldo detalle DELETE */
  Flight::route('DELETE /det_sueldo/delete/@id:[0-9]+', function($id){
    $deleted = tabSueldosDet::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });


  /* Ruta gererar sueldos ADD */
  Flight::route('POST /gensueldos/add', function(){
    $data = Flight::request()->data;

    $added = CalcSueldos::GenerarSueldos($data->periodo, $data->mes);

    if( !$added->success ){
      Flight::json($added, 400);
      Flight::stop();
    }
    else {
      Flight::json(array(
        'success' => true, 
        'deleted' => $added->descrip
      ));
    }
  });

  /* Ruta listado general sueldos */
  Flight::route('GET /listsueldos/@plla:[0-9]+/@periodo:[0-9]+/@mes:[0-9]+', function($plla, $periodo, $mes){
    Flight::json(CalcSueldos::listSueldos($plla, $periodo, $mes));
  });

  /* Ruta listado general sueldos con multas */
  Flight::route('GET /listsueldosmultas/@plla:[0-9]+/@periodo:[0-9]+/@mes:[0-9]+', function($plla, $periodo, $mes){
    Flight::json(CalcSueldos::listSueldosMultas($plla, $periodo, $mes));
  });

  /* Ruta aguinaldos */
  Flight::route('GET /aguinaldos', function(){
    Flight::json(Aguinaldo::getAguinaldo());
  });

  /* Ruta aguinaldo */
  Flight::route('GET /aguinaldo/@id/@periodo:[0-9]+', function($id, $periodo){
    Flight::json(Aguinaldo::searchAguinaldo($id, $periodo));
  });
  
  /* Ruta aguinaldo DELETE */
  Flight::route('DELETE /aguinaldo/delete/@id:[0-9]+', function($id){
    $deleted = tabAguinaldo::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });

  /* Ruta aguinaldo detalle */
  Flight::route('GET /det_aguinaldo', function(){
    Flight::json(Aguinaldo::getAguinaldo());
  });

   /* Ruta aguinaldo detalle ADD */
   Flight::route('POST /det_aguinaldo/add', function(){
    $data = Flight::request()->data;
    
    $added = tabAguinaldoDet::create(array(
      'idaguinaldo' => $data->idaguinaldo,
      'ci' => $data->ci_det,
      'periodo' => $data->periodo_det,
      'mes' => $data->mes_det,
      'idsueldo' => $data->idsueldo,
      'monto' => $data->monto
    ));

    if(is_array($added) || !$added){
      Flight::json($added, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'added' => $added
      ));
    }
  });

  /* Ruta aguinaldo detalle UPDATE */
  Flight::route('PATCH /det_aguinaldo/update/@id:[0-9]+', function($id){
    $data = Flight::request()->data;
    
    $updated = tabAguinaldoDet::find($id)->set(array(
      //'idsueldo' => $data->idsueldo,
      'ci' => $data->ci_det,
      'periodo' => $data->periodo_det,
      'mes' => $data->mes_det,
      'monto' => $data->monto
    ));

    if(is_array($updated)){
      Flight::json($updated, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'updated' => $updated
      ));
    }
  });

  /* Ruta aguinaldo detalle DELETE */
  Flight::route('DELETE /det_aguinaldo/delete/@id:[0-9]+', function($id){
    $deleted = tabAguinaldoDet::find($id)->delete();

    if(is_array($deleted)){
      Flight::json($deleted, 400);
      Flight::stop();
    }
    else{
      Flight::json(array(
        'success' => true, 
        'deleted' => $deleted
      ));
    }
  });


  /* Corremos la REST API */
  Flight::start();  
?>