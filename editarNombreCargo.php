<?php
    // TODO Para permitir el control accesos a angular
    header("Access-Control-Allow-Origin: *");
    // TODO Permitir recibir datos de Post utilizado en angular
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once 'ConexionBaseDatos.php';

    // TODO Datos Recibidos del post de angular
    $postdata = file_get_contents("php://input");

    // TODO Sergio Respuesta de los datos
    $request = json_decode($postdata);

    $nombreCargo = $request->nombre_cargo;
    $id = intval($request->id_cargo);

    $sqlActualizacion = "
        UPDATE cargo
        SET nombre = '$nombreCargo'
        WHERE id = '$id'  
            ";
    //throw new Exception("Sergio ". print_r($sqlActualizacion , true));
    pg_query(conexionPostgresql(), $sqlActualizacion);
    $mensaje = 1;
    echo json_encode($mensaje);

?>