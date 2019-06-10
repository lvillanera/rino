<?php 
namespace Rino\Request\Exeption;

class RequestException extends \Exception
{

	protected static $argumentException;

	private $nameClass;

	protected function getClass($nameClass='')
	{
		$this->nameClass = $nameClass;
		return $this;
	}

	public function write_log($level, $message = '',$class = '',$line = '')
	{
		$newStr = "[LEVEL=>".$level."][Fatal error class : ".$class.", in ".$line."]:".$message."\r\t";
		$fileName = APP_SYSTEM.DS."Storage".DS."ExceptionsPHP".DS."bad_script_requested.log";
		error_log($newStr, 3, $fileName);
    	error_log("\xA", 3, $fileName);
	}


	public function show_exception(\Exception $exception)
	{

		// if (ob_get_level() > $this->ob_level + 1)
		// {
		// 	ob_end_flush();
		// }

		// ob_start();
		// include($templates_path.'error_exception.php');
		// $buffer = ob_get_contents();
		// ob_end_clean();
		// echo $buffer;
	}


	protected function InstanceExeption($LevelFail = 0)
	{
		throw new InvalidArgumentException('tripleInteger function only accepts integers. Input was: '.$int);
		exit();
	}
}

 ?>