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

    //throw new Exception("Sergio Prueba Datos  " . print_r($request, true));

    $ci = intval($request->ci);
    $fecha_del = $request->fecha_del;
    $fecha_hasta = $request->fecha_hasta;
    $fecha_incorporacion = $request->fecha_incorporacion;
    $fecha_solicitud = $request->fecha_solicitud;
    $gestion = intval($request->gestion);
    $total_dias = intval($request->total_dias); // TODO Sergio Esto va ir restado A Cuenta y el resultado estara en el valor queda
    // TODO Sergio Total dias es la cantida de dias de vacaciones que esta sacando

    /* TODO Sergio Actualiza el Dato del Archivo */

    $conexionPG = conexionPostgresql();

    $sqlSearchIdGestion = "
        SELECT
        \"public\".gestion.\"id\",
        \"public\".vacacion.a_cuenta,
        \"public\".vacacion.queda,
        \"public\".gestion.gestion,
        \"public\".gestion.ci_persona_detalle_kardex,
        \"public\".gestion.corresponde
        FROM
        \"public\".gestion
        INNER JOIN \"public\".vacacion ON \"public\".vacacion.id_gestion = \"public\".gestion.\"id\"
        WHERE
        \"public\".gestion.ci_persona_detalle_kardex = '$ci' AND
        \"public\".gestion.gestion = '$gestion'		   
             ";

    $rGesrion = pg_query($conexionPG, $sqlSearchIdGestion);
    $idGestion = 0;
    while($row = pg_fetch_array($rGesrion, null, PGSQL_ASSOC)){
        $idGestion = $row['id'];
    }

    $sqlDatosVacacion = "
        SELECT
        \"public\".vacacion.a_cuenta,
        \"public\".vacacion.queda,
        \"public\".vacacion.id_gestion
        FROM
        \"public\".vacacion
        WHERE
        \"public\".vacacion.id_gestion = '$idGestion'
    ";

    $resDatosVacacion = pg_query($conexionPG, $sqlDatosVacacion);
    $resACuenta = 0;
    $resQueda = 0;
    while($row = pg_fetch_array($resDatosVacacion, null, PGSQL_ASSOC)){
        $resACuenta = intval($row['a_cuenta']);
        $resQueda = intval($row['queda']);
    }

    // TODO Sergio se añadira datos al historial  de vacaciones


        $resACuenta = $resACuenta + $total_dias;
        $resQueda = $resQueda - $total_dias;

        $sqlHistorialVacacion = "
        INSERT INTO
          \"historialVacaciones\" (id_gestion, a_cuenta, queda, fecha_del, fecha_hasta, fecha_incorporacion, fecha_solicitud, dias_que_saco)
        VALUES 
          ('$idGestion', '$resACuenta', '$resQueda', '$fecha_del', '$fecha_hasta', '$fecha_incorporacion', '$fecha_solicitud', '$total_dias')       
    ";

    pg_query($conexionPG, $sqlHistorialVacacion);



    $sqlUpdateVacacion = "
        UPDATE vacacion
        SET fecha_del = '$fecha_del',
        fecha_hasta = '$fecha_hasta',
        fecha_solicitud = '$fecha_solicitud',
        fecha_incorporacion = '$fecha_incorporacion',
        a_cuenta = '$resACuenta',
		queda = '$resQueda'
        WHERE id_gestion = '$idGestion'
    ";

    // TODO Se tiene que tener otro registro para el historial de vacaciones
    pg_query($conexionPG, $sqlUpdateVacacion);

    $mensaje = 1;
    echo json_encode($mensaje)

?>