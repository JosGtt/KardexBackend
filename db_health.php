<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'conexionBaseDatos.php';

$response = [ 'ok' => false ];

try {
    $cn = conexionPostgresql();
    if ($cn) {
        $version = null; $database = null; $user = null;
        $r1 = @pg_query($cn, 'select version()');
        if ($r1) { $version = pg_fetch_result($r1, 0, 0); }
        $r2 = @pg_query($cn, 'select current_database()');
        if ($r2) { $database = pg_fetch_result($r2, 0, 0); }
        $r3 = @pg_query($cn, 'select current_user');
        if ($r3) { $user = pg_fetch_result($r3, 0, 0); }

        $response['ok'] = true;
        $response['connection'] = [
            'version' => $version,
            'database' => $database,
            'user' => $user
        ];
    } else {
        http_response_code(500);
        $response['error'] = 'Sin conexión';
    }
} catch (Throwable $e) {
    http_response_code(500);
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
