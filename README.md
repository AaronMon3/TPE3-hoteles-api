# Hoteles API (básico)

Proyecto API REST simple para gestionar hoteles, tipos de habitación y habitaciones.

## Estructura

- `api_router.php` — punto de entrada y registro de rutas
- `app/controladores/` — controladores: `HotelApiController.php`, `TipoHabitacionApiController.php`, `HabitacionApiController.php`, `BaseApiController.php`
- `app/modelos/` — modelos que usan PDO para acceder a la base de datos
- `libs/router/` — router, request y response helpers
- `PAGINADO_EJEMPLO.php` — ejemplo/documentación de paginado y guía de token (archivo informativo)

## Rutas principales

Las rutas definidas en `api_router.php` incluyen (ejemplos):

- GET /habitaciones -> obtener lista de habitaciones (opciones: sort, order, page, limit)
- GET /habitaciones/{id} -> obtener habitación por id
- POST /habitaciones -> crear habitación
- PUT /habitaciones/{id} -> actualizar habitación
- DELETE /habitaciones/{id} -> borrar habitación

- GET /hoteles -> obtener lista de hoteles
- GET /hoteles/{id} -> obtener hotel por id
- POST /hoteles -> crear hotel
- PUT /hoteles/{id} -> actualizar hotel
- DELETE /hoteles/{id} -> borrar hotel

- GET /tipos -> obtener lista de tipos de habitación
- GET /tipos/{id} -> obtener tipo por id
- POST /tipos -> crear tipo
- PUT /tipos/{id} -> actualizar tipo
- DELETE /tipos/{id} -> borrar tipo

> Nota: actualmente la autenticación JWT no está implementada. Los endpoints POST/PUT/DELETE no están protegidos por token por defecto.
