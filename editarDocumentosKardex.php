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

        $titulo_bachiller = $request->titulo_bachiller;
        $titulo_academico = $request->titulo_academico;
        $titulo_provision_nacional = $request->titulo_provision_nacional;
        $libreta_militar = $request->libreta_militar;
        $cns = $request->cns;
        $aymara = $request->aymara;
        $formulario_incompatibilidad = $request->formulario_incompatibilidad;

        $sipasse = $request->sipasse;
        $antecedentes = $request->antecedentes;
        $rejap = $request->rejap;
        $declaracion_jurada = $request->declaracion_jurada;


        $ci_vigencia = $request->ci_vigencia;
        $ci = $request->ci;
        $dateSipasse = $request->dateSipasse;
        $dateAntecedentes = $request->dateAntecedentes;
        $dateRejap = $request->dateRejap;
        $dateDeclaracionJurada = $request->dateDeclaracionJurada;

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

        // TODO FECHAS

        if($sipasse == "Si"){$sipasse = 1; $dateSipasse = $request->dateSipasse; $swSipa = 1;
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
        if($rejap == "Si"){$rejap = 1; $dateRejap = $request->dateRejap; $swRejap = 3;
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

        /* TODO Sergio Actualizacion detalle Kardex */
if($swSipa == 1 && $swAnte == 2 && $swRejap == 3 && $swdecla == 4 ){
    $sqlActualizacion = "
                UPDATE documentos 
                SET 
                    titulo_bachiller = $titulo_bachiller,
                    titulo_academico = $titulo_academico,
                    titulo_provision_nacional = $titulo_provision_nacional,
                    libreta_militar = $libreta_militar,
                    cns = $cns,
                    sipasse = $sipasse,
                    antecedentes = $antecedentes,
                    rejap = $rejap,
                    aymara = $aymara,
                    declaracion_jurada = $declaracion_jurada,
                    formulario_incompatibilidad = $formulario_incompatibilidad,
                    fecha_sipasse = '$dateSipasse',
                    fecha_antecedentes = '$dateAntecedentes',
                    fecha_rejap = '$dateRejap',
                    fecha_declaracion = '$dateDeclaracionJurada',
                    cedula_identidad_vigencia = '$ci_vigencia'
                WHERE
                  ci = $ci   
                             ";
}else {
    if ($swSipa === 1 && $swAnte === 2 && $swRejap === 3){
        //throw new Exception("Sergio ". print_r("Esta entranoo aqui " , true));
        $sqlActualizacion = "
                UPDATE documentos 
                SET 
                    titulo_bachiller = $titulo_bachiller,
                    titulo_academico = $titulo_academico,
                    titulo_provision_nacional = $titulo_provision_nacional,
                    libreta_militar = $libreta_militar,
                    cns = $cns,
                    sipasse = $sipasse,
                    antecedentes = $antecedentes,
                    rejap = $rejap,
                    aymara = $aymara,
                    declaracion_jurada = $declaracion_jurada,
                    formulario_incompatibilidad = $formulario_incompatibilidad,
                    fecha_sipasse = '$dateSipasse',
                    fecha_antecedentes = '$dateAntecedentes',
                    fecha_rejap = '$dateRejap',
                    fecha_declaracion = $dateDeclaracionJurada,
                    cedula_identidad_vigencia = '$ci_vigencia'
                WHERE
                  ci = $ci   
                             ";
    }else {
        if ($swSipa == 1 && $swAnte == 2 && $swdecla == 4){
            $sqlActualizacion = "
                UPDATE documentos 
                SET 
                    titulo_bachiller = $titulo_bachiller,
                    titulo_academico = $titulo_academico,
                    titulo_provision_nacional = $titulo_provision_nacional,
                    libreta_militar = $libreta_militar,
                    cns = $cns,
                    sipasse = $sipasse,
                    antecedentes = $antecedentes,
                    rejap = $rejap,
                    aymara = $aymara,
                    declaracion_jurada = $declaracion_jurada,
                    formulario_incompatibilidad = $formulario_incompatibilidad,
                    fecha_sipasse = '$dateSipasse',
                    fecha_antecedentes = '$dateAntecedentes',
                    fecha_rejap = $dateRejap,
                    fecha_declaracion = '$dateDeclaracionJurada',
                    cedula_identidad_vigencia = '$ci_vigencia'
                WHERE
                  ci = $ci   
                             ";
        }else {
            if ($swAnte == 2 && $swRejap == 3 && $swdecla == 4){
                $sqlActualizacion = "
                UPDATE documentos 
                SET 
                    titulo_bachiller = $titulo_bachiller,
                    titulo_academico = $titulo_academico,
                    titulo_provision_nacional = $titulo_provision_nacional,
                    libreta_militar = $libreta_militar,
                    cns = $cns,
                    sipasse = $sipasse,
                    antecedentes = $antecedentes,
                    rejap = $rejap,
                    aymara = $aymara,
                    declaracion_jurada = $declaracion_jurada,
                    formulario_incompatibilidad = $formulario_incompatibilidad,
                    fecha_sipasse = $dateSipasse,
                    fecha_antecedentes = '$dateAntecedentes',
                    fecha_rejap = '$dateRejap',
                    fecha_declaracion = '$dateDeclaracionJurada',
                    cedula_identidad_vigencia = '$ci_vigencia'
                WHERE
                  ci = $ci   
                             ";
            }else {
                if ($swSipa == 1 && $swRejap == 3 && $swdecla == 4){
                    $sqlActualizacion = "
                UPDATE documentos 
                SET 
                    titulo_bachiller = $titulo_bachiller,
                    titulo_academico = $titulo_academico,
                    titulo_provision_nacional = $titulo_provision_nacional,
                    libreta_militar = $libreta_militar,
                    cns = $cns,
                    sipasse = $sipasse,
                    antecedentes = $antecedentes,
                    rejap = $rejap,
                    aymara = $aymara,
                    declaracion_jurada = $declaracion_jurada,
                    formulario_incompatibilidad = $formulario_incompatibilidad,
                    fecha_sipasse = '$dateSipasse',
                    fecha_antecedentes = $dateAntecedentes,
                    fecha_rejap = '$dateRejap',
                    fecha_declaracion = '$dateDeclaracionJurada',
                    cedula_identidad_vigencia = '$ci_vigencia'
                WHERE
                  ci = $ci   
                             ";
                }else {
                    if ($swSipa == 1 && $swAnte == 2 ){
                        $sqlActualizacion = "
                UPDATE documentos 
                SET 
                    titulo_bachiller = $titulo_bachiller,
                    titulo_academico = $titulo_academico,
                    titulo_provision_nacional = $titulo_provision_nacional,
                    libreta_militar = $libreta_militar,
                    cns = $cns,
                    sipasse = $sipasse,
                    antecedentes = $antecedentes,
                    rejap = $rejap,
                    aymara = $aymara,
                    declaracion_jurada = $declaracion_jurada,
                    formulario_incompatibilidad = $formulario_incompatibilidad,
                    fecha_sipasse = '$dateSipasse',
                    fecha_antecedentes = '$dateAntecedentes',
                    fecha_rejap = $dateRejap,
                    fecha_declaracion = $dateDeclaracionJurada,
                    cedula_identidad_vigencia = '$ci_vigencia'
                WHERE
                  ci = $ci   
                             ";
                    }else {
                        if ($swSipa == 1 && $swRejap == 3 ){
                            $sqlActualizacion = "
                            UPDATE documentos 
                            SET 
                            titulo_bachiller = $titulo_bachiller,
                            titulo_academico = $titulo_academico,
                            titulo_provision_nacional = $titulo_provision_nacional,
                            libreta_militar = $libreta_militar,
                            cns = $cns,
                            sipasse = $sipasse,
                            antecedentes = $antecedentes,
                            rejap = $rejap,
                            aymara = $aymara,
                            declaracion_jurada = $declaracion_jurada,
                            formulario_incompatibilidad = $formulario_incompatibilidad,
                            fecha_sipasse = '$dateSipasse',
                            fecha_antecedentes = $dateAntecedentes,
                            fecha_rejap = '$dateRejap',
                            fecha_declaracion = $dateDeclaracionJurada,
                            cedula_identidad_vigencia = '$ci_vigencia'
                            WHERE
                            ci = $ci   
                            ";
                        }else {
                            if ($swSipa == 1 && $swdecla == 4 ){
                                $sqlActualizacion = "
                            UPDATE documentos 
                            SET 
                            titulo_bachiller = $titulo_bachiller,
                            titulo_academico = $titulo_academico,
                            titulo_provision_nacional = $titulo_provision_nacional,
                            libreta_militar = $libreta_militar,
                            cns = $cns,
                            sipasse = $sipasse,
                            antecedentes = $antecedentes,
                            rejap = $rejap,
                            aymara = $aymara,
                            declaracion_jurada = $declaracion_jurada,
                            formulario_incompatibilidad = $formulario_incompatibilidad,
                            fecha_sipasse = '$dateSipasse',
                            fecha_antecedentes = $dateAntecedentes,
                            fecha_rejap = $dateRejap,
                            fecha_declaracion = '$dateDeclaracionJurada',
                            cedula_identidad_vigencia = '$ci_vigencia'
                            WHERE
                            ci = $ci   
                            ";
                            }else {
                                if ($swAnte  == 2 && $swRejap == 3 ){
                                    $sqlActualizacion = "
                                    UPDATE documentos 
                                    SET 
                                    titulo_bachiller = $titulo_bachiller,
                                    titulo_academico = $titulo_academico,
                                    titulo_provision_nacional = $titulo_provision_nacional,
                                    libreta_militar = $libreta_militar,
                                    cns = $cns,
                                    sipasse = $sipasse,
                                    antecedentes = $antecedentes,
                                    rejap = $rejap,
                                    aymara = $aymara,
                                    declaracion_jurada = $declaracion_jurada,
                                    formulario_incompatibilidad = $formulario_incompatibilidad,
                                    fecha_sipasse = $dateSipasse,
                                    fecha_antecedentes = '$dateAntecedentes',
                                    fecha_rejap = '$dateRejap',
                                    fecha_declaracion = $dateDeclaracionJurada,
                                    cedula_identidad_vigencia = '$ci_vigencia'
                                    WHERE
                                    ci = $ci   
                                ";
                                }else {
                                    if ($swAnte  == 2 && $swdecla == 4){
                                        $sqlActualizacion = "
                                    UPDATE documentos 
                                    SET 
                                    titulo_bachiller = $titulo_bachiller,
                                    titulo_academico = $titulo_academico,
                                    titulo_provision_nacional = $titulo_provision_nacional,
                                    libreta_militar = $libreta_militar,
                                    cns = $cns,
                                    sipasse = $sipasse,
                                    antecedentes = $antecedentes,
                                    rejap = $rejap,
                                    aymara = $aymara,
                                    declaracion_jurada = $declaracion_jurada,
                                    formulario_incompatibilidad = $formulario_incompatibilidad,
                                    fecha_sipasse = $dateSipasse,
                                    fecha_antecedentes = '$dateAntecedentes',
                                    fecha_rejap = $dateRejap,
                                    fecha_declaracion = '$dateDeclaracionJurada',
                                    cedula_identidad_vigencia = '$ci_vigencia'
                                    WHERE
                                    ci = $ci   
                                    ";
                                    }else {
                                        if ($swRejap  == 3 && $swdecla == 4){
                                            $sqlActualizacion = "
                                        UPDATE documentos 
                                        SET 
                                        titulo_bachiller = $titulo_bachiller,
                                        titulo_academico = $titulo_academico,
                                        titulo_provision_nacional = $titulo_provision_nacional,
                                        libreta_militar = $libreta_militar,
                                        cns = $cns,
                                        sipasse = $sipasse,
                                        antecedentes = $antecedentes,
                                        rejap = $rejap,
                                        aymara = $aymara,
                                        declaracion_jurada = $declaracion_jurada,
                                        formulario_incompatibilidad = $formulario_incompatibilidad,
                                        fecha_sipasse = $dateSipasse,
                                        fecha_antecedentes = $dateAntecedentes,
                                        fecha_rejap = '$dateRejap',
                                        fecha_declaracion = '$dateDeclaracionJurada',
                                        cedula_identidad_vigencia = '$ci_vigencia'
                                        WHERE
                                        ci = $ci   
                                        ";
                                        }else {
                                            if ($swdecla == 4){
                                                $sqlActualizacion = "
                                            UPDATE documentos 
                                            SET 
                                            titulo_bachiller = $titulo_bachiller,
                                            titulo_academico = $titulo_academico,
                                            titulo_provision_nacional = $titulo_provision_nacional,
                                            libreta_militar = $libreta_militar,
                                            cns = $cns,
                                            sipasse = $sipasse,
                                            antecedentes = $antecedentes,
                                            rejap = $rejap,
                                            aymara = $aymara,
                                            declaracion_jurada = $declaracion_jurada,
                                            formulario_incompatibilidad = $formulario_incompatibilidad,
                                            fecha_sipasse = $dateSipasse,
                                            fecha_antecedentes = $dateAntecedentes,
                                            fecha_rejap = $dateRejap,
                                            fecha_declaracion = '$dateDeclaracionJurada',
                                            cedula_identidad_vigencia = '$ci_vigencia'
                                            WHERE
                                            ci = $ci   
                                            ";
                                            }else {
                                                if ($swSipa == 1){
                                                    $sqlActualizacion = "
                                                UPDATE documentos 
                                                SET 
                                                titulo_bachiller = $titulo_bachiller,
                                                titulo_academico = $titulo_academico,
                                                titulo_provision_nacional = $titulo_provision_nacional,
                                                libreta_militar = $libreta_militar,
                                                cns = $cns,
                                                sipasse = $sipasse,
                                                antecedentes = $antecedentes,
                                                rejap = $rejap,
                                                aymara = $aymara,
                                                declaracion_jurada = $declaracion_jurada,
                                                formulario_incompatibilidad = $formulario_incompatibilidad,
                                                fecha_sipasse = '$dateSipasse',
                                                fecha_antecedentes = $dateAntecedentes,
                                                fecha_rejap = $dateRejap,
                                                fecha_declaracion = $dateDeclaracionJurada,
                                                cedula_identidad_vigencia = '$ci_vigencia'
                                                WHERE
                                                ci = $ci   
                                                ";
                                                }else {
                                                    if ($swAnte == 2){
                                                        $sqlActualizacion = "
                                                    UPDATE documentos 
                                                    SET 
                                                    titulo_bachiller = $titulo_bachiller,
                                                    titulo_academico = $titulo_academico,
                                                    titulo_provision_nacional = $titulo_provision_nacional,
                                                    libreta_militar = $libreta_militar,
                                                    cns = $cns,
                                                    sipasse = $sipasse,
                                                    antecedentes = $antecedentes,
                                                    rejap = $rejap,
                                                    aymara = $aymara,
                                                    declaracion_jurada = $declaracion_jurada,
                                                    formulario_incompatibilidad = $formulario_incompatibilidad,
                                                    fecha_sipasse = $dateSipasse,
                                                    fecha_antecedentes = '$dateAntecedentes',
                                                    fecha_rejap = $dateRejap,
                                                    fecha_declaracion = $dateDeclaracionJurada,
                                                    cedula_identidad_vigencia = '$ci_vigencia'
                                                    WHERE
                                                    ci = $ci   
                                                    ";
                                                    }else {
                                                        if ($swRejap == 3){
                                                            $sqlActualizacion = "
                                                        UPDATE documentos 
                                                        SET 
                                                        titulo_bachiller = $titulo_bachiller,
                                                        titulo_academico = $titulo_academico,
                                                        titulo_provision_nacional = $titulo_provision_nacional,
                                                        libreta_militar = $libreta_militar,
                                                        cns = $cns,
                                                        sipasse = $sipasse,
                                                        antecedentes = $antecedentes,
                                                        rejap = $rejap,
                                                        aymara = $aymara,
                                                        declaracion_jurada = $declaracion_jurada,
                                                        formulario_incompatibilidad = $formulario_incompatibilidad,
                                                        fecha_sipasse = $dateSipasse,
                                                        fecha_antecedentes = $dateAntecedentes,
                                                        fecha_rejap = '$dateRejap',
                                                        fecha_declaracion = $dateDeclaracionJurada,
                                                        cedula_identidad_vigencia = '$ci_vigencia'
                                                        WHERE
                                                        ci = $ci   
                                                        ";
                                                        }else {
                                                            $sqlActualizacion = "
                                                        UPDATE documentos 
                                                        SET 
                                                        titulo_bachiller = $titulo_bachiller,
                                                        titulo_academico = $titulo_academico,
                                                        titulo_provision_nacional = $titulo_provision_nacional,
                                                        libreta_militar = $libreta_militar,
                                                        cns = $cns,
                                                        sipasse = $sipasse,
                                                        antecedentes = $antecedentes,
                                                        rejap = $rejap,
                                                        aymara = $aymara,
                                                        declaracion_jurada = $declaracion_jurada,
                                                        formulario_incompatibilidad = $formulario_incompatibilidad,
                                                        fecha_sipasse = $dateSipasse,
                                                        fecha_antecedentes = $dateAntecedentes,
                                                        fecha_rejap = $dateRejap,
                                                        fecha_declaracion = $dateDeclaracionJurada,
                                                        cedula_identidad_vigencia = '$ci_vigencia'
                                                        WHERE
                                                        ci = $ci   
                                                        ";
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
        //throw new Exception("Sergio ". print_r($sqlActualizacion , true));
        pg_query(conexionPostgresql(), $sqlActualizacion);
        $mensaje = 1;
        echo json_encode($mensaje);

?>