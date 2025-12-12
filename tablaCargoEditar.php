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

    //throw new Exception("Sergio  -> ". print_r($request, true));
    $arrTablaCargo = array();

    if (!empty($request)){
        $idUnidad = intval($request->idUnidad);

        $sqlTablaCargo = "
                SELECT
                \"public\".cargo.\"id\",
                \"public\".cargo.nombre,
                \"public\".cargo.id_unidad,
                \"public\".cargo.detalle_ci_persona as ci
                FROM
                \"public\".cargo
                WHERE
                \"public\".cargo.id_unidad = '$idUnidad'	 
                ORDER BY
                \"public\".cargo.\"id\" ASC
                ";
        $rs = pg_query(conexionPostgresql(), $sqlTablaCargo);

        $idCargo = intval($request->idCargo);
        while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
        {

            if (is_null($row['ci'])){
                $arrTablaCargo[] = $row;
            }

            if ($row['id'] == $idCargo){
                $arrTablaCargo[] = $row;
            }
        }
    }
echo json_encode($arrTablaCargo);
?>