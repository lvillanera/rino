<?php 
namespace Rino\Core;

/**
 * summary
 */
class DbLog
{
    /**
     * summary
     */
    private $_table = NULL,$_sql = NULL;

	public function table_name($table='')
	{
		$this->_table = $table;
		return $this;
	}

	public function create_table()
	{
		$sql = 'CREATE TABLE IF NOT EXISTS '.$this->_table.'(';
		$sql.= trim($this->_sql,",");
		$sql.=');';
				
		$db = new ClassPdo();
		
		$db->query($sql);
		return true;
	}


	public static function addRegister()
	{
		$config = new Config();
    	$configGet = $config->get();
		
		$db = new \Rino\Database\ClassPdo();

		global $is_initialize;

        $formatDate = (defined('FORMAT_DATE') ? FORMAT_DATE : "Y-m-d H:i:s");
        $dateFormated = new \DateTime();
        $navegador = get_browser_name(Headers::http_user_agent());

        $post = isset($is_initialize)
                                    ? json_encode($is_initialize)
                                    : "NO DATA";

        $sesiones = !empty($_SESSION) ? json_encode($_SESSION) : "NO SESSION";

        $fieldsToArray = array(
                "R_DATE_OPERATION"=>$dateFormated->format($formatDate),
                "R_IP"=>get_client_ip(),
                "R_BROWSER"=>$navegador->name,
                "R_VERSION_BROWSER"=>$navegador->version,
                "R_HOSTNAME"=>gethostname(),
                "R_HOSTSERVER"=>Headers::http_host(),
                "R_PORT"=>Headers::remote_port(),
                "R_REQUEST_URI"=>Headers::request_uri(),
                "R_REQUEST_METHOD"=>Headers::request_method(),
                "R_HTTP_REFERRER"=>Headers::http_referrer(),
                "R_HTTP_PROTOCOL"=>Headers::wprotocol(),
                "R_HTTP_LANGUAJE"=>Headers::http_accept_language(),
                "R_HTTP_STATUS"=>Headers::redirect_status(),
                "R_HTTP_PARAMETERS"=>$post,
                "R_SESSIONS_APP"=>$sesiones
        );

		$db->table($configGet->table_log)->insert($fieldsToArray);
	}


	public function this_write($str = ''  ,$file  =  '')
	{
		$newStr = "[".date("Y-m-d H:i:s")."]: ".$str;
		error_log($newStr, 3, $file);
    	error_log("\xA", 3, $file);
	}
}




 ?>