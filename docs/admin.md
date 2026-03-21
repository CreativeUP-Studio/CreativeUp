# Panel de Administración

## Acceso

- **URL**: `/admin` (redirect a `/admin/dashboard`)
- **Login**: `/login`
- **Credenciales seed**: `admin@creativeup.com` / `password`
- **Protección**: middleware `auth` en todas las rutas admin

## Layout

Dos columnas:

- **Sidebar izquierda** (270px fixed): navegación con secciones
- **Contenido principal**: topbar sticky + área de contenido

### Navegación sidebar

```
Dashboard
─────────────
CONTENIDO
  Servicios
  Proyectos
  Posts
─────────────
CRM
  Leads
```

Cada item muestra estado activo con borde púrpura izquierdo y fondo gradiente.

### Topbar

- Izquierda: título de la sección actual (`@yield('title')`)
- Derecha: nombre del usuario + botón logout

### Alertas

Se muestran automáticamente desde flash messages de sesión:

- `session('success')` → alerta verde
- `session('error')` → alerta roja
- `$errors->any()` → lista de errores de validación en rojo

## Dashboard (`/admin/dashboard`)

### Stats cards (4)

| Card      | Dato               | Color     |
| --------- | ------------------ | --------- |
| Servicios | Total de servicios | Púrpura   |
| Proyectos | Publicados / Total | Azul      |
| Posts     | Publicados / Total | Ámbar     |
| Leads     | Nuevos / Total     | Esmeralda |

### Tablas recientes

- **Últimos 5 leads**: nombre, email, servicio, estado (badge), fecha
- **Últimos 5 posts**: título, estado, fecha

## Gestión de Servicios

### Listado (`/admin/services`)

Tabla con columnas: Título, Slug, Estado (Activo/Inactivo badge), Fecha, Acciones (Editar, Eliminar).
Paginación: 10 por página.

### Crear/Editar (`/admin/services/create`, `/admin/services/{id}/edit`)

| Campo       | Tipo     | Validación                       |
| ----------- | -------- | -------------------------------- |
| Título      | text     | requerido, max 150               |
| Slug        | text     | nullable, auto-generado si vacío |
| Descripción | textarea | requerido                        |
| Icono       | text     | nullable (emoji o clase)         |
| Activo      | checkbox | boolean                          |

## Gestión de Proyectos

### Listado (`/admin/projects`)

Tabla con: Thumbnail (miniatura), Título, Tipo, Estado, Fecha, Acciones.
Paginación: 10 por página.

### Crear/Editar

**Información básica:**

| Campo             | Tipo     | Validación                             |
| ----------------- | -------- | -------------------------------------- |
| Título            | text     | requerido, max 150                     |
| Slug              | text     | nullable, auto-generado, unique        |
| Descripción       | textarea | requerido                              |
| Tipo              | text     | nullable, max 80 (ej: "Brand Design")  |
| Cliente           | text     | nullable, max 150                      |
| Año               | text     | nullable, max 10                       |
| URL               | url      | nullable, max 255                      |
| Tecnologías       | text     | nullable, comma-separated → JSON array |
| Estado            | select   | draft / published                      |
| Fecha publicación | date     | nullable, auto si published            |

**Contenido detallado:**

| Campo     | Tipo     | Notas                |
| --------- | -------- | -------------------- |
| Challenge | textarea | Reto del proyecto    |
| Solution  | textarea | Solución aplicada    |
| Results   | textarea | Resultados obtenidos |

**Imágenes:**

| Campo            | Tipo            | Notas                     |
| ---------------- | --------------- | ------------------------- |
| Thumbnail        | file (image)    | Imagen principal, max 2MB |
| Imágenes galería | file[] (images) | Múltiples, max 2MB c/u    |

**Pasos del proceso (dinámicos):**

Cada step tiene:

- Título (text)
- Descripción (textarea)
- Imagen 1, 2, 3 (file, opcionales)

Se pueden agregar/editar/eliminar steps. El orden se determina por el índice.

### Vista detalle (`/admin/projects/{id}`)

Vista de solo lectura con:

- Header: título, tipo, estado, fecha
- Stats: total imágenes, total steps, tecnologías
- Galería de imágenes
- Lista de steps con imágenes
- Sidebar: cliente, año, URL, descripción

## Gestión de Posts

### Listado (`/admin/posts`)

Tabla con: Título, Autor, Estado, Fecha, Acciones.
Paginación: 10 por página.

### Crear/Editar

| Campo             | Tipo         | Validación                      |
| ----------------- | ------------ | ------------------------------- |
| Título            | text         | requerido, max 200              |
| Slug              | text         | nullable, auto-generado, unique |
| Contenido         | textarea     | requerido                       |
| Imagen destacada  | file (image) | nullable, max 2MB               |
| Estado            | select       | draft / published               |
| Fecha publicación | date         | nullable, auto si published     |

**Nota**: El `user_id` se asigna automáticamente al usuario logueado en creación.

## Gestión de Leads (CRM)

### Listado (`/admin/leads`)

**Filtros disponibles:**

- Por estado: `Todos`, `Nuevos`, `Contactados`, `Cerrados`
- Búsqueda: por nombre, email o teléfono

Tabla con: Nombre, Email, Servicio, Respuestas (count), Estado (badge), Fecha, Acciones.
Paginación: 15 por página.

**Badges de estado:**

- `new` → Verde "Nuevo"
- `contacted` → Amarillo "Contactado"
- `closed` → Gris "Cerrado"

### Detalle (`/admin/leads/{id}`)

Layout de 2 columnas:

**Columna izquierda — Conversación:**

- Mensaje original del lead (burbuja cliente)
- Historial de respuestas (burbujas admin con avatar, nombre, timestamp)
- Formulario de respuesta con:
    - Textarea para mensaje
    - Checkbox: enviar por email al lead
    - Checkbox: enviar copia al admin
    - Botón enviar

**Columna derecha — Información:**

- Datos del lead: nombre, email, teléfono, servicio
- Selector de estado (new/contacted/closed)
- Fecha de creación
- Botón eliminar

### Flujo de respuesta

1. Admin escribe mensaje en textarea
2. Opcionalmente marca "enviar por email" y/o "enviar copia"
3. Se crea `LeadReply` en BD
4. Si `send_to_email`: envía `LeadReplyMail` al email del lead
5. Si `send_copy`: envía `LeadReplyNotification` al email del admin
6. Si el lead estaba en `new`, cambia automáticamente a `contacted`

### Emails enviados

**Email al lead** (`LeadReplyMail`):

- Asunto: "Respuesta de CreativeUP - Re: Tu consulta"
- Template dark branded con gradiente
- Muestra: mensaje original + respuesta del admin
- Firma con nombre del admin que respondió

**Copia al admin** (`LeadReplyNotification`):

- Asunto: "[CreativeUP Admin] Respuesta enviada a {Nombre}"
- Datos: nombre lead, email destino, respondió, fecha/hora
- Muestra: consulta original + respuesta enviada
- Pie: "Copia automática generada por CreativeUP CRM"

## Responsive

| Viewport | Comportamiento                                     |
| -------- | -------------------------------------------------- |
| > 768px  | Sidebar visible, layout completo                   |
| ≤ 768px  | Sidebar oculta, toggle hamburger, overlay para nav |
| ≤ 480px  | Stats en 1 columna, padding reducido               |
