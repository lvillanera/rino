<?php



//Functions

if (!function_exists('read_file')) {

	function read_file($file) {
		return @file_get_contents($file);
	}
}



//Functions

if (!function_exists('write_file')) {

	function write_file($path, $data, $mode = 'wb') {
		if (!$fp = @fopen($path, $mode)) {
			return FALSE;
		}

		flock($fp, LOCK_EX);

		for ($result = $written = 0, $length = strlen($data); $written < $length; $written += $result) {
			if (($result = fwrite($fp, substr($data, $written))) === FALSE) {
				break;
			}
		}

		flock($fp, LOCK_UN);
		fclose($fp);

		return is_int($result);
	}
}



//Functions

if (!function_exists('delete_files')) {

	function delete_files($path, $delete_dir = FALSE, $htdocs = FALSE, $_level = 0) {
		$path = rtrim($path, '/\\');

		if (!$current_dir = @opendir($path)) {
			return FALSE;
		}

		while (FALSE !== ($filename = @readdir($current_dir))) {
			if ($filename !== '.' && $filename !== '..') {
				if (is_dir($path . DIRECTORY_SEPARATOR . $filename) && $filename[0] !== '.') {
					delete_files($path . DIRECTORY_SEPARATOR . $filename, $delete_dir, $htdocs, $_level + 1);
				} elseif ($htdocs !== TRUE OR !preg_match('/^(\.htaccess|index\.(html|htm|php)|web\.config)$/i', $filename)) {
					@unlink($path . DIRECTORY_SEPARATOR . $filename);
				}
			}
		}

		closedir($current_dir);

		return ($delete_dir === TRUE && $_level > 0)
		? @rmdir($path)
		: TRUE;
	}
}



//Functions

if (!function_exists('get_filenames')) {

	function get_filenames($dir_src, $include = FALSE, $is_recursive = FALSE) {
		static $setFileData = array();

		if ($fp = @opendir($dir_src)) {

			if ($is_recursive === FALSE) {
				$setFileData = array();
				$dir_src = rtrim(realpath($dir_src), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
			}

			while (FALSE !== ($file = readdir($fp))) {
				if (is_dir($dir_src . $file) && $file[0] !== '.') {
					get_filenames($dir_src . $file . DIRECTORY_SEPARATOR, $include, TRUE);
				} elseif ($file[0] !== '.') {
					$setFileData[] = ($include === TRUE) ? $dir_src . $file : $file;
				}
			}

			closedir($fp);
			return $setFileData;
		}

		return FALSE;
	}
}

// Functions

if (!function_exists('get_dir_file_info')) {

	function get_dir_file_info($src_dir, $level = TRUE, $is_recursive = FALSE) {
		static $_filedata = array();
		$relative_path = $src_dir;

		if ($fp = @opendir($src_dir)) {

			if ($is_recursive === FALSE) {
				$_filedata = array();
				$src_dir = rtrim(realpath($src_dir), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
			}

			while (FALSE !== ($file = readdir($fp))) {
				if (is_dir($src_dir . $file) && $file[0] !== '.' && $level === FALSE) {
					get_dir_file_info($src_dir . $file . DIRECTORY_SEPARATOR, $level, TRUE);
				} elseif ($file[0] !== '.') {
					$_filedata[$file] = get_file_info($source_dir . $file);
					$_filedata[$file]['relative_path'] = $relative_path;
				}
			}

			closedir($fp);
			return $_filedata;
		}

		return FALSE;
	}
}

// Functions

if (!function_exists('get_file_info')) {

	function get_file_info($file, $ret_values = array('name', 'server_path', 'size', 'date')) {
		if (!file_exists($file)) {
			return FALSE;
		}

		if (is_string($ret_values)) {
			$ret_values = explode(',', $ret_values);
		}

		foreach ($ret_values as $key) {
			switch ($key) {
			case 'name':
				$fileinfo['name'] = basename($file);
				break;
			case 'server_path':
				$fileinfo['server_path'] = $file;
				break;
			case 'size':
				$fileinfo['size'] = filesize($file);
				break;
			case 'date':
				$fileinfo['date'] = filemtime($file);
				break;
			case 'readable':
				$fileinfo['readable'] = is_readable($file);
				break;
			case 'writable':
				$fileinfo['writable'] = is_really_writable($file);
				break;
			case 'executable':
				$fileinfo['executable'] = is_executable($file);
				break;
			case 'fileperms':
				$fileinfo['fileperms'] = fileperms($file);
				break;
			}
		}

		return $fileinfo;
	}
}

// Functions

if (!function_exists('get_mime_by_extension')) {

	function get_mime_by_extension($filename) {
		static $mimes;

		if (!is_array($mimes)) {
			load_helper("mimefile");
			$mimes = &getMimefile();
			if (empty($mimes)) {
				return FALSE;
			}
		}

		$extension = strtolower(substr(strrchr($filename, '.'), 1));

		if (isset($mimes[$extension])) {
			return is_array($mimes[$extension])
			? current($mimes[$extension])
			: $mimes[$extension];
		}

		return FALSE;
	}
}

// Functions

if (!function_exists('symbolic_permissions')) {

	function symbolic_permissions($perms) {
		
		if (($perms & 0xC000) === 0xC000) {
			$symbolic = 's';
		} elseif (($perms & 0xA000) === 0xA000) {
			$symbolic = 'l';
		} elseif (($perms & 0x8000) === 0x8000) {
			$symbolic = '-';
		} elseif (($perms & 0x6000) === 0x6000) {
			$symbolic = 'b';
		} elseif (($perms & 0x4000) === 0x4000) {
			$symbolic = 'd';
		} elseif (($perms & 0x2000) === 0x2000) {
			$symbolic = 'c';
		} elseif (($perms & 0x1000) === 0x1000) {
			$symbolic = 'p';
		} else {
			$symbolic = 'u';
		}

		$symbolic .= (($perms & 0x0100) ? 'r' : '-')
			. (($perms & 0x0080) ? 'w' : '-')
			. (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));

		$symbolic .= (($perms & 0x0020) ? 'r' : '-')
			. (($perms & 0x0010) ? 'w' : '-')
			. (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));

		$symbolic .= (($perms & 0x0004) ? 'r' : '-')
			. (($perms & 0x0002) ? 'w' : '-')
			. (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));

		return $symbolic;
	}
}

// Functions

if (!function_exists('octal_permissions')) {

	function octal_permissions($perms) {
		return substr(sprintf('%o', $perms), -3);
	}
}

