<?php
        // TODO Para permitir el control accesos a angular
        header("Access-Control-Allow-Origin: *");
        // TODO Permitir recibir datos de Post utilizado en angular
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

        require_once 'ConexionBaseDatos.php';

        // TODO Datos Recibidos del post de angular
        $postdata = file_get_contents("php://input");

        // TODO Sergio Respuesta de los datos
        $request = json_decode($postdata);

        // throw new Exception("Sergio Prueba Datos" . print_r($request, true));
        $id = intval($request->id);
        $ap_paterno = $request->ap_paterno;
        $ap_materno = $request->ap_materno;
        $nombres= $request->nombres;
        $ci = intval($request->ci);
        $fecha_ingreso= $request->fecha_ingreso;
        $cas= intval($request->cas);
        $cargo =  intval($request->cargo); // TODO Sergio el Cargo es el ID
        $item= intval($request->item);
        $unidad = intval($request->unidad);


        $conexionPG = conexionPostgresql();
        /* TODO Sergio Actualizacion detalle Kardex */
                $sqlActualizacion = "
                    UPDATE \"detalleKardex\"
                        SET 
                        fecha_ingreso = '$fecha_ingreso',
                        cas = '$cas',
                        item = '$item'
                        WHERE id = '$id'		   
                 ";
                pg_query($conexionPG, $sqlActualizacion);
        /* TODO END Sergio Actualizacion detalle Kardex*/
        /* TODO Sergio Actualizacion Persona*/
                $sqlEditarPersona = "
                        UPDATE persona
                        SET 
                        ap_materno = '$ap_materno',
                        ap_paterno = '$ap_paterno',
                        nombre = '$nombres'
                        WHERE  ci = '$ci'
                ";
                pg_query($conexionPG, $sqlEditarPersona);
        /* TODO Sergio Fin Actualizacion Persona*/

        /* TODO Sergio Borrar la CI de Identidad del detalle Kardex */
                $sqlBuscarId = "
                        SELECT
                           \"public\".cargo.\"id\",
                           \"public\".cargo.detalle_ci_persona
                        FROM
                          \"public\".cargo
                        WHERE
                        \"public\".cargo.detalle_ci_persona = '$ci'
                ";
                $resSqlCargo = pg_query(conexionPostgresql(),$sqlBuscarId);

                while($row = pg_fetch_array($resSqlCargo, null, PGSQL_ASSOC)){
                        $idCargoAntiguo = $row['id'];
                }

                $sqlBorrarDetalleKardexCi = "
                        UPDATE cargo 
                        SET
                        detalle_ci_persona = null
                        WHERE id = '$idCargoAntiguo'";
                pg_query(conexionPostgresql(),$sqlBorrarDetalleKardexCi);
        /* TODO Sergio Borrar la CI de Identidad del detalle Kardex */

                /* TODO Sergio Asignar nuevo Cargo con la CI en Detalle Kardex */
                $sqlNuevoCargo = "
                        UPDATE cargo 
                        SET
                        detalle_ci_persona = '$ci'
                        WHERE id = '$cargo'";
                pg_query(conexionPostgresql(),$sqlNuevoCargo);

                /* TODO Sergio Fin Asignar nuevo Cargo con la CI en Detalle Kardex */

                $mensaje = 1;
                echo json_encode($mensaje);

?>