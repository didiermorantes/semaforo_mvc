
=======================================
SISTEMA DE SEGUIMIENTO DE COMPROMISOS
=======================================

Este sistema está desarrollado en PHP puro con el patrón MVC y programación orientada a objetos. Permite registrar compromisos institucionales, hacer seguimiento con estados tipo semáforo, subir evidencia en PDF, gestionar sesiones por dirección responsable, y auditar con una bitácora completa de cambios.

--------------------------
REQUISITOS DEL SISTEMA
--------------------------
- PHP >= 7.4
- MariaDB (MySQL)
- Servidor local como XAMPP
- Composer (para `dompdf`)

--------------------------
PASOS DE INSTALACIÓN EN XAMPP
--------------------------

1. COPIAR LOS ARCHIVOS
   - Extrae el contenido de `semaforo_mvc_completo.zip`.
   - Copia la carpeta del proyecto dentro de:
     `C:/xampp/htdocs/`

   Ejemplo:
   `C:/xampp/htdocs/semaforo_mvc`

2. IMPORTAR LA BASE DE DATOS
   - Abre phpMyAdmin.
   - Crea la base de datos ejecutando el script:
     `semaforo_db.sql`

3. CONFIGURAR RUTAS
   - Asegúrate que tu archivo `config.php` tenga definida la constante BASE_URL:

     define('BASE_URL', 'http://localhost/semaforo_mvc/public');

4. INSTALAR DEPENDENCIAS
   - Abre una terminal en la raíz del proyecto.
   - Ejecuta:

     composer require dompdf/dompdf

   Esto permitirá generar archivos PDF para la exportación de la bitácora.

5. ABRIR EL PROYECTO EN EL NAVEGADOR
   - Ve a: http://localhost/semaforo_mvc/public

--------------------------
USO DEL SISTEMA
--------------------------

- Inicia sesión con una de las direcciones disponibles en el menú desplegable.
  Ejemplo: "Despacho" para perfil administrador.

- Como administrador:
  - Puedes crear, editar compromisos, ver la bitácora completa, y el log de errores.
  - Puedes descargar el log o limpiar su contenido desde el panel.

- Otros usuarios solo acceden a sus propios compromisos y acciones auditadas.

--------------------------
SOPORTE Y MEJORAS
--------------------------
Este sistema es modular y se puede ampliar fácilmente:
- Agregar autenticación por contraseña.
- Reportes automáticos en PDF o Excel.
- Gestión de usuarios desde base de datos.

¡Listo para producción en entorno controlado institucional!
