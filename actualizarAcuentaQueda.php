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

    //throw new Exception("Sergio Morga Gestion: aaaaaa  ". print_r($request, true));
    //$fechaGestion = (string)$request->gestion;
    $idGestion = (string)$request->idGestion;
    $aCuenta = (string)$request->aCuenta;
    $queda = (string)$request->queda;

    $sqlAnadirVacacion = "
            INSERT INTO
            vacacion (a_cuenta, queda, id_gestion)
            VALUES 
            ('$aCuenta','$queda','$idGestion')
             ";
    pg_query(conexionPostgresql(), $sqlAnadirVacacion);


    echo json_encode(true);
    pg_close(conexionPostgresql());
