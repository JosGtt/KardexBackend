<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require_once 'ConexionBaseDatos.php';

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    //throw new Exception("Sergio entra: ". print_r($request, true));
    if (!empty($request))
    {
        $idUnidad = intval($request->idUnidad);
        $nombreCargo = $request->nombre;

        $sqlAddcargo = "
            INSERT INTO cargo (nombre, id_unidad)
            VALUES ('$nombreCargo', '$idUnidad')";
        pg_query(conexionPostgresql(),$sqlAddcargo);

        echo json_encode(true);
    }else {
        echo json_encode(false);
    }
?>