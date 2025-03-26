<?php 

class RunException extends \Exception
{
	protected $arguments;
	protected $tokenSession;

	public function write_log($code= '',$message = '',$file= '', $line= '')
	{
		$newDate = new \DateTime();

		if(!self::issetToken())
		{
			$token = self::generateTokenFile();

			$_SESSION["_rino_file_session"] = (object)array(
					"rino_file_token"=>$token
				);
		}
		else
		{
			$token = self::getToken();
		}
		

		$newStr = "[Date: ".$newDate->format('Y-m-d H:i:s')."][Fatal error code=".$code.". in file : ".$file.", in ".$line."]:".$message."\r\t";
		
		$fileName = APP_PATH.DS."vendor".DS."framework".DS."rino".DS."system".DS."Storage".DS."ExceptionsPHP".DS.$token.".log";
		
		file_exists($fileName) ? true : false;

		$this->arguments = (object)array(
				"code"=>$code,
				"message"=>$message,
				"file"=>$file,
				"line"=>$line,
		);

		error_log($newStr, 3, $fileName);
    	error_log("\xA", 3, $fileName);
	}

	protected static function getToken()
	{
		return $_SESSION["_rino_file_session"]->rino_file_token;
	}

	protected static function issetToken()
	{
		return (isset($_SESSION["_rino_file_session"]->rino_file_token)?true:false);
	}

	protected static function generateTokenFile() {
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ:;.,<>?/~!@#$%^&*()_+';
		$token = '';
		for ($i = 0; $i < 15; $i++) {
			$token .= (string) chr($chars[ mt_rand(0, strlen($chars) - 1) ]);
		}
		
		return sha1($token . time() . mt_rand() . 'PRXgydcAyvvCuMzDow2EhzbYlo5CbKrauu3CST7T');
	}


	public function show_exception()
	{
		
		$file = $this->arguments->file;
		$posicion = $this->arguments->line;

		$fichero = file($file); 

		$lenghRun = 8;

		$min = $posicion;
		$max = $posicion;

		$htmlUp='';
		$htmlDown='';

		for ($i=0; $i < $lenghRun; $i++) {
			$max++;
			$min--;
			$arrayDown[$max] = htmlentities($fichero[$max]);
			
			$arrayUp[$min] = htmlentities($fichero[$min]);
			// $htmlDown.= htmlentities($fichero[$max]);
		}
		
		$arrayUp = array_reverse($arrayUp);

		$ultimaFila = count($fichero) - 1; 

		$view = new Rino\Rain\View();

		$set["lineFail"] = $fichero[$posicion];
		$set["arrayDown"] = $arrayDown;
		$set["arrayUp"]  = $arrayUp;
		$set["datastart"]= ($posicion - $lenghRun);
		$set["argument"] = $this->arguments;

		$view->vars($set);
		echo $view->see(dirname(__FILE__).DS."tpl".DS."template_exception.html");

	}


}


 ?>