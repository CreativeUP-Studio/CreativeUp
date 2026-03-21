# Base de Datos

## Diagrama de Relaciones

```
users ──────────┐
   │            │
   │ 1:N        │ 1:N
   ▼            ▼
  posts      lead_replies
                │
                │ N:1
                ▼
services ──── leads
   1:N         1:N

projects
   │
   ├── 1:N ──► project_images
   │
   └── 1:N ──► project_steps
```

## Tablas

### `users`

| Columna           | Tipo         | Notas              |
| ----------------- | ------------ | ------------------ |
| id                | bigint       | PK, auto-increment |
| name              | varchar      | Nombre del usuario |
| email             | varchar      | Único              |
| email_verified_at | timestamp    | Nullable           |
| password          | varchar      | Hashed (bcrypt)    |
| remember_token    | varchar(100) | Nullable           |
| created_at        | timestamp    |                    |
| updated_at        | timestamp    |                    |

**Relaciones**: `hasMany(Post)`, `hasMany(LeadReply)` (implícita)

---

### `services`

| Columna     | Tipo         | Notas                             |
| ----------- | ------------ | --------------------------------- |
| id          | bigint       | PK                                |
| title       | varchar(150) | Nombre del servicio               |
| slug        | varchar(150) | Único, URL-friendly               |
| description | text         | Descripción completa              |
| icon        | varchar(255) | Emoji o clase de icono (nullable) |
| is_active   | boolean      | Default: `true`                   |
| created_at  | timestamp    |                                   |
| updated_at  | timestamp    |                                   |

**Relaciones**: `hasMany(Lead)`

---

### `projects`

| Columna      | Tipo         | Notas                                             |
| ------------ | ------------ | ------------------------------------------------- |
| id           | bigint       | PK                                                |
| title        | varchar(150) | Título del proyecto                               |
| slug         | varchar(150) | Único                                             |
| description  | text         | Descripción principal                             |
| challenge    | text         | Problema/reto (nullable)                          |
| solution     | text         | Solución aplicada (nullable)                      |
| results      | text         | Resultados obtenidos (nullable)                   |
| type         | varchar(80)  | Categoría: "Brand Design", "Web", etc. (nullable) |
| client       | varchar(150) | Nombre del cliente (nullable)                     |
| year         | varchar(10)  | Año del proyecto (nullable)                       |
| thumbnail    | varchar      | Path de imagen principal (nullable)               |
| url          | varchar(255) | URL externa del proyecto (nullable)               |
| technologies | json         | Array de tecnologías usadas (nullable)            |
| status       | enum         | `draft` \| `published`                            |
| published_at | timestamp    | Fecha de publicación (nullable)                   |
| created_at   | timestamp    |                                                   |
| updated_at   | timestamp    |                                                   |

**Relaciones**: `hasMany(ProjectImage)`, `hasMany(ProjectStep)`
**Casts**: `published_at → datetime`, `technologies → array`

---

### `project_images`

| Columna    | Tipo      | Notas                               |
| ---------- | --------- | ----------------------------------- |
| id         | bigint    | PK                                  |
| project_id | foreignId | FK → `projects.id` (cascade delete) |
| image_path | varchar   | Path relativo en storage            |
| created_at | timestamp |                                     |
| updated_at | timestamp |                                     |

**Relaciones**: `belongsTo(Project)`

---

### `project_steps`

| Columna     | Tipo             | Notas                               |
| ----------- | ---------------- | ----------------------------------- |
| id          | bigint           | PK                                  |
| project_id  | foreignId        | FK → `projects.id` (cascade delete) |
| title       | varchar(150)     | Título del paso                     |
| description | text             | Descripción del paso (nullable)     |
| order       | tinyint unsigned | Orden de visualización              |
| image1      | varchar          | Primera imagen (nullable)           |
| image2      | varchar          | Segunda imagen (nullable)           |
| image3      | varchar          | Tercera imagen (nullable)           |
| created_at  | timestamp        |                                     |
| updated_at  | timestamp        |                                     |

**Relaciones**: `belongsTo(Project)`

---

### `posts`

| Columna        | Tipo         | Notas                               |
| -------------- | ------------ | ----------------------------------- |
| id             | bigint       | PK                                  |
| user_id        | foreignId    | FK → `users.id` (cascade delete)    |
| title          | varchar(200) | Título del artículo                 |
| slug           | varchar(200) | Único                               |
| content        | text         | Contenido completo                  |
| featured_image | varchar      | Path de imagen destacada (nullable) |
| status         | enum         | `draft` \| `published`              |
| published_at   | timestamp    | Fecha de publicación (nullable)     |
| created_at     | timestamp    |                                     |
| updated_at     | timestamp    |                                     |

**Relaciones**: `belongsTo(User)`
**Accessors**: `excerpt` (120 chars), `read_time` (palabras/200), `category_label` (por slug)

---

### `leads`

| Columna    | Tipo         | Notas                                             |
| ---------- | ------------ | ------------------------------------------------- |
| id         | bigint       | PK                                                |
| name       | varchar(150) | Nombre del contacto                               |
| email      | varchar(150) | Email del contacto                                |
| phone      | varchar(30)  | Teléfono (nullable)                               |
| service_id | foreignId    | FK → `services.id` (nullable, set null on delete) |
| message    | text         | Mensaje/consulta                                  |
| status     | enum         | `new` \| `contacted` \| `closed`                  |
| created_at | timestamp    |                                                   |
| updated_at | timestamp    |                                                   |

**Relaciones**: `belongsTo(Service)`, `hasMany(LeadReply)`

---

### `lead_replies`

| Columna       | Tipo      | Notas                            |
| ------------- | --------- | -------------------------------- |
| id            | bigint    | PK                               |
| lead_id       | foreignId | FK → `leads.id` (cascade delete) |
| user_id       | foreignId | FK → `users.id` (cascade delete) |
| message       | text      | Respuesta del admin              |
| sent_to_email | boolean   | Si se envió por email            |
| created_at    | timestamp |                                  |
| updated_at    | timestamp |                                  |

**Relaciones**: `belongsTo(Lead)`, `belongsTo(User)`

---

### `roles`

| Columna    | Tipo      | Notas |
| ---------- | --------- | ----- |
| id         | bigint    | PK    |
| created_at | timestamp |       |
| updated_at | timestamp |       |

> **Nota**: Modelo vacío sin campos ni relaciones. Reservado para futuro sistema de permisos.

---

### Tablas del framework

| Tabla                   | Propósito                              |
| ----------------------- | -------------------------------------- |
| `cache`                 | Cache de aplicación                    |
| `cache_locks`           | Locks distribuidos                     |
| `jobs`                  | Cola de trabajos (emails)              |
| `job_batches`           | Batches de jobs                        |
| `failed_jobs`           | Jobs fallidos                          |
| `sessions`              | Sesiones de usuario                    |
| `password_reset_tokens` | Tokens de reset (no usado actualmente) |

## Migraciones

```
database/migrations/
├── 0001_01_01_000000_create_users_table.php          # users, password_reset_tokens, sessions
├── 0001_01_01_000001_create_cache_table.php           # cache, cache_locks
├── 0001_01_01_000002_create_jobs_table.php            # jobs, job_batches, failed_jobs
├── 2026_02_23_044108_create_services_table.php        # services
├── 2026_02_23_044310_create_roles_table.php           # roles
├── 2026_02_23_044324_create_projects_table.php        # projects (base)
├── 2026_02_23_044325_create_project_images_table.php  # project_images
├── 2026_02_23_044327_create_leads_table.php           # leads
├── 2026_02_23_044514_create_posts_table.php           # posts
├── 2026_02_25_100000_create_lead_replies_table.php    # lead_replies
├── 2026_02_25_172016_add_type_to_projects_table.php   # + type, client a projects
├── 2026_02_25_174914_add_detail_fields_to_projects_table.php  # + year, challenge, solution, results
├── 2026_02_26_100000_create_project_steps_table.php   # project_steps
└── 2026_02_26_170956_add_technologies_to_projects_table.php   # + technologies (json)
```
