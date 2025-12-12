<?php

    /**
     * author Sergio
     * @date 18/03/2021
     * description conexion a la base de datos
     * 
     * Modo de configuración (en orden de prioridad):
     *  1) DATABASE_URL (postgres://user:pass@host:port/db?sslmode=...)
     *  2) Variables POSTGRES_* (POSTGRES_HOST, POSTGRES_PORT, POSTGRES_DB, POSTGRES_USER, POSTGRES_PASSWORD)
     *  3) Valores por defecto (desarrollo local / XAMPP)
     */
    function conexionPostgresql(){
        $usuario = null;
        $pass = null;
        $host = null;
        $bd = null;
        $puerto = null;
        $sslmode = null;

        // ============================================================
        // 1) DATABASE_URL (formato URL)
        // ============================================================
        $databaseUrl = getenv('DATABASE_URL');
        if ($databaseUrl && strpos($databaseUrl, '://') !== false) {
            $parts = parse_url($databaseUrl);
            if ($parts !== false) {
                $usuario = isset($parts['user']) ? $parts['user'] : $usuario;
                $pass    = isset($parts['pass']) ? $parts['pass'] : $pass;
                $host    = isset($parts['host']) ? $parts['host'] : $host;
                $puerto  = isset($parts['port']) ? $parts['port'] : $puerto;
                if (isset($parts['path'])) {
                    $bd = ltrim($parts['path'], '/');
                }
                // Leer parámetros de query (ej: sslmode=require)
                if (isset($parts['query'])) {
                    parse_str($parts['query'], $q);
                    if (isset($q['sslmode'])) {
                        $sslmode = $q['sslmode'];
                    }
                }
            }
        }

        // ============================================================
        // 2) Variables POSTGRES_* / PG*
        // ============================================================
        if ($host === null) {
            $host = getenv('POSTGRES_HOST') ?: getenv('PGHOST') ?: 'postgres.railway.internal';
        }
        if ($puerto === null) {
            $puerto = getenv('POSTGRES_PORT') ?: getenv('PGPORT') ?: '5432';
        }
        if ($bd === null) {
            $bd = getenv('POSTGRES_DB') ?: getenv('PGDATABASE') ?: 'railway';
        }
        if ($usuario === null) {
            $usuario = getenv('POSTGRES_USER') ?: getenv('PGUSER') ?: 'postgres';
        }
        if ($pass === null) {
            $pass = getenv('POSTGRES_PASSWORD') ?: getenv('PGPASSWORD') ?: '';
        }
        if ($sslmode === null) {
            $sslmode = getenv('PGSSLMODE') ?: null; // opcional
        }

        // ============================================================
        // 3) Fallback local (XAMPP)
        // ============================================================
        // Si no hay password definida, asumimos entorno local por defecto
        if ($pass === '') {
            // Valores típicos de desarrollo local
            $usuario = 'postgres';
            $pass = '123456';
            $host = 'localhost';
            $bd = 'Kardex2';
            $puerto = '5432';
        }

        $connStr =
            "host=".$host." ".
            "port=".$puerto." ".
            "dbname=".$bd." ".
            "user=".$usuario." ".
            "password=".$pass;
        if ($sslmode) {
            $connStr .= " sslmode=".$sslmode;
        }

        $connection = @pg_connect($connStr);
        if (!$connection) {
            die("Error al conectar: ". pg_last_error());
        }

        return $connection;
    }

    // ============================================================
    // INSTRUCCIONES PARA RAILWAY:
    // ============================================================
    // Opción A (recomendada): Configura DATABASE_URL en la app PHP
    //    Ej: postgres://USER:PASS@HOST:5432/DB?sslmode=require
    // Opción B: Configura variables individuales:
    //    - POSTGRES_HOST
    //    - POSTGRES_PORT
    //    - POSTGRES_DB
    //    - POSTGRES_USER
    //    - POSTGRES_PASSWORD
    // Luego redeploy la aplicación.
    // ============================================================

?>