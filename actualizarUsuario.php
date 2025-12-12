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
    $nombre = $request->nombre;
    $paterno = $request->paterno;
    $materno = $request->materno;
    // $usuario = $request->usuario;
    // $password = $request->password;
    $tipoUsuario = intval($request->tipoUsuario);
    $exp = $request->exp;
    $ci = intval($request->ci);
    //throw new Exception("Sergio Prueba Datos" . print_r($tipoUsuario, true));


    $conexionPG = conexionPostgresql();
    /* TODO Sergio Actualizacion detalle Kardex */
        $sqlActualizacion = "
            UPDATE persona
            SET 
            nombre = '$nombre',
            ap_paterno = '$paterno',
            ap_materno = '$materno',
            expedido = '$exp'
            WHERE
            ci = '$ci'   
         ";
        pg_query($conexionPG, $sqlActualizacion);

        $sqlActualizacionUsuario = "
            UPDATE \"Usuario\"
            SET 
            sw_admin = '$tipoUsuario'
            WHERE 
            ci = '$ci'
        ";
        pg_query($conexionPG, $sqlActualizacionUsuario);

    $mensaje = true;
    echo json_encode($mensaje);
?>