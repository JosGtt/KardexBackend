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
    $gestion = intval($request->gestion);
    $fecha_retiro = $request->fecha_retiro;
    $ci = intval($request->ci);
    $motivo = $request->motivo;

    $conexionPG = conexionPostgresql();
    /* TODO Sergio Actualizacion detalle Kardex */
    $sqlActualizacion = "
        UPDATE retiro 
        SET 
        gestion = '$gestion',
        fecha_retiro = '$fecha_retiro',
        motivo = '$motivo'
        WHERE
        ci_persona_detalle_kardex = '$ci'   
                     ";
    pg_query($conexionPG, $sqlActualizacion);

    $mensaje = 1;
    echo json_encode($mensaje);

?>