<?php

// TODO Para permitir el control accesos a angular
header("Access-Control-Allow-Origin: *");
// TODO Permitir recibir datos de Post utilizado en angular
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
require_once 'conexionBaseDatos.php';
/* TODO Sergio SQL Inserta datos archivos*/
// TODO Datos Recibidos del post de angular


// TODO Sergio Respuesta de los datos

    $fechaActual = date('Y-m-d');

    echo json_encode($fechaActual);
?>