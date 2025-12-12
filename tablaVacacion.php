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
   // $ci = intval($request);


        $sqlTablakardex = "
            SELECT
            \"public\".persona.ci,
            \"public\".persona.ap_paterno,
            \"public\".persona.ap_materno,
            \"public\".persona.nombre,
            \"public\".gestion.gestion,
            \"public\".\"historialVacaciones\".id_gestion,
            \"public\".\"historialVacaciones\".a_cuenta,
            \"public\".\"historialVacaciones\".queda,
            \"public\".\"historialVacaciones\".fecha_del,
            \"public\".\"historialVacaciones\".fecha_hasta,
            \"public\".\"historialVacaciones\".fecha_incorporacion,
            \"public\".\"historialVacaciones\".fecha_solicitud,
            \"public\".\"historialVacaciones\".dias_que_saco,
            \"public\".gestion.ci_persona_detalle_kardex
            FROM
            \"public\".gestion
            INNER JOIN \"public\".\"historialVacaciones\" ON \"public\".\"historialVacaciones\".id_gestion = \"public\".gestion.\"id\"
            INNER JOIN \"public\".persona ON \"public\".gestion.ci_persona_detalle_kardex = \"public\".persona.ci
            INNER JOIN \"public\".cargo ON \"public\".cargo.detalle_ci_persona = \"public\".persona.ci";

            $arrTablaKardex = array();
            $rs = pg_query(conexionPostgresql(), $sqlTablakardex);
            $cnt = 0;
            while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
            {
                $arrTablaKardex[] = $row;
                $arrTablaKardex[$cnt]['indice'] = $cnt+1;
                $cnt++;
            }

            $fechaActual = date('Y-m-d');

            $response = array("tablaVacacion" => $arrTablaKardex, 'fechaActual' => $fechaActual);
            echo json_encode($response);
            pg_close(conexionPostgresql());

?>