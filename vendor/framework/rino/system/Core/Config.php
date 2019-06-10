<?php 
namespace Rino\Core;

/**
 * summary
 */
class Config
{
    /**
     * summary
     */

    public static function defined_constant($value='')
	{
		$getConstant = get_defined_constants();
		return ((strlen($value)>0)? $getConstant[$getConstant]:(object)$getConstant);
	}



	public static function get() 
	{
		$config = APP_PATH.DS."config".DS."config.php";

		if(file_exists($config)){
			$data = file_exists($config) ? require $config:'<span>File not found in: $path </span>';

			return array_to_object($data);
		}
	}

}

 ?>