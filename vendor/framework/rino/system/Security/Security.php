<?php
namespace Rino\Security;
use Rino\Core\Constant;

class Security {


	protected static $bad_chars_name_files =	array(
		'../', '<!--', '-->', '<', '>',
		"'", '"', '&', '$', '#',
		'{', '}', '[', ']', '=',
		';', '?', '%20', '%22',
		'%3c',
		'%253c',
		'%3e',
		'%0e',
		'%28',
		'%29',
		'%2528',
		'%26',
		'%24',
		'%3f',
		'%3b',
		'%3d'
	);

	protected static $_str_denied =	array(
		'document.cookie'	=> '[removed]',
		'document.write'	=> '[removed]',
		'.parentNode'		=> '[removed]',
		'.innerHTML'		=> '[removed]',
		'-moz-binding'		=> '[removed]',
		'<!--'				=> '&lt;!--',
		'-->'				=> '--&gt;',
		'<![CDATA['			=> '&lt;![CDATA[',
		'<comment>'			=> '&lt;comment&gt;'
	);

	protected static $bad_regex = array(
		'javascript\s*:',
		'(document|(document\.)?window)\.(location|on\w*)',
		'expression\s*(\(|&\#40;)',
		'vbscript\s*:',
		'wscript\s*:',
		'jscript\s*:',
		'vbs\s*:',
		'Redirect\s+30\d',
		"([\"'])?data\s*:[^\\1]*?base64[^\\1]*?,[^\\1]*?\\1?"
	);

	const SESSION_TOKEN_SALT = "";

	const SESSION_TOKEN_LENGTH = 15;

	protected static $lenght_token = 15;
	protected static $token_salt = 'PRXgydcAyvvCuMzDow2EhzbYlo5CbKrauu3CST7T';

	protected static $IN_SERVER_ARRAY = 'rino_xsrf_generated_tokens';

	
	protected static $IN_SERVER_TOKEN = 'rino_xsrf_generate_token';

	
	protected static $_NAME_POST_TOKEN    = 'rino_xsrf_token';


	/*
		Puede ser llamada en una peticion http
	*/

	public static function tokenIsSet() {
		global $is_post;
		return (
			isset($is_post[ self::$_NAME_POST_TOKEN ]) &&
			isset($_SESSION[ self::$IN_SERVER_ARRAY ][ self::$IN_SERVER_TOKEN ])
		);
	}

	/*
		Puede ser llamada en una peticion http
	*/

	public static function tokenIsValid() {
		global $is_post;
		if (self::tokenIsSet()) {
			return (
				$is_post[ self::$_NAME_POST_TOKEN ] === $_SESSION[ self::$IN_SERVER_ARRAY ][ self::$IN_SERVER_TOKEN ]
			);
		} else {
			return false;
		}
	}



	public static function destroyToken() {
		if(isset($_SESSION[  self::$IN_SERVER_ARRAY ][ self::$IN_SERVER_TOKEN ])) {
			unset($_SESSION[ self::$IN_SERVER_ARRAY ][ self::$IN_SERVER_TOKEN ]);
			return true;
		} else {
			return false;
		}
	}

	public static function generateToken() {
		return (string) $_SESSION[ self::$IN_SERVER_ARRAY ][ self::$IN_SERVER_TOKEN ] = self::createToken(); 
	}

	public static function len_token($lenght)
	{
		self::$lenght_token = $lenght;
	}


	public static function getToken() {
		return (string) $_SESSION[ self::$IN_SERVER_ARRAY ][ self::$IN_SERVER_TOKEN ];
	}


	protected static function tokensalt()
	{
		$tokenizer = self::$token_salt;
		$token_constant = (isset(Constant::get()->salt_token)?Constant::get()->salt_token:'');

		return (($token_constant !='') ?
					$token_constant:$tokenizer
					);

	}
	
	protected static function createToken($key = '') {
		$chars = (($key!='')?$key:'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ:;.,<>?/~!@#$%^&*()_+');
		$token = '';
		$k = self::$lenght_token;

		for ($i = 0; $i < $k; $i++) {
			$token .= (string) chr($chars[ mt_rand(0, strlen($chars) - 1) ]);
		}
		
		return sha1($token . time() . mt_rand() . self::tokensalt());
	}




	public static function clean_str_filename($str, $relative_path = FALSE)
	{
		$bad = self::$bad_chars_name_files;

		if ( ! $relative_path)
		{
			$bad[] = './';
			$bad[] = '/';
		}

		$str = remove_invisible_characters($str, FALSE);

		do
		{
			$old = $str;
			$str = str_replace($bad, '', $str);
		}
		while ($old !== $str);

		return stripslashes($str);
	}




	
	public static function escape($string = '',$image = false) {
			
			if(is_array($string))
			{
				foreach ($string as $key => $value) {

					$string[$key] = self::escape($string[$key]);
				}
				
				return $string;
			}

			$converted_string = $string;

			$string = remove_invisible_characters($string);

			do
			{
				$string = rawurldecode($string);
			}

			while (preg_match('/%[0-9a-f]{2,}/i', $string));

			$string = str_replace("\t", ' ', $string);

			$string = self::_never_allowed($string);


			if ($image === TRUE)
			{
				$string = preg_replace('/<\?(php)/i', '&lt;?\\1', $string);
			}
			else
			{
				$string = str_replace(array('<?', '?'.'>'), array('&lt;?', '?&gt;'), $string);
			}


			$words = array(
				'javascript', 'expression', 'vbscript', 'jscript', 'wscript',
				'vbs', 'script', 'base64', 'applet', 'alert', 'document',
				'write', 'cookie', 'window', 'confirm', 'prompt'
			);

			foreach ($words as $word)
			{
				$word = implode('\s*', str_split($word)).'\s*';
				$string = preg_replace_callback('#('.substr($word, 0, -3).')(\W)#is', 
					function ($matches)
					{
						return preg_replace('/\s+/s', '', $matches[1]).$matches[2];
					}
					, $string);
			}


			$naughty = 'alert|prompt|confirm|applet|audio|basefont|base|behavior|bgsound|blink|body|embed|expression|form|frameset|frame|head|html|ilayer|iframe|input|button|select|isindex|layer|link|meta|keygen|object|plaintext|style|script|textarea|title|math|video|svg|xml|xss';
			
			$string = preg_replace_callback('#<(/*\s*)('.$naughty.')([^><]*)([><]*)#is', function ($matches)
				{
					return '&lt;'.$matches[1].$matches[2].$matches[3].str_replace(array('>', '<'), array('&gt;', '&lt;'), $matches[4]);
					
				}, $string);

			$string = preg_replace('#(alert|prompt|confirm|cmd|passthru|eval|exec|expression|system|fopen|fsockopen|file|file_get_contents|readfile|unlink)(\s*)\((.*?)\)#si',
					'\\1\\2&#40;\\3&#41;',
					$string);

			$string = self::_never_allowed($string);

			if ($image === TRUE)
			{
				return ($string === $converted_string);
			}

			return $string;

	}

	protected static function _never_allowed($str)
	{
		$str = str_replace(array_keys(self::$_str_denied), self::$_str_denied, $str);

		foreach (self::$bad_regex as $regex)
		{
			$str = preg_replace('#'.$regex.'#is', '[removed]', $str);
		}

		return $str;
	}

}
