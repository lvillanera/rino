<?php 
namespace Rino\Modules;

/**
*	*
	*
	*
		* clase para valdar los permisos a usuarios por modulos
		* generalmente para sistemas que requiran uso de privilegios
		* clase creada por el desarrollador de este framework
	*
	*
	*
 */
class Module
{



	private $_modules = array();
	private $_arr_modules = array();


	public function __construct(){
		$this->capture();
	}


	/*
		captura los modulos por defecto de la aplicacion
		y estaran listos para usar.

		- no parametros
	*/

	public function capture()
	{
		$collection = glob('app/*',GLOB_ONLYDIR);

		if(!is_empty($collection))
		{
			foreach ($collection as $key => $module) {
				$filterModule = ucwords(UrlAmigable(str_replace("app", "", $module)));
				$this->_arr_modules[] = strtolower($filterModule);
				$this->addModule($filterModule,1,base_url("/".strtolower($filterModule)),NULL);
			}			
		}


	}


	/**
     * AuthType
     * 0 = No Auth
     * 1 = Global Auth
     * 3 = Local Auth
     */

	public function addModule($modname,$typeAuht = 0,$uriPage = '',$extraData = NULL)
	{
		$arguments	=	(object)array
						(
							'modName'=>$modname,
							'authType'=>$typeAuht,
							'index_page'=>$uriPage,
							'extra'=>$extraData
						);

		$this->_modules[$modname] = $arguments;
	}




	/*
		*
		* return void(:)
		* 
	*/


	public function getModules()
	{
		return $this->_modules;
	}



	/*
		valida existencia de el modulo
		parametros $key = 'modulo'
	*/


	public function existsModule($module = '') {
		if(!is_empty($module)) {
			return (bool)(
				in_array(
					strtolower($module), 
					$this->_arr_modules) ? true : false
			);
		}
	}


	/*

		*	obtiene la informacion del modulo que se ha obtenido
		*	caso contrario devolverá falso
				->falso [ Hara referencia que el modulo no existe ]
		*
		*	parametros nombre_modulo = 'modulo';

	*/


	public function infoModule($module = '')
	{
		if(!$this->existsModule($module))
		{
			return false;
		}


		$module = strtolower($module);

		if(!is_empty($this->_modules))
		{
			foreach ($this->_modules as $key => $value) 
			{
				if(strtolower($value->modName) == $module)
				{
					return $value;
					break;
				}
			}
			
		}
	}






}


 ?>