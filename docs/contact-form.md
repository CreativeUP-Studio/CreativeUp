# Formulario de Contacto — Multi-step Profesional

Formulario de contacto rediseñado con navegación por pasos, validación en tiempo real, floating labels y sección FAQ.

## Archivos

| Archivo                                            | Descripción                                             |
| -------------------------------------------------- | ------------------------------------------------------- |
| `resources/views/front/contact/index.blade.php`    | Vista Blade con HTML, estructura multi-step y JS inline |
| `resources/css/home.css` (sección `cf-*`)          | ~500 líneas de CSS bajo el namespace `cf-`              |
| `app/Http/Controllers/Front/ContactController.php` | Controlador: `index()` y `store()`                      |
| `app/Models/Lead.php`                              | Modelo Eloquent para leads                              |

## Arquitectura Visual

```
┌─────────────────────────────────────────────────┐
│                   CF-HERO                        │
│  (shapes animadas + badge + título + descripción)│
└─────────────────────────────────────────────────┘

┌──────────────────┬──────────────────────────────┐
│   CF-INFO        │      CF-FORM-WRAPPER          │
│   (sticky)       │                               │
│                  │  ┌─ Steps Indicator ────────┐ │
│  ┌─ Cards ─────┐ │  │  (1)──(2)──(3)          │ │
│  │ ⚡ Rápida    │ │  └────────────────────────┘ │
│  │ 🎨 Diseño   │ │                               │
│  │ 💻 Código   │ │  ┌─ Step 1: Datos ─────────┐ │
│  │ 🎧 Soporte  │ │  │  [Nombre]               │ │
│  └─────────────┘ │  │  [Email]                │ │
│                  │  │  [Teléfono]              │ │
│  ┌─ Contacto ──┐ │  │       [Siguiente →]      │ │
│  │ ✉ email     │ │  └────────────────────────┘ │
│  │ 📱 whatsapp │ │                               │
│  │ 📍 ubicación│ │  ┌─ Step 2: Proyecto ──────┐ │
│  └─────────────┘ │  │  [Servicio ▼]           │ │
│                  │  │  (chips presupuesto)     │ │
│  ┌─ Social ────┐ │  │  [← Anterior] [Sig. →]  │ │
│  │ fb ig tiktok│ │  └────────────────────────┘ │
│  └─────────────┘ │                               │
│                  │  ┌─ Step 3: Mensaje ────────┐ │
│                  │  │  [Textarea]     0/2000   │ │
│                  │  │  [← Anterior] [Enviar →] │ │
│                  │  └────────────────────────┘ │
│                  │                               │
│                  │  🔒 Tu información está segura│
└──────────────────┴──────────────────────────────┘

┌─────────────────────────────────────────────────┐
│                  CF-FAQ                          │
│  [+] ¿Cuánto tarda un proyecto?                  │
│  [+] ¿Ofrecen planes de pago?                   │
│  [+] ¿Qué incluye el soporte?                   │
│  [+] ¿Puedo ver avances?                        │
└─────────────────────────────────────────────────┘
```

## Secciones

### 1. Hero (`cf-hero`)

- **Fondo**: 3 formas circulares con `filter: blur(80px)`, opacidad 15%, animación `cfFloat` (8s, 10s, 12s)
- **Badge**: Pill con icono `fa-paper-plane`, borde gradiente sutil
- **Título**: Mont Heavy, `clamp(36px, 5vw, 56px)`, palabra "realidad" con gradiente
- **Descripción**: Mont ExtraLight, color `#666`

### 2. Split Layout (`cf-section` → `cf-container`)

Grid de 2 columnas (`1fr 1.2fr`, gap 60px). Colapsa a 1 columna en ≤1024px.

#### Panel izquierdo: Info (`cf-info`)

- **Sticky** en `top: 100px` (desktop)
- **4 tarjetas** (`cf-info-card`): icono con gradiente (44px), título + descripción. Hover: translate -2px + shadow
- **Info contacto**: Email, WhatsApp, ubicación con iconos FA
- **Redes sociales**: 3 botones (Facebook, Instagram, TikTok). Hover: fondo gradiente + color blanco

#### Panel derecho: Formulario (`cf-form-wrapper`)

Tarjeta blanca con `border-radius: 24px`, `box-shadow: 0 20px 60px rgba(0,0,0,0.06)`.

### 3. Steps Indicator

```
  (1) ──── (2) ──── (3)
 Datos   Proyecto  Mensaje
```

- **Dots**: 36px círculos numerados, border gradiente al activar, checkmark (FA `\f00c`) al completar
- **Líneas**: 2px de ancho, se llenan con gradiente al avanzar
- **Labels**: Visibles solo en ≥768px

Estados CSS:

- `cf-step-dot--active`: gradiente + shadow
- `cf-step-dot--done`: púrpura sólido + checkmark
- `cf-step-line--active`: gradiente horizontal

### 4. Formulario Multi-step

#### Step 1: Datos Personales (`cfStep1`)

| Campo    | Tipo    | Validación                             | Requerido |
| -------- | ------- | -------------------------------------- | --------- |
| Nombre   | `text`  | Min 2 chars, max 150                   | ✅        |
| Email    | `email` | Regex email válido, max 150            | ✅        |
| Teléfono | `tel`   | Regex dígitos/espacios/+/-, 7-30 chars | ❌        |

#### Step 2: Tu Proyecto (`cfStep2`)

| Campo       | Tipo          | Validación                   | Requerido |
| ----------- | ------------- | ---------------------------- | --------- |
| Servicio    | `select`      | Lista dinámica de `services` | ❌        |
| Presupuesto | `radio` chips | 5 opciones predefinidas      | ❌        |

Opciones de presupuesto:

- Menos de $500
- $500 – $2,000
- $2,000 – $5,000
- Más de $5,000
- Aún no lo sé

#### Step 3: Mensaje (`cfStep3`)

| Campo   | Tipo       | Validación             | Requerido |
| ------- | ---------- | ---------------------- | --------- |
| Mensaje | `textarea` | Min 10 chars, max 2000 | ✅        |

- Contador de caracteres en tiempo real (`cfCharCount`)
- Warning amarillo >1800 caracteres, rojo al llegar a 2000

### 5. FAQ Accordion (`cf-faq`)

4 preguntas con toggle abre/cierra. Solo una abierta a la vez.

- Icono `fa-plus` rota 45° → se convierte en ×
- Respuesta con `max-height` animada (0 → 200px)
- Hover: color púrpura en pregunta

## Floating Labels

Sistema de labels flotantes que suben al escribir:

```css
/* Estado normal: label centrada en el input */
.cf-label {
    top: 50%;
    transform: translateY(-50%);
    font-size: 15px;
}

/* Estado activo: label sube y se reduce */
.cf-input:focus ~ .cf-label,
.cf-input:not(:placeholder-shown) ~ .cf-label {
    top: 10px;
    font-size: 11px;
    color: #5e17eb;
    font-weight: 600;
}
```

Cada input incluye un `cf-input-border` (línea gradiente) que se expande desde el centro al hacer focus.

## Validación JavaScript

### Validación en tiempo real

- **On blur**: Valida el campo al perder focus
- **On input**: Re-valida solo si ya tiene error (evita alertar prematuramente)
- **On submit**: Valida paso actual + paso 1 (siempre se re-chequean los datos personales)

### Estados visuales

| Estado | Clase CSS         | Efecto                                   |
| ------ | ----------------- | ---------------------------------------- |
| Error  | `cf-input--error` | Borde rojo, fondo `#fff5f5`, shadow rojo |
| Válido | `cf-input--valid` | Borde verde `#2ecc71`                    |
| Focus  | `:focus`          | Borde púrpura `#5e17eb`, shadow púrpura  |

### Navegación entre pasos

```javascript
goToStep(n); // Actualiza dots, lines, labels, muestra step con animación slide-in
validateStep(n); // Valida campos del paso n antes de avanzar
```

- Step 1 → 2: Solo avanza si nombre y email son válidos
- Step 2 → 3: Sin validación requerida (campos opcionales)
- Submit: Valida paso 3 + re-valida paso 1

### Estado de carga

Al enviar, el botón cambia a estado loading:

- Texto → spinner con "Enviando..."
- Botón se deshabilita (`pointer-events: none`, opacity 0.8)

## Alertas

Dos tipos de alertas animadas:

| Tipo  | Clase               | Color           | Icono                   |
| ----- | ------------------- | --------------- | ----------------------- |
| Éxito | `cf-alert--success` | Verde `#2ecc71` | `fa-circle-check`       |
| Error | `cf-alert--error`   | Rojo `#e74c3c`  | `fa-circle-exclamation` |

- Animación de entrada: `cfAlertIn` (fade + translateY)
- Auto-dismiss: Se desvanecen después de 6 segundos
- Botón de cierre manual (×)

## Clases CSS — Namespace `cf-`

### Estructura principal

| Clase                  | Elemento                        |
| ---------------------- | ------------------------------- |
| `cf-hero`              | Sección hero con fondo animado  |
| `cf-hero-shape--1/2/3` | Blobs flotantes del hero        |
| `cf-hero-gradient`     | Texto con gradiente en título   |
| `cf-section`           | Contenedor del split layout     |
| `cf-container`         | Grid 2 columnas                 |
| `cf-info`              | Panel izquierdo (info)          |
| `cf-form-wrapper`      | Tarjeta del formulario          |
| `cf-faq`               | Sección de preguntas frecuentes |

### Formulario

| Clase                  | Elemento                    |
| ---------------------- | --------------------------- |
| `cf-form-step`         | Contenedor de cada paso     |
| `cf-form-step--active` | Paso visible                |
| `cf-input-wrapper`     | Wrapper para floating label |
| `cf-input`             | Input/textarea              |
| `cf-label`             | Label flotante              |
| `cf-input-border`      | Línea gradiente inferior    |
| `cf-select-wrapper`    | Wrapper para select custom  |
| `cf-budget-chip`       | Chip de presupuesto         |
| `cf-error-msg`         | Mensaje de error bajo input |
| `cf-char-count`        | Contador de caracteres      |

### Botones

| Clase             | Estilo                                       |
| ----------------- | -------------------------------------------- |
| `cf-btn--prev`    | Transparente, flecha izquierda               |
| `cf-btn--next`    | Dark (#1a1a2e), flecha derecha               |
| `cf-btn--submit`  | Gradiente púrpura→rosa, efecto hover reverse |
| `cf-btn--loading` | Estado de carga con spinner                  |

## Animaciones

| Nombre      | Duración       | Uso                                           |
| ----------- | -------------- | --------------------------------------------- |
| `cfFloat`   | 8-12s infinite | Shapes del hero (translate + scale)           |
| `cfSlideIn` | 0.4s           | Transición entre steps (opacity + translateX) |
| `cfAlertIn` | 0.4s           | Entrada de alertas (opacity + translateY)     |

## Responsive

| Breakpoint | Cambios                                                                                                                          |
| ---------- | -------------------------------------------------------------------------------------------------------------------------------- |
| ≤1024px    | Grid 1 columna, info cards en grid 2 cols, panel info no sticky                                                                  |
| ≤768px     | Hero padding reducido, form wrapper compacto, labels de steps ocultos, budget chips full-width, botones full-width, nav vertical |
| ≤480px     | Título 28px, inputs más compactos, padding reducido                                                                              |

## Backend

### Ruta

```
GET  /contact  → ContactController@index   (name: contact.index)
POST /contact  → ContactController@store   (name: contact.store)
```

### Validación del servidor

```php
$validated = $request->validate([
    'name'       => 'required|string|max:150',
    'email'      => 'required|email|max:150',
    'phone'      => 'nullable|string|max:30',
    'service_id' => 'nullable|exists:services,id',
    'message'    => 'required|string|max:2000',
]);
```

> **Nota**: El campo `budget` del step 2 es solo informativo en el frontend. No se persiste en la base de datos actualmente. Para guardar el presupuesto se requiere añadir una columna `budget` a la tabla `leads` y al `$fillable` del modelo.

### Modelo Lead

```php
protected $fillable = ['name', 'email', 'phone', 'service_id', 'message', 'status'];
```

### Tabla `leads`

| Columna    | Tipo                       | Nullable | Default |
| ---------- | -------------------------- | -------- | ------- |
| id         | bigint PK                  | ❌       | auto    |
| name       | varchar(150)               | ❌       | —       |
| email      | varchar(150)               | ❌       | —       |
| phone      | varchar(30)                | ✅       | null    |
| service_id | FK → services              | ✅       | null    |
| message    | text                       | ❌       | —       |
| status     | enum(new,contacted,closed) | ❌       | new     |
| created_at | timestamp                  | ✅       | —       |
| updated_at | timestamp                  | ✅       | —       |

### Flujo completo

1. Usuario llega a `/contact` → `ContactController@index` carga servicios activos
2. Blade renderiza formulario multi-step con servicios en el `<select>`
3. JS maneja navegación entre pasos y validación client-side
4. Al submit → POST `/contact` → validación server-side → `Lead::create()`
5. Redirect a `/contact` con flash `success`
6. Alert de éxito se muestra y auto-dismiss en 6s
7. Lead aparece en panel admin → `/admin/leads`
