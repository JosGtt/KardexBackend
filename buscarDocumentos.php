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

    if (!empty($request)){
        $ci = intval($request);
        $sqlTablakardex = "
            SELECT
            \"public\".documentos.\"id\",
            \"public\".documentos.titulo_bachiller,
            \"public\".documentos.titulo_academico,
            \"public\".documentos.titulo_provision_nacional,
            \"public\".documentos.libreta_militar,
            \"public\".documentos.cns,
            \"public\".documentos.sipasse,
            \"public\".documentos.antecedentes,
            \"public\".documentos.rejap,
            \"public\".documentos.aymara,
            \"public\".documentos.declaracion_jurada,
            \"public\".documentos.formulario_incompatibilidad,
            \"public\".documentos.fecha_sipasse,
            \"public\".documentos.fecha_antecedentes,
            \"public\".documentos.fecha_rejap,
            \"public\".documentos.fecha_declaracion,
            \"public\".documentos.ci,
            \"public\".documentos.cedula_identidad_vigencia,
            \"public\".persona.ap_paterno,
            \"public\".persona.ap_materno,
            \"public\".persona.nombre
            FROM
            \"public\".documentos
            INNER JOIN \"public\".persona ON \"public\".documentos.ci = \"public\".persona.ci
            WHERE \"public\".documentos.ci = '$ci'
        ";
    }else {
        $sqlTablakardex = "
            SELECT
            \"public\".documentos.\"id\",
            \"public\".documentos.titulo_bachiller,
            \"public\".documentos.titulo_academico,
            \"public\".documentos.titulo_provision_nacional,
            \"public\".documentos.libreta_militar,
            \"public\".documentos.cns,
            \"public\".documentos.sipasse,
            \"public\".documentos.antecedentes,
            \"public\".documentos.rejap,
            \"public\".documentos.aymara,
            \"public\".documentos.declaracion_jurada,
            \"public\".documentos.formulario_incompatibilidad,
            \"public\".documentos.fecha_sipasse,
            \"public\".documentos.fecha_antecedentes,
            \"public\".documentos.fecha_rejap,
            \"public\".documentos.fecha_declaracion,
            \"public\".documentos.ci,
            \"public\".documentos.cedula_identidad_vigencia,
            \"public\".persona.ap_paterno,
            \"public\".persona.ap_materno,
            \"public\".persona.nombre
            FROM
            \"public\".documentos
            INNER JOIN \"public\".persona ON \"public\".documentos.ci = \"public\".persona.ci
        ";
    }


    $arrTablaKardex = array();
    $rs = pg_query(conexionPostgresql(), $sqlTablakardex);
    $cnt = 0;
    // TODO Sergio este array es solo para ver las gestiones.
    //$arrGestion = array();
    while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
    {
        $arrTablaKardex[] = $row;
        $arrTablaKardex[$cnt]['indice'] = $cnt+1;
        //$arrTablaKardex[$cnt]['corresponde'] = $arrayGestion[0]['corresponde'];
        $cnt++;
    }


    //$response = array("tablaKardex"=> $arrTablaKardex, "fechaActual"=>$fechaActual);
    echo json_encode($arrTablaKardex);
    //echo json_encode($response);
    pg_close(conexionPostgresql());

    ?>