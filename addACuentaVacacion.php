<?php

    require_once 'conexionBaseDatos.php';

    // TODO Para permitir el control accesos a angular
    header("Access-Control-Allow-Origin: *");
    // TODO Permitir recibir datos de Post utilizado en angular
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require_once 'conexionBaseDatos.php';
    /* TODO Sergio SQL Inserta datos archivos*/
    // TODO Datos Recibidos del post de angular
    $postdata = file_get_contents("php://input");
    // TODO Sergio Respuesta de los datos
    $request = json_decode($postdata);

//throw new Exception("Sergio Datos" . print_r($request, true));
    $total_dias = intval($request->total_dias);
    $gestion = intval($request->gestion);
    $fecha_solicitud = $request->fecha_solicitud;
    $fecha_del = $request->fecha_del;
    $fecha_hasta = $request->fecha_hasta;
    $fecha_incorporacion = $request->fecha_incorporacion;
    // $item = intval($request->item);

    /*TODO Sergio Registra una Vacacion de un item.
     * */
    $resAddACuentaVacacion = "
        INSERT INTO
        \"aCuentaVacacion\" (total_dias,gestion, fecha_solicitud,fecha_del,fecha_hasta,fecha_incorporacion,id_item)
        VALUES 
        ('$total_dias','$gestion','$fecha_solicitud','$fecha_del','$fecha_hasta','$fecha_incorporacion','$item')
    ";

    pg_query(conexionPostgresql(), $resAddACuentaVacacion);
    echo json_encode(true);
    pg_close(conexionPostgresql());


?>