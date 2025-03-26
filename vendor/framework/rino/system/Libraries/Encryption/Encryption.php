<?php
namespace Rino\Libraries\Encryption;

class Encryption 
{
	private static $enc_method;
	private static $enc_key;
	private static $enc_iv;
	private static $enc_salt;
	

	protected static function config($config = array())
	{
		$constants = \Rino\Core\Config::get();
		
		$ec_method = (isset($config["type_method"]) && !empty($config["type_method"]) && $config["type_method"] != NULL) ? $config["type_method"] : $constants->type_method;

		$ec_key = (isset($config["enc_key"]) && !empty($config["enc_key"]) && $config["enc_key"] != NULL) ?
		$config["enc_key"] : $constants->enc_key;

		$ec_iv = (isset($config["enc_iv"]) && !empty($config["enc_iv"]) && $config["enc_iv"] != NULL) ?
		$config["enc_iv"] : $constants->enc_iv;

		$ec_salt = (isset($config["salt_token"]) && !empty($config["salt_token"]) && $config["salt_token"] != NULL) ?
		$config["salt_token"] : $constants->salt_token;

		if(
			$ec_method == '' ||
			$ec_key == '' ||
			$ec_iv == '' ||
			$ec_salt == ''
		)
		{
			try {

				throw new Exceptions\ExceptionEncrypt('Encryption arguments invalid<br>Required
									<br> -->type_method
									<br> -->enc_key
									<br> -->enc_iv
									<br> -->salt_token
									',1);
			} catch (Exception $e) {
				print_r($e);
			}
		}

		self::$enc_method = $ec_method;
		self::$enc_key = $ec_key;
		self::$enc_iv = $ec_iv;
		self::$enc_salt = $ec_salt;

	}

	public static function Encrypt($string)
	{
		self::config();
		$output = false;
		$key = hash('sha256', self::$enc_key);
		$iv = substr(hash('sha256', self::$enc_iv), 0, 16);
		$output = openssl_encrypt($string, self::$enc_method, $key, 0, $iv);
		$output = base64_encode($output);
		return $output;
	}
	

	public static function Decrypt($string)
	{
		self::config();
		$output = false;
		$key = hash('sha256', self::$enc_key);
		$iv = substr(hash('sha256', self::$enc_iv), 0, 16);
		$output = openssl_decrypt(base64_decode($string), self::$enc_method, $key, 0, $iv);
		return $output;
	}
	

	public static function EncryptPassword($Input)
	{
		self::config();
		if(!isset($Input) || $Input == null || empty($Input)) { return false;}
		
		$SALT = self::$Encrypt(self::$enc_salt);
		$SALT = md5($SALT);
		$Input = md5(self::$Encrypt(md5($Input)));
		$Input = self::$Encrypt($Input);
		$Input =  md5($Input);			
		$Encrypted = self::$Encrypt($SALT).self::$Encrypt($Input);
		$Encrypted = sha1($Encrypted.$SALT);

		return md5($Encrypted);
	}
}
?>