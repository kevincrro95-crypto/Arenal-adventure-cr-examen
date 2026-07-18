# Guía corta para defender el proyecto

## ¿Qué es MVC?
MVC separa el programa en modelos, vistas y controladores. Los modelos consultan la base de datos, las vistas muestran HTML y los controladores reciben la solicitud y deciden qué hacer.

## ¿Por qué PDO?
PDO permite conectarse a MySQL y usar consultas preparadas. Esto ayuda a evitar inyección SQL.

## Seguridad aplicada
- `password_hash()` y `password_verify()` para contraseñas.
- Sesiones para conservar al usuario autenticado.
- `session_regenerate_id()` al iniciar sesión.
- Token CSRF en formularios importantes.
- `htmlspecialchars()` al mostrar datos.
- Validaciones de correo, fechas y números.
- Rutas protegidas para administrador y cliente.
- Errores registrados en `storage/logs/app.log`.

## APIs
Open-Meteo muestra el clima actual usando latitud y longitud. Frankfurter obtiene el tipo de cambio de dólar a colón. OpenStreetMap presenta la ubicación del destino.

## Punto importante
La reservación usa una transacción. Si falla el hotel o una actividad, todos los cambios se revierten para no guardar una reservación incompleta.
