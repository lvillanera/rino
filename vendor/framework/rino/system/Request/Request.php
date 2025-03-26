<?php 
namespace Rino\Request;
use Rino\Security\Security as XSS;



class Request
{

	public static function input($keypost='',$filter_xss = false)
	{
		$input = self::_get_all_method_post();

		if($filter_xss)
		{
			return (is_string($keypost) ? XSS::escape($input[$keypost]):'') ;
		}

		if(is_array($input[$keypost])) {
			
			foreach ($input[$keypost] as $key => $value) {
				
				if(!is_array($value[$key]))
					$return[$key] =XSS::escape($value[$key]);
				else
					self::input($value[$key]);
			}
		}

		return (is_string($keypost) ? $input[$keypost]:'') ;
	}

	public static function file($key='',$filter_xss = false)
	{
		$typeRequest = $_FILES;

		return new File\File($typeRequest[$key]);
		
	}

	public static function get_all_file()
	{
		return $_FILES;
	}

	protected static function _get_all_method_post()
	{
		global $is_initialize;
		return $is_initialize;
	}

	public static function changePost($parameters = '')
	{
		$input = self::_get_all_method_post();

		if(is_array($parameters))
		{
			foreach ($parameters as $key => $value) {
				if(is_array($value)){
					self::changePost($value);
				}
				else
				{
					if(array_key_exists($key, $input))
					{
						$input[$value] = $input[$key];
						unset($input[$key]);
					}
				}

			}

		}
		return $input;

	}

	public static function only($params,$closure = '')
	{
		$input = self::_get_all_method_post();
		if(is_array($params))
		{	
			foreach ($params as $key => $value) {
				$setInput[$value] = $input[$value];
			}

			$setClosure = array_to_object($setInput);

			if($closure)
			{
				return $closure($setClosure);
			}
			return $setClosure;
		}
	}

	public static function cookie($key='')
	{
		global $is_cookie_package;

		return (isset($is_cookie_package[$key])?XSS::escape($is_cookie_package[$key]):'');
	}

	public static function getMethod()
	{
		return self::server("REQUEST_METHOD");
	}

	public static function getArrayPost($key='')
	{
		$input = self::_get_all_method_post();
		return (array_key_exists($key, $input)?array($key=>$input[$key]):$input);
	}

	public static function getObjectPost($key='')
	{
		$input = self::_get_all_method_post();
		return (array_key_exists($key, $input)?array_to_object(array($key=>$input[$key])):array_to_object($input));
	}

	public static function getPostJSON($key = '')
	{
		$input = self::_get_all_method_post();
		return sendJson((array_key_exists($key, $input)?array_to_object(array($key=>$input[$key])):array_to_object($input)));
	}

	public static function fieldRequired($fieldKey = NULL, $input =NULL) {
		$fieldsCorrect = array();
		if(is_array($fieldKey)) {
			foreach ($fieldKey as $key => $value) {
				if(isset($input[$key])) {
					if(empty($input[$key])) { $fieldsCorrect[$key] = "Este campo es obligatorio"; }
				}
			}
		}
		return $fieldsCorrect;
	}

	public static function validateRequest($ruleset ,$closure = '',$lang = 'PE')
	{
		$validador = new ValidatorRequest();

		$input = self::_get_all_method_post();
		
		$validador->is_correct($input,$ruleset);

		
		$dataError = $validador->get_error($lang);

		$trueError = false;

		if(!empty($dataError->data)) {
			$trueError = true;
		}
		
		$setInData = array_to_object(
				array(
					"handler_error"=>(bool)($trueError),
					"errors"=>$dataError->data,
				)
			);

		if($closure)
		{
			return $closure($setInData);
		}

		return $setInData;
	}

	public static function validateMethod($closure = '')
	{
		if($closure)
		{
			$methodExec = strtolower(self::getMethod());
			return $closure(array_to_object(
				array(
					"request_method"=>$methodExec,
					"uppermethod"=>strtoupper($methodExec),
				)));
		}
	}

	public static function server($key='')
	{
		global $is_headers_request;
		return (isset($is_headers_request[$key])?$is_headers_request[$key]:$is_headers_request);
	}

	public static function get($key='')
	{
		global $is_get_uri;
		return (isset($is_get_uri[$key])?XSS::escape($is_get_uri[$key]):'');
	}
}


 ?>