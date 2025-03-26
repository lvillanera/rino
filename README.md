<div align="center"><img src="http://opticanuevavision.pe/web/data/rino-logo.png" width="50%"></div>
<h1>Acerca de Rino Framework (oficial)</h1>

Framework para desarrollo de aplicaciones en PHP 


<h4>-- FRAMEWORK PARA DESARROLLOS DE PROYECTO PEQUEÑOS, MEDIANO, MEDIANO-AVANZADO</h4>
- Carpeta _cache donde rain tpl almacenara los archivos temporales que crea para procesar las plantillas
- Carpeta config aqui se crearan las configuraciones a la BD y definir constantes.
- Carpeta public donde se encuentran los archivos css,js, ademas de ya estar incluidos como boostrap y jquery entre otras librerias.
- Carpeta vendor donde se encuentran las configuraciones de la aplicación.
- <b>Carpeta app</b> la aplicacion principal para nuestro proyecto
- No contiene plataformas de despliegues
- carpetas iniciales para manejar el back (https:midominio.com/admin) y front (https:midominio.com), estas url son configurables pueden encontrarse en la config/config.php como <strong>$ret["backend_url"] = 'admin';</strong>
- carpeta inicial de desarrollo <strong>$ret["defaultmodule"] = 'main';</strong>

<h4>Requerimientos para su instalacion</h4>

<br><br><img src="https://lvillanera.github.io/images/rino_logo.png"><br><br>

- PHP >= 7.5
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extensión

<h3>Vulnerabilidades</h3>
* Importante, si descubre alguna vulnerabilidad escribir a <a href="mailto:leninlarry96@gmail.com">leninlarry96@gmail.com</a>, gracias por su apoyo ;)


<h4>¿Qué Puedo hacer Con Rino?</h4>
<ul>
  <li>URL Dinamicas</li>
  <li>Trabajar Con Módulos por separado</li>
  <li>Helpers (string,file,globals,html)</li>
  <li>Sesiones</li>
  <li>Clase request</li>
  <li>PDO Database gestion propia de Rino</li>
  <li>Upload</li>
  <li>Headers</li>
  <li>Tokens</li>
  <li>Conexión con clases de Symfony</li>
  <li>Trabajar calendarios con Carbon de Laravel</li>
  <li>Inyectar dependencias a otros componentes con Events</li>
  <li>Usar encriptaciones RSA, AES, SHA256</li>
  <li>Personalizar código</li>
  <li>Configurar url para sistemas y landing al mismo tiempo</li>
  <li>Usar Illuminate para bases de datos</li>
  <li>Vista para Diseñadores con RainTPL</li>
  <li>Detección de log o eventos propagados en el sistema (log_error)</li>
</ul>
<br>
<strong>Importante: Al instalar paquetes con composer</strong>
<p>El archivo Runner.php se dara de baja lo cual genera conflicto para correr la aplicación.<br> 
por lo cual hay que sacar un backup primero de este archivo y luego de terminar la instalación guardar nuevamente en vendor/phroute/src/Runner.php</p>

<strong>Para instalar paquetes de rino, ejecutar en la terminal: sudo mv rino /usr/local/bin/
<br> luego ejecutar la descarga de los paquetes propios ejemplo: rino install auth-module</strong>

luego posicionarse en la raiz del proyecto
y agregar en las variables globales
------------------------------------------------------------------------------------
#RINO
alias rino='/Users/leninvillanera/Documents/rino/rino/rino'

y luego ejecutar: chmod +x /Users/leninvillanera/Documents/rino/rino
------------------------------------------------------------------------------------


rino make:controller UserController
rino make:model User
