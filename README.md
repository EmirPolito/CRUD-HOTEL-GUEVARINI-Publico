<div align="center">
  <h1> Sistema de Gestión de Hotel</h1>
  <h1>HOTEL GUEVARINI</h1>
  <p>Una solución web integral para la administración eficiente de hoteles y reservaciones.</p>

  <!-- Badges -->
  <p>
    <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Badge"/>
    <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL Badge"/>
    <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5 Badge"/>
    <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3 Badge"/>
    <img src="https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E" alt="JavaScript Badge"/>
  </p>
</div>

<br/>

## Sobre el Proyecto

Este **Sistema de Gestión de Hotel (CRUD)** es una aplicación web robusta desarrollada bajo los estándares de **PHP** y bases de datos relacionales en **MySQL**. Está diseñado para simplificar y digitalizar los procesos administrativos dentro de un entorno hotelero, permitiendo un control estricto sobre los usuarios, el registro de clientes, el inventario de habitaciones y el ciclo completo de las reservaciones.

---

## ✨ Características Principales

- **Autenticación y Seguridad:**
  - Sistema de inicio de sesión seguro.
  - Gestión rigurosa de roles (Administrador y Cliente).
  - Verificación de cuentas nuevas y sistema de recuperación de contraseñas mediante enlace único enviado por correo electrónico.
  - Funcionalidad para **reenviar el correo de verificación** en caso de que un registro quede pendiente o el correo original se pierda.
- **Gestión de Clientes:**
  - Base de datos centralizada de información de contacto de huéspedes (activos/inactivos).
- **Control de Inventario (Habitaciones):**
  - Mantenimiento dinámico de habitaciones, abarcando diferentes tipos (Sencilla, Doble, Suite) y sus respectivos precios.
  - Monitoreo en tiempo real de su estatus (Disponible, Ocupada, Mantenimiento).
- **Administración de Reservaciones:**
  - Creación, seguimiento y confirmación de reservaciones hoteleras.
  - Trazabilidad y validación inteligente entre periodos de ingreso y salida.

---

## 🛠️ Tecnologías Utilizadas

- **Frontend:** Estructura en HTML5 semántico, diseño estilizado con Vanilla CSS3 y lógica interactiva con JavaScript.
- **Backend:** Desarrollado sobre PHP 7.4+ gestionando la lógica de negocio y las persistencias.
- **Base de Datos:** Servidor MySQL o MariaDB.
- **Librerías / Dependencias:** Manejadas mediante Composer (por ejemplo, PHPMailer para el control de la mensajería).

---

## 🚀 Guía de Instalación Rápida

Sigue estos pasos para desplegar el proyecto en tu entorno de desarrollo local:

### 1. Requisitos Previos

- Entorno de servidor local habilitado (XAMPP, WAMP, Laragon, MAMP).
- PHP version >= 7.4
- MySQL / MariaDB
- Composer (`composer`) instalado en tu equipo.

### 2. Configuración del Repositorio

1. Aloja los archivos del proyecto dentro del directorio raíz de tu servidor web (e.g., el directorio `htdocs` para XAMPP).
2. Abre la consola / terminal en la raíz del proyecto y ejecuta el comando para instalar dependencias de backend:
   ```bash
   composer install
   ```

### 3. Implementación de Base de Datos

1. Inicia sesión en tu gestor de base de datos favorito (como phpMyAdmin o DBeaver).
2. Importa el archivo principal `base_de_datos.sql`. Este script se hará cargo de construir la base `crud_hotel_3`, definir su arquitectura (tablas e integridad referencial) e inyectar el lote de datos iniciales.

### 4. Parámetros de Conexión y SMTP

**Configuración de Base de Datos (`php/conexion.php`)**
Verifica que las credenciales de la base de datos coincidan con tu entorno local:

```php
private $host = "tu-host";
private $username = "tu-usuario";
private $password = "tu-contraseña";
private $db_name = "tu-base-de-datos";
```

**Configuración de Correos (Mailtrap)**
Para que el envío de correos de verificación y recuperación funcione correctamente, el sistema utiliza **Mailtrap** (entorno de pruebas SMTP). Asegúrate de actualizar las credenciales de SMTP proporcionadas por Mailtrap en los siguientes archivos:

- `php/auth/procesar_registro.php`
- `php/auth/enviar_recuperacion.php`
- `php/auth/reenviar_verificacion.php`

### 5. Lanzamiento del Sistema

Por último, abre tu navegador web y dirígete a la ruta local del proyecto. Ejemplo:

```text
http://localhost/proyecto-crud-hotel-guevarini/CRUD-HOTEL-GUEVARINI-Publico/login.php
```

---

## 🔑 Cuentas de Prueba Preconfiguradas

Tras importar la base de datos, el sistema se abastecerá con un juego de credenciales semilla listas para evaluar el sistema en sus dos perfiles. La contraseña genérica asignada para pruebas es `12345`.

| Rol Asignado            | Correo Electrónico de Acceso              | Contraseña |
| :---------------------- | :---------------------------------------- | :--------- |
| 🛡️ **Administrador**    | `dsm23190242.epolito@alumnos.utsv.edu.mx` | `12345`    |
| 🛡️ **Administrador**    | `dsm23190360.imolina@alumnos.utsv.edu.mx` | `12345`    |
| 👤 **Cliente Genérico** | `emirpolitog@gmail.com`                   | `12345`    |

---

## 📂 Organización del Directorio

```text
CRUD-HOTEL-GUEVARINI-Publico/
├── css/                  # Diseño gráfico, reset y hojas de componente
├── img/                  # Activos multimedia visuales
├── js/                   # Control e interacción del cliente local
├── php/  y  libs/        # Capa de transacciones y procesamiento de formularios
├── views/                # Interfaces de Front y vistas autenticadas
├── vendor/               # Repositorio de librerías Composer
├── base_de_datos.sql     # Copia relacional en formato Script
├── composer.json         # Formato declarativo para repositorios Composer
├── README.md             # Documentación presente
└── login.php             # Puerta de enlace al dashboard / Punto de entrada
```

---

## 👨‍💻 Acerca de los Desarrolladores

Este proyecto fue estructurado y desarrollado como entrega e implementación final del Sistema de Gestión Hotelera por:

- **Emir Polito**
- GitHub: https://github.com/EmirPolito

- **Irving Molina**
- Github: https://github.com/1RV1N6-M3ND3Z
