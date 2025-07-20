# ProyectoHoteles
Sistema web dinámico para la administración de reservas de habitaciones en hoteles.

---

## Requisitos Previos

- PHP 8 o superior  
- Servidor Apache (XAMPP, WAMP o similar)  
- MySQL  
- Composer (para instalar librerías PHP)  

---

## Configuración del Entorno Local

1. Clonar el repositorio o descargar el código desde GitHub:  
git clone https://github.com/roberto211280/ProyectoHoteles.git

markdown
Copiar
Editar

2. Copiar o mover la carpeta del proyecto a la carpeta raíz del servidor local (ejemplo, `htdocs` en XAMPP).

3. Crear la base de datos:  
- Usar phpMyAdmin o consola MySQL para crear una base de datos llamada `hoteles`.  
- Importar el archivo `database/hoteles (1).sql` para crear las tablas y datos iniciales.

4. Configurar la conexión a la base de datos:  
- Editar el archivo de configuración (`config.php` o el archivo donde configures la conexión) con las credenciales locales:  
  ```php
  $host = "localhost";
  $user = "root"; // o tu usuario MySQL
  $password = ""; // o tu contraseña
  $dbname = "hoteles";
  ```

5. Instalar dependencias PHP con Composer:  
- Abrir la terminal en la carpeta del proyecto y ejecutar:  
  ```
  composer install
  ```

6. Acceder al sistema desde el navegador:  
http://localhost/ProyectoHoteles/

yaml
Copiar
Editar

---

## Dependencias del Sistema

- PHP 8  
- Apache  
- MySQL  
- Bootstrap 5  
- Librería QR Code vía Composer  

---

## Recomendaciones para Pruebas Funcionales

- Crear un usuario nuevo mediante el formulario de registro.  
- Iniciar sesión con el usuario creado.  
- Reservar una habitación y verificar que la reserva se registre correctamente.  
- Probar la generación y visualización del código QR para la reservación.  
- Revisar que los datos se guarden correctamente en la base de datos (usuarios, reservas, pagos).  
- Probar cierre de sesión y manejo de sesión por inactividad.  

---

## Contenido del Repositorio

ProyectoHoteles/
│
├─ database/
│ └─ hoteles (1).sql
│
├─ index.php
├─ login.php
├─ logout.php
├─ register.php
├─ reservar.php
├─ procesarReserva.php
├─ misReservas.php
├─ detalleHotel.php
│
├─ css/
├─ js/
├─ vendor/
│
└─ README.md

yaml
Copiar
Editar

---

Repositorio en GitHub:  
https://github.com/roberto211280/ProyectoHoteles

---

