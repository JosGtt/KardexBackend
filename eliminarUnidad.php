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

    // throw new Exception("Sergio Prueba Datos" . print_r($request, true));
    $idUnidad = intval($request);
    $conexionPG = conexionPostgresql();

    $sqlVerificarCargo = "
        SELECT
        \"public\".cargo.id_unidad,
        \"public\".cargo.\"id\",
        \"public\".unidad.nombre,
        \"public\".cargo.nombre
        FROM
        \"public\".unidad
        INNER JOIN \"public\".cargo ON \"public\".cargo.id_unidad = \"public\".unidad.\"id\"
        WHERE \"public\".cargo.id_unidad = '$idUnidad'
    ";

    $rs =pg_query($conexionPG, $sqlVerificarCargo);
    $cnt = 0;
    $arrEnviar = array();
    while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC)){
        $cnt++;
    }

    /* TODO Sergio Actualizacion detalle Kardex */
    if ($cnt == 0){
        $sqlEliminarUnidad = "
                DELETE from unidad
	            WHERE id = '$idUnidad'   
               ";
        pg_query($conexionPG, $sqlEliminarUnidad);
        $response = true;
    }else {
        $response = false;
    }

    echo json_encode($response);
    ?>