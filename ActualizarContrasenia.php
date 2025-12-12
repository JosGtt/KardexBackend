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

    //throw new Exception("Sergio   : ". print_r($request, true));
    $ci = intval($request->ci);
    $contrasenia = $request->contraseniaNueva;

    $password_encrip = password_hash($contrasenia, PASSWORD_DEFAULT);

    /* $idUsuario = intval("1") ;
    $contrasenia = "Contrasenia Nueva";*/

// TODO Actualiza La contraseña dependiendo al usuairo

    $conexionPG = conexionPostgresql();
    $sqlActualizacion ="
                        UPDATE \"Usuario\"
    SET \"password\" = '$password_encrip'
    WHERE ci = '$ci'";

    pg_query($conexionPG, $sqlActualizacion);

    $arrUsuario = array();
    $mensaje = 1;

    echo json_encode($mensaje);
?>