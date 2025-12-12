<?php

    // TODO Para permitir el control accesos a angular
    header("Access-Control-Allow-Origin: *");
    // TODO Permitir recibir datos de Post utilizado en angular
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require_once 'conexionBaseDatos.php';
    /* TODO Sergio SQL Inserta datos archivos*/
    // TODO Datos Recibidos del post de angular
    $postdata = file_get_contents("php://input");

    $request = json_decode($postdata);
    //$request = '30-08-2016';
                    /*$request = '01/04/2016';  // TODO FUNCIONA Formato a/m/d y  a-m-d de igual manera igual funciona al reves d/m/a
                    $request = new DateTime($request);
                    $request = $request->format('d-m-Y');*/
    //throw new Exception("Sergio entra" . print_r($request, true));
    $swNoCorrespondeNada = false;
    // TODO Serfio Scrip Python
    function get_formatAnio($df) {
        $str = '';
        //echo "entra aqui";
        //echo $df."";
        //echo $df->invert;
        $str .= ($df->invert == 1) ? ' - ' : '';
        if ($df->y > 0) {
            // years
            $str .= ($df->y > 1) ? $df->y : $df->y;
        }
        return $str;
    }
    function get_formatMes($df) {
        $str = '';
        $str .= ($df->invert == 1) ? ' - ' : '';
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

    // TODO Sergio Respuesta de los datos
    date_default_timezone_set('America/La_Paz');

    $date1 = new DateTime($request); // TODO Es mayor
    //$date1 = new DateTime('2021/01/01'); // TODO Es mayor
    $date2 = new DateTime("now");    // TODO Es Menor
    $diff = $date1->diff($date2);
    //throw new Exception("sergio " . print_r($diff , true));
    $anio = get_formatAnio($diff);
    $mes = get_formatMes($diff);
    $dias = get_formatdias($diff);

    // TODO Sergio Obtener la diferencia de los años
    // date("d-m-Y")
        //$limiteDelAñoRestadoDos = date("d-m-Y",strtotime(date("d-m-Y")."-". $anio. "year"));
        //TODO Sergio realizar la resta de 2 años para que cumpla la fecha de vacación
        // $restaAnioInicio = $anio - 2;
        // $restaAnioFinal = $restaAnioInicio - 1;
        /*if (($mes) > 0){
            $anio = intval($anio) +1;
            $restaAnioFinal = intval($anio) - 2;
        }else {
            $restaAnioFinal = intval($anio) - 2;
        }*/

        $restaAnioFinal = intval($anio) - 2;
        // TODO CASOS  (n>2)-2 = 2, Trabajo mas de 2 años
        // TODO CASOS  3-2 = 1, Trabajo 3 años -> Corresponde Vacacion
        // TODO CASOS  2-2 =0, Trabajo 2 años -> Corresponde Vacacion
        // TODO CASOS  1-2 = 1, Trabajo 1 años -> Corresponde Vacacion
        // TODO CASOS  0-2 = 1, Trabajo 0 años -> No corresponde
        $arrFechasCorrespondientes = array();
        // TODO Sergio Tiene Que cumplir que sea mas de un año
        if ($restaAnioFinal > 0){
            //throw new Exception("sergio " . print_r($restaAnioFinal , true));
                //TODO Sergio Nuevo Codigo
                    $date1 = new DateTime($request); // TODO Es mayor
                    $anioDeRequest = $date1->format("Y"); // TODO Es mayor
                    $date2 = new DateTime("now");    // TODO Es Menor
                    $anioActualRes = $date2->format("Y");
                    $anioInicio  =  date("d-m-Y",strtotime($request."+". $restaAnioFinal. "year"));
                    $anioInicio = new DateTime($anioInicio);

                    $anioInicio = $anioInicio->format("Y");
                    // throw new Exception("sergio " . print_r($anioInicio , true));
                    $anioActualRes = $anioActualRes -2;
                        // TODO Sergio Fin del Nuevo Codigo
                   $swVerificar = false;
                // TODO Sergio Inicio Del IF
                           //2018     ==  2019    ||    2019  =  2019
            if (intval($anioInicio) == intval($anioActualRes)){
                $swVerificar = true;
                $restaAnioInicio = intval($restaAnioFinal) -1;
                $inicioFechaRangoInicio  =  date("d-m-Y",strtotime($request."+". $restaAnioInicio. "year"));
                $inicioFechaRangoFinal  =  date("d-m-Y",strtotime($request."+". $restaAnioFinal. "year"));
                $inicioFechaRangoInicioSoloAnio = new DateTime($inicioFechaRangoInicio);
                $inicioFechaRangoInicioSoloAnio = $inicioFechaRangoInicioSoloAnio->format('Y');

                $limite = 3;
                $aux = "";
                for ($i = 0; $i < $limite; $i++ ){
                    $sumaAnioInicio = $i + $restaAnioFinal -1;
                    $sumaAnioFinal = $i + $restaAnioFinal;
                    $fechaInicioArray  = date("d-m-Y",strtotime($request."+". $sumaAnioInicio. "year"));
                    $fechaFinalArray  = date("d-m-Y",strtotime($request."+". $sumaAnioFinal. "year"));
                    $fechaMerge = $fechaInicioArray . " - " .$fechaFinalArray;
                    $arrFechasCorrespondientes[$i]  = $fechaMerge;

                    // TODO Sergio Calulamos si la ultima Fecha Si esta abierto o Cerrado
                    if ($i == 0){
                        // TODO Ejemplo Final Array es 18/08/2019
                        // TODO Sergio Prueba de Diferencias de Fechas en el ultimo
                        $strAbierto = "";
                        $strAbierto = "(Abierto)";
                        $aux  = $fechaMerge;
                        $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                    }else {
                        if ($i == 2){
                            // TODO Sergio Prueba de Diferencias de Fechas en el ultimo
                            $date11 = new DateTime($fechaFinalArray); // TODO Es mayor
                            $date22 = new DateTime("now");    // TODO Es Menor
                            $diff2 = $date11->diff($date22);
                            $anio1 = get_formatAnio($diff2);
                            $mes1 = get_formatMes($diff2);
                            $dias1 = get_formatdias($diff2);
                            $strAbierto = "";
                            if (intval($anio1) > 0){
                                $strAbierto = "(Abierto)";
                                $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                $arrFechasCorrespondientes[0]  = $aux. " ". "(Cerrado)";
                            }else {
                                if (intval($mes1) > 0){
                                    $strAbierto = "(Abierto)";
                                    $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                    $arrFechasCorrespondientes[0]  = $aux. " ". "(Cerrado)";
                                }else {
                                    if (intval($dias1)>=0){
                                        $strAbierto = "(Abierto)";
                                        $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                        $arrFechasCorrespondientes[0]  = $aux. " ". "(Cerrado)";
                                    } else {
                                        $strAbierto = "(Por abrise)";
                                        $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                    }
                                }
                            }
                        }else {
                            $arrFechasCorrespondientes[$i]  = $fechaMerge . " " . " (Abierto)";
                        }
                    }

                }
            }else {

                // intval($anioInicio) == intval($anioActualRes)
                // throw new Exception("sergio " . print_r("  dsfasfsdafasfsfd", true));
                $limite = 2;
                $aux = "";
                $sumaAnioInicio = 0;
                $sumaAnioFinal = 0;
                for ($i = 0; $i < $limite; $i++ ){
                    $sumaAnioInicio = $i + $restaAnioFinal;
                    $sumaAnioFinal = $i + $restaAnioFinal+1;
                    $fechaInicioArray  = date("d-m-Y",strtotime($request."+". $sumaAnioInicio. "year"));
                    $fechaFinalArray  = date("d-m-Y",strtotime($request."+". $sumaAnioFinal. "year"));
                    $fechaMerge = $fechaInicioArray . " - " .$fechaFinalArray;
                    $arrFechasCorrespondientes[$i]  = $fechaMerge;

                    // TODO Sergio Calulamos si la ultima Fecha Si esta abierto o Cerrado
                    if ($i == 0){
                        // TODO Ejemplo Final Array es 18/08/2019
                        // TODO Sergio Prueba de Diferencias de Fechas en el ultimo
                        $strAbierto = "";
                        $strAbierto = " (Abierto)";
                        $aux  = $fechaMerge;
                        $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                    }else {
                        $strAbierto = "";
                        $strAbierto = " (Abierto)";
                        $aux  = $fechaMerge;
                        $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                    }

                }
                    //throw new Exception("sergio rango " . print_r($sumaAnioFinal, true));
                    // TODO Hay Que borrar esto
                    $inicioFechaRangoInicio  =  date("d-m-Y",strtotime($request."+". $sumaAnioFinal. "year"));
                    $sumaAnioFinal = $sumaAnioFinal +1;
                    $inicioFechaRangoFinal  =  date("d-m-Y",strtotime($request."+". $sumaAnioFinal. "year"));

                    //if($swVerificar){
                        $fechaMerge = $inicioFechaRangoInicio . " - ". $inicioFechaRangoFinal . " ( Por Abrirse)";
                    //}


                    $arrFechasCorrespondientes[2]  = $fechaMerge; //. " ". $strAbierto;

                // TODO Fin de Borrar
            }
        }else {
            // TODO Sergio Trabajo 2 años exactos
            // TODO La resta es igual a 0 por lo tanto solo se tiene que empezar desde su inicio
            // TODO Siempre empieza desde 2 años la constante va hacer dos
            if ($restaAnioFinal == 0){

                //throw new Exception("Sergio prueba". print_r($request, true));
                $limite = 2;
                    // TODO Sergio Verificacion de años
                        $date1 = new DateTime($request); // TODO Es mayor
                        $anioDeRequest = $date1->format("Y"); // TODO Es mayor
                        $date2 = new DateTime("now");    // TODO Es Menor
                        $anioActualRes = $date2->format("Y");
                        $anioActualRes = $anioActualRes -2;
                    // TODO Fin de Verificacion de Años
                    $swAbrirAnio = true;


                if (intval($anioDeRequest) == intval($anioActualRes)){
                    // TODO Sergio Codigo Nuevo
                    $swAbrirAnio = false;
                    $anterior = 1;
                    $sinSuma = 0;
                    $fechaInicioArray0  = date("d-m-Y",strtotime($request."-". $anterior. "year"));
                    $fechaFinalArray0  = date("d-m-Y",strtotime($request."+". $sinSuma. "year"));
                    $fechaMerge0 = $fechaInicioArray0 . " - " .$fechaFinalArray0;
                    $arrFechasCorrespondientes[0]  = $fechaMerge0. " (Cerrado)";
                    // TODO Sergio Fin del Codigo Nuevo
                    for ($i = 0; $i < $limite; $i++ ){
                        $sumaAnioInicio = $i;
                        $sumaAnioFinal = $i+1;
                        $fechaInicioArray  = date("d-m-Y",strtotime($request."+". $sumaAnioInicio. "year"));
                        $fechaFinalArray  = date("d-m-Y",strtotime($request."+". $sumaAnioFinal. "year"));
                        $fechaMerge = $fechaInicioArray . " - " .$fechaFinalArray;
                        $arrFechasCorrespondientes[$i+1]  = $fechaMerge;
                        if ($i == 0){
                            // TODO Sergio Prueba de Diferencias de Fechas en el ultimo
                            $date11 = new DateTime($fechaFinalArray); // TODO Es mayor
                            $date22 = new DateTime("now");    // TODO Es Menor
                            $diff2 = $date11->diff($date22);
                            $anio1 = get_formatAnio($diff2);
                            $mes1 = get_formatMes($diff2);
                            $dias1 = get_formatdias($diff2);

                            $strAbierto = "";
                            if (intval($anio1) > 0){
                                $strAbierto = "(Abierto)";
                                $arrFechasCorrespondientes[$i+1]  = $fechaMerge. " ". $strAbierto;
                            }else {
                                if (intval($mes1) > 0){
                                    $strAbierto = "(Abierto)";
                                    $arrFechasCorrespondientes[$i+1]  = $fechaMerge. " ". $strAbierto;
                                }else {
                                    if (intval($dias1)>0){
                                        $strAbierto = "(Abierto)";
                                        $arrFechasCorrespondientes[$i+1]  = $fechaMerge. " ". $strAbierto;
                                    } else {
                                        $strAbierto = "(Cerrado)";
                                        $arrFechasCorrespondientes[$i+1]  = $fechaMerge. " ". $strAbierto;
                                    }
                                }
                            }
                        }else {
                            if ($i == 1){
                                // TODO Sergio Prueba de Diferencias de Fechas en el ultimo
                                $date11 = new DateTime($fechaFinalArray); // TODO Es mayor
                                $date22 = new DateTime("now");    // TODO Es Menor
                                $diff2 = $date11->diff($date22);
                                $anio1 = get_formatAnio($diff2);
                                $mes1 = get_formatMes($diff2);
                                $dias1 = get_formatdias($diff2);
                                $strAbierto = "";
                                if (intval($anio1) > 0){
                                    $strAbierto = "(Abierto)";
                                    $arrFechasCorrespondientes[$i+1]  = $fechaMerge. " ". $strAbierto;
                                }else {
                                    if (intval($mes1) > 0){
                                        $strAbierto = "(Abierto)";
                                        $arrFechasCorrespondientes[$i+1]  = $fechaMerge. " ". $strAbierto;
                                    }else {
                                        if (intval($dias1)>=0){
                                            $strAbierto = "(Abierto)";
                                            $arrFechasCorrespondientes[$i+1]  = $fechaMerge. " ". $strAbierto;
                                        } else {
                                            // throw new Exception("Sergio". print_r("Sergio", true));
                                            $strAbierto = "(Por abrise)";
                                            $arrFechasCorrespondientes[$i+1]  = $fechaMerge. " ". $strAbierto;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }else {
                    // TODO Sergio Codigo Nuevo
                    // TODO Sergio Fin del Codigo Nuevo
                    $swAbrirAnio = true;
                    for ($i = 0; $i < $limite; $i++ ){
                        $sumaAnioInicio = $i;
                        $sumaAnioFinal = $i+1;
                        $fechaInicioArray  = date("d-m-Y",strtotime($request."+". $sumaAnioInicio. "year"));
                        $fechaFinalArray  = date("d-m-Y",strtotime($request."+". $sumaAnioFinal. "year"));
                        $fechaMerge = $fechaInicioArray . " - " .$fechaFinalArray;
                        $arrFechasCorrespondientes[$i]  = $fechaMerge;
                        if ($i == 0){
                            // TODO Sergio Prueba de Diferencias de Fechas en el ultimo
                            $date11 = new DateTime($fechaFinalArray); // TODO Es mayor
                            $date22 = new DateTime("now");    // TODO Es Menor
                            $diff2 = $date11->diff($date22);
                            $anio1 = get_formatAnio($diff2);
                            $mes1 = get_formatMes($diff2);
                            $dias1 = get_formatdias($diff2);

                            $strAbierto = "";
                            if (intval($anio1) > 0){
                                $strAbierto = "(Abierto)";
                                $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                            }else {
                                if (intval($mes1) > 0){
                                    $strAbierto = "(Abierto)";
                                    $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                }else {
                                    if (intval($dias1)>0){
                                        $strAbierto = "(Abierto)";
                                        $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                    } else {
                                        $strAbierto = "(Cerrado)";
                                        $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                    }
                                }
                            }
                        }else {
                            if ($i == 1){
                                // TODO Sergio Prueba de Diferencias de Fechas en el ultimo
                                $date11 = new DateTime($fechaFinalArray); // TODO Es mayor
                                $date22 = new DateTime("now");    // TODO Es Menor
                                $diff2 = $date11->diff($date22);
                                $anio1 = get_formatAnio($diff2);
                                $mes1 = get_formatMes($diff2);
                                $dias1 = get_formatdias($diff2);
                                $strAbierto = "";
                                if (intval($anio1) > 0){
                                    $strAbierto = "(Abierto)";
                                    $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                }else {
                                    if (intval($mes1) > 0){
                                        $strAbierto = "(Abierto)";
                                        $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                    }else {
                                        if (intval($dias1)>0){
                                            $strAbierto = "(Abierto)";
                                            $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                        } else {
                                            //throw new Exception("Sergio". print_r("Sergio", true));
                                            $strAbierto = "(Por abrise)";
                                            $arrFechasCorrespondientes[$i]  = $fechaMerge. " ". $strAbierto;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if($swAbrirAnio){
                    //throw new Exception("Sergio". print_r("Sergio", true));
                    $anterior = $limite;
                    $sinSuma = $limite +1;
                    $fechaInicioArray0  = date("d-m-Y",strtotime($request."+". $anterior. "year"));
                    $fechaFinalArray0  = date("d-m-Y",strtotime($request."+". $sinSuma. "year"));
                    $fechaMerge0 = $fechaInicioArray0 . " - " .$fechaFinalArray0;
                    $arrFechasCorrespondientes[$limite]  = $fechaMerge0. " (Por Abrirse)";
                }


                // TODo FIn
                // TODO Sergio Fin de cuando el Año que trabajo es 0 ose trabajo 2 años
            }else {
                // TODO Sergio Trabajo 1 año exacto l corresponde tambien
                if ($restaAnioFinal == -1){

                    // TODO Sergio Codigo nuevo
                        $date1 = new DateTime($request); // TODO Es mayor
                        $anioDeRequest = $date1->format("Y"); // TODO Es mayor
                        $fechaActualAnio = new DateTime("now");    // TODO Es Menor
                        $anioActualRes = $fechaActualAnio->format("Y");
                        $anioActualRes = $anioActualRes -1;
                    // TODO Sergio Codigo Fin
                    //throw new Exception("Sergio". print_r("Sergio", true));

                    //throw new Exception("Seergio". print_r($anioActualRes, true));
                       // 2020 == 2020
                    if ( intval($anioDeRequest) == intval($anioActualRes) ){
                        // TODO SERGIO RESTA QUE Siempre sera Cerrado Por que solo entro un año
                        $sumaAnioInicioAnterior = -2;
                        $sumaAnioFinalAnterior = -1;
                        $fechaInicioArrayAnterior  = date("d-m-Y",strtotime($request."+". $sumaAnioInicioAnterior. "year"));
                        $fechaFinalArrayAnterior  = date("d-m-Y",strtotime($request."+". $sumaAnioFinalAnterior. "year"));
                        $fechaMergeAnterior = $fechaInicioArrayAnterior . " - " .$fechaFinalArrayAnterior;
                        $arrFechasCorrespondientes[0]  = $fechaMergeAnterior. " ". "(Cerrado)";
                        // TODO SERGIO FIN de Prueba que Siempre sera Cerrado

                        // TODO SERGIO RESTA QUE Siempre sera Cerrado Por que solo entro un año
                        $sumaAnioInicio = -1;
                        $sumaAnioFinal = 0;
                        $fechaInicioArray  = date("d-m-Y",strtotime($request."+". $sumaAnioInicio. "year"));
                        $fechaFinalArray  = date("d-m-Y",strtotime($request."+". $sumaAnioFinal. "year"));
                        $fechaMerge = $fechaInicioArray . " - " .$fechaFinalArray;
                        $arrFechasCorrespondientes[1]  = $fechaMerge;
                        $arrFechasCorrespondientes[1]  = $fechaMerge. " ". "(Cerrado)";
                        // TODO SERGIO FIN de Prueba que Siempre sera Cerrado
                        $limite = 1;
                        for ($i = 0; $i < $limite; $i++ ){
                            $sumaAnioInicio = $i;
                            $sumaAnioFinal = $i + 1;
                            $fechaInicioArray  = date("d-m-Y",strtotime($request."+". $sumaAnioInicio. "year"));
                            $fechaFinalArray  = date("d-m-Y",strtotime($request."+". $sumaAnioFinal. "year"));
                            $fechaMerge = $fechaInicioArray . " - " .$fechaFinalArray;
                            $arrFechasCorrespondientes[2]  = $fechaMerge. " ". "(Abierto)";
                        }

                        /*$sumaAnioInicio = $limite;
                        $sumaAnioFinal = $limite + 1;
                        $fechaInicioArray  = date("d-m-Y",strtotime($request."+". $sumaAnioInicio. "year"));
                        $fechaFinalArray  = date("d-m-Y",strtotime($request."+". $sumaAnioFinal. "year"));
                        $fechaMerge = $fechaInicioArray . " - " .$fechaFinalArray;
                        $arrFechasCorrespondientes[2]  = $fechaMerge;*/

                        // TODO Sergio Prueba
                        // TODO Sergio Prueba de Diferencias de Fechas en el ultimo
                        /*$date11 = new DateTime($fechaFinalArray); // TODO Es mayor
                        $date22 = new DateTime("now");    // TODO Es Menor
                        $diff2 = $date11->diff($date22);
                        $anio1 = get_formatAnio($diff2);
                        $mes1 = get_formatMes($diff2);
                        $dias1 = get_formatdias($diff2);
                        $strAbierto = "";
                        if (intval($anio1) > 0){
                            $strAbierto = "(Abierto)";
                            $arrFechasCorrespondientes[2]  = $fechaMerge. " ". $strAbierto;
                        }else {
                            if (intval($mes1) > 0){
                                $strAbierto = "(Abierto)";
                                $arrFechasCorrespondientes[2]  = $fechaMerge. " ". $strAbierto;
                            }else {
                                if (intval($dias1)>0){
                                    $strAbierto = "(Abierto)";
                                    $arrFechasCorrespondientes[2]  = $fechaMerge. " ". $strAbierto;
                                } else {
                                    $strAbierto = "(Por abrise)";
                                    $arrFechasCorrespondientes[2]  = $fechaMerge. " ". $strAbierto;
                                }
                            }
                        }*/
                      //      throw new Exception("Seergio". print_r("dfsdfdsfsd", true));
                    }else {
                        $sumaAnioInicioAnterior = 1;
                        $sumaAnioFinalAnterior = 0;
                        $fechaInicioArrayAnterior  = date("d-m-Y",strtotime($request."-". $sumaAnioInicioAnterior. "year"));
                        $fechaFinalArrayAnterior  = date("d-m-Y",strtotime($request."+". $sumaAnioFinalAnterior. "year"));
                        $fechaMergeAnterior = $fechaInicioArrayAnterior . " - " .$fechaFinalArrayAnterior;
                        $arrFechasCorrespondientes[0]  = $fechaMergeAnterior. " ". "(Cerrado)";

                        $sumaAnioInicioAnterior = 0;
                        $sumaAnioFinalAnterior = 1;
                        $fechaInicioArrayAnterior  = date("d-m-Y",strtotime($request."-". $sumaAnioInicioAnterior. "year"));
                        $fechaFinalArrayAnterior  = date("d-m-Y",strtotime($request."+". $sumaAnioFinalAnterior. "year"));
                        $fechaMergeAnterior = $fechaInicioArrayAnterior . " - " .$fechaFinalArrayAnterior;
                        $arrFechasCorrespondientes[1]  = $fechaMergeAnterior. " ". "(Abierto)";

                        $sumaAnioInicioAnterior = 1;
                        $sumaAnioFinalAnterior = 2;
                        $fechaInicioArrayAnterior  = date("d-m-Y",strtotime($request."+". $sumaAnioInicioAnterior. "year"));
                        $fechaFinalArrayAnterior  = date("d-m-Y",strtotime($request."+". $sumaAnioFinalAnterior. "year"));
                        $fechaMergeAnterior = $fechaInicioArrayAnterior . " - " .$fechaFinalArrayAnterior;
                        $arrFechasCorrespondientes[2]  = $fechaMergeAnterior. " ". "(Por abrirse)";
                        //throw new Exception("Seergio". print_r("dfsdfdsfsd", true));
                    }
                }else {
                    // TODO Sergio cuando no coresponde
                    // TODO Sergio no Corresponde Vacacion porque la resta final es -2 por lo tanto no trabajo ni un año
                    // TODO Sergio no le corresponde nada
                    // TODO Sergio Cuando Empezo a trabajar recien ese año y no lo cumplio por lo tanto,
                    // TODO Desde su fecha inicial hasta tres años menos
                    $cnt3 = 3;
                        // TODO Sergio Fecha inicial
                    $date1 = new DateTime($request); // TODO Es mayor
                    $anioDeRequest = $date1->format("Y"); // TODO Es mayor
                    $date2 = new DateTime("now");    // TODO Es Menor
                    $anioActualRes = $date2->format("Y");

                    if (intval($anioDeRequest) == intval($anioActualRes)){
                        //throw new Exception("sergio " . print_r($anioDeRequest , true));
                        $primerAnioInicio  = date("d-m-Y",strtotime($request."- 3 year"));
                        $primerAnioFinal  = date("d-m-Y",strtotime($request."- 2 year"));
                        $mergeFechaInicial = $primerAnioInicio . " - ". $primerAnioFinal;
                        $arrFechasCorrespondientes[0] = $mergeFechaInicial . " (Cerrado)";
                        // TODO Sergio Fecha inicial Final

                        // TODO Sergio Fecha segundo
                        $segundoAnioInicio  = date("d-m-Y",strtotime($request."- 2 year"));
                        $segundoAnioFinal  = date("d-m-Y",strtotime($request."- 1 year"));
                        $mergeFechaSegundo = $segundoAnioInicio . " - ". $segundoAnioFinal;
                        $arrFechasCorrespondientes[1] = $mergeFechaSegundo. " (Cerrado)";
                        // TODO Sergio Fecha segundo Final

                        // TODO Sergio Fecha Tercera
                        $terceroAnioInicio  = date("d-m-Y",strtotime($request."- 1 year"));
                        $terceroAnioFinal  = date("d-m-Y",strtotime($request."+ 0 year"));
                        $mergeFechaTercero = $terceroAnioInicio . " - ". $terceroAnioFinal;
                        $arrFechasCorrespondientes[2] = $mergeFechaTercero. " (Por Abrirse)";
                    }
                    else {
                        $primerAnioInicio  = date("d-m-Y",strtotime($request."- 2 year"));
                        $primerAnioFinal  = date("d-m-Y",strtotime($request."- 1 year"));
                        $mergeFechaInicial = $primerAnioInicio . " - ". $primerAnioFinal;
                        $arrFechasCorrespondientes[0] = $mergeFechaInicial . " (Cerrado)";
                        // TODO Sergio Fecha inicial Final

                        $terceroAnioInicio  = date("d-m-Y",strtotime($request."- 1 year"));
                        $terceroAnioFinal  = date("d-m-Y",strtotime($request."+ 0 year"));
                        $mergeFechaTercero = $terceroAnioInicio . " - ". $terceroAnioFinal;
                        $arrFechasCorrespondientes[1] = $mergeFechaTercero. " (Cerrado)";

                        $segundoAnioInicio  = date("d-m-Y",strtotime($request."+ 0 year"));
                        $segundoAnioFinal  = date("d-m-Y",strtotime($request."+ 1 year"));
                        $mergeFechaSegundo = $segundoAnioInicio . " - ". $segundoAnioFinal;
                        $arrFechasCorrespondientes[2] = $mergeFechaSegundo. " (Por Abrirse)";
                    }
                    //$anio = get_formatAnio($diff);
                    //$diff = $date1->diff($date2);
                    //throw new Exception("sergio " . print_r($diff , true));
                        // TODO Sergio Fecha Tercera Final
                    $swNoCorrespondeNada = true;
                    // TODO Sergio
                    //$arrFechasCorrespondientes = [];
                }

            }
            $restaAnioIncio = -1;
            $restaAnioFinal = 0;
            //TODO Sergio caso contrario || Tiene que ser simpre 3
            // $inicioFechaRangoInicio = date("d-m-Y",strtotime($request."+". $restaAnioInicio. "year"));;
            $inicioFechaRangoInicio = date("d-m-Y",strtotime($request."+". $restaAnioIncio. "year"));;
            $inicioFechaRangoFinal  =  date("d-m-Y",strtotime($request."+". $restaAnioFinal. "year"));

            $inicioFechaRangoInicioSoloAnio = new DateTime($inicioFechaRangoInicio);
            $inicioFechaRangoInicioSoloAnio = $inicioFechaRangoInicioSoloAnio->format('Y');
        }

        $finalAnio = date("Y");
        $finalAnioEmpiezo = intval($finalAnio) - 3;
            // TODO Sergio Fin obtener la diferencia de los años
        if (!empty($anio)){ $anio = intval($anio); }else { $anio = 0; }
        if (!empty($mes)){ $mes = intval($mes); }else { $mes = 0; }
        if (!empty($dias)){ $dias = intval($dias); }else { $dias = 0; }

        // TODO Sergio Prueba de Diferencias de Fechas
        /*$date11 = new DateTime("04-01-2021"); // TODO Es mayor
        //$date1 = new DateTime('2021/01/01'); // TODO Es mayor
        $date22 = new DateTime("now");    // TODO Es Menor
        $diff2 = $date11->diff($date22);
        $anio1 = get_formatAnio($diff2);
        $mes1 = get_formatMes($diff2);
        $dias1 = get_formatdias($diff2);

        !empty($anio1) ? $anio1 = intval($anio1): $anio1 = 0;
        $strPrueba = "";
        $strPrueba .= $anio1. "-". $mes1 ." - ".$dias1;*/

        $response = array('diferenciaAnio'=>$anio,
                          'diferenciaMes'=>$mes,
                          'diferenciaDias'=>$dias,
                          //'inicioDeAnio'=>$limiteDelAñoRestadoDos,
                          'inicioFechaRangoInicio'=> $inicioFechaRangoInicio,
                          'inicioFechaRangoFinal' => $inicioFechaRangoFinal,
                          'inicioAnio' => $finalAnioEmpiezo,
                          'finalAnio' => $finalAnio,
                          'arrFechasCorrespondientes' => $arrFechasCorrespondientes,
                          'noCorrespondeVacacion' => $swNoCorrespondeNada
                          );

        //$arrayDatos[1]['fechaActualHorario'] = new DateTime("now");
        echo json_encode($response);
?>