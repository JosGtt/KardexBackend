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
    // TODO Sergio Pruebas de control de

    $sqlTablaUsuario = "
        SELECT
        \"public\".persona.ap_paterno,
        \"public\".persona.ap_materno,
        \"public\".persona.nombre,
        \"public\".persona.ci,
        \"public\".persona.expedido,
        \"public\".\"Usuario\".\"login\",
        \"public\".\"Usuario\".sw_admin
        FROM
        \"public\".persona
        INNER JOIN \"public\".\"Usuario\" ON \"public\".\"Usuario\".ci = \"public\".persona.ci
    ";

    $arrTablaUsuario = array();
    $rs = pg_query(conexionPostgresql(), $sqlTablaUsuario);
    $cnt = 0;
    // TODO Sergio este array es solo para ver las gestiones.
    //$arrGestion = array();
    while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
    {
        $arrTablaUsuario[] = $row;
        $arrTablaUsuario[$cnt]['indice'] = $cnt+1;
        //$arrTablaUsuario[$cnt]['corresponde'] = $arrayGestion[0]['corresponde'];
        $cnt++;
    }


    //$response = array("tablaKardex"=> $arrTablaUsuario, "fechaActual"=>$fechaActual);
    echo json_encode($arrTablaUsuario);
    //echo json_encode($response);
    pg_close(conexionPostgresql());

?>