# CreativeUP — Documentación

Documentación técnica del proyecto **CreativeUP**, sitio web y panel de administración de una agencia creativa/digital.

## Índice

| Documento                          | Descripción                                     |
| ---------------------------------- | ----------------------------------------------- |
| [setup.md](setup.md)               | Instalación, requisitos y comandos              |
| [architecture.md](architecture.md) | Arquitectura, estructura de carpetas y patrones |
| [database.md](database.md)         | Esquema de base de datos, modelos y relaciones  |
| [routes.md](routes.md)             | Rutas públicas, admin y autenticación           |
| [frontend.md](frontend.md)         | Diseño, CSS, animaciones y componentes JS       |
| [contact-form.md](contact-form.md) | Formulario de contacto multi-step profesional   |
| [admin.md](admin.md)               | Panel de administración y CRM                   |

## Stack Tecnológico

| Capa    | Tecnología   | Versión                        |
| ------- | ------------ | ------------------------------ |
| Backend | Laravel      | 12.x                           |
| PHP     | PHP          | ^8.2                           |
| CSS     | Tailwind CSS | 4.x                            |
| Bundler | Vite         | 7.x                            |
| JS      | Vanilla JS   | ES6+                           |
| Fuente  | Mont         | ExtraLight (200) / Heavy (800) |
| HTTP    | Axios        | 1.x                            |

## Convenciones del Proyecto

- **Idioma del código**: inglés (nombres de variables, clases, métodos)
- **Idioma de la UI**: español
- **Estilo CSS**: Tailwind utilities + CSS custom en `home.css` / `admin.css`
- **Sin frameworks JS reactivos**: todo el frontend usa vanilla JS con IntersectionObserver
- **Imágenes**: almacenadas en `storage/app/public/`, servidas vía `Storage::url()`
- **Slugs**: auto-generados desde el título si no se proveen
