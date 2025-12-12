# Backend Kardex (PHP)

Backend en PHP con PostgreSQL para Railway o XAMPP.

## Estructura
- Scripts PHP en la carpeta actual (sin framework)
- Conexión DB: `conexionBaseDatos.php`

## Despliegue en Railway
1. Crea un nuevo servicio en Railway desde este repo (esta carpeta como raíz).
2. Start Command (Procfile): `php -S 0.0.0.0:$PORT -t .`
3. Variables (si usas variables): `POSTGRES_HOST`, `POSTGRES_DB`, `POSTGRES_USER`, `POSTGRES_PASSWORD`.
4. Asegura que la URL pública está accesible; las rutas son por archivo, por ejemplo:
   - `/backKardex/validarUsuario.php`
   - `/backKardex/consultaTablakardex.php`
   - `/backKardex/db_health.php` (chequeo rápido de conexión)

> Nota: Actualmente `conexionBaseDatos.php` está configurado con credenciales de Railway hardcodeadas. Puedes migrarlo a variables de entorno si lo prefieres.
> Actualizado: ahora lee `DATABASE_URL` o `POSTGRES_*` con fallback local.

## Despliegue con Docker (Railway / cualquier plataforma)

### Backend (PHP 7.4)
Imagen definida en `Dockerfile` (php:7.4-cli + pgsql). El contenedor escucha en `$PORT`.

Build local:

```bash
docker build -t kardex-backend .
docker run --rm -e PORT=8080 -e DATABASE_URL="postgres://user:pass@host:5432/db" -p 8080:8080 kardex-backend
```

En Railway, selecciona "Deploy from Dockerfile" y define variables de entorno (`DATABASE_URL` o `POSTGRES_*`).


## Despliegue en XAMPP (Windows)
1. Instala PostgreSQL (v9.6+ recomendado). 
2. En `php.ini` habilita: `extension=pgsql` y `extension=pdo_pgsql`.
3. Copia `libpq.dll` de PostgreSQL a `xampp\apache\bin` si es necesario.
4. Coloca esta carpeta dentro de `htdocs` o configura un VirtualHost.
5. Ajusta `conexionBaseDatos.php` con host/puerto/credenciales locales.

## Requisitos
- PHP 7.4+ (probado también en 8.x)
- Extensiones: `pgsql`, `pdo_pgsql`

## Endpoints principales
- `validarUsuario.php`
- `consultaTablakardex.php`
- `addArchivoKardex.php`
- `tablaUsuario.php`
- ...
