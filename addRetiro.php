<?php

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

    $ci = intval($request->ci);
    $fecha_retiro = $request->fecha_retiro;
    $gestion = intval($request->gestion);
    $id = intval($request->id); // id_detalle_kardex
    $motivo = $request->motivo;
    $id_item = intval($request->id_item);

        /* TODO Sergio SQL Retiro Kardex
        Se asigna el idItem  a la tabla retiro
    */
    $sqlRetiroItemKardex = "
        INSERT INTO
          retiro (fecha_retiro,gestion, motivo,ci_persona_detalle_kardex)
        VALUES 
        ('$fecha_retiro','$gestion','$motivo','$ci')";

    pg_query(conexionPostgresql(), $sqlRetiroItemKardex);

    /* TODO Sergio Actualizacion estado */
    // TODO Sergio cierra la conexion de la base de datos

        $sqlUpdateDetalleKardex = "
            UPDATE \"detalleKardex\"
            SET estado = 2, item = null
            WHERE \"detalleKardex\".ci_persona = '$ci'";
        pg_query(conexionPostgresql(), $sqlUpdateDetalleKardex);
    // TODO Sergio se quita el cargo

        $sqlUpdateCargo = "
            UPDATE cargo
            set detalle_ci_persona = null
            WHERE cargo.detalle_ci_persona = '$ci'
        ";
        pg_query(conexionPostgresql(), $sqlUpdateCargo);
    echo json_encode(true);
    pg_close(conexionPostgresql());
?>

