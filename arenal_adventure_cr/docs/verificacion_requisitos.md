# Verificación de requerimientos

## Funcionalidades principales

- Autenticación: registro, inicio de sesión, cierre de sesión, recuperación simulada y cambio de contraseña.
- Roles: administrador y cliente.
- Usuarios: listado, creación, edición, cambio de rol, activación, desactivación y eliminación controlada.
- Destinos: CRUD y búsqueda por nombre o provincia.
- Hoteles: CRUD, asociación con destinos y control básico de habitaciones disponibles.
- Actividades: CRUD, asociación con destinos y control de cupo.
- Reservaciones: creación, historial del cliente, cambio de estado y eliminación administrativa.
- Perfil: nombre, correo, teléfono, fotografía y contraseña.
- Reportes: por destino, hotel, actividad, usuario y fecha, además de ingresos estimados.

## APIs

1. Open-Meteo: información meteorológica del destino.
2. Frankfurter: tipo de cambio para presentar precios de referencia.
3. OpenStreetMap: mapa con la ubicación del destino.

## Seguridad

- Contraseñas con `password_hash()` y `password_verify()`.
- Consultas preparadas con PDO.
- Tokens CSRF.
- Escape de salida con `htmlspecialchars()`.
- Validaciones del lado del servidor y del cliente.
- Control de acceso por sesión y rol.
- Validación de archivos de imagen por MIME y tamaño.
- Manejo de excepciones y registro interno de errores.

## Funcionalidades adicionales

- Dashboard de estadísticas.
- Filtros y búsquedas.
- Transacciones en reservaciones.
- Fotografía de perfil.
- Control de disponibilidad y cupos.

## Pruebas sugeridas

1. Registrar un cliente y comprobar que no acepta un correo repetido.
2. Iniciar sesión como administrador y crear, editar y desactivar un usuario.
3. Crear un destino, un hotel y una actividad.
4. Reservar con un cliente y revisar que quede en estado pendiente.
5. Confirmar la reservación desde el panel administrativo.
6. Intentar reservar un hotel sin habitaciones disponibles.
7. Intentar reservar una actividad superando su cupo.
8. Filtrar reportes por rango de fechas.
9. Subir una fotografía JPG, PNG o WEBP menor a 2 MB.
10. Intentar acceder al panel administrativo con un cliente.
