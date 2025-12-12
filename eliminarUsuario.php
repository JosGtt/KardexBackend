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

    //throw new Exception("Sergio Prueba Datos" . print_r($request, true));
    $ci = intval($request);
    $conexionPG = conexionPostgresql();
    /* TODO Sergio Actualizacion detalle Kardex */
    $sqlUsuario = "
            DELETE from \"Usuario\"
	        WHERE ci = '$ci'   
               ";
    pg_query($conexionPG, $sqlUsuario);

    $sqlUsuario = "
            DELETE from persona
            WHERE ci = '$ci'   
                   ";
    pg_query($conexionPG, $sqlUsuario);

    $mensaje = 1;
    echo json_encode($mensaje);
?>