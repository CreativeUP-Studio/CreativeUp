# Frontend y Diseño

> **⚠️ PRIORIDAD DE TEMA BLANCO**: Las páginas públicas deben priorizar el **tema blanco/claro** (fondos blancos `#fff` / `#fafafa`, texto oscuro `#1a1a2e`, bordes suaves `#f0f0f5` / `#e2e8f0`). Los acentos de color (purple `#5e17eb`, gradientes) se mantienen sobre fondo blanco. El tema oscuro (`#09090b`) solo se usa en secciones específicas como el header/footer. Las páginas de Servicios ya están implementadas con tema blanco.

## Paleta de Colores

### Colores principales

| Color           | Hex                      | Uso                                  |
| --------------- | ------------------------ | ------------------------------------ |
| Fondo oscuro    | `#09090b`                | Header, footer, secciones puntuales  |
| Fondo claro     | `#fff` / `#fafafa`       | **Background principal (prioridad)** |
| Purple primario | `#5e17eb`                | Acentos, botones, gradiente inicio   |
| Pink acento     | `#d946ef`                | Gradiente final, hovers              |
| Texto oscuro    | `#1a1a2e`                | Texto principal sobre fondo claro    |
| Texto muted     | `#64748b` / `#94a3b8`    | Texto secundario sobre fondo claro   |
| Bordes claros   | `#f0f0f5` / `#e2e8f0`    | Separadores sobre fondo claro        |
| Bordes oscuros  | `rgba(255,255,255,0.06)` | Separadores sobre fondo oscuro       |

### Gradiente principal

```css
background: linear-gradient(90deg, #5c6ff4, #e870c2);
/* También usado como: */
background: linear-gradient(135deg, #5e17eb, #ff00cc);
```

Se usa en: textos destacados, botones hover, menú, decoraciones.

### Variables CSS

```css
:root {
    --gradient-primary: linear-gradient(90deg, #5c6ff4, #e870c2);
    --text-dark: #404040;
}
```

## Tipografía

**Fuente principal**: Mont (custom, cargada localmente)

| Peso             | Archivo                   | Uso                             |
| ---------------- | ------------------------- | ------------------------------- |
| 200 (ExtraLight) | `Mont-ExtraLightDEMO.otf` | Textos de cuerpo, descripciones |
| 800 (Heavy)      | `Mont-HeavyDEMO.otf`      | Títulos, headings, hero text    |

Fallbacks: `Instrument Sans`, `ui-sans-serif`, `system-ui`, `sans-serif`

## Archivos CSS

### `app.css` — Entry point

```css
@import "tailwindcss";
@import "./home.css";
@import "./admin.css";
```

Importa Tailwind CSS 4, los estilos del sitio público y del admin.

### `home.css` (~4680 líneas) — Sitio público

Secciones principales:

1. **Topbar y navegación** — Fixed top, logo con gradiente, 9-dot grid button
2. **Menú fullscreen** — Overlay con 3 columnas: links, imagen, info/social
3. **Hero** — Full viewport, split layout, imágenes staggered
4. **Portafolio** — Featured project + grid alternado con círculos
5. **Services teaser** — Transición animada con scroll indicator
6. **Servicios** — Pares alternados izq/der con blob clip-paths SVG
7. **Clientes** — Grid 3 cols, grayscale→color hover
8. **Blog** — Featured post + grid 3 cols + newsletter
9. **Proyectos index** — Filtros flotantes, mosaico multi-foto
10. **Proyecto show** — Hero fullscreen, steps alternados, banner CTA, next project
11. **Login** — Glassmorphism con orbs animados
12. **Chat widget** — Botón flotante, modal dark, bubbles, typing indicator
13. **Footer** — Gradiente púrpura, multi-columna
14. **Contact form** — Hero animado, multi-step, floating labels, FAQ accordion

### `admin.css` (~1880 líneas) — Panel admin

Secciones principales:

1. **Sidebar** — Fixed 270px, gradiente borde, nav sections
2. **Topbar** — Sticky, glassmorphic blur
3. **Stats cards** — Grid auto-fit, gradient border hover
4. **Tablas** — Sticky header, hover rows, badges de estado
5. **Formularios** — Grids 2-3 cols, focus purple, sections
6. **Botones** — Primary/success/danger/ghost variants
7. **Badges** — 6 colores: green, yellow, red, blue, gray, purple
8. **Alertas** — Success/danger con icono
9. **Galería proyecto** — Grid thumbnails con delete overlay
10. **Conversación leads** — Bubbles admin/cliente, timestamps
11. **Responsive** — Sidebar collapse <768px

## JavaScript

### `app.js` — Lógica principal

Sin frameworks. Todo vanilla JS. Funcionalidades:

#### 1. Animaciones de entrada (tipo AOS)

```html
<!-- Animación inmediata al cargar -->
<div class="anim-hidden" data-anim="fade-up">...</div>

<!-- Animación al hacer scroll -->
<div class="anim-scroll" data-anim="fade-up">...</div>
```

Tipos de animación disponibles:

- `fade-up`, `fade-down`, `fade-left`, `fade-right`
- `fade-in`, `zoom-in`, `flip-up`
- `ball-roll-left`, `ball-roll-right`
- `blob-reveal`, `slide-up-bounce`, `slide-down-bounce`
- `line-grow`, `dot-glow`

**Mecanismo**: IntersectionObserver con `threshold: 0.15`. Al intersectar, remueve clase `anim-scroll` activando la animación CSS.

#### 2. Topbar scroll

Agrega clase `scrolled` al hacer scroll > 80px. Cambia opacidad/fondo de la barra.

#### 3. Menú fullscreen

- Click en 9-dots → toggle clase `active` en `#fullscreenMenu`
- Cierre con Escape o click en overlay
- Bloquea scroll del body cuando está abierto
- Imágenes dinámicas al hover en links del menú

#### 4. Dots animation

Los 9 puntos del botón aparecen con animación `dot-pop` staggered.

### Chat widget (inline en `layouts/app.blade.php`)

Flujo multistep:

1. **Paso 1**: Pedir nombre → burbuja usuario
2. **Paso 2**: Pedir email → burbuja usuario
3. **Paso 3**: Pedir mensaje → enviar AJAX a `/chat-message`
4. **Paso done**: Confirmación

**Persistencia**: Estado guardado en `localStorage` con key `creativeup_chat`, expira a las 24h. Guarda: nombre, email, step actual, mensajes, estado del badge.

**Typing indicator**: Simula escritura con 3 dots animados antes de mostrar respuesta bot.

## Componentes Visuales

### Menú (9-dot grid)

```
• • •
• • •     →    ✕ (al abrir)
• • •
```

Botón de 9 puntos que se transforma en X. Abre overlay fullscreen con:

- Columna izquierda: navegación numerada (01-05)
- Columna central: imagen que cambia al hover
- Columna derecha: servicios, contacto, redes sociales

### Blob images (Servicios)

Imágenes con `clip-path` SVG orgánico. 4 formas diferentes definidas en `<defs>`:

- `#blob-0`: curvas amplias asimétricas
- `#blob-1`: ondulaciones suaves
- `#blob-2`: orgánica alargada horizontal
- `#blob-3`: fluida con entrantes pronunciados

### Proyecto show — Steps

Layout alternado fullscreen:

- **Impares**: texto izquierda + collage 3 imágenes derecha
- **Pares**: collage izquierda + texto derecha

Progress bar horizontal fija en top que avanza con el scroll.

### Chat flotante

Botón circular en esquina inferior derecha con badge de notificación. Se expande a modal de chat con:

- Header con logo UP y status "Disponible"
- Body con burbujas bot (avatar UP) y usuario
- Input area con 3 steps secuenciales

### Formulario de contacto (Multi-step)

Ver documentación completa en [contact-form.md](contact-form.md).

Componente compuesto por 3 secciones:

1. **Hero animado** — Fondo con 3 formas flotantes (blur), badge, título con gradiente
2. **Split layout** — Panel info (sticky) + formulario multi-step
3. **FAQ accordion** — 4 preguntas frecuentes con toggle animado

**Prefijo CSS**: `cf-` (contact form) — todas las clases usan este namespace

## Breakpoints Responsive

| Breakpoint | Cambios principales                              |
| ---------- | ------------------------------------------------ |
| 992px      | Menú: columnas stack, hero ajusta                |
| 768px      | Grid → 1 col, sidebar admin collapse, nav toggle |
| 600px      | Mobile landscape → portrait                      |
| 480px      | Chat widget reduce ancho, botón flotante reduce  |

## Imágenes

### Ubicaciones

| Path                                     | Contenido                                                              |
| ---------------------------------------- | ---------------------------------------------------------------------- |
| `public/images/`                         | Imágenes estáticas del sitio                                           |
| `public/images/hero-1.jpg`, `hero-2.jpg` | Hero section                                                           |
| `public/images/menu/`                    | Imágenes del menú hover (inicio, servicios, proyectos, blog, contacto) |
| `public/images/clients/`                 | Logos de clientes                                                      |
| `storage/app/public/projects/`           | Thumbnails, imágenes de galería, imágenes de steps                     |
| `storage/app/public/posts/`              | Imágenes destacadas de blog                                            |

### Patrones de uso

```blade
{{-- Imágenes estáticas --}}
{{ asset('images/hero-1.jpg') }}

{{-- Imágenes de storage --}}
{{ Storage::url($project->thumbnail) }}
{{ asset('storage/' . $post->featured_image) }}
```
