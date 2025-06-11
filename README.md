# RavePass

## 🚀 Presentación del Proyecto

**RavePass** es un proyecto concebido y desarrollado por **Daniel Lomas** con el propósito principal de **democratizar y simplificar el acceso a los eventos de música electrónica más destacados en España**. Nace de una visión personal y una profunda pasión por la cultura rave, buscando ser el puente definitivo entre los entusiastas de la música electrónica y las experiencias que definen esta vibrante escena.

Esta plataforma está diseñada para facilitar la **búsqueda y la compra simulada de entradas** para eventos de techno, house y otros géneros afines. Busca centralizar la información que a menudo está dispersa, ofreciendo una solución integral para descubrir y planificar las mejores noches de música electrónica.

## ✨ Características Principales

* **Exploración de Eventos**: Navega por un feed dinámico de eventos de música electrónica con información detallada (descripción, fechas, ubicación, precios).
* **Gestión de Usuarios**:
    * Registro y autenticación de usuarios.
    * Edición y gestión de perfiles de usuario.
* **Gestión de Entradas (Simulada)**:
    * Proceso de compra simulada de tickets para eventos.
    * Visualización de "Mis Entradas" adquiridas por el usuario.
* **Panel de Administración Integral**:
    * Control total (CRUD) sobre usuarios y publicaciones de eventos.
    * Gestión de categorías de eventos.

## 🛠️ Tecnologías Utilizadas

El proyecto RavePass ha sido construido sobre una arquitectura robusta y modular, utilizando las siguientes tecnologías:

* **Backend**:
    * Lenguaje: `PHP`
    * Framework: `Laravel`
    * Base de Datos: `MySQL`
* **Frontend**:
    * Lenguajes: `HTML`, `CSS`, `JavaScript`
    * Framework CSS: `Tailwind CSS`
    * Herramienta de construcción: `Vite`
* **Control de Versiones**: `Git`

## 📦 Instalación y Configuración (Entorno de Desarrollo Local)

Para configurar y ejecutar el proyecto RavePass en tu máquina local, sigue estos pasos:

### Requisitos Previos

Asegúrate de tener instaladas las siguientes herramientas:

* **XAMPP** (incluye Apache, MySQL y PHP)
* **Git**
* **Composer**
* **Node.js y npm** (o Yarn)

### Pasos de Instalación

1.  **Clona el Repositorio**:
    ```bash
    git clone [https://github.com/daniellms96/repositorioLomas.git](https://github.com/daniellms96/repositorioLomas.git)
    cd RavePass
    ```

2.  **Configuración de Laravel**:
    ```bash
    composer install
    cp .env.example .env
    php artisan key:generate
    ```
    * Edita el archivo `.env` y configura tus credenciales de base de datos MySQL (por ejemplo, `DB_DATABASE=ravepass`, `DB_USERNAME=root`, `DB_PASSWORD=`).
    * Crea la base de datos `ravepass` en tu gestor de base de datos (ej. phpMyAdmin).

3.  **Migraciones de Base de Datos**:
    ```bash
    php artisan migrate
    ```
    * (Opcional) Si deseas poblar la base de datos con datos de prueba:
        ```bash
        php artisan db:seed
        ```

4.  **Configuración del Frontend**:
    ```bash
    npm install
    npm run dev # Para desarrollo o npm run build para producción
    ```

5.  **Inicia el Servidor Local**:
    ```bash
    php artisan serve
    ```
    Accede a la aplicación en tu navegador web, generalmente en `http://127.0.0.1:8000`.

## 📈 Futuras Mejoras

El proyecto está diseñado para ser escalable y permitir futuras expansiones. Algunas ideas para futuras mejoras incluyen:

* Implementación de pasarelas de pago reales.
* Búsqueda avanzada y filtros de eventos.
* Notificaciones personalizadas para usuarios.
* Funcionalidades de comentarios o valoraciones para eventos.

## 🎓 Propósito del Proyecto

Este proyecto ha sido desarrollado por **Daniel Lomas** como parte de su **Trabajo de Fin de Grado (TFG)** para el **Grado Superior de Desarrollo de Aplicaciones Web (DAW)**. Representa la aplicación práctica de los conocimientos adquiridos en el desarrollo web full-stack.

---

¡Esperamos que disfrutes explorando RavePass!
