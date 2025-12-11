# 🔧 Corrección de Variables en Railway

Tus capturas muestran que faltan configuraciones críticas para que la app arranque y se conecte a la base de datos.
El servicio aparece "Offline" principalmente porque falta la `APP_KEY` y los datos de conexión a MySQL.

Por favor, ve a la pestaña **Variables** de tu servicio `JarochosPizza` y agrega/modifica lo siguiente:

## 1. Variables Faltantes (¡CRITICAS!)

Agrega estas variables nuevas:

| Variable | Valor | ¿Por qué? |
| :--- | :--- | :--- |
| `APP_KEY` | `base64:D1o2zSQHmdwjbbvjARWGfzWHHaYnu50pM3TAwnitDFs=` | **Sin esto la app no inicia.** (Cópiala exacta) |
| `DB_HOST` | `${{MySQL.HOST}}` | Conecta con tu servicio MySQL automáticamente. |
| `DB_PORT` | `${{MySQL.PORT}}` | Puerto de la base de datos. |
| `DB_DATABASE` | `${{MySQL.DATABASE}}` | Nombre de la base de datos. |
| `DB_USERNAME` | `${{MySQL.USER}}` | Usuario de la base de datos. |
| `DB_PASSWORD` | `${{MySQL.PASSWORD}}` | Contraseña de la base de datos. |

> **Truco:** Al escribir `${{MySQL.` Railway te autocompletará las variables si tienes el servicio de MySQL creado en el mismo proyecto.

## 2. Variables a Corregir

Modifica las que ya tienes:

| Variable | Valor Actual | Nuevo Valor |
| :--- | :--- | :--- |
| `APP_ENV` | `local` | **`production`** |
| `APP_DEBUG` | `true` | **`false`** |
| `APP_URL` | `http://localhost` | *Tu dominio público de Railway* (ej: `https://web-production-xxxx.up.railway.app`) |

## 3. Después de guardar

1.  Railway redesplegará automáticamente.
2.  Si sigue fallando, ve a la pestaña **Deployments**, haz clic en el último intento y mira la pestaña **Build Logs** o **Deploy Logs** para ver el error exacto.
