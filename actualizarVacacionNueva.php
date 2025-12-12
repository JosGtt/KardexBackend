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

    //throw new Exception("Sergio Morga Gestion:  ". print_r($request, true));
    //$fechaGestion = (string)$request->gestion;
    $fechaGestion = (string)$request->gestion;
    $fechaGestion = $fechaGestion.'-01-01';
    $fechaGestion = new DateTime($fechaGestion);
    $fechaGestion = $fechaGestion->format('Y-m-d');
    $gestionNumeral = intval($request->gestion);
    $corresponde = intval($request->corresponde);
    //$aCuenta = intval($request->aCuenta);
    //$queda = intval($request->queda);
    $fechaRegistroGestion = date('Y-m-d');

    $ci = intval($request->ci);

    function insertarNuevaGestion($conexion, $fechaGestion,$gestionNumeral,$fechaRegistroGestion,$ci, $corresponde){

        $sqlAnadirGestion = "  
            INSERT INTO 
            gestion (fecha,gestion, fecha_registro,ci_persona_detalle_kardex, corresponde) 
            VALUES('$fechaGestion','$gestionNumeral','$fechaRegistroGestion','$ci', '$corresponde')";

            pg_query($conexion, $sqlAnadirGestion);

            // TODO Sergio Ultimo dato de la Gestion
            $sqlMaxIdGestion =
                "SELECT MAX(id) AS id
                                     from gestion";
            $rsGestionMax = pg_query(conexionPostgresql(), $sqlMaxIdGestion);
            $maxIdGestion = pg_fetch_array($rsGestionMax, null, PGSQL_ASSOC);
            return  intval($maxIdGestion["id"]);
            //pg_close(conexionPostgresql());
    }

        // TODO Sergio Metodo para Añadir vacacion
        // TODO Sergio Solo tiene que entrar una Vez
        $idgestion = insertarNuevaGestion(conexionPostgresql(),$fechaGestion,$gestionNumeral,$fechaRegistroGestion,$ci, $corresponde);
        /*if (!empty($idgestion)){
            $sqlAnadirVacacion = "
                INSERT INTO
                vacacion (a_cuenta, queda, id_gestion)
                VALUES 
                ('$aCuenta','$queda','$idgestion')
                 ";
            pg_query(conexionPostgresql(), $sqlAnadirVacacion);
        }*/

        $arrEnviar = ["sw"=>true, "idGestion" =>$idgestion];


        echo json_encode($arrEnviar);
        pg_close(conexionPostgresql());
