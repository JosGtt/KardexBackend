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

    //throw  new Exception("Sergio: " .print_r($request, 1));

    $titulo_bachiller = $request->titulo_bachiller;
    $titulo_academico = $request->titulo_academico;
    $titulo_provision_nacional = $request->titulo_provision_nacional;
    $libreta_militar = $request->libreta_militar;
    $cns = $request->cns;
    $sipasse = $request->sipasse;
    $antecedentes = $request->antecedentes;
    $rejap = $request->rejap;
    $aymara = $request->aymara;
    $declaracion_jurada = $request->declaracion_jurada;
    $formulario_incompatibilidad = $request->formulario_incompatibilidad;
    $ci_vigencia = $request->ci_vigencia;
    $ci = intval($request->ci);

    // TODO Sergio Datos Que Probablemente no se añadan
    //throw new Exception("Sergio Datos:  ". print_r($request, true));
    $cntfecha =  0;
    $swSipa = 100; $swAnte = 200; $swRejap = 300; $swdecla =400;

    $date = date('Y-m-d');
    $titulo_bachiller == "Si" ? $titulo_bachiller = 1:  $titulo_bachiller = 0;
    $titulo_academico == "Si" ? $titulo_academico =  1: $titulo_academico = 0;
    $titulo_provision_nacional == "Si" ? $titulo_provision_nacional = 1: $titulo_provision_nacional = 0;
    $libreta_militar == "Si" ? $libreta_militar = 1: $libreta_militar = 0;
    $cns == "Si" ? $cns = 1 :  $cns = 0;
    $aymara == "Si" ? $aymara = 1: $aymara = 0;
    $formulario_incompatibilidad == "Si" ? $formulario_incompatibilidad = 1: $formulario_incompatibilidad = 0;

    if($sipasse == "Si"){$sipasse = 1;$dateSipasse = $request->dateSipasse; $swSipa = 1;
    }else {
        $sipasse = 0;
        $dateSipasse = 'NULL';
        $cntfecha++;
    }
    if($antecedentes == "Si"){$antecedentes = 1; $dateAntecedentes = $request->dateAntecedentes; $swAnte = 2;
    }else {
        $antecedentes = 0;
        $dateAntecedentes = 'NULL';
        $cntfecha++;
    }
    if($rejap == "Si"){$rejap = 1;$dateRejap = $request->dateRejap; $swRejap = 3;
    }else {
        $rejap = 0;
        $dateRejap = 'NULL';
        $cntfecha++;
    }

    if($declaracion_jurada == "Si"){
        $declaracion_jurada = 1;
        $dateDeclaracionJurada = $request->dateDeclaracionJurada; $swdecla = 4;
    }else {
        $declaracion_jurada = 0;
        $dateDeclaracionJurada = 'NULL';
        $cntfecha++;
    }

    // TODO Sergio Query para grabar los documentos que se necesitan
    // TODO Sergio Cuando no ingresan los datos
    if($swSipa == 1 && $swAnte == 2 && $swRejap == 3 && $swdecla == 4 ){
            $sqlPersona = "                
            INSERT INTO documentos (
            titulo_bachiller,
            titulo_academico,
            titulo_provision_nacional,
            libreta_militar,
            cns,
            sipasse,
            antecedentes,
            rejap,
            aymara,
            declaracion_jurada,
            formulario_incompatibilidad,
            fecha_sipasse,
            fecha_antecedentes,
            fecha_rejap,
            fecha_declaracion,
            ci,
            cedula_identidad_vigencia
            )
            VALUES
            (
            $titulo_bachiller,
            $titulo_academico,
            $titulo_provision_nacional,
            $libreta_militar,
            $cns,
            $sipasse,
            $antecedentes,
            $rejap,
            $aymara,
            $declaracion_jurada,
            $formulario_incompatibilidad,
            '$dateSipasse',
            '$dateAntecedentes',
            '$dateRejap',
            '$dateDeclaracionJurada',
            $ci,
            '$ci_vigencia'
            )";
    }else {
        if ($swSipa === 1 && $swAnte === 2 && $swRejap === 3){
            //throw new Exception("Sergio ". print_r("Esta entranoo aqui " , true));
                $sqlPersona = "                
                    INSERT INTO documentos (
                    titulo_bachiller,
                    titulo_academico,
                    titulo_provision_nacional,
                    libreta_militar,
                    cns,
                    sipasse,
                    antecedentes,
                    rejap,
                    aymara,
                    declaracion_jurada,
                    formulario_incompatibilidad,
                    fecha_sipasse,
                    fecha_antecedentes,
                    fecha_rejap,
                    fecha_declaracion,
                    ci,
                    cedula_identidad_vigencia
                    )
                VALUES
                (
                    $titulo_bachiller,
                    $titulo_academico,
                    $titulo_provision_nacional,
                    $libreta_militar,
                    $cns,
                    $sipasse,
                    $antecedentes,
                    $rejap,
                    $aymara,
                    $declaracion_jurada,
                    $formulario_incompatibilidad,
                    '$dateSipasse',
                    '$dateAntecedentes',
                    '$dateRejap',
                    $dateDeclaracionJurada,
                    $ci,
                    '$ci_vigencia'
                )";
        }else {
            if ($swSipa == 1 && $swAnte == 2 && $swdecla == 4){
                    $sqlPersona = "                
                    INSERT INTO documentos (
                        titulo_bachiller,
                        titulo_academico,
                        titulo_provision_nacional,
                        libreta_militar,
                        cns,
                        sipasse,
                        antecedentes,
                        rejap,
                        aymara,
                        declaracion_jurada,
                        formulario_incompatibilidad,
                        fecha_sipasse,
                        fecha_antecedentes,
                        fecha_rejap,
                        fecha_declaracion,
                        ci,
                        cedula_identidad_vigencia
                    )
                    VALUES
                        (
                        $titulo_bachiller,
                        $titulo_academico,
                        $titulo_provision_nacional,
                        $libreta_militar,
                        $cns,
                        $sipasse,
                        $antecedentes,
                        $rejap,
                        $aymara,
                        $declaracion_jurada,
                        $formulario_incompatibilidad,
                        '$dateSipasse',
                        '$dateAntecedentes',
                        $dateRejap,
                        '$dateDeclaracionJurada',
                        $ci,
                        '$ci_vigencia'
                        )";
            }else {
                if ($swAnte == 2 && $swRejap == 3 && $swdecla == 4){
                        $sqlPersona = "                
                        INSERT INTO documentos (
                        titulo_bachiller,
                        titulo_academico,
                        titulo_provision_nacional,
                        libreta_militar,
                        cns,
                        sipasse,
                        antecedentes,
                        rejap,
                        aymara,
                        declaracion_jurada,
                        formulario_incompatibilidad,
                        fecha_sipasse,
                        fecha_antecedentes,
                        fecha_rejap,
                        fecha_declaracion,
                        ci,
                        cedula_identidad_vigencia
                    )
                    VALUES
                        (
                        $titulo_bachiller,
                        $titulo_academico,
                        $titulo_provision_nacional,
                        $libreta_militar,
                        $cns,
                        $sipasse,
                        $antecedentes,
                        $rejap,
                        $aymara,
                        $declaracion_jurada,
                        $formulario_incompatibilidad,
                        $dateSipasse,
                        '$dateAntecedentes',
                        '$dateRejap',
                        '$dateDeclaracionJurada',
                        $ci,
                        '$ci_vigencia'
                        )";
                }else {
                    if ($swSipa == 1 && $swRejap == 3 && $swdecla == 4){
                        $sqlPersona = "                
                        INSERT INTO documentos (
                        titulo_bachiller,
                        titulo_academico,
                        titulo_provision_nacional,
                        libreta_militar,
                        cns,
                        sipasse,
                        antecedentes,
                        rejap,
                        aymara,
                        declaracion_jurada,
                        formulario_incompatibilidad,
                        fecha_sipasse,
                        fecha_antecedentes,
                        fecha_rejap,
                        fecha_declaracion,
                        ci,
                        cedula_identidad_vigencia
                    )
                    VALUES
                        (
                        $titulo_bachiller,
                        $titulo_academico,
                        $titulo_provision_nacional,
                        $libreta_militar,
                        $cns,
                        $sipasse,
                        $antecedentes,
                        $rejap,
                        $aymara,
                        $declaracion_jurada,
                        $formulario_incompatibilidad,
                        '$dateSipasse',
                        $dateAntecedentes,
                        '$dateRejap',
                        '$dateDeclaracionJurada',
                        $ci,
                        '$ci_vigencia'
                        )";
                    }else {
                        if ($swSipa == 1 && $swAnte == 2 ){
                            $sqlPersona = "                
                            INSERT INTO documentos (
                            titulo_bachiller,
                            titulo_academico,
                            titulo_provision_nacional,
                            libreta_militar,
                            cns,
                            sipasse,
                            antecedentes,
                            rejap,
                            aymara,
                            declaracion_jurada,
                            formulario_incompatibilidad,
                            fecha_sipasse,
                            fecha_antecedentes,
                            fecha_rejap,
                            fecha_declaracion,
                            ci,
                            cedula_identidad_vigencia
                            )
                        VALUES
                        (
                            $titulo_bachiller,
                            $titulo_academico,
                            $titulo_provision_nacional,
                            $libreta_militar,
                            $cns,
                            $sipasse,
                            $antecedentes,
                            $rejap,
                            $aymara,
                            $declaracion_jurada,
                            $formulario_incompatibilidad,
                            '$dateSipasse',
                            '$dateAntecedentes',
                            $dateRejap,
                            $dateDeclaracionJurada,
                            $ci,
                            '$ci_vigencia'
                        )";
                        }else {
                            if ($swSipa == 1 && $swRejap == 3 ){
                                $sqlPersona = "                
                                INSERT INTO documentos (
                                titulo_bachiller,
                                titulo_academico,
                                titulo_provision_nacional,
                                libreta_militar,
                                cns,
                                sipasse,
                                antecedentes,
                                rejap,
                                aymara,
                                declaracion_jurada,
                                formulario_incompatibilidad,
                                fecha_sipasse,
                                fecha_antecedentes,
                                fecha_rejap,
                                fecha_declaracion,
                                ci,
                                cedula_identidad_vigencia
                                )
                                VALUES
                                (
                                $titulo_bachiller,
                                $titulo_academico,
                                $titulo_provision_nacional,
                                $libreta_militar,
                                $cns,
                                $sipasse,
                                $antecedentes,
                                $rejap,
                                $aymara,
                                $declaracion_jurada,
                                $formulario_incompatibilidad,
                                '$dateSipasse',
                                $dateAntecedentes,
                                '$dateRejap',
                                $dateDeclaracionJurada,
                                $ci,
                                '$ci_vigencia'
                            )";
                            }else {
                                if ($swSipa == 1 && $swdecla == 4 ){
                                    $sqlPersona = "                
                                    INSERT INTO documentos (
                                    titulo_bachiller,
                                    titulo_academico,
                                    titulo_provision_nacional,
                                    libreta_militar,
                                    cns,
                                    sipasse,
                                    antecedentes,
                                    rejap,
                                    aymara,
                                    declaracion_jurada,
                                    formulario_incompatibilidad,
                                    fecha_sipasse,
                                    fecha_antecedentes,
                                    fecha_rejap,
                                    fecha_declaracion,
                                    ci,
                                    cedula_identidad_vigencia
                                    )
                                    VALUES
                                    (
                                    $titulo_bachiller,
                                    $titulo_academico,
                                    $titulo_provision_nacional,
                                    $libreta_militar,
                                    $cns,
                                    $sipasse,
                                    $antecedentes,
                                    $rejap,
                                    $aymara,
                                    $declaracion_jurada,
                                    $formulario_incompatibilidad,
                                    '$dateSipasse',
                                     $dateAntecedentes,
                                     $dateRejap,
                                    '$dateDeclaracionJurada',
                                    $ci,
                                    '$ci_vigencia'
                                    )";
                                }else {
                                    if ($swAnte  == 2 && $swRejap == 3 ){
                                        $sqlPersona = "                
                                        INSERT INTO documentos (
                                        titulo_bachiller,
                                        titulo_academico,
                                        titulo_provision_nacional,
                                        libreta_militar,
                                        cns,
                                        sipasse,
                                        antecedentes,
                                        rejap,
                                        aymara,
                                        declaracion_jurada,
                                        formulario_incompatibilidad,
                                        fecha_sipasse,
                                        fecha_antecedentes,
                                        fecha_rejap,
                                        fecha_declaracion,
                                        ci,
                                        cedula_identidad_vigencia
                                        )
                                        VALUES
                                        (
                                        $titulo_bachiller,
                                        $titulo_academico,
                                        $titulo_provision_nacional,
                                        $libreta_militar,
                                        $cns,
                                        $sipasse,
                                        $antecedentes,
                                        $rejap,
                                        $aymara,
                                        $declaracion_jurada,
                                        $formulario_incompatibilidad,
                                        $dateSipasse,
                                        '$dateAntecedentes',
                                        '$dateRejap',
                                        $dateDeclaracionJurada,
                                        $ci,
                                        '$ci_vigencia'
                                        )";
                                    }else {
                                        if ($swAnte  == 2 && $swdecla == 4){
                                            $sqlPersona = "                
                                            INSERT INTO documentos (
                                            titulo_bachiller,
                                            titulo_academico,
                                            titulo_provision_nacional,
                                            libreta_militar,
                                            cns,
                                            sipasse,
                                            antecedentes,
                                            rejap,
                                            aymara,
                                            declaracion_jurada,
                                            formulario_incompatibilidad,
                                            fecha_sipasse,
                                            fecha_antecedentes,
                                            fecha_rejap,
                                            fecha_declaracion,
                                            ci,
                                            cedula_identidad_vigencia
                                            )
                                            VALUES
                                            (
                                            $titulo_bachiller,
                                            $titulo_academico,
                                            $titulo_provision_nacional,
                                            $libreta_militar,
                                            $cns,
                                            $sipasse,
                                            $antecedentes,
                                            $rejap,
                                            $aymara,
                                            $declaracion_jurada,
                                            $formulario_incompatibilidad,
                                            $dateSipasse,
                                            '$dateAntecedentes',
                                            $dateRejap,
                                            '$dateDeclaracionJurada',
                                            $ci,
                                            '$ci_vigencia'
                                            )";
                                        }else {
                                            if ($swRejap  == 3 && $swdecla == 4){
                                                $sqlPersona = "                
                                                INSERT INTO documentos (
                                                titulo_bachiller,
                                                titulo_academico,
                                                titulo_provision_nacional,
                                                libreta_militar,
                                                cns,
                                                sipasse,
                                                antecedentes,
                                                rejap,
                                                aymara,
                                                declaracion_jurada,
                                                formulario_incompatibilidad,
                                                fecha_sipasse,
                                                fecha_antecedentes,
                                                fecha_rejap,
                                                fecha_declaracion,
                                                ci,
                                                cedula_identidad_vigencia
                                                )
                                                VALUES
                                                (
                                                $titulo_bachiller,
                                                $titulo_academico,
                                                $titulo_provision_nacional,
                                                $libreta_militar,
                                                $cns,
                                                $sipasse,
                                                $antecedentes,
                                                $rejap,
                                                $aymara,
                                                $declaracion_jurada,
                                                $formulario_incompatibilidad,
                                                $dateSipasse,
                                                $dateAntecedentes,
                                                '$dateRejap',
                                                '$dateDeclaracionJurada',
                                                $ci,
                                                '$ci_vigencia'
                                                )";
                                            }else {
                                                if ($swdecla == 4){
                                                    $sqlPersona = "                
                                                INSERT INTO documentos (
                                                titulo_bachiller,
                                                titulo_academico,
                                                titulo_provision_nacional,
                                                libreta_militar,
                                                cns,
                                                sipasse,
                                                antecedentes,
                                                rejap,
                                                aymara,
                                                declaracion_jurada,
                                                formulario_incompatibilidad,
                                                fecha_sipasse,
                                                fecha_antecedentes,
                                                fecha_rejap,
                                                fecha_declaracion,
                                                ci,
                                                cedula_identidad_vigencia
                                                )
                                                VALUES
                                                (
                                                $titulo_bachiller,
                                                $titulo_academico,
                                                $titulo_provision_nacional,
                                                $libreta_militar,
                                                $cns,
                                                $sipasse,
                                                $antecedentes,
                                                $rejap,
                                                $aymara,
                                                $declaracion_jurada,
                                                $formulario_incompatibilidad,
                                                $dateSipasse,
                                                $dateAntecedentes,
                                                $dateRejap,
                                                '$dateDeclaracionJurada',
                                                $ci,
                                                '$ci_vigencia'
                                                )";
                                                }else {
                                                    if ($swSipa == 1){
                                                        $sqlPersona = "                
                                                    INSERT INTO documentos (
                                                    titulo_bachiller,
                                                    titulo_academico,
                                                    titulo_provision_nacional,
                                                    libreta_militar,
                                                    cns,
                                                    sipasse,
                                                    antecedentes,
                                                    rejap,
                                                    aymara,
                                                    declaracion_jurada,
                                                    formulario_incompatibilidad,
                                                    fecha_sipasse,
                                                    fecha_antecedentes,
                                                    fecha_rejap,
                                                    fecha_declaracion,
                                                    ci,
                                                    cedula_identidad_vigencia
                                                    )
                                                    VALUES
                                                    (
                                                    $titulo_bachiller,
                                                    $titulo_academico,
                                                    $titulo_provision_nacional,
                                                    $libreta_militar,
                                                    $cns,
                                                    $sipasse,
                                                    $antecedentes,
                                                    $rejap,
                                                    $aymara,
                                                    $declaracion_jurada,
                                                    $formulario_incompatibilidad,
                                                    '$dateSipasse',
                                                    $dateAntecedentes,
                                                    $dateRejap,
                                                    $dateDeclaracionJurada,
                                                    $ci,
                                                    '$ci_vigencia'
                                                    )";
                                                    }else {
                                                        if ($swAnte == 2){
                                                            $sqlPersona = "                
                                                            INSERT INTO documentos (
                                                            titulo_bachiller,
                                                            titulo_academico,
                                                            titulo_provision_nacional,
                                                            libreta_militar,
                                                            cns,
                                                            sipasse,
                                                            antecedentes,
                                                            rejap,
                                                            aymara,
                                                            declaracion_jurada,
                                                            formulario_incompatibilidad,
                                                            fecha_sipasse,
                                                            fecha_antecedentes,
                                                            fecha_rejap,
                                                            fecha_declaracion,
                                                            ci,
                                                            cedula_identidad_vigencia
                                                            )
                                                            VALUES
                                                            (
                                                            $titulo_bachiller,
                                                            $titulo_academico,
                                                            $titulo_provision_nacional,
                                                            $libreta_militar,
                                                            $cns,
                                                            $sipasse,
                                                            $antecedentes,
                                                            $rejap,
                                                            $aymara,
                                                            $declaracion_jurada,
                                                            $formulario_incompatibilidad,
                                                            $dateSipasse,
                                                            '$dateAntecedentes',
                                                            $dateRejap,
                                                            $dateDeclaracionJurada,
                                                            $ci,
                                                            '$ci_vigencia'
                                                            )";
                                                        }else {
                                                            if ($swRejap == 3){
                                                                $sqlPersona = "                
                                                            INSERT INTO documentos (
                                                            titulo_bachiller,
                                                            titulo_academico,
                                                            titulo_provision_nacional,
                                                            libreta_militar,
                                                            cns,
                                                            sipasse,
                                                            antecedentes,
                                                            rejap,
                                                            aymara,
                                                            declaracion_jurada,
                                                            formulario_incompatibilidad,
                                                            fecha_sipasse,
                                                            fecha_antecedentes,
                                                            fecha_rejap,
                                                            fecha_declaracion,
                                                            ci,
                                                            cedula_identidad_vigencia
                                                            )
                                                            VALUES
                                                            (
                                                            $titulo_bachiller,
                                                            $titulo_academico,
                                                            $titulo_provision_nacional,
                                                            $libreta_militar,
                                                            $cns,
                                                            $sipasse,
                                                            $antecedentes,
                                                            $rejap,
                                                            $aymara,
                                                            $declaracion_jurada,
                                                            $formulario_incompatibilidad,
                                                            $dateSipasse,
                                                            $dateAntecedentes,
                                                            $dateRejap,
                                                            $dateDeclaracionJurada,
                                                            $ci,
                                                            '$ci_vigencia'
                                                            )";
                                                            }else {
                                                                $sqlPersona = "                
                                                                INSERT INTO documentos (
                                                                titulo_bachiller,
                                                                titulo_academico,
                                                                titulo_provision_nacional,
                                                                libreta_militar,
                                                                cns,
                                                                sipasse,
                                                                antecedentes,
                                                                rejap,
                                                                aymara,
                                                                declaracion_jurada,
                                                                formulario_incompatibilidad,
                                                                fecha_sipasse,
                                                                fecha_antecedentes,
                                                                fecha_rejap,
                                                                fecha_declaracion,
                                                                ci,
                                                                cedula_identidad_vigencia
                                                                )
                                                                VALUES
                                                                (
                                                                $titulo_bachiller,
                                                                $titulo_academico,
                                                                $titulo_provision_nacional,
                                                                $libreta_militar,
                                                                $cns,
                                                                $sipasse,
                                                                $antecedentes,
                                                                $rejap,
                                                                $aymara,
                                                                $declaracion_jurada,
                                                                $formulario_incompatibilidad,
                                                                $dateSipasse,
                                                                $dateAntecedentes,
                                                                $dateRejap,
                                                                $dateDeclaracionJurada,
                                                                $ci,
                                                                '$ci_vigencia'
                                                            )";
                                                            }

                                                        }

                                                    }


                                                }

                                            }

                                        }

                                    }

                                }

                            }

                        }
                    }

                }
            }

        }
    }

    //throw new Exception("Sergio entrada:  ". print_r($sqlPersona, true));
    pg_query(conexionPostgresql(), $sqlPersona);

    echo json_encode(true);
    pg_close(conexionPostgresql());
?>