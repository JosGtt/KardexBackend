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

    //throw  new Exception("Sergio: " .print_r($con, true));
    $ci = intval($request->ci);
    $cas = intval($request->cas);
    $item = intval($request->item);
    $idCargo = intval($request->cargo);
    //  TODO Sergio ArrayGestion
    $arrGestion = $request->arrGestion;

    //throw new Exception("Sergio Datos:  ". print_r($request, true));

    $date = date('Y-m-d');


        // TODO Sergio se le asigna datos de nombre a una persona
        $sqlPersona = "
                INSERT INTO persona (ap_paterno, ap_materno, nombre, ci, expedido)
                VALUES
                    ('$request->paterno',
                    '$request->materno',
                    '$request->nombres',
                    '$ci',
                    '$request->exp')";
        pg_query(conexionPostgresql(), $sqlPersona);

    /*TODO Sergio  estado 1 es habilitado,  2 es desabilitado */
    /* TODO Cuando se ingresa el estado siempre va ha ser 1 para que este habilitado */

    // TODO Sergio Query Para Añadir detalleKardex
        $sqlAnadirKardex = "
        INSERT INTO
          \"detalleKardex\" (fecha_ingreso,cas, item,estado,fecha_reg, ci_persona)
          VALUES 
        ('$request->FechaIngreso','$cas','$item',1,'$date','$ci')";
        pg_query(conexionPostgresql(), $sqlAnadirKardex);
    // TODO Sergio Fin de Query Para Añadir detalleKardex


        /* TODO Sergio Esta linea de codigo obtiene el ultimo registro del detalle kardex */
            $sqlUltimoIdDetalleKardex = "SELECT MAX(id) AS id
                                              FROM \"detalleKardex\"";

            $rsDetalleKardex = pg_query(conexionPostgresql(), $sqlUltimoIdDetalleKardex);
            $maxIdDetalleArchivo = pg_fetch_array($rsDetalleKardex,null, PGSQL_ASSOC);
            $idDetalleKardex = intval($maxIdDetalleArchivo["id"]);

        // TODO Sergio Primer Arreglo Julio 2021

            // TODO Sergio al usuario Kardex se le asigna un cargo correspondiente
            
            $sqlCargo = "
                UPDATE cargo 
                SET detalle_ci_persona = '$ci' 
                WHERE
                    id = '$idCargo'
            ";
            pg_query(conexionPostgresql(), $sqlCargo);


        // TODO Sergio Se elimino el codigo para añadir la CI de la Persona

        /* TODO Sergio Actualizacion de la gestión*/

        /* TODO Sergio id_gestion_detalle_kardex el indice del array */

        foreach($arrGestion AS $index => $row)
        {
            $fechaRegistroGestion = date('Y-m-d');

            // throw new Exception("Sergio Morga Gestion:  ". print_r($arrGestion[0]->gestion, true));
            $fechaGestion = (string)$row->gestion;
            $fechaGestion = (string)$row->gestion;
            $fechaGestion = $fechaGestion.'-01-01';
            $fechaGestion = new DateTime($fechaGestion);
            $fechaGestion = $fechaGestion->format('Y-m-d');
            $gestionNumeral = (integer)$arrGestion[$index]->gestion;
            $corresponde = (integer)$arrGestion[$index]->corresponde;
            $aCuenta = (integer)$arrGestion[$index]->aCuenta;
            $queda = (integer)$arrGestion[$index]->queda;
            // $cas = $arrTablaKardex[$index]['cas'];

            $sqlAnadirGestion = "  
                INSERT INTO 
                gestion (fecha,gestion, fecha_registro,ci_persona_detalle_kardex, corresponde) 
                VALUES('$fechaGestion','$gestionNumeral','$fechaRegistroGestion','$ci', '$corresponde')";
                pg_query(conexionPostgresql(), $sqlAnadirGestion);

                // TODO Sergio Ultimo dato de la Gestion
            $sqlMaxIdGestion =
                "SELECT MAX(id) AS id
                 from gestion";
            $rsGestionMax = pg_query(conexionPostgresql(), $sqlMaxIdGestion);
            $maxIdGestion = pg_fetch_array($rsGestionMax, null, PGSQL_ASSOC);
            $idGestionUl = intval($maxIdGestion["id"]);
            // TODO Sergio Metodo para Añadir vacacion
            $sqlAnadirVacacion = "
                INSERT INTO 
                vacacion (a_cuenta, queda, id_gestion)
                VALUES 
                ('$aCuenta','$queda',$idGestionUl)
            ";
            pg_query(conexionPostgresql(), $sqlAnadirVacacion);
        }

        echo json_encode(true);
        pg_close(conexionPostgresql());
?>