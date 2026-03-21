# Arquitectura del Proyecto

## Visión General

CreativeUP sigue la arquitectura estándar de Laravel (MVC) con separación clara entre:

- **Frontend público**: sitio web de la agencia (home, servicios, proyectos, blog, contacto)
- **Panel admin**: gestión de contenido y CRM de leads
- **Autenticación**: login manual sin paquetes externos

No se usan frameworks JS reactivos. Todo el frontend es server-side rendered (Blade) con animaciones vanilla JS.

## Estructura de Carpetas

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                  # Controladores del panel de administración
│   │   │   ├── DashboardController.php   # Stats y vista general
│   │   │   ├── LeadController.php        # CRUD leads + respuestas email
│   │   │   ├── PostController.php        # CRUD posts del blog
│   │   │   ├── ProjectController.php     # CRUD proyectos + steps + imágenes
│   │   │   └── ServiceController.php     # CRUD servicios
│   │   ├── Auth/
│   │   │   └── LoginController.php       # Login/logout manual
│   │   ├── Front/                  # Controladores del sitio público
│   │   │   ├── ContactController.php     # Formulario contacto + chat AJAX
│   │   │   ├── HomeController.php        # Página principal
│   │   │   ├── PostController.php        # Blog público
│   │   │   ├── ProjectController.php     # Portafolio público (filtros por tipo)
│   │   │   └── ServiceController.php     # Servicios público
│   │   └── Controller.php         # Base controller
│   ├── Middleware/                  # (vacío, usa middleware de Laravel)
│   └── Requests/                   # (vacío, validación inline en controllers)
├── Mail/
│   ├── LeadReplyMail.php           # Email de respuesta al cliente
│   └── LeadReplyNotification.php   # Copia de respuesta al admin
├── Models/                         # 10 modelos Eloquent
│   ├── Lead.php
│   ├── LeadReply.php
│   ├── Post.php
│   ├── Project.php
│   ├── ProjectImage.php
│   ├── ProjectStep.php
│   ├── Role.php                    # Modelo vacío (sin uso actual)
│   ├── Service.php
│   └── User.php
├── Providers/
│   └── AppServiceProvider.php
├── Repositories/                   # (vacío, acceso directo al modelo)
└── Services/                       # (vacío, lógica en controllers)

resources/
├── css/
│   ├── app.css                     # Entry point: importa home.css + admin.css + Tailwind
│   ├── home.css                    # ~4680 líneas — estilos del sitio público
│   └── admin.css                   # ~1880 líneas — estilos del panel admin
├── fonts/
│   └── Mont/                       # Fuente Mont (ExtraLight 200, Heavy 800)
├── js/
│   ├── app.js                      # Animaciones, menú, scroll observer
│   └── bootstrap.js                # Config de Axios
└── views/
    ├── layouts/
    │   └── app.blade.php           # Layout público (topbar, menú, chat, footer)
    ├── admin/
    │   ├── layouts/
    │   │   └── app.blade.php       # Layout admin (sidebar, topbar, alertas)
    │   ├── dashboard.blade.php
    │   ├── leads/
    │   ├── posts/
    │   ├── projects/
    │   └── services/
    ├── auth/
    │   └── login.blade.php
    ├── emails/
    │   ├── lead-reply.blade.php
    │   └── lead-reply-notification.blade.php
    ├── front/
    │   ├── home.blade.php
    │   ├── blog/
    │   ├── contact/
    │   ├── projects/
    │   └── services/
    └── partials/
        ├── menuBlob.svg
        └── menuBlob2.svg
```

## Flujo de Datos

```
Navegador → Route (web.php)
              ↓
          Controller (valida, procesa)
              ↓
          Model (Eloquent query)
              ↓
          View (Blade template)
              ↓
          Layout (app.blade.php)
              ↓
          CSS (Tailwind + custom) + JS (vanilla)
```

## Patrones Utilizados

### Controladores

- Validación inline en cada método (no Form Requests separados)
- Lógica de negocio directa en controllers (no Services/Repositories por ahora)
- Resource controllers para CRUD admin

### Modelos

- Accessors en `Post`: `excerpt`, `read_time`, `category_label`
- Casts: `technologies` como array JSON, `published_at` como datetime
- Relaciones: belongsTo, hasMany con cascade delete

### Almacenamiento

- Disco `public` para todas las imágenes
- Paths: `projects/thumbnails/`, `projects/images/`, `projects/steps/`, `posts/`
- Acceso vía `Storage::url()` en vistas

### Autenticación

- Login manual en `LoginController` (sin Breeze/Fortify/Jetstream)
- Middleware `auth` en grupo de rutas admin
- Session regeneration en login, invalidation en logout

### Frontend

- Animaciones con `data-anim` + IntersectionObserver (scroll-triggered)
- Chat widget con estado persistido en `localStorage` (TTL 24h)
- Menú fullscreen con transiciones CSS
- Imágenes responsive con `loading="lazy"` y `decoding="async"`
