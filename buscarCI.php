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

    //throw new Exception("Sergio ". print_r($request, true));

    $arrTablaKardex = array();
    if(!empty($request)){
      $ci = intval($request);
        $sqlTablaKardex = "
            SELECT
            \"public\".persona.ci,
            \"public\".persona.ap_paterno,
            \"public\".persona.ap_materno,
            \"public\".persona.nombre
            FROM
            \"public\".persona
            WHERE 
            \"public\".persona.ci = $ci
            ";

        $rs = pg_query(conexionPostgresql(), $sqlTablaKardex);
        $cnt = 0;
        while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
        {
            $arrTablaKardex[] = $row;
        }
    }

    echo json_encode($arrTablaKardex);
    pg_close(conexionPostgresql());
?>