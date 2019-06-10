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
    	
    	$getlist = $this->getPublicHelperHtml();
    	$data["elements"] = $getlist;
    	$this->view->vars($data);
    	$html = $this->view->see(dirname(__DIR__).DS."tpl".DS."wgt".DS."class_headers.html");
    	


    	sendJson(array("html"=>$html));
    }


    function getPublicHelperHtml()
    {
    	load_helper("html");

    	return ul(array(
    			"get_browser_name()",
    			"city_language()",
    			"language_navigator()",
    			"http_x_requested_with()",
    			"http_x_forwarded_for()",
    			"remote_addr()",
    			"http_user_agent()",
    			"http_host()",
    			"remote_port()",
    			"request_uri()",
    			"request_method()",
    			"http_referer()",
    			"wprotocol()",
    			"http_accept_language()",
    			"redirect_status()",
    			"http_connection()",
    			"http_cache_control()",
    			"http_accept_encoding()",
    			"http_cookie()",
    			"path()",
    			"redirect_wprotocol()",
    			"server_signature()",
    			"server_name()",
    			"server_addr()",
    			"server_port()",
    			"server_admin()",
    			"script_filename()",
    			"redirect_url()",
    			"gateway_interface()",
    			"query_string()",
    			"script_name()",
    			"path_info()",
    			"path_translated()",
    			"php_self()",
    			"request_time()",
    			"request_time_float()",
    	));
    }


}

 ?>