# Arenal Adventure CR

Arenal Adventure CR es un sistema web de gestion turistica enfocado en destinos, hoteles, actividades y reservaciones dentro de Costa Rica.

El proyecto fue desarrollado utilizando PHP, MySQL, PDO y la arquitectura MVC. Tambien se aplicaron algunos conceptos de Programación Orientada a Objetos, validaciones, manejo de sesiones y medidas de seguridad para proteger los datos del sistema.

## Instalación en XAMPP

1. Copiar la carpeta `arenal_adventure_cr` dentro de `C:\xampp\htdocs`.
2. Iniciar Apache y MySQL desde el panel de XAMPP.
3. Abrir phpMyAdmin desde el navegador.
4. Importar el archivo `database/01_create_database.sql`.
5. Despues importar `database/02_seed_data.sql`.
6. Revisar el archivo `app/config/config.php` para confirmar el usuario, contraseña y la URL del proyecto.
7. Abrir `http://localhost/arenal_adventure_cr/public/`.

En caso de que la base de datos ya estuviera creada y solamente se quiera actualizar los destinos, hoteles y actividades, se puede importar:

`database/03_actualizar_contenido_turistico.sql`

## Usuarios de prueba

### Administrador

- Correo: `admin@arenaladventure.cr`
- Contraseña: `Admin123`

### Cliente

- Correo: `cliente@correo.com`
- Contraseña: `Admin123`

## Funciones principales

El sistema permite realizar las siguientes funciones:

- Registro de nuevos usuarios.
- Inicio y cierre de sesión.
- Cambio de contraseña.
- Actualizar la información del perfil.
- Consultar destinos turisticos.
- Buscar hoteles y actividades.
- Realizar reservaciones.
- Consultar el historial de reservas.
- Administrar usuarios, destinos, hoteles, actividades y reservaciones.
- Visualizar reportes y estadisticas.
- Consultar el clima, tipo de cambio y ubicación de los destinos.

## Organización del proyecto

- `app/config`: contiene la configuración principal del sistema.
- `app/controllers`: contiene los controladores y la logica de los diferentes modulos.
- `app/core`: contiene la conexión, autenticación, seguridad y clases principales.
- `app/models`: contiene las consultas realizadas a la base de datos utilizando PDO.
- `app/services`: contiene el consumo de las APIs externas.
- `app/views`: contiene las pantallas que puede ver el usuario.
- `public`: contiene el archivo principal, los estilos, JavaScript e imagenes.
- `database`: contiene los archivos para crear y llenar la base de datos.
- `docs`: contiene la documentación y el modelo entidad relación.
- `storage/logs`: se utiliza para guardar los errores internos del sistema.

## Información importante

La recuperación de contraseña es simulada, ya que el enunciado permite realizarla de esta forma.

Cuando un cliente realiza una reservación, el sistema verifica la disponibilidad de habitaciones del hotel y tambien el cupo disponible de las actividades seleccionadas.

Los precios que aparecen dentro del sistema son datos de ejemplo que se utilizan para probar el funcionamiento de las reservaciones. Estos precios no representan necesariamente las tarifas reales de los hoteles o actividades.

## Identidad del proyecto

La pagina utiliza una identidad visual propia de Arenal Adventure CR, inspirada principalmente en la naturaleza de Costa Rica, el Volcán Arenal y el turismo nacional.

Se agregaron imagenes de diferentes destinos del pais, hoteles y actividades turisticas para que la pagina tenga una apariencia mas real y agradable para los usuarios.

La empresa cuenta actualmente con dos automoviles y un SUV para ofrecer el servicio de transporte privado. Por el momento no se cuenta con busetas.

El numero de WhatsApp se puede configurar en el archivo `app/config/config.php`. Este debe escribirse incluyendo el código del país, pero sin espacios ni guiones.

1. Ejecute `database/03_actualizar_contenido_turistico.sql`.
2. El script conservará los usuarios y reemplazará destinos, hoteles, actividades y reservas de prueba.

Las imágenes se cargan desde enlaces externos para mantener liviano el proyecto. El administrador puede cambiar cada URL desde los módulos CRUD.
