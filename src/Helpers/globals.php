<?php


use Rino\Security\XSRF;
use Illuminate\Support\HtmlString;


if (!function_exists('is_php')) {

	function is_php($version) {
		static $_is_php;
		$version = (string) $version;

		if (!isset($_is_php[$version])) {
			$_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
		}

		return $_is_php[$version];
	}
}



if (! function_exists('csrf_field')) {
    /**
     * Generate a CSRF token form field.
     *
     * @return String
     */
    function csrf_field()
    {
        return new HtmlString('<input type="hidden" name="value_token" value="'.csrf_token().'">');
    }
}


if(!function_exists('csrf_token')) 
{
	/**
     * Get the CSRF token value.
     *
     * @return string
     *
     */

	function csrf_token()
	{
		$xsrf = new XSRF();

        if (isset($xsrf)) {
        	$token = $xsrf->getToken();
        	if(is_empty($token)){
				$xsrf->generateToken();
        		$token = $xsrf->getToken();
        		
        	}
            return $token;
        }

	}
}


if (!function_exists('get_browser_name')) {

	function get_browser_name($user_agent) {
		$u_agent = $user_agent;
		$bname = 'No Encontrado';
		$platform = 'No Encontrado';
		$version = "";

		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		} elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}

		if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		} elseif (preg_match('/Firefox/i', $u_agent)) {
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		} elseif (preg_match('/Chrome/i', $u_agent)) {
			$bname = 'Google Chrome';
			$ub = "Chrome";
		} elseif (preg_match('/Safari/i', $u_agent)) {
			$bname = 'Apple Safari';
			$ub = "Safari";
		} elseif (preg_match('/Opera/i', $u_agent)) {
			$bname = 'Opera';
			$ub = "Opera";
		} elseif (preg_match('/Netscape/i', $u_agent)) {
			$bname = 'Netscape';
			$ub = "Netscape";
		}

		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
			')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}

		$i = count($matches['browser']);
		if ($i != 1) {
			if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
				$version = $matches['version'][0];
			} else {
				$version = $matches['version'][1];
			}
		} else {
			$version = $matches['version'][0];
		}
		if ($version == null || $version == "") {$version = "?";}

		return (Object) array(
			'userAgent' => $u_agent,
			'name' => $bname,
			'version' => $version,
			'platform' => $platform,
			'pattern' => $pattern,
		);
	}
}


if (!function_exists('remove_invisible_characters')) {

	function remove_invisible_characters($str, $url_encoded = TRUE) {
		$displays = array();

		if ($url_encoded) {
			$displays[] = '/%0[0-8bcef]/';
			$displays[] = '/%1[0-9a-f]/';
		}

		$displays[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';

		do {
			$str = preg_replace($displays, '', $str, -1, $all);
		} while ($all);

		return $str;
	}
}


if(!function_exists('is_empty'))
{
	function is_empty(&$value='')
	{
		return !isset($value) || (is_scalar($value) ? (trim($value) === '') : empty($value));
	}
}





if (!function_exists('set_status_header')) {
	/**
	 *
	 * @param	int	
	 * @param	string
	 * @return	void
	 */
	function set_status_header($code = 200, $text = '') {

		global $is_headers_request;
		if (empty($code) OR !is_numeric($code)) {
			show_error('Status codes must be numeric', 500);
		}

		if (empty($text)) {
			is_int($code) OR $code = (int) $code;
			$stati = array(
				200 => 'OK',
				201 => 'Created',
				202 => 'Accepted',
				203 => 'Non-Authoritative Information',
				204 => 'No Content',
				205 => 'Reset Content',
				206 => 'Partial Content',

				300 => 'Multiple Choices',
				301 => 'Moved Permanently',
				302 => 'Found',
				303 => 'See Other',
				304 => 'Not Modified',
				305 => 'Use Proxy',
				307 => 'Temporary Redirect',

				400 => 'Bad Request',
				401 => 'Unauthorized',
				403 => 'Forbidden',
				404 => 'Not Found',
				405 => 'Method Not Allowed',
				406 => 'Not Acceptable',
				407 => 'Proxy Authentication Required',
				408 => 'Request Timeout',
				409 => 'Conflict',
				410 => 'Gone',
				411 => 'Length Required',
				412 => 'Precondition Failed',
				413 => 'Request Entity Too Large',
				414 => 'Request-URI Too Long',
				415 => 'Unsupported Media Type',
				416 => 'Requested Range Not Satisfiable',
				417 => 'Expectation Failed',
				422 => 'Unprocessable Entity',

				500 => 'Internal Server Error',
				501 => 'Not Implemented',
				502 => 'Bad Gateway',
				503 => 'Service Unavailable',
				504 => 'Gateway Timeout',
				505 => 'HTTP Version Not Supported',
			);

			if (isset($stati[$code])) {
				$text = $stati[$code];
			} else {
				show_error('No status text available. Please check your status code number or supply your own message text.', 500);
			}
		}

		if (strpos(PHP_SAPI, 'cgi') === 0) {
			header('Status: ' . $code . ' ' . $text, TRUE);
		} else {
			$server_protocol = isset($is_headers_request['SERVER_PROTOCOL']) ? $is_headers_request['SERVER_PROTOCOL'] : 'HTTP/1.1';
			header($server_protocol . ' ' . $code . ' ' . $text, TRUE, $code);
		}
	}
}


if (!function_exists('prmUri')) {
	function prmUri($key = '') {
		global $is_headers_request;
		$basepath = implode('/', array_slice(explode('/', $is_headers_request['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($is_headers_request['REQUEST_URI'], strlen($basepath));
		if (strstr($uri, '?')) {
			$uri = substr($uri, 0, strpos($uri, '?'));
		}
		
		$uri = '/' . trim($uri, '/');
		$routes = explode('/', $uri);

		if ($key != "") {
			$indice = $routes[$key];
			if (!empty($indice)) 
			{
				if(preg_match("/^[a-zA-Z-0-9_-]+$/", $indice))
				{
					return str_replace(array("'","\"","."), "", $routes[$key]);
				}
				return;
			} else {
				return $routes;
			}

		} else {
			return $routes;
		}
	}
}



if(!function_exists('encrypt'))
{
	function encrypt($data='')
	{
		try {
			$first_key = base64_decode(FIRSTKEY);
			$second_key = base64_decode(SECONDKEY);    

			$method = "aes-256-cbc";    
			$iv_length = openssl_cipher_iv_length($method);
			$iv = openssl_random_pseudo_bytes($iv_length);

			$first_encrypted = openssl_encrypt($data,$method,$first_key, OPENSSL_RAW_DATA ,$iv);    
			$second_encrypted = hash_hmac('sha256', $first_encrypted, $second_key, TRUE);

			$output = base64_encode($iv.$second_encrypted.$first_encrypted);    
			return $output;
		} catch (Exception $e) {
			
		}
	}
}




if(!function_exists('decrypt'))
{
	function decrypt($input='')
	{
		$first_key = base64_decode(FIRSTKEY);
		$second_key = base64_decode(SECONDKEY);            
		$mix = base64_decode($input);
		        
		$method = "aes-256-cbc";    
		$iv_length = openssl_cipher_iv_length($method);
		
		$iv = substr($mix,0,$iv_length);
		$second_encrypted = substr($mix,$iv_length,64);
		$first_encrypted = substr($mix,$iv_length+64);
		            
		$data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);
		$second_encrypted_new = hash_hmac('sha256', $first_encrypted, $second_key, TRUE);
		load_helper("hash");
		
		if (hash_equals($second_encrypted,$second_encrypted_new))
		return $data;
		    
		return false;
	}
}


/*
 *
 *
 *	
 *	
 *
 *
 */


if (!function_exists('decode_string')) {
	function decode_string($urlEncode) {
		$urlEncode = explode("-", $urlEncode);
		$string = "";
		foreach ($urlEncode as $key => $value) {
			$string .= ucwords($value);
		}
		return $string;
	}
}


/*
 *
 *
 *
 *	Comprueba que la direccion de correo sea la correcta
 *	@param (string) email
 *
 *
 *
 */

if (!function_exists('is_email')) {
	function is_email($email = '') {
		if($email !='' && !is_array($email))
		{
			if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
				if (filter_var($email, FILTER_SANITIZE_EMAIL)) {
					return TRUE;
				}
			} else {
				return FALSE;
			}
		}
	}
}

if (!function_exists('getIp')) {
	function getIp() {
		$dataDirection = array();
		global $is_headers_request;
		if (isset($is_headers_request["HTTP_X_FORWARDED_FOR"])) {
			if ($pos = strpos($is_headers_request["HTTP_X_FORWARDED_FOR"], " ")) {
				$ipLocal = substr($is_headers_request["HTTP_X_FORWARDED_FOR"], 0, $pos);

				$ippublica = substr($is_headers_request["HTTP_X_FORWARDED_FOR"], $pos + 1);
				$dataDirection["IPPUBLICA"] = $ippublica;
				$hostlocal = substr($is_headers_request["HTTP_X_FORWARDED_FOR"], $pos + 1);
			} else {
				$ippublica = $is_headers_request["HTTP_X_FORWARDED_FOR"];
				$hostlocal = $is_headers_request["HTTP_X_FORWARDED_FOR"];
				$dataDirection["HOST_LOCAL"] = $hostlocal;
				$dataDirection["IPPUBLICA"] = $ippublica;
			}
			if ($is_headers_request["REMOTE_ADDR"]) {
				$proxy = $is_headers_request["REMOTE_ADDR"];
				$dataDirection["PROXY"] = $proxy;
			}

		} else {
			$proxy = $is_headers_request["REMOTE_ADDR"];
			$hostlocal = $is_headers_request["REMOTE_ADDR"];
			$dataDirection["HOST_LOCAL"] = $hostlocal;
			if ($hostlocal != $is_headers_request["REMOTE_ADDR"]) {
				$__hostname = $hostlocal;
			}
			$dataDirection["PROXY"] = $proxy;
		}
		
		$hostname = gethostbyaddr($hostlocal);

		$dataDirection["HOST_LOCAL"] = $hostlocal;
		if ($hostlocal != $hostname) {
			$hostname = $hostname;
			$dataDirection["HOSTNAME"] = $hostname;
		}

		if (isset($is_headers_request['HTTP_X_FORWARDED_FOR'])) {
			$ip = $is_headers_request['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($is_headers_request['HTTP_VIA'])) {
			$ip = $is_headers_request['HTTP_VIA'];
		} elseif (isset($is_headers_request['REMOTE_ADDR'])) {
			$ip = $is_headers_request['REMOTE_ADDR'];
		} else {
			$ip = "Desconocido";
		}
		$dataDirection["IP"] = $ip;
		$dataDirection["DNS"] = $is_headers_request['HTTP_USER_AGENT'];

		return array_to_object($dataDirection);
	}
}


if (!function_exists('validNumeric')) {
	function validNumeric($number) {
		if ($number == "") {
			return ;
		} elseif (preg_match("/^([0-9]+)$/", $number)) {
			return true;
		} else {
			return false;
		}
	}
}



if (!function_exists('add_hashtag')) {
	function add_hashtag($msg = '') {
		if(strlen($msg)>0)
		{
			$output = preg_replace("/#([^\s]+)/", "<a href=\"#$1\"><i><b>#$1</b></i></a>", $msg);
			return $output;
		}
	}
}


if (!function_exists('add_smileys')) {

	function add_smileys($msg = '') {
		if(strlen($msg)>0)
		{
			$file = APP_PATH . DS . "config" . DS . "smileys.php";
			if(file_exists($file))
			{
				require $file;				
			}

			foreach ($smilies as $smilie => $image) {
				$regex = preg_quote("/$smilie/");
				$image_tag = '<img style="width:25px;" src="' . base_url("/public/files/emoticons/png/" . $image . ".png") . '">';

				$msg = preg_replace($regex, $image_tag, $msg);
			}

			return $msg;			
		}
	}
}

/*
 *
 *
 *
 *	Crea un formato de entero a decimal añadiendo valores al final del texto
 *	(intval) $numeric
 *
 *
 */


if ( ! function_exists('_exception_handler'))
{
	/**
	 * Exception Handler
	 * @return	void
	 */
	function _exception_handler($exception = '')
	{
		if($exception != '')
		{
			// $file = APP_SYSTEM.DS.'Storage'.DS.'ExceptionsPHP'.DS.'RunException.php';
			$file = APP_PATH.DS."vendor".DS."framework".DS."rino".DS."system".DS."Storage".DS."ExceptionsPHP".DS."RunException.php";
			
				
			include_once $file;
			$error = new RunException();
			
			$error->write_log($exception->getCode(),$exception->getMessage(),$exception->getFile(), $exception->getLine());
			
			if (str_ireplace(array('off', 'none', 'no', 'false', 'null'), '', ini_get('display_errors')))
			{
				$error->show_exception();
			}

			exit(1);
		}
	}
}



if (!function_exists('toDecimal')) {
	function toDecimal($numeric, $decimals = '', $typeFormat = '', $space = '') {
		if ($numeric == "") {
			return false;
		} elseif (intval($numeric) > 0) {
			if ($decimals == "") {
				$decimals = 1;
			}
			if ($typeFormat == '') {
				$typeFormat = ".";
			}
			return number_format($numeric, $decimals, $typeFormat, $space);
		} else {
			return false;
		}
	}
}

/*
 *
 *
 *
 *	Corta una frase hasta un determinado punto que se quiere obtener
 *	(String) $frase,(int)totalcaracteres
 *
 *
 */

if (!function_exists('cut_string')) {

	function cut_string($texto, $limite = 20) {

		$texto = trim($texto);

		$texto = strip_tags($texto);

		$tamano = strlen($texto);

		$resultado = '';

		if ($tamano <= $limite) {

			return $texto;
		} else {
			$texto = substr($texto, 0, $limite);
			$palabras = explode(' ', $texto);
			$resultado = implode(' ', $palabras);
			$resultado .= '...';
		}

		return $resultado;
	}
}

/*
 *
 *
 *
 *
 *
 *
 *	Crea una url amigable para comenzar a trabajar con url que serán dinamicas
 *
 *
 *
 *
 *
 */

if (!function_exists('UrlAmigable')) {
	function UrlAmigable($texto) {
		$temp = mb_convert_case($texto, MB_CASE_LOWER, "UTF-8");
		$b1 = array();
		$nueva_cadena = '';

		$ent = array('&aacute;', '&eacute;', '&iacute;', '&oacute;', '&oacute;', '&ntilde;');
		$entRep = array('á', 'é', 'í', 'ó', 'ú', 'ñ');

		$b = array('á', 'é', 'í', 'ó', 'ú', 'ä', 'ë', 'ï', 'ö', 'ü', 'à', 'è', 'ì', 'ò', 'ù', 'ñ',
			',', '.', ';', ':', '¡', '!', '¿', '?', '"', '_',
			'Á', 'É', 'Í', 'Ó', 'Ú', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü', 'À', 'È', 'Ì', 'Ò', 'Ù', 'Ñ');
		$c = array('a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'n',
			'', '', '', '', '', '', '', '', '', '-',
			'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u', 'ni');

		$temp = str_replace($ent, $entRep, $temp);
		$temp = str_replace($b, $c, $temp);
		$temp = str_replace($b1, $c, $temp);

		$new_cadena = explode(' ', $temp);

		foreach ($new_cadena as $cad) {
			//$word = preg_replace("[^A-Za-z0-9]", "", $cad);
			$word = preg_replace('/[^A-Za-z0-9_-]+/', '', $cad);

			if (strlen($word) > 0) {
				$nueva_cadena .= $word . '-';
			}
		}

		$nueva_cadena = substr($nueva_cadena, 0, strlen($nueva_cadena) - 1);

		return $nueva_cadena;
	}
}

/*
 *
 *
 *
 *	Valida el formato de una url que esta intetando hacer
 *
 *
 *
 *
 */

if (!function_exists('ValidUrl')) {
	function ValidUrl($url) {
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}
}

/*
 *
 *
 *
 *	entrega la url de la web
 *
 *
 *
 *
 */

if (!function_exists('base_url')) {
	function base_url($link = "") {
		$link = $link;
		return rawurldecode(trim(BASE_URL_WEB,"/") . $link);
	}
}

/*
 *
 *
 *
 *
 *	redirige a un destino por medio de la url
 *	@param
 *
 *
 *
 */
if (!function_exists('redirect')) {

	function redirect($uri = '', $method = 'auto', $code = NULL) {
		global $is_headers_request;
		if ($method === 'auto' && isset($is_headers_request['SERVER_SOFTWARE']) && strpos($is_headers_request['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE) {
			$method = 'refresh';
		} elseif ($method !== 'refresh' && (empty($code) OR !is_numeric($code))) {
			if (isset($is_headers_request['SERVER_PROTOCOL'], $is_headers_request['REQUEST_METHOD']) && $is_headers_request['SERVER_PROTOCOL'] === 'HTTP/1.1') {
				$code = ($is_headers_request['REQUEST_METHOD'] !== 'GET')
				? 303
				: 307;
			} else {
				$code = 302;
			}
		}

		switch ($method) {
		case 'refresh':
			header('Refresh:0;url=' . $uri);
			break;
		default:
			header('Location: ' . $uri, TRUE, $code);
			break;
		}
		exit;
	}
}

if (!function_exists('to_utf8')) {
	
	function to_utf8($in) 
	{ 
		if (is_array($in)) { 
			foreach ($in as $key => $value) { 
				$out[to_utf8($key)] = html_entity_decode($value); 
			}
			return $out;
		} elseif(is_string($in)) { 
			return html_entity_decode($in);  
		} else { 
			return $in; 
		} 
	} 
}




if (!function_exists('is_https')) {
	/**
	 * Is HTTPS?
	 *
	 * Determines if the application is accessed via an encrypted
	 * (HTTPS) connection.
	 *
	 * @return	(bool)
	 */
	function is_https() {
		global $is_headers_request;
		if (!empty($is_headers_request['HTTPS']) && strtolower($is_headers_request['HTTPS']) !== 'off') {
			return TRUE;
		} elseif (isset($is_headers_request['HTTP_X_FORWARDED_PROTO']) && $is_headers_request['HTTP_X_FORWARDED_PROTO'] === 'https') {
			return TRUE;
		} elseif (!empty($is_headers_request['HTTP_FRONT_END_HTTPS']) && strtolower($is_headers_request['HTTP_FRONT_END_HTTPS']) !== 'off') {
			return TRUE;
		}

		return FALSE;
	}
}


if (!function_exists('sendJson')) {
	function sendJson($data,$formater = '') {
		header('Content-Type: application/json;charset=utf-8');
		
		if(is_array($data) || is_object($data))
			$setData = $data;
		else
			$setData = array($data);
		
		if(intval($formater)>0)
			echo json_encode($setData,$formater);
		else
			echo json_encode($setData);
	}
}

if (!function_exists('convertObjectToArray')) {
	function convertObjectToArray($object,$reset_key = true) {
		$arr_tmp = array();
		foreach ($object as $key => $value) {

			if (is_object($value)) {
				if($reset_key){
					$arr_tmp[] = convertObjectToArray($value,$reset_key);
				}else{
					$arr_tmp[$key] = convertObjectToArray($value,$reset_key);
				}
			} 
			else 
			{
				if($reset_key){
					
					$arr_tmp[] = $value;
				}else{
					$arr_tmp[$key] = $value;
				}
			}
		}
		return $arr_tmp;
	}
}

if(!function_exists('instance_to_object'))
{
	function instance_to_object($array, &$obj)
	{
		if(!empty($array))
        {
            foreach ($array as $key => $value)
            {
                if (is_array($value))
                {
                    $obj->$key = new \stdClass();
                    instance_to_object($value, $obj->$key);
                }
                else
                {                    
                    $obj->$key = $value;
                }
            }

            return $obj;
        }
	}
}


if(!function_exists('array_to_object'))
{
	function array_to_object($array = array())
	{
		$object= new \stdClass();
	        
	    return instance_to_object($array,$object);
	}
}



if(!function_exists('load_helper'))
{
	function load_helper($helperPath='')
	{
		$pathFile = dirname(__DIR__).DIRECTORY_SEPARATOR."Helpers".DIRECTORY_SEPARATOR.$helperPath.".php";
		
		if(file_exists($pathFile))
		{
			include $pathFile;
		}
	}
}



/*--------------------*/




if(!function_exists('get_client_ip'))
{
	//Obtiene la IP del cliente
	function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
	
}


    //Obtiene la info de la IP del cliente desde geoplugin
if(!function_exists('ip_info'))
{
    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        return $output;
    }
	
}




?>