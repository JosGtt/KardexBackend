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

    //throw new Exception("Sergio" . print_r($request, true));
    $arrTablaCargo = array();

    if (!empty($request)) {
        $idUnidad = intval($request);
        $sqlTablaCargo = "
                SELECT
                    \"public\".unidad.\"id\" AS id_unidad,
                    \"public\".cargo.\"id\" AS id_cargo,
                    \"public\".unidad.nombre nombre_unidad,
                    \"public\".cargo.nombre AS nombre_cargo,
                    \"public\".cargo.detalle_ci_persona AS ci
                    FROM
                    \"public\".unidad
                    INNER JOIN \"public\".cargo ON \"public\".cargo.id_unidad = \"public\".unidad.\"id\"
                    WHERE \"public\".unidad.\"id\" = '$idUnidad' 
                    ORDER BY \"public\".unidad.\"id\"
            ";
    
        $rs = pg_query(conexionPostgresql(), $sqlTablaCargo);
        $cnt = 0;
        while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC)) {
            $arrTablaCargo[] = $row;
            $arrTablaCargo[$cnt]["indice"] = $cnt + 1;
            $cnt++;
        }
    }else {
        $sqlTablaCargo = "
        SELECT
            \"public\".unidad.\"id\" AS id_unidad,
            \"public\".cargo.\"id\" AS id_cargo,
            \"public\".unidad.nombre nombre_unidad,
            \"public\".cargo.nombre AS nombre_cargo,
            \"public\".cargo.detalle_ci_persona AS ci
            FROM
            \"public\".unidad
            INNER JOIN \"public\".cargo ON \"public\".cargo.id_unidad = \"public\".unidad.\"id\"
            ORDER BY \"public\".unidad.\"id\"
    ";

        $rs = pg_query(conexionPostgresql(), $sqlTablaCargo);
        $cnt = 0;
        while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
        {
            $arrTablaCargo[] = $row;
            $arrTablaCargo[$cnt]["indice"] = $cnt + 1;
            $cnt++;
        }
    }

    echo json_encode($arrTablaCargo);
?>