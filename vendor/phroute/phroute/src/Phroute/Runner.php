<?php 
namespace Phroute\Phroute;

/**
 * summary
 */
@set_exception_handler('_exception_handler');

class Runner
{
    /**
     * summary
     */
    var $pageHome;
    var $filtersReplace = array(".","'",'"');
    var $initPath = 'App';
    var $_path_masked;
    var $is_masked_uri;
    var $config;

    public function home($module = '')
    {
    	$homePage = (object)(is_array($module) ? $module : array("home"=>$module));
    	$this->pageHome = $homePage;
    	return $this;
    }

    public function __construct()
    {
        define('VERSION_APP', 'V_1.1');
        if(!defined("DS"))
				{
					define('DS', DIRECTORY_SEPARATOR);
				}

			$_config = new \Rino\Core\Config();
    	$this->config = $_config->get();
			$this->unsetRegisterGlobals();
    }




	protected function unsetRegisterGlobals()
	{
		$GLOBALS['is_initialize'] = $_POST;
		$GLOBALS['is_get_uri'] = $_GET;
		$GLOBALS['is_env_data'] = $_ENV;
		$GLOBALS['is_cookie_package'] = $_COOKIE;
		$GLOBALS['is_headers_request'] = $_SERVER;
		$_registered = ini_get('variables_order');
		
		foreach (array('E' => '_ENV', 'G' => '_GET', 'P' => '_POST', 'C' => '_COOKIE', 'S' => '_SERVER') as $key => $superglobal) {
			
			if (isset($GLOBALS[$superglobal])) {
				unset($GLOBALS[$superglobal]);
			}
		}
	}

    public function run()
    {
    	$path_masked = (isset($this->config->backend_url)?$this->config->backend_url:'');
    	$this->_path_masked = $path_masked;
		if((bool)$this->config->add_logs)
		{
			\Rino\Core\DbLog::addRegister();
		}
    	$this->main_view = $this->pageHome->home;
    	$this->is_masked_uri = 'Fe';
		if (!is_array(UriParser(1))) {
			if (strtolower(UriParser(1)) === $path_masked) {
				$this->is_masked_uri = 'Be';
				$this->runApp($path_masked);
			} else {

				$this->runApp();
			}
		} else {

			$this->runApp();
		}

		$this->_load_package();
		
		_exception_handler();


    }



    private function render_class($view = '')
    {
    	$view = ($view == '' ? $this->main_view."/".$this->is_masked_uri."/Main": $view);
    	$strRender = $this->initPath. DS . ucwords($view);
		
		$strRender = str_replace($this->filtersReplace, "", $strRender);
		$this->metodrender($strRender);
    }

	protected function runApp($path_masked = 'Fe') {

		$modulo = UriParser(1);
		$ficha = UriParser(2);
		$services = UriParser(3);
		$is_method = UriParser(4);

		if($this->_path_masked == $path_masked)
		{
			$modulo = UriParser(2);
			$ficha = UriParser(3);
			$services = UriParser(4);
			$is_method = UriParser(5);
		}
		

		if ($modulo != '') {

			if($ficha != ''){
				if (strtolower($ficha) === "svc") {
						if($services != '')
						{
							$convertString = $this->urldecode_String($services);
							$strRender = $this->svc_fe($this->urldecode_String($modulo), $convertString);

							$this->metoddoit($strRender);
						}
					} elseif (strtolower($ficha) === "ws") {

						$strRender = $this->ws_fe($this->urldecode_String($modulo));


						if($services != '')
						{
							$strMethod = $this->urldecode_String($services);
							$this->metodAnonimus($strRender,$strMethod,$services);
						}
						else
						{
							$this->loadError();
						}
					}
					elseif(strtolower($ficha) === "models")
					{
						if($services != '')
						{
							$convertString = $this->urldecode_String($services);

							$strRender = $this->models($this->urldecode_String($modulo), $convertString,$this->is_masked_uri);
							$strMethod = (!is_array($is_method)?$this->urldecode_String($is_method):'');
							
							$this->metoddoit($strRender,$strMethod);
						}
						else
						{
							$this->loadError();
						}
					}
					else {

						$this->render_class(
							$this->cbpath(
								$this->urldecode_String(
									$modulo
								), 
								$this->urldecode_String(
									$ficha
								)
							)
						);

					}
			} else if($modulo != ''){
				
				$decodemodulo = $this->urldecode_String($modulo);
				$runmodulo = ucwords($decodemodulo).DS.$this->is_masked_uri.DS.($ficha =='' ? 'Main': $this->urldecode_String($ficha));

				$this->render_class(
					$runmodulo
				);
			}
		}
		else
		{
			/*modulo default*/
			$this->render_class();
		}

	}


	protected function _load_package()
	{
		if((bool)$this->config->init_modules) {
			$modulos = new \Rino\Modules\Module();
		}
	}


	protected function metodrender($class = '')
	{
		$class = str_replace("/", "\\", $class);
		
		if(class_exists($class))
		{
			$cls = new $class();
			
			if(method_exists($cls, "render"))
			{
				$cls->render();
			}
			else
			{
				$this->loadError();
			}
		}
		else
		{
			
			$tclass = $this->deleteLastWord($class)."\\Main";
			if(class_exists($tclass)) {
				$cls = new $tclass();
				
				if(method_exists($cls, "render")) {
					$cls->render();
				} else {
					$this->loadError();
				}
			} else {
				$this->loadError();
			}
		}
	}

	function deleteLastWord($ruta) {
		$ultimaBarra = strrpos($ruta, '\\');
		if ($ultimaBarra !== false) {
			return substr($ruta, 0, $ultimaBarra);
		}
		return $ruta;
	}


	protected function metoddoit($class = '',$getMethod='')
	{
		$class = str_replace("/", "\\", $class);
			
		if(class_exists($class))
		{
			$cl = new $class();
			if(strlen($getMethod)>0)
			{
				if(method_exists($cl, $getMethod))
				{
					$cl->$getMethod();
				}
			}
			elseif(method_exists($cl, "doIt"))
			{
				$cl->doIt();
			}
			else
			{
				$this->loadError();
			}
		}		
		else
		{
			$this->loadError();
		}
	}

	protected function metodAnonimus($class = '',$metod='',$trueMethod = '')
	{
		$class = str_replace("/", "\\", $class);

		$cl = new $class();

		if(method_exists($cl, $metod))
			$cl->$metod();
		else
			die("this string '$trueMethod' No Exist");
	}


	protected function loadError() {
    	
		$nameClass = $this->config->page_error;
		
		$e404 = new $nameClass();
		$e404->render();
	}

	protected function urldecode_String($urlEncode = '') 
	{
		$urlEncode = strtolower($urlEncode);
		if($urlEncode != "")
		{
			$urlEncode = explode("-", $urlEncode);
			$string = "";
			foreach ($urlEncode as $key => $value) {
				$string .= ucwords($value);
			}
			return $string;
		}
		return '';
	}

	protected function models($modulo='',$filename='',$back='Fe')
	{
		if($modulo !='' && $filename!='')
			
		return $this->initPath.DS. ucwords($modulo) . DS . $this->is_masked_uri . DS . 'Models' . DS . ucwords($filename);;
	}
	protected function svc_fe($modulo = '', $filename = '', $back = '') {
		if($modulo !='' && $filename!='')
			return $this->initPath.DS.ucwords($modulo) . DS . $this->is_masked_uri . DS . "Svc" . DS . ucwords($filename);
		return;
	}
	protected function ws_fe($modulo = '', $back = "Fe") {
		if($modulo!='')
			return $this->initPath.DS.ucwords($modulo) . DS . $this->is_masked_uri .DS."Svc". DS . "Ws";
		return;
	}

	protected function cbpath($modulo = '', $filename = '',$back='Fe') {
		if($modulo !='' && $filename!='')
			return ucwords($modulo) . DS . $this->is_masked_uri . DS . ucwords($filename);
		return;
	}

}




if (!function_exists('UriParser')) {

	function UriParser($key='')
	{
		global $is_headers_request;
		$basepath = implode('/', array_slice(explode('/', $is_headers_request['SCRIPT_NAME']), 0, -1)) . '/';
		$uri = substr($is_headers_request['REQUEST_URI'], strlen($basepath));
		if (strstr($uri, '?')) {
			$uri = substr($uri, 0, strpos($uri, '?'));
		}
		
		$uri = '/' . trim($uri, '/');

		$routes = explode('/', $uri);
		
		if ($key != "") 
		{
			if(array_key_exists($key, $routes))
			{
				$indice = $routes[$key];
			}

			if (!empty($indice))
			{
				if(preg_match("/^[a-zA-Z-0-9_-]+$/", $indice))
				{
					return str_replace(array("'","\"","..","."), "", $routes[$key]);
				}
				return;
			} else {
				return ;
			}

		} else {
			return ;
		}
	}
}

 ?>