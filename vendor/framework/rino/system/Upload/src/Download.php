<?php

namespace Rino\Upload\src;

class Download {
	protected $file;
	protected $path = '';
	protected $extensions = array('pdf', 'jpg', 'jpeg', 'png', 'gif', 'zip');
	protected $whitelist = array();
	protected $errors = array();
	protected $dest;
	protected $dirTmp;
	public function __construct($file, $path = null,$dirTmp = null, array $extensions = null, array $whitelist = null) {
		$this->file = $file;

		if ($path) {
			$this->path = $path;
		}

		if($dirTmp)
		{
			$this->dirTmp = $dirTmp;
		}

		if ($extensions) {
			$this->extensions = $extensions;
		}

		if ($whitelist) {
			$this->whitelist = $whitelist;
		}
	}


	public function validate() {

		if ($this->extensionAllowed( $this->getFileName(false) ) === false) {
			$this->errors[] = "Illegal file extension";
			return false;
		}

		if (empty($this->whitelist) === false) {
			if ($this->fileInWhiteList( $this->getFileName(false) )) {
				$this->errors[] = "Illegal file name";
				return false;
			}
		}

		if ($this->fileExists( $this->getFileName(true) ) === false) {
			$this->errors[] = "File does not exist";
			return false;
		} else {
			return true;
		}
	}

	protected function extensionAllowed($file) {
		return in_array(strtolower(end(explode('.', $file))), array_map('strtolower', $this->extensions));
	}

	protected function fileInWhiteList($file) {
		return in_array($file, $this->whitelist);
	}

	protected function fileExists($file) {
		return (file_exists($file) && is_readable($file));
	}


	protected function getFileName($fullPath = false) {
		if ($fullPath) {
			return $this->path . $this->sanitize( $this->file );
		} else {
			return $this->sanitize( $this->file );
		}
	}


	protected function sanitize($string) {
		return str_replace(
			array(
				"\x2E\x2E\x2F",
				"\x2E\x2E\x5C",
				"\x2E\x2F",
				"\x2E\x5C",
				"\x2F",
				"\x5C",
				"\x0D\x0A",
				"\x0D",
				"\x0A",
				"\x00"
			), 

			'',

			$string
		);
	}

	public function renameTo($newName = '')
	{
		$file = $this->getFileName(true);
		$newName = $this->sanitize($newName);
		$temporal = $this->path . $this->dirTmp;
		if(!is_dir($temporal))
		{
			mkdir($temporal);
		}

		$destino = $temporal.DIRECTORY_SEPARATOR.$newName;
		
		@copy($file, $destino);

		$this->file = $newName;
		$this->path = $temporal.DIRECTORY_SEPARATOR;

	}

	public function download() {
		
		if ($this->hasErrors() === false) {
			header('Content-Disposition: attachment; size=' . filesize( $this->getFileName(true) )); 
			header('Content-type: application/force-download');
			header('Content-Transfer-Encoding: binary');  
			header('Content-Disposition: attachment; filename="'. $this->getFileName(false) .'"');
			readfile( $this->getFileName(true) );
			return true;
		} else {
			return false;
		}
	}
	public function hasErrors() {
		return (empty($this->errors) === false);
	}
	public function getErrors() {
		return $this->errors;
	}
}
