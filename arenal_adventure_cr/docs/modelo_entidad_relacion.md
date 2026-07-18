# Modelo entidad-relación

```mermaid
erDiagram
    USERS ||--o{ RESERVATIONS : realiza
    USERS ||--o{ FAVORITES : guarda
    USERS ||--o{ AUDIT_LOG : genera
    DESTINATIONS ||--o{ HOTELS : contiene
    DESTINATIONS ||--o{ ACTIVITIES : ofrece
    DESTINATIONS ||--o{ FAVORITES : recibe
    HOTELS ||--o{ RESERVATIONS : recibe
    RESERVATIONS ||--o{ RESERVATION_ACTIVITIES : incluye
    ACTIVITIES ||--o{ RESERVATION_ACTIVITIES : pertenece
```

## Explicación
- Un destino puede tener muchos hoteles y actividades.
- Un usuario puede realizar varias reservaciones.
- Una reservación puede tener un hotel y varias actividades.
- La relación entre reservaciones y actividades se resuelve mediante `reservation_activities`.
- Las llaves foráneas mantienen la integridad referencial.
