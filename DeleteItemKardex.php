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

    // throw new Exception("Sergio Dato Recibido". print_r($request, true));
    $sqlDeleteItemKardex = "
        Delete
        FROM \"detalleKardex\"
        WHERE \"detalleKardex\".id = '$request'
    ";

    pg_query(conexionPostgresql(), $sqlDeleteItemKardex);
    $mensaje = 1;

    echo json_encode($mensaje);

?>