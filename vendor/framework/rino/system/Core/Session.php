<?php
namespace Rino\Core;

class Session
{

	private $sessionName,$nameCookie,$time;

	protected $newconfig,$name, $domain, $hash, $key, $path, $secure, $decoy, $min_time, $max_time;

	protected $arrayconfig;

	
	/**
	 * @void
	 * @param array config
	 * return this
	 * 
	 */

	public function config($params='')
	{
		if(is_array($params))
		{
			$this->arrayconfig = $params;
			ini_set('session.gc_maxlifetime', $params["session_expiration"]);
			session_cache_expire($params["sess_cache_expire"]);

		}

		return $this;
	}


	
	/**
	 * @void
	 * Inicia con la carga de la sesión
	 * return null
	 * 
	 */

	public function start()
	{
		global $is_cookie_package;

		if(empty($is_cookie_package))
		{
			$is_cookie_package = $_COOKIE;
		}

		$config = new Config();
    	

		$this->arrayconfig = $config->get();

		$requestedwith = Headers::http_x_requested_with()->lower;
		$regenerate_time = $this->arrayconfig->sess_time_to_update;
		
		$expiration = $this->arrayconfig->session_expiration;
		
		if(isset($is_cookie_package["PHPSESSID"]))
		{
			unset($is_cookie_package["PHPSESSID"]);
		}

		session_set_cookie_params(
			$this->arrayconfig->cookie_lifetime,
			$this->arrayconfig->cookie_path,
			$this->arrayconfig->cookie_domain,
			$this->arrayconfig->cookie_secure,
			TRUE
		);

		if (empty($expiration))
		{
			ini_get('session.gc_maxlifetime');
		}
		else
		{
			ini_set('session.gc_maxlifetime', $expiration);
		}

		ini_set('session.use_trans_sid', 0);
		ini_set('session.use_strict_mode', 1);
		ini_set('session.use_cookies', 1);
		ini_set('session.use_only_cookies', 1);
		ini_set('session.hash_function', 1);
		ini_set('session.hash_bits_per_character', 4);
		
		session_name($this->arrayconfig->sess_cookie_name);
		session_start();

		if (empty($requestedwith) && $regenerate_time > 0)
		{

			if (!isset($_SESSION['_rino_rg_time']))
			{
				$_SESSION['_rino_rg_time'] = time();
			}
			elseif ($_SESSION['_rino_rg_time'] < (time() - $regenerate_time))
			{
				session_regenerate_id($this->arrayconfig->sess_regenerate_destroy);
			}
		}
		elseif (isset($is_cookie_package[$this->arrayconfig->sess_cookie_name]) && $is_cookie_package[$this->arrayconfig->sess_cookie_name] === session_id())
		{
			setcookie(
				$this->arrayconfig->sess_cookie_name,
				session_id(),
				(empty($this->arrayconfig->cookie_lifetime) ? 0 : time() + $this->arrayconfig->cookie_lifetime),
				$this->arrayconfig["cookie_path"],
				$this->arrayconfig["cookie_domain"],
				$this->arrayconfig["cookie_secure"],
				TRUE
			);
		}

	}


	/**
	 * @void
	 * @param key session
	 * return bool
	 * 
	 */
	public function session_exist($key = '')
	{
		if(!is_array($key))
		{
			return (isset($_SESSION[$key])?true:false);
		}

	}

	
	/**
	 * @void
	 * return array
	 * 
	 */

	public function getAll()
	{
		return $_SESSION;
	}


	/**
	 * @void
	 * @param key session
	 * return null
	 * 
	 */

	public function quit($key = '')
	{
		if (is_array($key))
		{
			foreach ($key as $k)
			{
				unset($_SESSION[$k]);
			}

			return;
		}

		unset($_SESSION[$key]);
	}


	/**
	 * @void
	 * @param namesession,values
	 * return this
	 * 
	 */
	public function set($nameSession = 'default',$values = NULL)
	{
				
		if (is_array($nameSession))
		{
			foreach ($nameSession as $key => &$value)
			{
				$_SESSION[$key] = $value;
			}

			return;
		}

		if(!isset($_SESSION[$nameSession]))
		{
			if(!isset($_SESSION[$nameSession]))
			{
				$_SESSION[$nameSession] = $values;
			}
		}
		return $this;

	}



	/**
	 * @void
	 * @param key,values
	 * return null
	 * 
	 */
	public function pushIn($key='',$values = '')
	{
		$this->__push($key,$values);
	}

	protected function __push($sessionkey='',$values = '')
	{
		
		if(isset($_SESSION[$sessionkey]))
		{
			// print_r($values);
			if(is_array($values))
			{
				foreach ($values as $key => $value) {
					if(is_array($value))
					{
						$this->__push($sessionkey,$value);
					}
					else
					{
						$_SESSION[$sessionkey][$key] = $value;
					}
				}

				return;
			}

			$_SESSION[$sessionkey] = $values;

		}
	}

	
	/**
	 * @void getObject
	 * @param key session
	 * return object
	 * 
	 */

	public function getObject($key='')
	{
		return (($key != '') ? array_to_object($_SESSION[$key]):array_to_object($_SESSION));
	}

	/**
	 * @void getArray
	 * @param key session
	 * return array
	 * 
	 */

	public function getArray($key='')
	{
		return (($key != '') ? convertObjectToArray($_SESSION[$key],false) : convertObjectToArray($_SESSION,false) );
	}

	/**
	 * @void valFrom
	 * @param key(session),index (default)
	 * return String
	 * 
	 */

	public function valFrom($key='',$index = 'default')
	{
		if(isset($_SESSION[$key]))
		{
			if(array_key_exists($index, $_SESSION[$key]))
			{
				return $_SESSION[$key][$index];
			}
		}
	}


	/**
	 * @void get
	 * @param name(session)
	 * return String
	 * 
	 */

	public function get($name='')
	{
		if (!empty($name)) {
			return (isset($_SESSION[$name]) ? $_SESSION[$name] :'');
		}
	}

	/**
	 * @void id
	 * return null
	 * 
	 */
	public function id()
	{
		return session_id();
	}

	/**
	 * @void destroy
	 * @param name(session)
	 * return bool
	 * 
	 */

	public function destroy($name='')
	{
		if(!empty($name))
		{
			if(is_array($name))
			{
				foreach ($name as $keysession => $session) {
					if(isset($_SESSION[$session]))
					{
						unset($_SESSION[$session]);
					}
				}
			}
			else
			{
				unset($_SESSION[$name]);
			}
		}
		else
		{
			$_SESSION = array();
			session_destroy();
		}
		return true;
	}

/**
	 * @void set_iterator
	 * @param key(session),data
	 * return this
	 * 
	 */
	public function set_iterator($key='',$data)
	{
		$itemsCount = count($_SESSION[$key]);
		$_SESSION[$key][$itemsCount + 1] = $data;
		return $this;
	}


}

 ?>
