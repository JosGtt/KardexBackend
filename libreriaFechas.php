<?php

    // TODO Para permitir el control accesos a angular
    header("Access-Control-Allow-Origin: *");
    // TODO Permitir recibir datos de Post utilizado en angular
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require_once 'conexionBaseDatos.php';
    /* TODO Sergio SQL Inserta datos archivos*/
    // TODO Datos Recibidos del post de angular


    // TODO Sergio Respuesta de los datos
    date_default_timezone_set('America/La_Paz');
    $arrayDatos = [];
    $arrayDatos[0]['fechaActual'] = date('Y-m-d');
    $arrayDatos[1]['fechaActualHorario'] = new DateTime("now");

    echo json_encode($arrayDatos);
?>