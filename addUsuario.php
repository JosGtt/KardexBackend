<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require_once 'ConexionBaseDatos.php';

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    //throw new Exception("Sergio entra: ". print_r($request, true));
    if (!empty($request))
    {
        $nombre = $request->nombre;
        $paterno = $request->paterno;
        $materno = $request->materno;
        $usuario = $request->usuario;
        $password = $request->password;
        $tipoUsuario = intval($request->tipoUsuario);
        $exp = $request->exp;
        $ci = intval($request->ci);

        // TODO Encriptar contrasenia
        $password_encrip = password_hash($password, PASSWORD_DEFAULT);
        //$password_encrip = d ($password, PASSWORD_DEFAULT);

        $date = date('Y-m-d');

        // TODO Sergio  sw_admin = 2 , es administrador
        // TODO Sergio  sw_admin = 1 , es un usuario estandar
        // TODO Sergio  sw_habilitar = 2, desabilitado
        // TODO Sergio  sw_habilitar = 1, habilitado
        $sqlDetalleArchivo = "
             INSERT INTO persona (nombre, ap_paterno, ap_materno, ci, expedido)
	            VALUES ('$nombre', '$paterno', '$materno', '$ci', '$exp')";
        pg_query(conexionPostgresql(),$sqlDetalleArchivo);

            // TODO Sergio Obtenemos el ultimo id y obtenenmos la CI
            /*$sqlUltimoIdUsuario = "
                SELECT MAX(id) as maxId
                FROM persona";
            $rsUsuarioId = pg_query(conexionPostgresql(), $sqlUltimoIdUsuario);
            $maxUsuarioId = pg_fetch_array($rsUsuarioId,null, PGSQL_ASSOC);
            $maxIdUsuario = intval($maxUsuarioId["maxId"]);*/
            // TODO END
        //TODO Sergio Registramos el Usuario
        $date = date('Y-m-d');
        $sqlRegistroUsuario = "
            INSERT INTO \"Usuario\" (login,password, sw_admin, date_usuario, ci)
		    VALUES ('$usuario','$password_encrip',$tipoUsuario,'$date', '$ci')
        ";
        pg_query(conexionPostgresql(),$sqlRegistroUsuario);
        echo json_encode(true);
    }else {
        echo json_encode(false);
    }
?>