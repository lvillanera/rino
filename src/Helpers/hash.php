<?php

if ( ! function_exists('hash_equals'))
{

	function hash_equals($known_string, $user_string)
	{
		if ( ! is_string($known_string))
		{
			trigger_error('hash_equals(): Expected known_string to be a string, '.strtolower(gettype($known_string)).' given', E_USER_WARNING);
			return FALSE;
		}
		elseif ( ! is_string($user_string))
		{
			trigger_error('hash_equals(): Expected user_string to be a string, '.strtolower(gettype($user_string)).' given', E_USER_WARNING);
			return FALSE;
		}
		elseif (($length = strlen($known_string)) !== strlen($user_string))
		{
			return FALSE;
		}

		$diff = 0;
		for ($i = 0; $i < $length; $i++)
		{
			$diff |= ord($known_string[$i]) ^ ord($user_string[$i]);
		}

		return ($diff === 0);
	}
}

if ( ! function_exists('hash_pbkdf2'))
{
	function hash_pbkdf2($algo, $password, $salt, $iterations, $length = 0, $raw_output = FALSE)
	{
		if ( ! in_array($algo, hash_algos(), TRUE))
		{
			trigger_error('hash_pbkdf2(): Unknown hashing algorithm: '.$algo, E_USER_WARNING);
			return FALSE;
		}

		if (($type = gettype($iterations)) !== 'integer')
		{
			if ($type === 'object' && method_exists($iterations, '__toString'))
			{
				$iterations = (string) $iterations;
			}

			if (is_string($iterations) && is_numeric($iterations))
			{
				$iterations = (int) $iterations;
			}
			else
			{
				trigger_error('hash_pbkdf2() expects parameter 4 to be long, '.$type.' given', E_USER_WARNING);
				return NULL;
			}
		}

		if ($iterations < 1)
		{
			trigger_error('hash_pbkdf2(): Iterations must be a positive integer: '.$iterations, E_USER_WARNING);
			return FALSE;
		}

		if (($type = gettype($length)) !== 'integer')
		{
			if ($type === 'object' && method_exists($length, '__toString'))
			{
				$length = (string) $length;
			}

			if (is_string($length) && is_numeric($length))
			{
				$length = (int) $length;
			}
			else
			{
				trigger_error('hash_pbkdf2() expects parameter 5 to be long, '.$type.' given', E_USER_WARNING);
				return NULL;
			}
		}

		if ($length < 0)
		{
			trigger_error('hash_pbkdf2(): Length must be greater than or equal to 0: '.$length, E_USER_WARNING);
			return FALSE;
		}

		$hash_length = strlen(hash($algo, NULL, TRUE));
		if (empty($length))
		{
			$length = $hash_length;
		}

		$hash = '';
		
		for ($bc = ceil($length / $hash_length), $bi = 1; $bi <= $bc; $bi++)
		{
			$key = $derived_key = hash_hmac($algo, $salt.pack('N', $bi), $password, TRUE);
			for ($i = 1; $i < $iterations; $i++)
			{
				$derived_key ^= $key = hash_hmac($algo, $key, $password, TRUE);
			}

			$hash .= $derived_key;
		}

		return substr($raw_output ? $hash : bin2hex($hash), 0, $length);
	}
}
