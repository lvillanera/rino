<?php

namespace Rino\Rain;

use Rino\Rain\Tpl;

class View 
{
	private $colVars;

	public function __construct() {
		$this->colVars = array();
	}

	function vars($varName, $value='') {
		if(is_array($varName))
			$this->colVars = $varName;
		else
			$this->colVars[$varName] = $value;
	}

	function exists($file='')
	{
		return file_exists($file) ? true : false;
	}

	function see($template = '') {

		if(strlen($template)>0)
		{
			if($this->exists($template))
			{
				$route = pathinfo($template);

				$tpl = new Tpl();

				Tpl::configure(array(
					"tpl_dir" => $route['dirname'] . DS,
					"tpl_ext" => $route['extension'],
					"debug" => false,
					"cache_dir" => APP_PATH . DS . CACHE_DIR . DS,
				));

				foreach ($this->colVars as $key => $value) {
					$tpl->assign($key, $value);
				}

				return $tpl->draw($route['filename'], $return_string = true);
			}
		}

	}
}