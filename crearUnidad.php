<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require_once 'ConexionBaseDatos.php';

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    //throw new Exception("Sergio Prueba: ". print_r($request, true));
    if (!empty($request)){
        $sqlRegistroUsuario = "
                INSERT INTO unidad (nombre)
				VALUES ('$request->nombre')
            ";
        pg_query(conexionPostgresql(),$sqlRegistroUsuario);
        $respuesta = true;
    }else {
        $respuesta = false;
    }

    pg_close(conexionPostgresql());
    echo json_encode($respuesta);

?>