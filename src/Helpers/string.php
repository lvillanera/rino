<?php

if ( ! function_exists('strip_slashes'))
{
	function strip_slashes($str = '')
	{
		if (!is_array($str))
		{
			return stripslashes($str);
		}
		else
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = strip_slashes($val);
			}

			return $str;
		}
	}
}


// ------------------------------------------------------------------------

if ( ! function_exists('strip_quotes'))
{
	function strip_quotes($str)
	{
		return str_replace(array('"', "'"), '', $str);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('quotes_to_entities'))
{
	function quotes_to_entities($str)
	{
		return str_replace(array("\'","\"","'",'"'), array("&#39;","&quot;","&#39;","&quot;"), $str);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('reduce_double_slashes'))
{
	function reduce_double_slashes($str)
	{
		return preg_replace('#(^|[^:])//+#', '\\1/', $str);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('reduce_multiples'))
{
	function reduce_multiples($str, $character = ',', $trim = FALSE)
	{
		$str = preg_replace('#'.preg_quote($character, '#').'{2,}#', $character, $str);
		return ($trim === TRUE) ? trim($str, $character) : $str;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('random_string'))
{

	function random_string($type = 'alnum', $len = 8)
	{
		switch ($type)
		{
			case 'basic':
				return mt_rand();
			case 'alnum':
			case 'numeric':
			case 'nozero':
			case 'alpha':
				switch ($type)
				{
					case 'alpha':
						$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'alnum':
						$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'numeric':
						$pool = '0123456789';
						break;
					
					case 'nozero':
						$pool = '123456789';
						break;
				}
				return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
			case 'unique':
			case 'md5':
				return md5(uniqid(mt_rand()));
			case 'encrypt':
			case 'time':
				$replace = str_replace(array("."," ",","),"",microtime(true));
				return substr($replace,$len);

			case 'sha1':
				return sha1(uniqid(mt_rand(), TRUE));
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('increment_string'))
{

	function increment_string($str, $separator = '_', $first = 1)
	{
		preg_match('/(.+)'.$separator.'([0-9]+)$/', $str, $match);
		return isset($match[2]) ? $match[1].$separator.($match[2] + 1) : $str.$separator.$first;
	}
}

if ( ! function_exists('repeater'))
{
	function repeater($data, $num = 1)
	{
		return ($num > 0) ? str_repeat($data, $num) : '';
	}
}


if ( ! function_exists('objectToUtf8')) {
	function objectToUtf8( $data, $array = array() , $type = false)
	{
		if (is_object($data) || is_array($data)) {
			if ($type) {
				foreach ($array as $arrayValue) {
					foreach ($data as $dataKey => $dataValue) {
							$data[$dataKey]->$arrayValue = to_utf8($data[$dataKey]->$arrayValue);
					 } 
				}
			}else{
				foreach ($array as $value) {
					$data->$value = to_utf8($data->$value); 
				}
			}
			return $data;
		}
		return false;
	}
}


// ----------------------------------------------------------

if(!function_exists('clear_boom'))
{

	function clear_boom($source_file) {
		$str = file_get_contents($source_file);
		$str = str_replace("\xEF\xBB\xBF", '', $str);
		$obj = json_decode($str);
	}
}

// ----------------------------------------------------------

if ( ! function_exists('rmDir_rf')) {
	function rmDir_rf($carpeta)
    {
      foreach(glob($carpeta . "/*") as $archivos_carpeta){             
        if (is_dir($archivos_carpeta)){
          rmDir_rf($archivos_carpeta);
        } else {
        unlink($archivos_carpeta);
        }
      }
      rmdir($carpeta);
     }
}

