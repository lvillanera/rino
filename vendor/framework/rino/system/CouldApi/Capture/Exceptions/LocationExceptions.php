<?php 
namespace Rino\CouldApi\Capture\Exceptions;
/**
* 
*/
class LocationExceptions extends \Exception
{


	function __construct()
	{
		parent::__construct();
	}


	/* 
	 * @return (String)
	*/

	public function new_error_text()
	{
		return $this->getMessage();
	}



}


 ?>