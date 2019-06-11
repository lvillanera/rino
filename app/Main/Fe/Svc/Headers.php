<?php 
namespace App\Main\Fe\Svc;
use \Rino\Request\Request;
use App\Main\Fe\FichaParaExtender;

class Headers extends FichaParaExtender
{
	public function __construct($param = null)
	{
		parent::__construct();
	}

    function doIt()
    {
    	
		$metodos = get_class_methods(new \Rino\Core\Headers);
		
		$set["methods"] = $metodos;
		
    	$this->view->vars($set);
    	$html = $this->view->see(dirname(__DIR__).DS."tpl".DS."wgt".DS."class_headers.html");
    	
    	sendJson(array("html"=>$html));
    }

}

 ?>