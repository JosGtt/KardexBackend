<?php

    /**
     * author Sergio
     * @date 18/03/2021
     * description conexion a la base de datos
     * */
    function conexionPostgresql(){
        $usuario = 'postgres';
        $pass = "123456";
        $host = "localhost";
        $bd = "Kardex2";

        $connection = pg_connect(
            "user=".$usuario." ".
            "password=".$pass." ".
            "host=".$host." ".
            "dbname=".$bd
        ) or die ("Error al conectar: ". pg_last_error());

        return $connection;
    }


?>