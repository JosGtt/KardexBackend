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

    $sqlTablaUnidad = "
        SELECT
        \"public\".unidad.nombre,
        \"public\".unidad.\"id\"
        FROM
        \"public\".unidad
        ORDER BY \"public\".unidad.nombre
    ";

    $arrTablaUnidad = array();
    $rs = pg_query(conexionPostgresql(), $sqlTablaUnidad);
    $cnt = 0;
    while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
    {
        $arrTablaUnidad[] = $row;
        $arrTablaUnidad[$cnt]['indice'] = $cnt+1;
        $cnt++;
    }

    echo json_encode($arrTablaUnidad);
?>