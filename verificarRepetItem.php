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
    $item = intval($request->item);


        $sqlItemYCIRepetido = "
            SELECT
            \"public\".\"detalleKardex\".item,
            \"public\".\"detalleKardex\".ci_persona
            FROM
            \"public\".\"detalleKardex\"
            WHERE
            \"public\".\"detalleKardex\".item = '$item'
            OR
            \"public\".\"detalleKardex\".ci_persona = '$ci'
        ";

        $arrTablaKardex = array();
        $rs = pg_query(conexionPostgresql(), $sqlItemYCIRepetido);

        $swVerificar = true;
        while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
        {
            $arrTablaKardex[] = $row;
        }

        if(count($arrTablaKardex)> 0 ){
            $swVerificar = false;
        }

        // TODO Sergio Si existe un array mayor a 0 entonces hay repetido y seria
        // TODO falso si es igual a 0 entonces no hay repetido y seria verdadero
        echo json_encode($swVerificar);
        pg_close(conexionPostgresql());

?>