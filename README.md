# Music Festival

Landing page + sistema de compra de tickets para un festival de música.

## Stack

- PHP (+ MySQLi)
- JavaScript (compilado con Gulp)
- SCSS
- MySQL

## Estructura

- `index.php` — página principal (hero, about, servicios, entradas)
- `tickets.php` — flujo de compra en 3 pasos (`?paso=1/2/3&ticket=...`)
- `login.php` / `crear_cuenta.php` / `logout.php` — autenticación de usuarios
- `includes/` — funciones (`funciones.php`), config de BD (`includes/config/database.php`) y templates (`includes/templates/header.php`, `footer.php`)
- `src/scss` — estilos fuente, compilados a `build/css/app.css`
- `src/js` — scripts fuente, compilados a `build/js/bundle.min.js`

## Base de datos

Tablas principales:

- **eventos** — id_evento, nombre, lugar, fecha_evento, precio, entradas_disponibles
- **compras** — id_compra, id_evento, id_usuario, nombre_asistente, dni_asistente, email_asistente, telefono_asistente, cantidad, total, fecha_compra
- **usuarios** — id_usuario, nombre, contraseña_hash, rol, fecha_registro

El script de creación está en `music_festival.sql`.

## Instalación local

1. Clonar el repositorio
2. Importar `music_festival.sql` en MySQL
3. Configurar las credenciales de conexión en `includes/config/database.php`
4. Instalar dependencias y compilar assets:
   ```bash
   npm install
   gulp
   ```
5. Levantar el proyecto con tu servidor local (ej. `http://localhost:3000`)

## Deploy en hosting (ej. TinkerHost / hostUNO)

1. Compilar los assets localmente antes de subir (`gulp`) — el hosting gratis no corre Gulp por ti.
2. Comprimir el proyecto completo en un `.zip` y subirlo por el file manager del hosting, o subirlo directo por FTP (recomendado, evita problemas al extraer subcarpetas).
3. Si se usa el file manager, extraer el `.zip` en la carpeta pública (`htdocs`) y verificar manualmente que **todas** las subcarpetas se hayan extraído completas (`includes/`, `includes/templates/`, `build/`, etc.) — algunos extractores web pierden subcarpetas anidadas.
4. Crear la base de datos desde el panel de control (Databases / MySQL Databases) y ejecutar `music_festival.sql` sobre ella vía phpMyAdmin.
5. Actualizar `includes/config/database.php` con el host, usuario, contraseña y nombre de base de datos reales que entregue el panel (no asumir el nombre, confirmarlo tal cual aparece después de crear la BD).
6. Si aparece error 500, activar temporalmente en la primera línea de `index.php`:
   ```php
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
   ```
   para ver el error real, y quitarlo una vez resuelto.

## Autor

Proyecto personal — en desarrollo.
