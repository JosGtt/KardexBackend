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

//  throw new Exception("Sergio ". print_r($request, true));


if (!empty($request->estado) AND !empty($request->ap_paterno) AND !empty($request->ap_materno) AND !empty($request->nombre) AND !empty($request->ci))
{
    $estado = intval($request->estado);
    $paterno = strtoupper($request->ap_paterno);
    $paterno = '%'.$paterno.'%';
    $materno = strtoupper($request->ap_materno);
    $materno = '%'.$materno.'%';
    $nombre = strtoupper($request->nombre);
    $nombre = '%'.$nombre.'%';
    $ci = intval($request->ci);

    $strFrom = "
            \"public\".\"detalleKardex\"
              WHERE
                UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND 
                UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND 
                UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                \"public\".\"detalleKardex\".ci = '$ci' AND 
                \"public\".\"detalleKardex\".estado = '$estado'
            ORDER BY 
            \"public\".\"detalleKardex\".item
        ";
} else {
    if (!empty($request->estado) AND !empty($request->ap_paterno) AND !empty($request->ap_materno) AND !empty($request->nombre))
    {

        $estado = intval($request->estado);
        $paterno = strtoupper($request->ap_paterno);
        $paterno = '%'.$paterno.'%';
        $materno = strtoupper($request->ap_materno);
        $materno = '%'.$materno.'%';
        $nombre = strtoupper($request->nombre);
        $nombre = '%'.$nombre.'%';

        $strFrom = "
                \"public\".\"detalleKardex\"
                WHERE
                UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND 
                UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND 
                UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                \"public\".\"detalleKardex\".estado = '$estado'
                ORDER BY 
                \"public\".\"detalleKardex\".item   
            ";

    }else {
        if (!empty($request->ci) AND !empty($request->ap_paterno) AND !empty($request->ap_materno) AND !empty($request->nombre)){

            $paterno = strtoupper($request->ap_paterno);
            $paterno = '%'.$paterno.'%';
            $materno = strtoupper($request->ap_materno);
            $materno = '%'.$materno.'%';
            $nombre = strtoupper($request->nombre);
            $nombre = '%'.$nombre.'%';
            $ci = intval($request->ci);

            $strFrom = "
                    \"public\".\"detalleKardex\"
                        WHERE
                        UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND 
                        UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND 
                        UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                        \"public\".\"detalleKardex\".ci = '$ci'
                        ORDER BY 
                        \"public\".\"detalleKardex\".item
                    ";
        }else {
            if(!empty($request->ap_paterno) AND !empty($request->ap_materno) AND !empty($request->estado) AND !empty($request->ci)){
                $estado = intval($request->estado);
                $paterno = strtoupper($request->ap_paterno);
                $paterno = '%'.$paterno.'%';
                $materno = strtoupper($request->ap_materno);
                $materno = '%'.$materno.'%';
                $ci = intval($request->ci);

                $strFrom = "
                        \"public\".\"detalleKardex\"
                        WHERE
                        UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND 
                        UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                        \"public\".\"detalleKardex\".ci = '$ci' AND 
                        \"public\".\"detalleKardex\".estado = '$estado'
                        ORDER BY 
                        \"public\".\"detalleKardex\".item
                    ";
            }else {
                if ( !empty($request->nombre)  AND !empty($request->estado) AND !empty($request->ci) AND !empty($request->ap_paterno)){
                    $estado = intval($request->estado);
                    $paterno = strtoupper($request->ap_paterno);
                    $paterno = '%'.$paterno.'%';
                    $nombre = strtoupper($request->nombre);
                    $nombre = '%'.$nombre.'%';
                    $ci = intval($request->ci);

                    $strFrom = "
                            \"public\".\"detalleKardex\"
                            WHERE
                            UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND 
                            UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND  
                            \"public\".\"detalleKardex\".ci = '$ci' AND 
                            \"public\".\"detalleKardex\".estado = '$estado'
                            ORDER BY 
                            \"public\".\"detalleKardex\".item
                        ";
                }else {
                    if (!empty($request->estado) AND !empty($request->ap_paterno) AND !empty($request->ap_materno)){
                        $estado = intval($request->estado);
                        $paterno = strtoupper($request->ap_paterno);
                        $paterno = '%'.$paterno.'%';
                        $materno = strtoupper($request->ap_materno);
                        $materno = '%'.$materno.'%';

                        $strFrom = "
                                \"public\".\"detalleKardex\"
                                WHERE
                                UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND 
                                UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                                \"public\".\"detalleKardex\".estado = '$estado'
                                ORDER BY 
                                \"public\".\"detalleKardex\".item
                            ";
                    }else {
                        if (!empty($request->estado) AND !empty($request->ap_paterno) AND !empty($request->nombre)){
                            $estado = intval($request->estado);
                            $paterno = strtoupper($request->ap_paterno);
                            $paterno = '%'.$paterno.'%';
                            $nombre = strtoupper($request->nombre);
                            $nombre = '%'.$nombre.'%';

                            $strFrom = "
                                    \"public\".\"detalleKardex\"
                                    WHERE
                                    UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND 
                                    UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND 
                                    \"public\".\"detalleKardex\".estado = '$estado'
                                    ORDER BY 
                                    \"public\".\"detalleKardex\".item
                                ";
                        }else {
                            if (!empty($request->estado) AND !empty($request->ap_materno) AND !empty($request->nombre)){
                                $estado = intval($request->estado);
                                $materno = strtoupper($request->ap_materno);
                                $materno = '%'.$materno.'%';
                                $nombre = strtoupper($request->nombre);
                                $nombre = '%'.$nombre.'%';

                                $strFrom = "
                                        \"public\".\"detalleKardex\"
                                        WHERE
                                        UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND 
                                        UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND  
                                        \"public\".\"detalleKardex\".estado = '$estado'
                                        ORDER BY 
                                        \"public\".\"detalleKardex\".item
                                    ";
                            }else {
                                if (!empty($request->estado) AND !empty($request->ci) AND !empty($request->ap_paterno)){
                                    $estado = intval($request->estado);
                                    $paterno = strtoupper($request->ap_paterno);
                                    $paterno = '%'.$paterno.'%';
                                    $ci = intval($request->ci);

                                    $strFrom = "
                                            \"public\".\"detalleKardex\"
                                            WHERE
                                            UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND 
                                            UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND 
                                            UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                                            \"public\".\"detalleKardex\".ci = '$ci' AND 
                                            \"public\".\"detalleKardex\".estado = '$estado'
                                            ORDER BY 
                                            \"public\".\"detalleKardex\".item
                                        ";
                                }else {
                                    if (!empty($request->ap_paterno) AND !empty($request->ap_materno) AND !empty($request->nombre)){

                                        $paterno = strtoupper($request->ap_paterno);
                                        $paterno = '%'.$paterno.'%';
                                        $materno = strtoupper($request->ap_materno);
                                        $materno = '%'.$materno.'%';
                                        $nombre = strtoupper($request->nombre);
                                        $nombre = '%'.$nombre.'%';

                                        $strFrom = "
                                            \"public\".\"detalleKardex\"
                                            WHERE
                                            UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND 
                                            UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND 
                                            UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                                            ORDER BY 
                                            \"public\".\"detalleKardex\".item
                                            ";
                                    }else {
                                        if(!empty($request->ap_paterno) AND !empty($request->ap_materno) AND !empty($request->ci)){
                                            $paterno = strtoupper($request->ap_paterno);
                                            $paterno = '%'.$paterno.'%';
                                            $materno = strtoupper($request->ap_materno);
                                            $materno = '%'.$materno.'%';
                                            $ci = intval($request->ci);

                                            $strFrom = "
                                                \"public\".\"detalleKardex\"
                                                WHERE 
                                                UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND 
                                                UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                                                \"public\".\"detalleKardex\".ci = '$ci' AND 
                                                ORDER BY 
                                                \"public\".\"detalleKardex\".item
                                                ";
                                        }else {
                                            if (!empty($request->ap_materno) AND !empty($request->ci) AND !empty($request->estado)){
                                                $estado = intval($request->estado);
                                                $materno = strtoupper($request->ap_materno);
                                                $materno = '%'.$materno.'%';
                                                $ci = intval($request->ci);

                                                $strFrom = "
                                                        \"public\".\"detalleKardex\"
                                                        WHERE
                                                        UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                                                        \"public\".\"detalleKardex\".ci = '$ci' AND 
                                                        \"public\".\"detalleKardex\".estado = '$estado'
                                                        ORDER BY 
                                                        \"public\".\"detalleKardex\".item
                                                    ";
                                            }else {
                                                if (!empty($request->estado) AND !empty($request->nombre) AND !empty($request->ci)){

                                                    $estado = intval($request->estado);
                                                    $nombre = strtoupper($request->nombre);
                                                    $nombre = '%'.$nombre.'%';
                                                    $ci = intval($request->ci);

                                                    $strFrom = "
                                                            \"public\".\"detalleKardex\"
                                                            WHERE
                                                            UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND  
                                                            \"public\".\"detalleKardex\".ci = '$ci' AND 
                                                            \"public\".\"detalleKardex\".estado = '$estado'
                                                            ORDER BY 
                                                            \"public\".\"detalleKardex\".item
                                                        ";
                                                }else {
                                                    if (!empty($request->estado) AND !empty($request->ci) AND !empty($request->ap_materno)){

                                                        $estado = intval($request->estado);
                                                        $materno = strtoupper($request->ap_materno);
                                                        $materno = '%'.$materno.'%';
                                                        $ci = intval($request->ci);

                                                        $strFrom = "
                                                                \"public\".\"detalleKardex\"
                                                                WHERE
                                                                UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                                                                \"public\".\"detalleKardex\".ci = '$ci' AND 
                                                                \"public\".\"detalleKardex\".estado = '$estado'
                                                                ORDER BY 
                                                                \"public\".\"detalleKardex\".item
                                                            ";
                                                    }else {
                                                        if (!empty($request->estado) AND !empty($request->ap_paterno) ){
                                                            $estado = intval($request->estado);
                                                            $paterno = strtoupper($request->ap_paterno);
                                                            $paterno = '%'.$paterno.'%';
                                                            $strFrom = "
                                                                    \"public\".\"detalleKardex\"
                                                                    WHERE                                                                
                                                                    UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND                                                                 
                                                                    \"public\".\"detalleKardex\".estado = '$estado'
                                                                    ORDER BY 
                                                                    \"public\".\"detalleKardex\".item
                                                                ";
                                                        }else {

                                                            if (!empty($request->estado) AND !empty($request->nombre)){
                                                                $estado = intval($request->estado);
                                                                $nombre = strtoupper($request->nombre);
                                                                $nombre = '%'.$nombre.'%';

                                                                $strFrom = "
                                                                        \"public\".\"detalleKardex\"
                                                                        WHERE
                                                                        UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND                                                                    
                                                                        \"public\".\"detalleKardex\".estado = '$estado'
                                                                        ORDER BY 
                                                                        \"public\".\"detalleKardex\".item
                                                                    ";
                                                            }else {
                                                                if(!empty($request->estado)  AND !empty($request->ap_materno)){
                                                                    $estado = intval($request->estado);
                                                                    $materno = strtoupper($request->ap_materno);
                                                                    $materno = '%'.$materno.'%';

                                                                    $strFrom = "
                                                                            \"public\".\"detalleKardex\"
                                                                            WHERE                                                                      
                                                                            UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                                                                            \"public\".\"detalleKardex\".estado = '$estado'
                                                                            ORDER BY 
                                                                            \"public\".\"detalleKardex\".item
                                                                        ";
                                                                }else {
                                                                    if (!empty($request->estado) AND !empty($request->ci)){
                                                                        $estado = intval($request->estado);
                                                                        $ci = intval($request->ci);

                                                                        $strFrom = "
                                                                            \"public\".\"detalleKardex\"
                                                                            WHERE                                                                          
                                                                            \"public\".\"detalleKardex\".ci = '$ci' AND 
                                                                            \"public\".\"detalleKardex\".estado = '$estado'
                                                                            ORDER BY 
                                                                            \"public\".\"detalleKardex\".item
                                                                            ";
                                                                    }else {
                                                                        if (!empty($request->ap_paterno) AND !empty($request->nombre)){

                                                                            $paterno = strtoupper($request->ap_paterno);
                                                                            $paterno = '%'.$paterno.'%';
                                                                            $nombre = strtoupper($request->nombre);
                                                                            $nombre = '%'.$nombre.'%';

                                                                            $strFrom = "
                                                                                \"public\".\"detalleKardex\"
                                                                                WHERE
                                                                                UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND 
                                                                                UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno'                                                                       
                                                                                ORDER BY 
                                                                                \"public\".\"detalleKardex\".item
                                                                                ";
                                                                        }else {
                                                                            if (!empty($request->ap_materno) AND !empty($request->nombre)){
                                                                                $materno = strtoupper($request->ap_materno);
                                                                                $materno = '%'.$materno.'%';
                                                                                $nombre = strtoupper($request->nombre);
                                                                                $nombre = '%'.$nombre.'%';

                                                                                $strFrom = "
                                                                                        \"public\".\"detalleKardex\"
                                                                                        WHERE
                                                                                        UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND 
                                                                                        UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE  '$materno'                                                                       
                                                                                        ORDER BY 
                                                                                        \"public\".\"detalleKardex\".item
                                                                                        ";
                                                                            }else {
                                                                                if (empty($request->nombre) AND !empty($request->ci))
                                                                                {
                                                                                    $nombre = strtoupper($request->nombre);
                                                                                    $nombre = '%'.$nombre.'%';
                                                                                    $ci = intval($request->ci);

                                                                                    $strFrom = "
                                                                                        \"public\".\"detalleKardex\"
                                                                                        WHERE
                                                                                        UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre' AND                                                                                         
                                                                                        \"public\".\"detalleKardex\".ci = '$ci'                                                                                       
                                                                                        ORDER BY 
                                                                                        \"public\".\"detalleKardex\".item
                                                                                        ";
                                                                                }else {
                                                                                    if (!empty($request->ap_paterno) AND !empty($request->ci))
                                                                                    {
                                                                                        $paterno = strtoupper($request->ap_paterno);
                                                                                        $paterno = '%'.$paterno.'%';
                                                                                        $ci = intval($request->ci);

                                                                                        $strFrom = "
                                                                                            \"public\".\"detalleKardex\"
                                                                                            WHERE                                                                                            
                                                                                            UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND                                                                                             
                                                                                            \"public\".\"detalleKardex\".ci = '$ci' AND                                                                                            
                                                                                            ORDER BY 
                                                                                            \"public\".\"detalleKardex\".item
                                                                                            ";
                                                                                    }else {
                                                                                        if (!empty($request->ap_paterno) AND !empty($request->ap_materno))
                                                                                        {
                                                                                            $paterno = strtoupper($request->ap_paterno);
                                                                                            $paterno = '%'.$paterno.'%';
                                                                                            $materno = strtoupper($request->ap_materno);
                                                                                            $materno = '%'.$materno.'%';
                                                                                            $strFrom = "
                                                                                                \"public\".\"detalleKardex\"
                                                                                                WHERE                                                                                                 
                                                                                                UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno' AND 
                                                                                                UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno'                                                                                             
                                                                                                ORDER BY 
                                                                                                \"public\".\"detalleKardex\".item
                                                                                                ";
                                                                                        }else {
                                                                                            if (!empty($request->ap_materno) AND !empty($request->ci))
                                                                                            {
                                                                                                $materno = strtoupper($request->ap_materno);
                                                                                                $materno = '%'.$materno.'%';
                                                                                                $ci = intval($request->ci);
                                                                                                $strFrom = "
                                                                                                    \"public\".\"detalleKardex\"
                                                                                                    WHERE                                                                                                   
                                                                                                    UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno' AND 
                                                                                                    \"public\".\"detalleKardex\".ci = '$ci'
                                                                                                    ORDER BY 
                                                                                                    \"public\".\"detalleKardex\".item
                                                                                                    ";
                                                                                            }else {
                                                                                                if (!empty($request->estado)){
                                                                                                    $estado = intval($request->estado);
                                                                                                    $strFrom = "
                                                                                                            \"public\".\"detalleKardex\"
                                                                                                            WHERE                                                                                                            
                                                                                                            \"public\".\"detalleKardex\".estado = '$estado'
                                                                                                            ORDER BY 
                                                                                                            \"public\".\"detalleKardex\".item
                                                                                                            ";
                                                                                                }else {
                                                                                                    if (!empty($request->ap_paterno)){
                                                                                                        $paterno = strtoupper($request->ap_paterno);
                                                                                                        $paterno = '%'.$paterno.'%';
                                                                                                        $strFrom = "
                                                                                                                \"public\".\"detalleKardex\"
                                                                                                                WHERE                                                                                                              
                                                                                                                UPPER(\"public\".\"detalleKardex\".ap_paterno) LIKE  '$paterno'                                                                                                                
                                                                                                                ORDER BY 
                                                                                                                \"public\".\"detalleKardex\".item
                                                                                                                ";
                                                                                                    }else {
                                                                                                        if (!empty($request->ap_materno))
                                                                                                        {
                                                                                                            $materno = strtoupper($request->ap_materno);
                                                                                                            $materno = '%'.$materno.'%';

                                                                                                            $strFrom = "
                                                                                                                \"public\".\"detalleKardex\"
                                                                                                                WHERE                                                                                                                                                                                                                                 
                                                                                                                UPPER(\"public\".\"detalleKardex\".ap_materno) LIKE '$materno'                                                                                                                 
                                                                                                                ORDER BY 
                                                                                                                \"public\".\"detalleKardex\".item
                                                                                                                ";
                                                                                                        }else {
                                                                                                            if (!empty($request->nombre))
                                                                                                            {
                                                                                                                $nombre = strtoupper($request->nombre);
                                                                                                                $nombre = '%'.$nombre.'%';

                                                                                                                $strFrom = "
                                                                                                                    \"public\".\"detalleKardex\"
                                                                                                                    WHERE
                                                                                                                    UPPER(\"public\".\"detalleKardex\".nombres) LIKE '$nombre'                                                                                                                  
                                                                                                                    ORDER BY 
                                                                                                                    \"public\".\"detalleKardex\".item
                                                                                                                    ";
                                                                                                            } else {
                                                                                                                if (!empty($request->ci))
                                                                                                                {
                                                                                                                    $ci = intval($request->ci);
                                                                                                                    $strFrom = "
                                                                                                                        \"public\".\"detalleKardex\"
                                                                                                                        WHERE                                                                                                                        
                                                                                                                        \"public\".\"detalleKardex\".ci = '$ci' AND                                                                                                                         
                                                                                                                        ORDER BY 
                                                                                                                        \"public\".\"detalleKardex\".item
                                                                                                                        ";
                                                                                                                }else {

                                                                                                                    if(!empty($request->cas)){
                                                                                                                        $cas = intval($request->cas);
                                                                                                                        $strFrom = "
                                                                                                                                \"public\".\"detalleKardex\"
                                                                                                                                WHERE
                                                                                                                              \"public\".\"detalleKardex\".cas = '$cas'                                                                                                              
                                                                                                                                ORDER BY 
                                                                                                                                \"public\".\"detalleKardex\".item
                                                                                                                                ";
                                                                                                                    }else {
                                                                                                                        if ($request->fecha_ingreso !== "0000-00-00"){
                                                                                                                            $strFrom = "
                                                                                                                                \"public\".\"detalleKardex\"
                                                                                                                                WHERE
                                                                                                                               \"public\".\"detalleKardex\".fecha_ingreso = '$request->fecha_ingreso'                                                                                                              
                                                                                                                                ORDER BY 
                                                                                                                                \"public\".\"detalleKardex\".item
                                                                                                                                ";

                                                                                                                        }else {
                                                                                                                            $strFrom = "
                                                                                                                                \"public\".\"detalleKardex\"                                                                                                                                                                                                                                               
                                                                                                                                ORDER BY 
                                                                                                                                \"public\".\"detalleKardex\".item
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
}

$sqlTablaKardex = "
                        SELECT
                        \"public\".\"detalleKardex\".\"id\",
                        \"public\".\"detalleKardex\".ap_paterno,
                        \"public\".\"detalleKardex\".ap_materno,
                        \"public\".\"detalleKardex\".nombres,
                        \"public\".\"detalleKardex\".ci,
                        \"public\".\"detalleKardex\".fecha_ingreso,
                        \"public\".\"detalleKardex\".cas,
                        \"public\".\"detalleKardex\".cargo,
                        \"public\".\"detalleKardex\".item,
                        \"public\".\"detalleKardex\".estado
                        FROM
                        $strFrom 
                    ";

$arrTablaKardex = array();

$rs = pg_query(conexionPostgresql(), $sqlTablaKardex);

while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC))
{
    $arrTablaKardex[] = $row;
}


$cnt = 0;
foreach($arrTablaKardex AS $index => $row)
{
    $cnt++;
    // $row->item;
    $idItem =  $arrTablaKardex[$index]['item'];
    $cas = $arrTablaKardex[$index]['cas'];

    $sqlTotalDias = "        
                            SELECT
                            -- \"public\".\"aCuentaVacacion\".id_item,
                            SUM(\"public\".\"aCuentaVacacion\".total_dias) AS total
                            FROM
                            \"public\".\"aCuentaVacacion\"
                            WHERE
                            \"public\".\"aCuentaVacacion\".id_item = '$idItem'
                            GROUP BY  \"public\".\"aCuentaVacacion\".id_item
                        ";

    $rsTotal = pg_query(conexionPostgresql(), $sqlTotalDias);

    $row = pg_fetch_array($rsTotal, null, PGSQL_ASSOC);

    $arrTablaKardex[$index]['indice'] = $cnt;


    //throw new Exception("Sergio Datos" . print_r($totalDias, true));

    if($cas >= 1 && $cas <= 4){
        $arrTablaKardex[$index]['cantidad_vacaciones'] = 15;
    }else{
        if($cas >= 5 && $cas < 10){
            $arrTablaKardex[$index]['cantidad_vacaciones'] = 20;
        }else {
            if($cas >= 10){
                $arrTablaKardex[$index]['cantidad_vacaciones'] = 30;
            }else {
                $arrTablaKardex[$index]['cantidad_vacaciones'] = 0;
            }
        }
    }

    // dias Sacados
    $totalDias =  $row['total'];
    if (!empty($totalDias)){
        $arrTablaKardex[$index]['total_dias_a_cuenta'] = $totalDias;
        $arrTablaKardex[$index]['queda'] =  $arrTablaKardex[$index]['cantidad_vacaciones'] - $totalDias ;


    }else{
        $arrTablaKardex[$index]['total_dias_a_cuenta'] = 0;
        $arrTablaKardex[$index]['queda'] = $arrTablaKardex[$index]['cantidad_vacaciones'];
    }
}





echo json_encode($arrTablaKardex);
?>