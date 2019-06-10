<?php 
namespace Rino\Core;
use Rino\Request\Request;
/**
* 
*/
class Headers
{

	public static function get_browser_name($user_agent = '') {
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
	

	public static function city_language()
	{
		return trim(substr(Request::server("HTTP_ACCEPT_LANGUAGE"),3 , 2));
	}

	public static function http_referrer()
	{
		return trim(Request::server("HTTP_REFERRER"));
	}

	public static function language_navigator()
	{
		return trim(substr(Request::server("HTTP_ACCEPT_LANGUAGE"),0 , 2));
	}

	public static function http_x_requested_with()
	{
		return array_to_object(array(
					"lower"=>strtolower(Request::server("HTTP_X_REQUESTED_WITH")),
					"upper"=>strtoupper(Request::server("HTTP_X_REQUESTED_WITH")),
					"normal"=>Request::server("HTTP_X_REQUESTED_WITH")
				));
	}

	public static function http_x_forwarded_for()
	{
		return Request::server("HTTP_X_FORWARDED_FOR");
	}

	public static function remote_addr()
	{
		return Request::server("REMOTE_ADDR");
	}

	public static function http_user_agent()
	{
		return Request::server("HTTP_USER_AGENT");
	}

	public static function http_host()
	{
		return Request::server("HTTP_HOST");
	}

	public static function remote_port()
	{
		return Request::server("REMOTE_PORT");
	}


	public static function request_uri()
	{
		return Request::server("REQUEST_URI");
	}


	public static function request_method()
	{
		return Request::server("REQUEST_METHOD");
	}


	public static function http_referer()
	{
		return Request::server("HTTP_REFERER");
	}


	public static function wprotocol()
	{
		return Request::server("WPROTOCOL");
	}


	public static function http_accept_language()
	{
		return Request::server("HTTP_ACCEPT_LANGUAGE");
	}


	public static function redirect_status()
	{
		return Request::server("REDIRECT_STATUS");
	}


	public static function http_connection()
	{
		return Request::server("HTTP_CONNECTION");
	}


	public static function http_cache_control()
	{
		return Request::server("HTTP_CACHE_CONTROL");
	}


	public static function http_accept()
	{
		return Request::server("HTTP_ACCEPT");
	}


	public static function http_accept_encoding()
	{
		return Request::server("HTTP_ACCEPT_ENCODING");
	}


	public static function http_cookie()
	{
		return htmlspecialchars(Request::server("HTTP_COOKIE"));
	}


	public static function path()
	{
		return Request::server("PATH");
	}


	public static function redirect_wprotocol()
	{
		return Request::server("REDIRECT_WPROTOCOL");
	}


	public static function server_signature()
	{
		return Request::server("SERVER_SIGNATURE");
	}


	public static function server_software()
	{
		return Request::server("SERVER_SOFTWARE");
	}


	public static function server_name()
	{
		return Request::server("SERVER_NAME");
	}


	public static function server_addr()
	{
		return Request::server("SERVER_ADDR");
	}


	public static function server_port()
	{
		return Request::server("SERVER_PORT");
	}


	public static function server_admin()
	{
		return Request::server("SERVER_ADMIN");
	}


	public static function script_filename()
	{
		return Request::server("SCRIPT_FILENAME");
	}


	public static function redirect_url()
	{
		return Request::server("REDIRECT_URL");
	}


	public static function gateway_interface()
	{
		return Request::server("GATEWAY_INTERFACE");
	}


	public static function query_string()
	{
		return Request::server("QUERY_STRING");
	}


	public static function script_name()
	{
		return Request::server("SCRIPT_NAME");
	}


	public static function path_info()
	{
		return Request::server("PATH_INFO");
	}


	public static function path_translated()
	{
		return Request::server("PATH_TRANSLATED");
	}


	public static function php_self()
	{
		return Request::server("PHP_SELF");
	}


	public static function request_time()
	{
		return Request::server("REQUEST_TIME");
	}


	public static function request_time_float()
	{
		return Request::server("REQUEST_TIME_FLOAT");
	}


}


 ?>