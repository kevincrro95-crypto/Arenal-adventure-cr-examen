# Arenal Adventure CR

Proyecto académico de gestión turística desarrollado con PHP puro, MySQL, PDO, MVC y Programación Orientada a Objetos. El código utiliza estructuras sencillas para que pueda ser comprendido y explicado por un estudiante.

## Instalación en XAMPP

1. Copiar la carpeta `arenal_adventure_cr` dentro de `C:\xampp\htdocs`.
2. Iniciar Apache y MySQL.
3. Abrir phpMyAdmin.
4. Importar `database/01_create_database.sql`.
5. Importar `database/02_seed_data.sql`.
6. Revisar `app/config/config.php` y confirmar usuario, contraseña y URL base.
7. Abrir `http://localhost/arenal_adventure_cr/public/`.

## Usuarios de prueba

Administrador:
- Correo: `admin@arenaladventure.cr`
- Contraseña: `Admin123`

Cliente:
- Correo: `cliente@correo.com`
- Contraseña: `Admin123`

## Módulos

- Autenticación y sesiones.
- Administración de usuarios.
- CRUD de destinos, hoteles y actividades.
- Reservaciones con control de disponibilidad y cupos.
- Perfil con fotografía.
- Reportes y estadísticas.
- Clima, tipo de cambio y mapas mediante servicios externos.

## Estructura

- `app/config`: configuración.
- `app/controllers`: controladores.
- `app/core`: conexión, seguridad, autenticación y clases base.
- `app/models`: acceso a datos con PDO.
- `app/services`: consumo de APIs.
- `app/views`: vistas HTML/PHP.
- `public`: punto de entrada y recursos estáticos.
- `database`: creación y datos iniciales.
- `docs`: modelo entidad-relación, guía de defensa y verificación.
- `storage/logs`: registro de errores.

## Observaciones académicas

La recuperación de contraseña es simulada, como permite el enunciado. Cada reservación utiliza una habitación; el sistema compara las reservas activas en fechas coincidentes contra la cantidad de habitaciones del hotel. El cupo de las actividades también se controla con base en las reservaciones que coinciden en el mismo período.

## Identidad y contenido turístico

Esta versión incluye una identidad visual propia de Arenal Adventure CR con un perezoso y el Volcán Arenal, destinos de Costa Rica, hoteles reales de la zona de La Fortuna y actividades turísticas. Los montos son datos académicos de referencia para probar el sistema y no representan tarifas oficiales.

El número de WhatsApp se configura en `app/config/config.php`. Debe escribirse con el código de país, sin espacios ni guiones.

### Actualizar una base que ya estaba importada

Para conservar los usuarios y reemplazar únicamente el contenido turístico:

1. Ejecute `database/03_actualizar_contenido_turistico.sql`.
2. El script conservará los usuarios y reemplazará destinos, hoteles, actividades y reservas de prueba.

Las imágenes se cargan desde enlaces externos para mantener liviano el proyecto. El administrador puede cambiar cada URL desde los módulos CRUD.
