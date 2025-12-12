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

    $sqlTablakardexRetirado = "
        SELECT
        \"public\".\"detalleKardex\".estado,
        \"public\".persona.ap_paterno,
        \"public\".persona.ap_materno,
        \"public\".persona.nombre,
        \"public\".persona.ci,
        \"public\".persona.expedido,
        \"public\".\"detalleKardex\".\"id\" as id_detalle_kardex,
        \"public\".retiro.motivo,
        \"public\".retiro.gestion,
        \"public\".retiro.fecha_retiro,
        \"public\".retiro.\"id\" AS id_retiro,
        \"public\".\"detalleKardex\".cas
        FROM
        \"public\".\"detalleKardex\"
        INNER JOIN \"public\".retiro ON \"public\".retiro.ci_persona_detalle_kardex = \"public\".\"detalleKardex\".ci_persona
        INNER JOIN \"public\".persona ON \"public\".\"detalleKardex\".ci_persona = \"public\".persona.ci
        WHERE \"public\".\"detalleKardex\".estado = 2
        ORDER BY \"public\".retiro.fecha_retiro
            ";

    $arrTablaKardexRetirado = array();
    $rs = pg_query(conexionPostgresql(), $sqlTablakardexRetirado);
    $cnt = 0;
    while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
    {
        $arrTablaKardexRetirado[] = $row;

        $arrTablaKardexRetirado[$cnt]['indice'] = $cnt+1;
        $arrTablaKardexRetirado[$cnt]['gestion'] = intval($row['gestion']);
        $arrTablaKardexRetirado[$cnt]['ci'] = intval($row['ci']);
        $arrTablaKardexRetirado[$cnt]['cas'] = intval($row['cas']);
        //$arrTablaKardexRetirado[$cnt]['estado'] = intval($row['estado']);
        $arrTablaKardexRetirado[$cnt]['id_detalle_kardex'] = intval($row['id_detalle_kardex']);
        $arrTablaKardexRetirado[$cnt]['id_retiro'] = intval($row['id_retiro']);
        $cnt++;
    }
    //$response = array("tablaKardex"=> $arrTablaKardexRetirado, "arrGestion"=>$arrayGestion);
    //$fechaActual = date('Y-m-d');
    //$fechaActual = "2022-01-01";
    //$response = array("tablaKardex"=> $arrTablaKardexRetirado, "fechaActual"=>$fechaActual);
    echo json_encode($arrTablaKardexRetirado);
    //echo json_encode($response);
    pg_close(conexionPostgresql());

?>