<?php 
namespace Rino\Request\File;
/**
* 
*/
class FileException extends \Exception
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function file_not_found()
	{
		$errorMsg = 'No se puede obtener el fichero en '.$this->getFile()." "
        .$this->getMessage().
        '</b> no es una dirección de email válida';
        return $errorMsg;

	}

	 public function fileMessage() {
        $errorMsg = 'Error en la línea '
        .$this->getLine().' en el archivo '
        .$this->getFile() .': <b>'
        .$this->getMessage().
        '</b> no es una dirección de email válida';
        return $errorMsg;
    }

}

 ?>