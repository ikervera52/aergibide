# Aergibide - Plataforma de Preguntas y Respuestas

![Estado](https://img.shields.io/badge/Estado-Producción-success)
![Versión](https://img.shields.io/badge/Versión-1.0-blue)
![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql&logoColor=white)

Guía técnica de arquitectura, requisitos e instalación para el entorno local y servidor de producción de la aplicación **Aergibide**.

---

## 📋 Tabla de Contenidos
- [Descripción General](#-descripción-general)
- [Arquitectura del Proyecto](#-arquitectura-del-proyecto)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Requisitos del Sistema](#-requisitos-del-sistema)
- [Configuración de la Base de Datos](#-configuración-de-la-base-de-datos)
- [Guía de Despliegue (Paso a Paso)](#-guía-de-despliegue-paso-a-paso)
- [Verificación Post-Despliegue](#-verificación-post-despliegue)

---

## 📝 Descripción General

**Aergibide** es una aplicación web de preguntas y respuestas desarrollada en PHP nativo mediante el patrón de arquitectura **MVC (Modelo-Vista-Controlador)**. Permite la publicación de dudas, carga de imágenes adjuntas, notificaciones y gestión administrativa de usuarios y categorías.

> **Importante:** La interfaz utiliza librerías externas mediante CDN (**Bootstrap Icons** y **SweetAlert2**). Los clientes requieren conexión a Internet para visualizarlas correctamente.

---

## 🏗 Arquitectura del Proyecto

El flujo de control se centraliza a través del archivo `index.php` que invoca al componente `Router.php`. Por defecto se ejecuta el controlador `PreguntaController` y la acción `index`. Cualquier controlador diferente a `UsuarioController` exige autenticación previa.

| Capa | Tecnología | Ubicación |
| :--- | :--- | :--- |
| **Vista (Cliente)** | HTML, CSS, JavaScript | `views/`, `styles/`, `scripts/` |
| **Controlador** | PHP (Respuestas HTML o JSON) | `controllers/` |
| **Modelo** | PHP + PDO (Consultas SQL) | `models/` |
| **Base de Datos** | MySQL / MariaDB | Esquema `aergibide` |
| **Almacenamiento** | Imágenes y Fotos de Perfil | `uploads/` |

---

## 📂 Estructura del Proyecto

> ⚠️ **Atención:** La raíz web del servidor HTTP (**DocumentRoot**) debe apuntar estrictamente a la carpeta interior `aergibide/aergibide/`. Los directorios externos como `documentacion/` **no** deben quedar accesibles desde la red pública.

```text
aergibide/
├── aergibide/              ← Raíz web (DocumentRoot)
│   ├── index.php           ← Punto de entrada principal
│   ├── Router.php          ← Enrutador de peticiones
│   ├── config/
│   │   └── config.php      ← Credenciales de Base de Datos
│   ├── controllers/        ← Controladores MVC
│   ├── models/             ← Modelos y lógica de datos
│   ├── views/              ← Vistas de la aplicación
│   ├── scripts/            ← Archivos JS locales
│   ├── styles/             ← Archivos CSS locales
│   └── uploads/            ← Almacenamiento de adjuntos y avatares
├── documentacion/          ← Documentación técnica (NO PUBLICAR)
├── script_creacio_BD.sql   ← Script de creación de estructuras SQL
└── README.md
```

---

## 💻 Requisitos del Sistema

### 1. Software del Servidor
* **Sistema Operativo:** Linux (Debian/Ubuntu recomendado) o Windows (XAMPP/WAMP).
* **Servidor Web:** Apache 2.4 (con `mod_rewrite` opcional) o Nginx + PHP-FPM.
* **PHP:** Versión `8.0` o superior.
* **Base de Datos:** MySQL `5.7+` o MariaDB `10.3+`.
* **Extensiones PHP requeridas:** `pdo_mysql`, `fileinfo`, `mbstring`.

### 2. Configuración de PHP (`php.ini`)
La aplicación permite subir archivos de hasta **30 MB**, por lo que es necesario ajustar los siguientes límites:

```ini
upload_max_filesize = 30M
post_max_size = 32M
file_uploads = On
```
*Si utilizas Nginx, añade también en el bloque del sitio:* `client_max_body_size 32M;`

---

## 🗄️ Configuración de la Base de Datos

### 1. Estructura
Ejecuta el script SQL incluido en el repositorio para generar la estructura de tablas:
```bash
mysql -u usuario -p nombre_bd < script_creacio_BD.sql
```

### 2. Datos Iniciales Requeridos
Ejecuta el siguiente bloque SQL para insertar los registros básicos de inicio (Avatar por defecto, categorías iniciales y usuario Administrador):

```sql
-- Foto de perfil por defecto (ID obligatoria = 1)
INSERT INTO foto_perfil_usuarios (id, nombre, ruta_archivo, mime_tipo, tamano) 
VALUES (1, 'Default Avatar', './uploads/default-avatar.png', 'image/png', 173484);

-- Categorías de inicio
INSERT INTO categorias_preguntas (id, nombre, slug) 
VALUES 
  (1, 'Programación Web', 'programacion-web'),
  (2, 'Bases de Datos', 'bases-de-datos'),
  (3, 'Sistemas Operativos', 'sistemas-operativos');

-- Usuario Administrador inicial
INSERT INTO usuarios (nombre, tipo, email, contrasena, foto_perfil_id, estado) 
VALUES ('Admin', 'admin', 'admin@ejemplo.com', '12345Abcde', 1, 'activo');
```

> 🔐 **Seguridad:** Cambia la contraseña por defecto del administrador tras el primer inicio de sesión.

---

## 🚀 Guía de Despliegue (Paso a Paso)

### 1. Configuración de Archivos (`config.php`)
Edita el archivo `aergibide/config/config.php` e introduce las credenciales correspondientes a tu base de datos de producción:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'aergibide');
define('DB_USER', 'usuario_db');
define('DB_PASS', 'password_seguro');
```

### 2. Permisos de Almacenamiento (Linux)
Asegúrate de conceder permisos de escritura sobre la carpeta `uploads/` al usuario del servidor web (ej. `www-data` o `daemon`):

```bash
sudo chown -R www-data:www-data /var/www/aergibide/aergibide/uploads
sudo chmod -R 750 /var/www/aergibide/aergibide/uploads
```

### 3. Ejemplo de Despliegue en Entorno XAMPP (Linux)

```bash
# 1. Instalar git y navegar al htdocs de XAMPP
sudo apt install git
cd /opt/lampp/htdocs

# 2. Clonar la rama main del repositorio
sudo git clone -b main <URL_DEL_REPOSITORIO> miproyecto

# 3. Asignar los permisos del servidor web
sudo chown -R egibide:daemon /opt/lampp/htdocs/miproyecto
sudo chmod -R 775 /opt/lampp/htdocs/miproyecto

# 4. Importar base de datos
/opt/lampp/bin/mysql -u root < /opt/lampp/htdocs/miproyecto/script_creacio_BD.sql
```

#### Actualización de código:
```bash
cd /opt/lampp/htdocs/miproyecto
git pull
```

---

## ✅ Verificación Post-Despliegue

Revisa la lista de comprobación antes de autorizar la puesta en producción:

- [ ] La pantalla de login carga con los estilos CSS y logotipos.
- [ ] El login del administrador funciona correctamente y redirige a la vista principal.
- [ ] Es posible publicar una pregunta con imagen adjunta (verificar archivo creado en `uploads/`).
- [ ] La imagen del avatar por defecto y de las publicaciones se cargan de forma adecuada.
- [ ] Las notificaciones y respuestas de otros usuarios funcionan en tiempo real/sesión.
- [ ] Los paneles de administración permiten dar de alta nuevos usuarios.
- [ ] Los componentes gráficos (iconos de Bootstrap y alertas de SweetAlert2) se renderizan correctamente.