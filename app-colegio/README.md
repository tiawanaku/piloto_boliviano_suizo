# Colegio Virtual (piloto)

Aplicación del Colegio Virtual: **Laravel 13 + Filament 5** sobre PHP 8.3, con SQLite.
Es un **piloto de demostración con datos 100 % ficticios** (`@colegio-piloto.test`): no hay producción, staging ni correos a personas reales.

Documentación del proyecto (historias, arquitectura, sprints) en el vault de Obsidian de la raíz del repositorio; el stack está en `05-Arquitectura/Decisiones/ADR-005 Stack PHP Laravel y Filament.md`.

## Requisitos

- PHP 8.3 o superior con las extensiones `pdo_sqlite`, `sqlite3`, `mbstring` e `intl`, y soporte de Argon2id (`php -r "var_dump(defined('PASSWORD_ARGON2ID'));"` debe mostrar `true`).
- Composer 2.
- Node.js 20+ y npm (solo para `composer dev`, que lanza los procesos con `npx`).
- No se necesita Docker ni un servidor de base de datos.

## Arranque desde cero

Desde la carpeta `app-colegio/`:

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
composer dev
```

`composer dev` levanta juntos el servidor web (`http://127.0.0.1:8000`), el *worker* de la cola, los logs (`pail`) y Vite. Para detenerlo: `Ctrl+C`.

Sin npm se puede arrancar a mano en dos terminales: `php artisan serve` y `php artisan queue:work`.

Paneles:

| Panel | Dirección |
|---|---|
| Administrativo | http://127.0.0.1:8000/admin |
| Docente | http://127.0.0.1:8000/docente |

Cuenta ficticia creada por el *seeder*: `demo@colegio-piloto.test` / `password`.

## Configuración del piloto (`.env`)

| Variable | Valor | Para qué |
|---|---|---|
| `DB_CONNECTION` | `sqlite` | Base en `database/database.sqlite` |
| `SESSION_DRIVER`, `CACHE_STORE`, `QUEUE_CONNECTION` | `database` | Sin Redis |
| `MAIL_MAILER` | `log` | Los correos quedan en `storage/logs/laravel.log` |
| `APP_LOCALE` / `APP_TIMEZONE` | `es` / `America/La_Paz` | Español y hora de Bolivia |
| `HASH_DRIVER` | `argon2id` | Hash de contraseñas |
| `COLEGIO_*` | ver `config/colegio.php` | Dominio institucional, bloqueo, vigencias |

## Correo y colas

Todas las notificaciones por correo van **en cola** (`ShouldQueue`); el *worker* lo levanta `composer dev`.

Para probar el envío:

```bash
php artisan colegio:correo-prueba prueba@colegio-piloto.test
```

El comando solo acepta correos del dominio ficticio del piloto. Con `MAIL_MAILER=log` el correo aparece en `storage/logs/laravel.log` cuando el *worker* procesa la cola.

**Mailpit (opcional)** para ver los correos en una bandeja web durante la demostración:

1. Instale y ejecute [Mailpit](https://mailpit.axllent.org) (un solo binario; escucha SMTP en el puerto 1025 y la web en el 8025).
2. En `.env`, comente `MAIL_MAILER=log` y descomente el bloque de Mailpit (`MAIL_MAILER=smtp`, `MAIL_HOST=127.0.0.1`, `MAIL_PORT=1025`).
3. `php artisan config:clear` y abra http://127.0.0.1:8025.

**Tareas programadas:** `routes/console.php` registra `auth:clear-resets` (diario). En local se ejecutan con `php artisan schedule:work`.

## Cómo hacer la demostración

1. Regenerar la base de demostración (borra la base actual y carga solo datos ficticios):

   ```bash
   php artisan colegio:demo          # pide confirmación; --force para no preguntar
   ```

   El comando se niega a correr con `APP_ENV=production`, ejecuta `migrate:fresh --seed` y muestra las direcciones de los paneles y las cuentas ficticias. Los *seeders* que agregue cada sprint en `DatabaseSeeder` quedan incluidos.
2. Levantar la aplicación: `composer dev`.
3. Entrar a http://127.0.0.1:8000/admin con `demo@colegio-piloto.test` / `password`.
4. Si la demostración incluye correos, tener Mailpit abierto (ver arriba) o mostrar `storage/logs/laravel.log`.

Si la demostración se publica fuera del equipo, usar HTTPS y cambiar `APP_URL`; los datos siguen siendo ficticios.

## Calidad

```bash
vendor/bin/pint --test        # formato
vendor/bin/phpstan analyse    # análisis estático (Larastan)
vendor/bin/pest               # pruebas (SQLite en memoria)
composer audit                # vulnerabilidades de dependencias
```

## Reglas del piloto

- Solo datos ficticios con correos `@colegio-piloto.test` (hasta 15 administrativos y 50 docentes).
- Ningún correo sale a personas reales.
- Textos de interfaz en español mediante `lang/es`.
