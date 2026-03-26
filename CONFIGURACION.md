# Configuración y Despliegue del Sistema

Bienvenido a la guía de configuración del **Sistema de Gestión de Hotel**. Sigue estos pasos para lograr poner en marcha el proyecto en tu entorno local sin complicaciones.

---

## 📌 1. Requisitos Previos

Asegúrate de tener instalados los siguientes componentes antes de iniciar:

- **Servidor Web Local:** XAMPP, WAMP, Laragon, o MAMP (debe incluir Apache y MySQL/MariaDB).
- **PHP:** Versión 7.4 o superior.
- **Base de Datos:** MySQL o MariaDB.
- **Composer:** Manejador de dependencias para PHP.

---

## 📂 2. Clonación y Ubicación del Proyecto

1. Descarga el repositorio y extrae los archivos, o clónalo directamente usando Git.
2. Mueve la carpeta del proyecto (`CRUD-HOTEL-GUEVARINI-Publico`) al directorio de publicación de tu servidor local.
   -En **Apache**: `C:\apache\htdocs\`
   - En **XAMPP**: `C:\xampp\htdocs\`
   - En **WAMP**: `C:\wamp64\www\`
   - En **Laragon**: `C:\laragon\www\`

---

## 📦 3. Instalación de Dependencias

El sistema utiliza dependencias externas como `PHPMailer` para el manejo de correos electrónicos. Necesitarás instalarlas utilizando Composer:

1. Abre tu terminal o consola de comandos.
2. Navega hasta la carpeta raíz de tu proyecto.
3. Ejecuta el siguiente comando:
   ```bash
   composer install
   ```
   Esto creará la carpeta `vendor/` con todas las librerías necesarias.

---

## 🗄️ 4. Configuración de la Base de Datos

1. Abre y activa tu gestor de bases de datos (por ejemplo, encendiendo el módulo MySQL en XAMPP).
2. Entra a tu cliente de MySQL (phpMyAdmin, DBeaver, o Workbench).
3. Importa el archivo principal llamado `base_de_datos.sql`, que se encuentra en la raíz del proyecto.
   > **Nota:** Este archivo creará automáticamente la base de datos `hotel_guevarini_publico`, añadirá todas las tablas requeridas y datos de prueba.

---

## ⚙️ 5. Configuración de Credenciales

Para garantizar una correcta conexión a la base de datos y funcionalidad de envío de correos, edita los siguientes archivos:

### 5.1 Parámetros de la Base de Datos

Dirígete a: `php/conexion.php`

Asegúrate de reemplazar los siguientes valores para que coincidan con tu entorno local:

```php
private $host = "localhost"; // O la dirección de tu servidor de BD
private $db_name = "hotel_guevarini_publico";
private $username = "root"; // Tu usuario de MySQL
private $password = ""; // Tu contraseña de MySQL (comúnmente vacío en local)
```

### 5.2 Configuración de SMTP (Correos Electrónicos)

El sistema utiliza Mailtrap (o cualquier otro servidor SMTP) para enviar correos de verificación y recuperación de contraseña.

Abre y configura tus credenciales SMTP en los siguientes 3 archivos:

1. `php/auth/procesar_registro.php`
2. `php/auth/enviar_recuperacion.php`
3. `php/auth/reenviar_verificacion.php`
4. `php/usuarios/guardar_usuario.php`

Remplaza los campos marcados:

```php
$mail->Host = 'sandbox.smtp.mailtrap.io'; // O tu servidor SMTP preferido
$mail->Username = 'TU_USUARIO_SMTP'; // REEMPLAZAR
$mail->Password = 'TU_PASSWORD_SMTP'; // REEMPLAZAR
$mail->Port = 2525;
```

---

## 🚀 6. ¡Lanzamiento!

Una vez que hayas completado los pasos anteriores, abre tu navegador web favorito y accede a la ruta local del proyecto. Suponiendo que usas XAMPP, sería algo así:

```text
http://localhost/CRUD-HOTEL-GUEVARINI-Publico/
```

### 🔑 Cuentas Activas para Pruebas:

- **Administrador:**
  - Correo: `admin@correo.com`
  - Contraseña: `12345`
- **Cliente:**
  - Correo: `cliente@correo.com`
  - Contraseña: `12345`

¡Disfruta del sistema! Si encuentras algún problema, revisa los logs de tu servidor o asegúrate de haber importado correctamente la base de datos.
