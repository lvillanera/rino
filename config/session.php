<?php 

if(!defined("APP_SYSTEM")) die("APPLICACION DETENIDA");

/*
| ------------------------------------------------- -------------------------
| Variables de sesión
| ------------------------------------------------- -------------------------
|
| 'sess_driver'
|
| El controlador de almacenamiento a utilizar: archivos, base de datos, redis, memcached
|
| 'sess_cookie_name'
|
| El nombre de la cookie de sesión, debe contener solo [0-9a-z_-] caracteres
|
| 'sess_expiration'
|
| El número de SEGUNDOS que desea que dure la sesión.
| Establecer en 0 (cero) significa que caduca cuando se cierra el navegador.
|
| 'sess_save_path'
|
| La ubicación para guardar sesiones en, dependiente del conductor.
|
| Para el controlador de 'archivos', es una ruta a un directorio grabable.
| ADVERTENCIA: ¡Sólo se admiten rutas absolutas!
|
| Para el controlador de 'base de datos', es un nombre de tabla.
| Por favor lea el manual para el formato con otros controladores de sesión.
|
| IMPORTANTE: ¡SE REQUIERE que establezca una ruta de guardado válida!
|
| 'sess_match_ip'
|
| Si se debe hacer coincidir la dirección IP del usuario al leer los datos de la sesión.
|
| 'sess_time_to_update'
|
| Cuántos segundos transcurre entre la regeneración del ID de la sesión.
|
| 'sess_regenerate_destroy'
|
| Si se deben destruir los datos de sesión asociados con el ID de sesión anterior
| cuando se regenera automáticamente el ID de sesión. Cuando se establece en FALSE, los datos
| será eliminado más tarde por el recolector de basura.
|
| Otras configuraciones de cookies de sesión se comparten con el resto de la aplicación,
| excepto por 'cookie_prefix' y 'cookie_httponly', que se ignoran aquí.
|
*/

$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'init_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = '';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;

$config['cookie_lifetime'] = 0;
$config['cookie_path'] = "/";
$config['cookie_domain'] = "";
$config['cookie_secure'] = "";



 ?>