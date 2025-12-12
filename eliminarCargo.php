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

    // throw new Exception("Sergio Prueba Datos" . print_r($request, true));
    $id_unidad = intval($request->id_unidad);
    $id_cargo = intval($request->id_cargo);

    $conexionPG = conexionPostgresql();

    /* TODO Sergio Actualizacion detalle Kardex */
    if (!empty($request->ci)){
        $response = false;
    }else {
        $sqlEliminarUnidad = "
                    DELETE from cargo
	                WHERE id = '$id_cargo'  
                   ";
        pg_query($conexionPG, $sqlEliminarUnidad);
        $response = true;
    }

    echo json_encode($response);
?>