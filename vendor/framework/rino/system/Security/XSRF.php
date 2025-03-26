<?php

namespace Rino\Security;

class XSRF {

	const SESSION_TOKEN_SALT = 'PRXgydcAyvvCuMzDow2EhzbYlo5CbKrauu3CST7T';

	const SESSION_TOKEN_LENGTH = 15;


	protected $SESSION_ARRAY_NAME = 'XSRF_TOKENS';

	
	protected $SESSION_TOKEN_NAME = 'XSRF_TOKEN';

	
	protected $POST_TOKEN_NAME    = 'XSRF_TOKEN';


	public function __construct($session_key = null, $post_key = null, $session_array = null) {
		if ($session_key) {
			$this->SESSION_TOKEN_NAME = $session_key;
		}

		if ($post_key) {
			$this->POST_TOKEN_NAME    = $post_key;
		}

		if ($session_array) {
			$this->SESSION_ARRAY_NAME = $session_array;
 		}

 		if (isset($_SESSION[ $this->SESSION_ARRAY_NAME ]) === false) {
 			$_SESSION[ $this->SESSION_ARRAY_NAME ] = array();
 		}
	}


	
	public function destroyToken() {
		if(isset($_SESSION[  $this->SESSION_ARRAY_NAME ][ $this->SESSION_TOKEN_NAME ])) {
			unset($_SESSION[ $this->SESSION_ARRAY_NAME ][ $this->SESSION_TOKEN_NAME ]);
			return true;
		} else {
			return false;
		}
	}


	
	public function generateToken() {
		return (string) $_SESSION[ $this->SESSION_ARRAY_NAME ][ $this->SESSION_TOKEN_NAME ] = $this->createToken(); 
	}


	
	public function getToken() {
		return (string) $_SESSION[ $this->SESSION_ARRAY_NAME ][ $this->SESSION_TOKEN_NAME ];
	}


	
	public function tokenIsValid() {
		if ($this->tokenIsSet()) {
			return (
				$_POST[ $this->POST_TOKEN_NAME ] === $_SESSION[ $this->SESSION_ARRAY_NAME ][ $this->SESSION_TOKEN_NAME ]
			);
		} else {
			return false;
		}
	}


	
	public function tokenIsSet() {
		return (
			isset($_POST[ $this->POST_TOKEN_NAME ]) &&
			isset($_SESSION[ $this->SESSION_ARRAY_NAME ][ $this->SESSION_TOKEN_NAME ])
		);
	}


	
	protected function createToken() {
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ:;.,<>?/~!@#$%^&*()_+';
		$token = '';
		$iterator = range(0,self::SESSION_TOKEN_LENGTH);
		foreach ($iterator as $i) {
			$token .= (string) chr($chars[ mt_rand(0, strlen($chars) - 1) ]);
		}

		return sha1($token . time() . mt_rand() . self::SESSION_TOKEN_SALT);
	}
}
