<div align="center">
  <h1>HOTEL GUEVARINI</h1>
  <h1> Sistema de Gestión de Hotel</h1>
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
https://www.mintlify.com/EmirPolito/CRUD-HOTEL-GUEVARINI-Publico
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

Para conocer todos los pasos detallados de instalación, desde la preparación de la base de datos hasta la configuración de PHP y SMTP, así como poner en marcha este proyecto de forma exitosa, revisa nuestra:

👉 **[Guía Completa de Configuración y Despliegue](CONFIGURACION.md)**

---

## 🔑 Cuentas de Prueba Preconfiguradas

Tras importar la base de datos, el sistema se abastecerá con un juego de credenciales semilla listas para evaluar el sistema en sus dos perfiles. La contraseña genérica asignada para pruebas es `12345`.

| Rol Asignado      | Correo Electrónico de Acceso | Contraseña |
| :---------------- | :--------------------------- | :--------- |
| **Administrador** | `admin@correo.com`           | `12345`    |
| **Cliente**       | `cliente@correo.com`         | `12345`    |

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

## 📜 Licencia

Este proyecto está bajo la Licencia MIT. Para más detalles, consulta el archivo [LICENSE](LICENSE).

---

## 👨‍💻 Desarrolladores

Este proyecto fue estructurado y desarrollado como entrega e implementación final del Sistema de Gestión Hotelera por:

**Emir Polito**

- GitHub: https://github.com/EmirPolito

**Irving Mendez**

- Github: https://github.com/1RV1N6-M3ND3Z
