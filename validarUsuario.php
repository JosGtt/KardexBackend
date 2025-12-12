<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    require_once 'ConexionBaseDatos.php';
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    /*$login = "morga";
    $password = "pruebas";*/
    $login = $request->usuario;
    $password = $request->password;

    // TODO Sergio Cifrado de contraseniaa
    //$pass_cifrado = password_hash($password, );
    $conexionPG = conexionPostgresql();
    $sqlConsultaUsuario = "
        SELECT
        \"public\".\"Usuario\".\"login\",
        \"public\".\"Usuario\".\"password\",
        \"public\".persona.nombre,
        \"public\".persona.ap_materno,
        \"public\".persona.ap_paterno,
        \"public\".\"Usuario\".sw_admin,
        \"public\".persona.ci 
        FROM
        \"public\".persona
        INNER JOIN \"public\".\"Usuario\" ON \"public\".\"Usuario\".ci = \"public\".persona.ci
        WHERE
        \"public\".\"Usuario\".\"login\" = '$login'
            -- AND \"public\".\"Usuario\".\"password\" LIKE 
            ";
        // '$password'
        $rs = pg_query($conexionPG, $sqlConsultaUsuario);

        $arrUsuarios = array();
        $contador = 0;
        $contador1 = 0;
    while ($row = pg_fetch_array($rs, null, PGSQL_ASSOC)) {
        // throw new Exception("Sergio" . print_r($row['password'], true));
        $arrUsuarios[] = $row;
        if(password_verify($password, $row['password'])){
            $contador1++;
            $contador++;
            $arrUsuarios[] = $row;
        }
        $contador++;

    }
    $mensaje = false;
    $contador > 0 ? $mensaje = true:$mensaje = false;

    $nombreUsuario = "";
    $mensajeSalida = [];

    if ($contador1 > 0){
        foreach ($arrUsuarios AS $index => $row)
        {
            $mensajeSalida['usuario'] = $row['nombre']. " ". $row['ap_paterno'] . " ". $row['ap_materno'];
            //$mensajeSalida['sw_habilitar'] = $row['sw_habilitar'];
            $mensajeSalida['swAdmin'] = $row['sw_admin'];
            $mensajeSalida['validado'] = $mensaje;
        }
    }
    echo json_encode($mensajeSalida);

?>