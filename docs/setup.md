# Instalación y Configuración

## Requisitos

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL / MariaDB
- Extensiones PHP: `mbstring`, `xml`, `bcmath`, `curl`, `fileinfo`, `gd`

## Instalación rápida

```bash
# 1. Clonar e instalar dependencias
composer install
npm install

# 2. Configurar entorno
cp .env.example .env
php artisan key:generate

# 3. Configurar .env (DB, Mail, etc.)

# 4. Migrar y sembrar datos
php artisan migrate --seed

# 5. Link de storage
php artisan storage:link
```

## Comandos de Desarrollo

### Iniciar todo (recomendado)

```bash
composer dev
```

Ejecuta simultáneamente:

- `php artisan serve` — Servidor web en `localhost:8000`
- `php artisan queue:listen` — Procesador de colas (emails)
- `php artisan pail` — Logs en tiempo real
- `npm run dev` — Vite dev server (HMR)

### Comandos individuales

```bash
# Solo servidor PHP
php artisan serve

# Solo Vite (hot reload)
npm run dev

# Build de producción
npm run build

# Tests
composer test

# Lint PHP
vendor/bin/pint
```

## Datos de Prueba (Seeders)

Al ejecutar `php artisan migrate --seed` se crean:

| Entidad       | Datos                                                          |
| ------------- | -------------------------------------------------------------- |
| **Admin**     | `admin@creativeup.com` / `password`                            |
| **Servicios** | Social Media, Branding, Desarrollo Web, SEO Profesional        |
| **Proyectos** | TechFlow Rebranding, Naturale E-commerce, StartUp Hub Campaign |
| **Posts**     | 4 artículos de blog con fechas escalonadas                     |

## Variables de Entorno Clave

```env
APP_NAME=CreativeUP
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_DATABASE=creativeup

MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=...
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=hola@creativeup.com
MAIL_FROM_NAME="CreativeUP"

FILESYSTEM_DISK=public
```

## Producción

```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```
