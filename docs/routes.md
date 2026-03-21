# Rutas

Archivo principal: `routes/web.php`

## Autenticación

| Método | URI       | Controlador                          | Nombre   | Descripción         |
| ------ | --------- | ------------------------------------ | -------- | ------------------- |
| GET    | `/login`  | `Auth\LoginController@showLoginForm` | `login`  | Formulario de login |
| POST   | `/login`  | `Auth\LoginController@login`         | —        | Procesar login      |
| POST   | `/logout` | `Auth\LoginController@logout`        | `logout` | Cerrar sesión       |

## Rutas Públicas (Front)

### Home

| Método | URI | Controlador                  | Nombre | Descripción      |
| ------ | --- | ---------------------------- | ------ | ---------------- |
| GET    | `/` | `Front\HomeController@index` | `home` | Página principal |

**Datos cargados**: servicios activos (4), proyecto destacado, proyectos recientes (4), posts recientes (4).

### Servicios

| Método | URI                | Controlador                     | Nombre           | Descripción          |
| ------ | ------------------ | ------------------------------- | ---------------- | -------------------- |
| GET    | `/services`        | `Front\ServiceController@index` | `services.index` | Listado de servicios |
| GET    | `/services/{slug}` | `Front\ServiceController@show`  | `services.show`  | Detalle de servicio  |

### Proyectos

| Método | URI                | Controlador                     | Nombre           | Descripción              |
| ------ | ------------------ | ------------------------------- | ---------------- | ------------------------ |
| GET    | `/projects`        | `Front\ProjectController@index` | `projects.index` | Portafolio (paginado 12) |
| GET    | `/projects/{slug}` | `Front\ProjectController@show`  | `projects.show`  | Detalle de proyecto      |

**Query params**: `?type=Brand+Design` para filtrar por tipo.

**Datos en show**: proyecto con imágenes y steps, proyectos relacionados (3 random, mismo tipo), proyecto anterior/siguiente.

### Blog

| Método | URI            | Controlador                  | Nombre       | Descripción                   |
| ------ | -------------- | ---------------------------- | ------------ | ----------------------------- |
| GET    | `/blog`        | `Front\PostController@index` | `blog.index` | Listado de posts (paginado 9) |
| GET    | `/blog/{slug}` | `Front\PostController@show`  | `blog.show`  | Artículo completo             |

### Contacto

| Método | URI             | Controlador                         | Nombre          | Descripción                  |
| ------ | --------------- | ----------------------------------- | --------------- | ---------------------------- |
| GET    | `/contact`      | `Front\ContactController@index`     | `contact.index` | Formulario de contacto       |
| POST   | `/contact`      | `Front\ContactController@store`     | `contact.store` | Crear lead desde formulario  |
| POST   | `/chat-message` | `Front\ContactController@chatStore` | `chat.store`    | Crear lead desde chat (AJAX) |

**Validación contact.store**:

- `name`: requerido, string, max 150
- `email`: requerido, email, max 150
- `phone`: nullable, string, max 30
- `service_id`: nullable, exists en services
- `message`: requerido, string, max 2000

**Validación chat.store** (AJAX):

- `name`: requerido, string, max 150
- `email`: requerido, email, max 150
- `message`: requerido, string, max 2000
- Responde JSON: `{ success: true, message: "..." }`

## Rutas Admin

Todas protegidas con middleware `auth`, prefijo `/admin`, nombre `admin.*`.

### Dashboard

| Método | URI                | Nombre            | Descripción          |
| ------ | ------------------ | ----------------- | -------------------- |
| GET    | `/admin`           | —                 | Redirect a dashboard |
| GET    | `/admin/dashboard` | `admin.dashboard` | Panel principal      |

### Servicios (Resource)

| Método | URI                         | Nombre                   | Descripción           |
| ------ | --------------------------- | ------------------------ | --------------------- |
| GET    | `/admin/services`           | `admin.services.index`   | Listado (paginado 10) |
| GET    | `/admin/services/create`    | `admin.services.create`  | Formulario crear      |
| POST   | `/admin/services`           | `admin.services.store`   | Guardar nuevo         |
| GET    | `/admin/services/{id}`      | `admin.services.show`    | Redirect a edit       |
| GET    | `/admin/services/{id}/edit` | `admin.services.edit`    | Formulario editar     |
| PUT    | `/admin/services/{id}`      | `admin.services.update`  | Actualizar            |
| DELETE | `/admin/services/{id}`      | `admin.services.destroy` | Eliminar              |

### Proyectos (Resource)

| Método | URI                         | Nombre                   | Descripción                     |
| ------ | --------------------------- | ------------------------ | ------------------------------- |
| GET    | `/admin/projects`           | `admin.projects.index`   | Listado (paginado 10)           |
| GET    | `/admin/projects/create`    | `admin.projects.create`  | Formulario crear                |
| POST   | `/admin/projects`           | `admin.projects.store`   | Guardar (+ imágenes + steps)    |
| GET    | `/admin/projects/{id}`      | `admin.projects.show`    | Vista detalle                   |
| GET    | `/admin/projects/{id}/edit` | `admin.projects.edit`    | Formulario editar               |
| PUT    | `/admin/projects/{id}`      | `admin.projects.update`  | Actualizar (+ imágenes + steps) |
| DELETE | `/admin/projects/{id}`      | `admin.projects.destroy` | Eliminar (+ archivos)           |

**Campos especiales**:

- `technologies`: se envía como string separado por comas, se convierte a JSON array
- `images.*`: array de archivos de imagen (max 2MB c/u)
- `steps[N][title]`, `steps[N][description]`, `steps[N][image1-3]`: pasos del proceso
- `delete_images[]`: IDs de imágenes a eliminar
- `delete_steps[]`: IDs de pasos a eliminar

### Posts (Resource)

| Método | URI                      | Nombre                | Descripción           |
| ------ | ------------------------ | --------------------- | --------------------- |
| GET    | `/admin/posts`           | `admin.posts.index`   | Listado (paginado 10) |
| GET    | `/admin/posts/create`    | `admin.posts.create`  | Formulario crear      |
| POST   | `/admin/posts`           | `admin.posts.store`   | Guardar nuevo         |
| GET    | `/admin/posts/{id}`      | `admin.posts.show`    | Redirect a edit       |
| GET    | `/admin/posts/{id}/edit` | `admin.posts.edit`    | Formulario editar     |
| PUT    | `/admin/posts/{id}`      | `admin.posts.update`  | Actualizar            |
| DELETE | `/admin/posts/{id}`      | `admin.posts.destroy` | Eliminar (+ imagen)   |

### Leads (Manual)

| Método | URI                         | Nombre                | Descripción                               |
| ------ | --------------------------- | --------------------- | ----------------------------------------- |
| GET    | `/admin/leads`              | `admin.leads.index`   | Listado (filtros + búsqueda, paginado 15) |
| GET    | `/admin/leads/{lead}`       | `admin.leads.show`    | Detalle + conversación                    |
| PUT    | `/admin/leads/{lead}`       | `admin.leads.update`  | Cambiar estado                            |
| POST   | `/admin/leads/{lead}/reply` | `admin.leads.reply`   | Responder (+ email opcional)              |
| DELETE | `/admin/leads/{lead}`       | `admin.leads.destroy` | Eliminar lead                             |

**Query params en index**: `?status=new|contacted|closed`, `?search=texto`

**Reply params**:

- `message`: requerido, string, max 5000
- `send_to_email`: boolean, enviar email al lead
- `send_copy`: boolean, enviar copia al admin
