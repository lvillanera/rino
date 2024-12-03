<?php
	/*
	--
		Estas constantes seran devueltas como objetos

	/*

	*/
	$ret["charset"] = "UTF-8";


	/*
	*
	* Clase para cargar la pagina de error por defecto es:
	* system\Rain\Errors\Not_Found
	*/

	$ret["page_error"] = 'Rino\Rain\Errors\Not_Found';
	/*
	*
	*	Configurando nuevas claves para su posterior uso
	*
	*/
	$ret["miclave"] = '123456789';
	$ret["segundaclave"] = '234456678';


	/*
		------------------------
		*IMPORTANTE
		*Esto no se debe modificar debido a que Rino carga el modulo por defecto al iniciar la aplicacion
		*
		*
		*
	*/



	$ret["defaultmodule"] = 'main';
	/*
		*
		*
		*	Si se desea usar el admin dentro de nuestra aplicacion
		*	Entonces se debe colocar el nombre de la ruta 
		*	Esta ruta apuntara a la carpeta 'Be'
		*
		*
	*/



	$ret["backend_url"] = 'admin';
	/*
		*
		*
		*	Confiracion de el token para el nivel de seguridad en crear el hash
		*
		*
	*/
	$ret["salt_token"] = '\\w//+aa_rino-code.';
	$ret["type_method"] = "AES-256-CBC";
	$ret["enc_key"] = "RW5NQlhjT2NXemJCQktvL2VwLzNtUT09";
	$ret["enc_iv"] = "RW5NQlhjT2NXemJCQktvL2VwLzNtUT09";
	/*
		*----------------------------------------------------
		*
		*	Trabajando con sessiones
		*
		*
	*/
	$ret["load_session"] = TRUE;// cargar la clase session (true) ? load : not;

	$ret["session_expiration"] = 7200;//duracion de las sessiones
	$ret["sess_cookie_name"] = "rino_session";
	$ret['sess_cache_expire'] = 120;//minutos que se limpiara la memoria cache de sessiones
	$ret['sess_save_path'] = NULL;
	$ret['sess_match_ip'] = FALSE;
	$ret['sess_time_to_update'] = 300;
	$ret['sess_regenerate_destroy'] = FALSE;


	/*
	*	
	*----------------------------------------------
	Configuracion de cookie
	*
	*/


	$ret['cookie_lifetime']	= 0;
	$ret['cookie_prefix']	= '';
	$ret['cookie_domain']	= '';
	$ret['cookie_path']		= '/';
	$ret['cookie_secure']	= FALSE;
	$ret['cookie_httponly'] 	= FALSE;



	/**/

	$ret['time_zone'] = 'America/Lima';

	$ret['set_locale'] = 'es_PE';

	/*
	 *
	 * Configuracion para el registro de logs de la aplicacion
	 *
	 */



	$ret["table_log"] = 'rino_log';

	/*
		*
		*
		* Configuracion para grabar logs generados por el usuario final
		*
		*
	*/


	$ret["add_logs"] = FALSE;//true = guardar; false=no graba los logs

	//campos correspondientes a la base de datos

	/*

		ID
		R_DATE_OPERATION
		R_IP
		R_BROWSER
		R_VERSION_BROWSER
		R_HOSTNAME
		R_HOSTSERVER
		R_PORT
		R_REQUEST_URI
		R_REQUEST_METHOD
		R_HTTP_REFERRER
		R_HTTP_PROTOCOL
		R_HTTP_LANGUAJE
		R_HTTP_STATUS
		R_HTTP_PARAMETERS
		R_SESSIONS_APP


		---------------------------------------------------
		Query generator


		CREATE TABLE `rino_log` (
		  `ID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
		  `R_SESSIONS_APP` varchar(50) DEFAULT NULL,
		  `R_DATE_OPERATION` datetime DEFAULT NULL,
		  `R_IP` varchar(50) DEFAULT NULL,
		  `R_BROWSER` varchar(200) DEFAULT NULL,
		  `R_VERSION_BROWSER` varchar(20) DEFAULT NULL,
		  `R_HOSTNAME` varchar(50) DEFAULT NULL,
		  `R_HOSTSERVER` varchar(30) DEFAULT NULL,
		  `R_PORT` varchar(10) DEFAULT NULL,
		  `R_REQUEST_URI` longtext,
		  `R_REQUEST_METHOD` varchar(20) DEFAULT NULL,
		  `R_HTTP_REFERRER` varchar(80) DEFAULT NULL,
		  `R_HTTP_PROTOCOL` varchar(20) DEFAULT NULL,
		  `R_HTTP_LANGUAJE` varchar(80) DEFAULT NULL,
		  `R_HTTP_STATUS` varchar(15) DEFAULT NULL,
		  `R_HTTP_PARAMETERS` longtext
		) 

	*/



	/*Iniciar la carga de modulos*/

	$ret["init_modules"] = TRUE;

	return $ret;

?>