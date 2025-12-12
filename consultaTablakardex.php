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

    $sqlTablakardex = "
        SELECT
        \"public\".persona.nombre,
        \"public\".\"detalleKardex\".\"id\",
        \"public\".\"detalleKardex\".ci_persona,
        \"public\".cargo.nombre AS cargo,
        \"public\".cargo.\"id\" AS idCargo,
        \"public\".\"detalleKardex\".item,
        \"public\".\"detalleKardex\".estado,
        \"public\".\"detalleKardex\".fecha_ingreso,
        \"public\".\"detalleKardex\".fecha_reg,
        \"public\".persona.ap_paterno,
        \"public\".persona.ap_materno,
        \"public\".persona.ci,
        \"public\".persona.expedido,
        \"public\".\"detalleKardex\".cas,
        \"public\".cargo.id_unidad,
        \"public\".unidad.nombre AS nom_unidad
        FROM
        \"public\".\"detalleKardex\"
        INNER JOIN \"public\".persona ON \"public\".\"detalleKardex\".ci_persona = \"public\".persona.ci
        INNER JOIN \"public\".cargo ON \"public\".cargo.detalle_ci_persona = \"public\".\"detalleKardex\".ci_persona
        INNER JOIN \"public\".unidad ON \"public\".cargo.id_unidad = \"public\".unidad.\"id\"
        WHERE \"public\".\"detalleKardex\".estado = 1
        ORDER BY \"public\".\"detalleKardex\".item
        ";

    $arrTablaKardex = array();
    $rs = pg_query(conexionPostgresql(), $sqlTablakardex);
    $cnt = 0;
    // TODO Sergio este array es solo para ver las gestiones.
    //$arrGestion = array();
    $cntPrueba = 0;
    while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
    {
        $arrTablaKardex[] = $row;
        // TODO Sergio Inicio
        date_default_timezone_set('America/La_Paz');
        $date1 = new DateTime($row['fecha_ingreso']);
        $date2 = new DateTime("now");
        $diff = $date1->diff($date2);
        // TODO --------------------------------------
        $anio = get_formatAnio($diff);
        $mes = get_formatMes($diff);
        $dias = get_formatDias($diff);
        $anioDiferencia = intval($anio);
        $arrTablaKardex[$cnt]["diferenciaFechaFormat"] =  $dias."-".$mes."-".$anio;
        // TODO Sedeges Ejemplo 5 - 2 = 3
        $anioSumado = intval($anio) - 2;
        // ----------------------------------------------------------------
        $arrTablaKardex[$cnt]["diferenciaFecha"] =  get_format($diff);
            //  TODO Diferencia de 2 años date('Y-m-d')
        // $arrTablaKardex[$cnt]["diferenciaDosAnios"] = date("d-m-Y",strtotime($row['fecha_ingreso']."- 2 year"));
        //$arrTablaKardex[$cnt]["diferenciaDosAnios"] = date("d-m-Y",strtotime($row['fecha_ingreso']."- 2 year"));
            // TODO 3 > 0
        if ($anioSumado > 0){
            $arrTablaKardex[$cnt]["diferenciaDosAnios"] = date("d-m-Y",strtotime($row['fecha_ingreso']."+". $anioSumado. "year"));
        }else {
            $anioSumado = 0;
            $arrTablaKardex[$cnt]["diferenciaDosAnios"] = date("d-m-Y",strtotime($row['fecha_ingreso']."-". $anioSumado. "year"));
        }

        $arrTablaKardex[$cnt]["diferenciaLimite"] = date("d-m-Y",strtotime(date("d-m-Y")."- 2 year"));
        $arrTablaKardex[$cnt]["anioSumado"] = $anioSumado;
        $arrTablaKardex[$cnt]["date2"] = $date2;
        $arrTablaKardex[$cnt]["date1"] = $date1;
        $arrTablaKardex[$cnt]["FechaIngresoFormato"] = $date1->format("d-m-Y");
        $fechaIngresoFormato = $date1->format("d-m-Y");

        // TODO Sedeges realizando la diferencia de la fecha diferenciaDosAnios con el limite
            // TODO diferenciaDosAnios es el mayor y el otro es el menor
              $fechadifMay  =  date("d-m-Y",strtotime($row['fecha_ingreso']."+". $anioSumado. "year"));
                $dtMayor = new DateTime($fechadifMay);
              $fechadifMen  =  date("d-m-Y",strtotime(date("d-m-Y")."- 2 year"));
                $dtMenor = new DateTime($fechadifMen);
                // $diff = date("d-m-Y", strtotime($fechadifMen))->diff(date("d-m-Y", strtotime($fechadifMay)));
                $diff2 = $dtMenor->diff($dtMayor);

                $arrTablaKardex[$cnt]["pruebaRegistro"] = get_format($diff2);
                $arrTablaKardex[$cnt]["mayor"] = $dtMayor;
                $arrTablaKardex[$cnt]["menor"] = $dtMenor;
            //  TODO Fin
        // TODO Sergio Final

        $ci =  $row['ci'];

            $sqlGestion = "
                SELECT
                    \"public\".gestion.gestion,
                    \"public\".gestion.fecha_registro,
                    \"public\".vacacion.a_cuenta,
                    \"public\".vacacion.queda,
                    \"public\".vacacion.cas,
                    \"public\".vacacion.id_gestion,
                    \"public\".\"detalleKardex\".ci_persona,
                    \"public\".gestion.corresponde
                    FROM
                    \"public\".\"detalleKardex\"
                    INNER JOIN \"public\".gestion ON \"public\".gestion.ci_persona_detalle_kardex = \"public\".\"detalleKardex\".ci_persona
                    INNER JOIN \"public\".vacacion ON \"public\".vacacion.id_gestion = \"public\".gestion.\"id\"
                    WHERE
                    \"public\".\"detalleKardex\".ci_persona = '$ci'
                    ORDER BY \"public\".gestion.gestion DESC
                    
            ";

            $arrayGestion =  array();
            $rsGestion = pg_query(conexionPostgresql(), $sqlGestion);

            // TODO Sergio Ejemplo /*
                /*  0:a_cuenta: "2"cas: nullci_persona: "8304569"corresponde: "20" gestion: "2022"id_gestion: "120"queda: "18"
                    1:a_cuenta: "2"cas: "5"ci_persona: "8304569"corresponde: "20" gestion: "2021"id_gestion: "8"queda: "18"
                    2:a_cuenta: "0"cas: "5"ci_persona: "8304569"corresponde: "20" gestion: "2020"id_gestion: "7"queda: "20"
                    3:a_cuenta: "0"cas: nullci_persona: "8304569"corresponde: "20" gestion: "2019"id_gestion: "131"queda: "20" */
            $cntGestion = 0;
            $anio1 = 0;   // TODO Sergio Verificar 22/08/2021
            $mes1 = 0;
            $dias1 = 0;
            while($rowGestion = pg_fetch_array($rsGestion, null, PGSQL_ASSOC)){
                $arrayGestion[$cntGestion] =  $rowGestion;
                // TODO Sergio Codigo Nuevo
                            $date1 = new DateTime($row['fecha_ingreso']); // TODO Es mayor
                            /*if ($cntPrueba === 3){
                                throw new Exception("Prueba de entra en el añio ". print_r($row['fecha_ingreso'] , true));
                            }*/
                                // TODO Sergio esto es el año actual
                            $date2 = new DateTime("now");    // TODO Es Menor
                            $AnioActuaL = $date2->format("Y");  // TODO Año Actual

                                //throw new Exception("Sergio ". print_r($AnioActuaL , true));
                            $diff2 = $date1->diff($date2);
                            $anio1Principal = get_formatAnio($diff2);
                            $anio1Principal = intval($anio1Principal);
                            // TODO Sergio Preguntar si el añio e mayor o igual a 2
                            /*if ($cntPrueba === 0){
                                throw new Exception("Prueba de entra en el mes ". print_r($anio1Principal , true));
                            }*/
                            //throw new Exception("Sergio ". print_r($diff2 , true));
                        // TODO Sergio Ejemplo 2021
                        if (strval($AnioActuaL) == intval($rowGestion['gestion'])){
                            $formatoFechaDeIngreso = $date1->format("d-m-Y");
                            $anio1 = get_formatAnio($diff2); // TODO Diferencias de años TOTAL
                            $mesPrueba = get_formatMes($diff2); // TODO Diferencias de años TOTAL
                            $diaPrueba = get_formatDias($diff2); // TODO Diferencias de años TOTAL
                            /* $mes1 = get_formatMes($diff2);
                            $dias1 = get_formatdias($diff2);*/
                            $anio1 = intval($anio1);
                            /*if ($cntPrueba === 2){
                                throw new Exception("Prueba de entra en el mes ". print_r($diaPrueba , true));
                            }*/
                            if ($anio1 < 0){
                                   $anio1 = 0;
                            }


                            $fechaRango =  date("d-m-Y",strtotime($formatoFechaDeIngreso."+". $anio1. "year"));

                            $date2 = new DateTime($fechaRango); // TODO Es mayor
                            $date1 = new DateTime("now");    // TODO Es Menor
                            $diff2 = $date2->diff($date1); // el rango siempre es de una fecha inicial a otra

                            $formatoFechaDeIngreso = $date1->format("d-m-Y");
                            //throw new Exception("Sergio Fecha Rango ultimo con formato  ". print_r($formatoFechaDeIngreso , true));
                            $anio1 = get_formatAnio($diff2); // TODO Diferencias de años TOTAL
                            $mes1 = get_formatMes($diff2);
                            $dias1 = get_formatdias($diff2);
                            $total = get_format($diff2);

                            $anio1 = intval($anio1);
                            $anio1 = intval($mes1);
                            $anio1 = intval($dias1);

                            /*if ($cntPrueba === 2){ $anio1Principal
                                throw new Exception("Prueba de entra en el mes ". print_r($dias1 , true));
                            }*/
                            $dia_mes_anio =  get_format($diff2);
                            if ($anio1 == ""){
                                $anio1 = 0;
                            }
                            if ($mes1 == ""){
                                $mes1 = 0;
                            }
                            if ($anio1 == ""){
                                $anio1 = 0;
                            }
                            //throw new Exception("Sergio Fecha Rango ultimo con formato mes ". print_r($dias1 , true));

                            if ($anio1Principal >= 2){
                                // TODO Sergio Cuando es mayor a 3 años o mas    1 = abierto, 0 = cerrado
                                if (intval($anio1) > 0){
                                    // TODO Sergio Que ser un año
                                    $strAbierto = "(Abierto)";
                                    $arrayGestion[$cntGestion]['swAbierto'] = 1;
                                    $arrayGestion[$cntGestion]['Anio'] = $anio1;
                                    // $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                    // $arrFechasCorrespondientes[0]  = $aux. " ". "(Cerrado)";
                                }else {
                                    //$arrayGestion[$cntGestion]['swAbierto'] = 0;
                                    //$arrayGestion[$cntGestion]['Anio'] = $anio1;
                                    $arrayGestion[$cntGestion]['swAbierto'] = 0;
                                    // TODO Sergio Verificar Codigo
                                    if (intval($mes1) > 0){
                                        $strAbierto = "(Abierto)";
                                        $arrayGestion[$cntGestion]['swAbierto'] = 1;
                                        $arrayGestion[$cntGestion]['Anio'] = $anio1;
                                        // $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                        // $arrFechasCorrespondientes[0]  = $aux. " ". "(Cerrado)";
                                    }else {
                                        if (intval($dias1)>0){
                                            $strAbierto = "(Abierto)";
                                            $arrayGestion[$cntGestion]['swAbierto'] = 1;
                                            $arrayGestion[$cntGestion]['Anio'] = $anio1;
                                            // $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                            // $arrFechasCorrespondientes[0]  = $aux. " ". "(Cerrado)";
                                        } else {
                                            $strAbierto = "(Por abrise)";
                                            $arrayGestion[$cntGestion]['swAbierto'] = 0; // TODO Sergio Por Abrise cuando es = 0
                                            // $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                        }
                                    }
                                }
                            }else {
                                $arrayGestion[$cntGestion]['swAbierto'] = 0;
                            }

                        }

                        $cntGestion = $cntGestion +1;
                // TODO Sergio Codigo Fin Nuevo

                // TODO Sergio No borrar Todavia Sirve
                // $arrayGestion[] =  $rowGestion;
            }
            $arrTablaKardex[$cnt]['gestion']  =  $arrayGestion;
            $arrTablaKardex[$cnt]['AnioDirefenciaOrigianl']  =  $anioDiferencia;
            $arrTablaKardex[$cnt]['indice'] = $cnt+1;
            //$arrTablaKardex[$cnt]['corresponde'] = $arrayGestion[0]['corresponde'];
            $cnt++;
            $cntPrueba++;
    }


    //$response = array("tablaKardex"=> $arrTablaKardex, "arrGestion"=>$arrayGestion);
    $fechaActual = date('Y-m-d');
    //$fechaActual = "2022-01-01";

    $date1 = new DateTime("2020-08-17");
    $date2 = new DateTime("now");
    // $date1 = new DateTime("2021-04-02");
    //$date2 = new DateTime("now");
    $diff = $date1->diff($date2);
    $diferenciaFecha =  get_format($diff);
    function get_format($df) {
        $str = '';
        $str .= ($df->invert == 1) ? ' - ' : '';
        if ($df->y > 0) {
            // years
            $str .= ($df->y > 1) ? $df->y . ' Años ' : $df->y . ' Año ';
        } if ($df->m > 0) {
            // month
            $str .= ($df->m > 1) ? $df->m . ' Meses ' : $df->m . ' Mes ';
        } if ($df->d > 0) {
            // days
            $str .= ($df->d > 1) ? $df->d . ' Dias ' : $df->d . ' Dia ';
        }else {
            $str .= 0;
        }
        return $str;
    }
    function get_formatAnio($df) {
        $str = '';
        // Realiza la union
        //$str .= ($df->invert == 1) ? ' - ' : '';
        if ($df->y > 0) {
            // years
            $str .= ($df->y > 1) ? $df->y : $df->y;
        }
        return $str;
    }
    function get_formatMes($df) {
        $str = '';
        //$str .= ($df->invert == 1) ? ' - ' : '';
         if ($df->m > 0) {
            // month
            $str .= ($df->m > 1) ? $df->m : $df->m;
        }
        return $str;
    }
    function get_formatDias($df) {
        $str = '';
        $str .= ($df->invert == 1) ? ' - ' : '';
        if ($df->d > 0) {
            // days
            $str .= ($df->d > 1) ? $df->d : $df->d;
        }
        return $str;
    }

        // Script
    $response = array("tablaKardex"=> $arrTablaKardex, "fechaActual"=>$fechaActual, "diferenciaFecha" => $diferenciaFecha);
    echo json_encode($response);
    //echo json_encode($response);
    pg_close(conexionPostgresql());

?>