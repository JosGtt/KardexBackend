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
    //throw new Exception("Sergio ". print_r($request->nombre, true));
    $swActivoFecha = true;

    if ($request->fecha_inicio != "0000-00-00" && !empty($request->fecha_inicio)){
        $swActivoFecha = false;
        if ($request->fecha_inicio !=  "0000-00-00" && !empty($request->fecha_inicio) && $request->fecha_final != "0000-00-00" && !empty($request->fecha_inicio)){
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
                INNER JOIN \"public\".cargo ON \"public\".cargo.detalle_ci_persona = \"public\".persona.ci
                WHERE \"public\".\"historialVacaciones\".fecha_solicitud >= '$request->fecha_inicio' and 
                \"public\".\"historialVacaciones\".fecha_solicitud <= '$request->fecha_final'
                ORDER BY \"public\".\"historialVacaciones\".fecha_solicitud 
            ";
        }else{
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
                INNER JOIN \"public\".cargo ON \"public\".cargo.detalle_ci_persona = \"public\".persona.ci
                WHERE \"public\".\"historialVacaciones\".fecha_solicitud = '$request->fecha_inicio' 
                ORDER BY \"public\".\"historialVacaciones\".fecha_solicitud
                
            ";
        }
    }

    if ($swActivoFecha){
        if(!empty($request->ci)){
            $ci = intval($request->ci);
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
            INNER JOIN \"public\".cargo ON \"public\".cargo.detalle_ci_persona = \"public\".persona.ci
            WHERE \"public\".persona.ci = '$ci'";
        }else {
            if (!empty($request->paterno)){
                $paterno = strtoupper($request->paterno);
                $paterno = '%'.$paterno.'%';
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
                    INNER JOIN \"public\".cargo ON \"public\".cargo.detalle_ci_persona = \"public\".persona.ci
                    WHERE UPPER(\"public\".persona.ap_paterno) LIKE '$paterno'";
            }else {
                if (!empty($request->materno)){
                $materno = strtoupper($request->materno);
                $materno = '%'.$materno.'%';
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
                    INNER JOIN \"public\".cargo ON \"public\".cargo.detalle_ci_persona = \"public\".persona.ci
                    WHERE UPPER(\"public\".persona.ap_materno) LIKE '$materno'";
                }else {
                    if(!empty($request->nombre)){
                        //throw new Exception("Sergio ". print_r($request->nombre, true));
                        $nombre = strtoupper($request->nombre);
                        $nombre = '%'.$nombre.'%';
                        //throw new Exception("Sergio ". print_r($nombre, true));
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
                            INNER JOIN \"public\".cargo ON \"public\".cargo.detalle_ci_persona = \"public\".persona.ci
                            WHERE
                            UPPER(\"public\".persona.nombre) LIKE '$nombre'
                            ";
                        //throw new Exception("Sergio ". print_r($sqlTablakardex, true));

                    }else {
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
                            INNER JOIN \"public\".cargo ON \"public\".cargo.detalle_ci_persona = \"public\".persona.ci
                            ";
                    }
                }
            }
        }
    }
        //throw new Exception("Sergio Dato: " . print_r($sqlTablakardex, true));
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