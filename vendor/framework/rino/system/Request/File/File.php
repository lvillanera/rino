<?php 
namespace Rino\Request\File;

class File extends FileException
{
	
	function __construct($file, $lang = 'PE') {
				
		$this->upload($file, $idioma);
	}

	function init() {
		
		try {
		$fileMine = APP_PATH.DS."config".DS."file_mime.php";
		
			if(file_exists($fileMine)) {
				include $fileMine;
			} else {
				throw new FileException();
			}
		} catch (FileException $e) {
			echo $this->file_not_found();
		}

		$this->allowed = $mime_allowed;

		$this->mime_types = $mime_type;
		
		$this->file_new_name_body = null;
		$this->file_name_body_add = null;
		$this->file_name_body_pre = null;
		$this->file_new_name_ext = null;
		$this->file_safe_name = true;
		$this->file_force_extension = true;
		$this->file_overwrite = false;
		$this->file_auto_rename = true;
		$this->dir_auto_create = true;
		$this->dir_auto_chmod = true;
		$this->dir_chmod = 0777;

		$this->no_script = true;
		$this->mime_check = true;

		$this->mime_fileinfo = true;
		$this->mime_file = true;
		$this->mime_magic = true;
		$this->mime_getimagesize = true;

		$this->file_max_size_raw = trim(ini_get('upload_max_filesize'));
		$this->file_max_size = $this->getsize($this->file_max_size_raw);

		$this->image_resize = false;
		$this->image_convert = ''; 

		$this->image_x = 150;
		$this->image_y = 150;
		$this->image_ratio = false;
		$this->image_ratio_crop = false;
		$this->image_ratio_fill = false;
		$this->image_ratio_pixels = false;
		$this->image_ratio_x = false;
		$this->image_ratio_y = false;
		$this->image_ratio_no_zoom_in = false;
		$this->image_ratio_no_zoom_out = false;
		$this->image_no_enlarging = false;
		$this->image_no_shrinking = false;

		$this->png_compression = null;
		$this->jpeg_quality = 85;
		$this->jpeg_size = null;
		$this->image_interlace = false;
		$this->image_is_transparent = false;
		$this->image_transparent_color = null;
		$this->image_background_color = null;
		$this->image_default_color = '#ffffff';
		$this->image_is_palette = false;

		$this->image_max_width = null;
		$this->image_max_height = null;
		$this->image_max_pixels = null;
		$this->image_max_ratio = null;
		$this->image_min_width = null;
		$this->image_min_height = null;
		$this->image_min_pixels = null;
		$this->image_min_ratio = null;

		$this->image_brightness = null;
		$this->image_contrast = null;
		$this->image_opacity = null;
		$this->image_threshold = null;
		$this->image_tint_color = null;
		$this->image_overlay_color = null;
		$this->image_overlay_opacity = null;
		$this->image_negative = false;
		$this->image_greyscale = false;
		$this->image_pixelate = null;
		$this->image_unsharp = false;
		$this->image_unsharp_amount = 80;
		$this->image_unsharp_radius = 0.5;
		$this->image_unsharp_threshold = 1;

		$this->image_text = null;
		$this->image_text_direction = null;
		$this->image_text_color = '#FFFFFF';
		$this->image_text_opacity = 100;
		$this->image_text_background = null;
		$this->image_text_background_opacity = 100;
		$this->image_text_font = 5;
		$this->image_text_size = 16;
		$this->image_text_angle = null;
		$this->image_text_x = null;
		$this->image_text_y = null;
		$this->image_text_position = null;
		$this->image_text_padding = 0;
		$this->image_text_padding_x = null;
		$this->image_text_padding_y = null;
		$this->image_text_alignment = 'C';
		$this->image_text_line_spacing = 0;

		$this->image_reflection_height = null;
		$this->image_reflection_space = 2;
		$this->image_reflection_opacity = 60;

		$this->image_watermark = null;
		$this->image_watermark_x = null;
		$this->image_watermark_y = null;
		$this->image_watermark_position = null;
		$this->image_watermark_no_zoom_in = true;
		$this->image_watermark_no_zoom_out = false;

		$this->image_flip = null;
		$this->image_auto_rotate = true;
		$this->image_rotate = null;
		$this->image_crop = null;
		$this->image_precrop = null;

		$this->image_bevel = null;
		$this->image_bevel_color1 = '#FFFFFF';
		$this->image_bevel_color2 = '#000000';
		$this->image_border = null;
		$this->image_border_color = '#FFFFFF';
		$this->image_border_opacity = 100;
		$this->image_border_transparent = null;
		$this->image_frame = null;
		$this->image_frame_colors = '#FFFFFF #999999 #666666 #000000';
		$this->image_frame_opacity = 100;

		$this->forbidden = array();
		

	}

	function upload($file, $lang = '') {

		$this->version = '0.34dev';

		$this->file_src_name = '';
		$this->file_src_name_body = '';
		$this->file_src_name_ext = '';
		$this->file_src_mime = '';
		$this->file_src_size = '';
		$this->file_src_error = '';
		$this->file_src_pathname = '';
		$this->file_src_temp = '';

		$this->file_dst_path = '';
		$this->file_dst_name = '';
		$this->file_dst_name_body = '';
		$this->file_dst_name_ext = '';
		$this->file_dst_pathname = '';

		$this->image_src_x = null;
		$this->image_src_y = null;
		$this->image_src_bits = null;
		$this->image_src_type = null;
		$this->image_src_pixels = null;
		$this->image_dst_x = 0;
		$this->image_dst_y = 0;
		$this->image_dst_type = '';

		$this->uploaded = true;
		$this->no_upload_check = false;
		$this->processed = false;
		$this->error = '';
		$this->log = '';
		$this->allowed = array();
		$this->forbidden = array();
		$this->file_is_image = false;
		$this->init();

		$info = null;
		$mime_from_browser = null;

		// sets default language
		$this->translation = array();
		$this->translation['file_error'] = 'File error. Please try again.';
		$this->translation['local_file_missing'] = 'Local file doesn\'t exist.';
		$this->translation['local_file_not_readable'] = 'Local file is not readable.';
		$this->translation['uploaded_too_big_ini'] = 'File upload error (the uploaded file exceeds the upload_max_filesize directive in php.ini).';
		$this->translation['uploaded_too_big_html'] = 'File upload error (the uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form).';
		$this->translation['uploaded_partial'] = 'File upload error (the uploaded file was only partially uploaded).';
		$this->translation['uploaded_missing'] = 'File upload error (no file was uploaded).';
		$this->translation['uploaded_no_tmp_dir'] = 'File upload error (missing a temporary folder).';
		$this->translation['uploaded_cant_write'] = 'File upload error (failed to write file to disk).';
		$this->translation['uploaded_err_extension'] = 'File upload error (file upload stopped by extension).';
		$this->translation['uploaded_unknown'] = 'File upload error (unknown error code).';
		$this->translation['try_again'] = 'File upload error. Please try again.';
		$this->translation['file_too_big'] = 'File too big.';
		$this->translation['no_mime'] = 'MIME type can\'t be detected.';
		$this->translation['incorrect_file'] = 'Incorrect type of file.';
		$this->translation['image_too_wide'] = 'Image too wide.';
		$this->translation['image_too_narrow'] = 'Image too narrow.';
		$this->translation['image_too_high'] = 'Image too tall.';
		$this->translation['image_too_short'] = 'Image too short.';
		$this->translation['ratio_too_high'] = 'Image ratio too high (image too wide).';
		$this->translation['ratio_too_low'] = 'Image ratio too low (image too high).';
		$this->translation['too_many_pixels'] = 'Image has too many pixels.';
		$this->translation['not_enough_pixels'] = 'Image has not enough pixels.';
		$this->translation['file_not_uploaded'] = 'File not uploaded. Can\'t carry on a process.';
		$this->translation['already_exists'] = '%s already exists. Please change the file name.';
		$this->translation['temp_file_missing'] = 'No correct temp source file. Can\'t carry on a process.';
		$this->translation['source_missing'] = 'No correct uploaded source file. Can\'t carry on a process.';
		$this->translation['destination_dir'] = 'Destination directory can\'t be created. Can\'t carry on a process.';
		$this->translation['destination_dir_missing'] = 'Destination directory doesn\'t exist. Can\'t carry on a process.';
		$this->translation['destination_path_not_dir'] = 'Destination path is not a directory. Can\'t carry on a process.';
		$this->translation['destination_dir_write'] = 'Destination directory can\'t be made writeable. Can\'t carry on a process.';
		$this->translation['destination_path_write'] = 'Destination path is not a writeable. Can\'t carry on a process.';
		$this->translation['temp_file'] = 'Can\'t create the temporary file. Can\'t carry on a process.';
		$this->translation['source_not_readable'] = 'Source file is not readable. Can\'t carry on a process.';
		$this->translation['no_create_support'] = 'No create from %s support.';
		$this->translation['create_error'] = 'Error in creating %s image from source.';
		$this->translation['source_invalid'] = 'Can\'t read image source. Not an image?.';
		$this->translation['gd_missing'] = 'GD doesn\'t seem to be present.';
		$this->translation['watermark_no_create_support'] = 'No create from %s support, can\'t read watermark.';
		$this->translation['watermark_create_error'] = 'No %s read support, can\'t create watermark.';
		$this->translation['watermark_invalid'] = 'Unknown image format, can\'t read watermark.';
		$this->translation['file_create'] = 'No %s create support.';
		$this->translation['no_conversion_type'] = 'No conversion type defined.';
		$this->translation['copy_failed'] = 'Error copying file on the server. copy() failed.';
		$this->translation['reading_failed'] = 'Error reading the file.';

		$this->lang = "PE";

		// if (file_exists(dirname(__FILE__) . '/lang') && file_exists(dirname(__FILE__) . '/lang/class.upload.' . $idioma . '.php')) {
		// 	$translation = null;

		// 	include dirname(__FILE__) . '/lang/class.upload.' . $idioma . '.php';
		// 	if (is_array($translation)) {

		// 		$this->translation = array_merge($this->translation, $translation);
		// 	} else {
		// 	}
		// }
		// $this->translation = array_merge($this->translation, $translation);

		// determines the supported MIME types, and matching image format
		$this->image_supported = array();
		if ($this->gdversion()) {
			if (imagetypes() & IMG_GIF) {
				$this->image_supported['image/gif'] = 'gif';
			}
			if (imagetypes() & IMG_JPG) {
				$this->image_supported['image/jpg'] = 'jpg';
				$this->image_supported['image/jpeg'] = 'jpg';
				$this->image_supported['image/pjpeg'] = 'jpg';
			}
			if (imagetypes() & IMG_PNG) {
				$this->image_supported['image/png'] = 'png';
				$this->image_supported['image/x-png'] = 'png';
			}
			if (imagetypes() & IMG_WBMP) {
				$this->image_supported['image/bmp'] = 'bmp';
				$this->image_supported['image/x-ms-bmp'] = 'bmp';
				$this->image_supported['image/x-windows-bmp'] = 'bmp';
			}
		}

		// display some system information
		if (empty($this->log)) {
			$this->log .= '<b>system information</b><br />';
			if ($this->function_enabled('ini_get_all')) {
				$inis = ini_get_all();
				$open_basedir = (array_key_exists('open_basedir', $inis) && array_key_exists('local_value', $inis['open_basedir']) && !empty($inis['open_basedir']['local_value'])) ? $inis['open_basedir']['local_value'] : false;
			} else {
				$open_basedir = false;
			}
			$gd = $this->gdversion() ? $this->gdversion(true) : 'GD not present';
			$supported = trim((in_array('png', $this->image_supported) ? 'png' : '') . ' ' . (in_array('jpg', $this->image_supported) ? 'jpg' : '') . ' ' . (in_array('gif', $this->image_supported) ? 'gif' : '') . ' ' . (in_array('bmp', $this->image_supported) ? 'bmp' : ''));
			$this->log .= '-&nbsp;class version           : ' . $this->version . '<br />';
			$this->log .= '-&nbsp;operating system        : ' . PHP_OS . '<br />';
			$this->log .= '-&nbsp;PHP version             : ' . PHP_VERSION . '<br />';
			$this->log .= '-&nbsp;GD version              : ' . $gd . '<br />';
			$this->log .= '-&nbsp;supported image types   : ' . (!empty($supported) ? $supported : 'none') . '<br />';
			$this->log .= '-&nbsp;open_basedir            : ' . (!empty($open_basedir) ? $open_basedir : 'no restriction') . '<br />';
			$this->log .= '-&nbsp;upload_max_filesize     : ' . $this->file_max_size_raw . ' (' . $this->file_max_size . ' bytes)<br />';
			$this->log .= '-&nbsp;language                : ' . $this->lang . '<br />';
		}

		if (!$file) {

			$this->uploaded = false;
			$this->error = $this->translate('file_error');
		}


		// check if we sent a local filename or a PHP stream rather than a $_FILE element

		// $file = (!is_array($file)?(array)$file:$file);

		// if(count($file) == 1)
		// {
		// 	$indexName = array_keys($file);
		// 	$file = (array)$file[$indexName[0]];
		// }
		
		
		if (!is_array($file)) {

			if (empty($file)) {
				$this->uploaded = false;
				$this->error = $this->translate('file_error');

			} else {

				if (substr($file, 0, 4) == 'php:' || substr($file, 0, 5) == 'data:' || substr($file, 0, 7) == 'base64:') {
					$data = null;
					if (substr($file, 0, 4) == 'php:') {
						$file = preg_replace('/^php:(.*)/i', '$1', $file);
						if (!$file) {
							$file = $_SERVER['HTTP_X_FILE_NAME'];
						}

						if (!$file) {
							$file = 'unknown';
						}

						$data = file_get_contents('php://input');
						$this->log .= '<b>source is a PHP stream ' . $file . ' of length ' . strlen($data) . '</b><br />';

					} else if (substr($file, 0, 5) == 'data:') {
						$data = preg_replace('/^data:(.*)/i', '$1', $file);
						$file = 'data';
						$this->log .= '<b>source is a data string of length ' . strlen($data) . '</b><br />';

					} else if (substr($file, 0, 7) == 'base64:') {
						$data = base64_decode(preg_replace('/^base64:(?:.*base64,)?(.*)/i', '$1', $file));
						$file = 'base64';
						$this->log .= '<b>source is a base64 data string of length ' . strlen($data) . '</b><br />';
					}

					if (!$data) {
						$this->log .= '- source is empty!<br />';
						$this->uploaded = false;
						$this->error = $this->translate('source_invalid');
					}

					$this->no_upload_check = TRUE;

					if ($this->uploaded) {
						$this->log .= '- requires a temp file ... ';
						$hash = $this->temp_dir() . md5($file . rand(1, 1000));
						if ($data && file_put_contents($hash, $data)) {
							$this->file_src_pathname = $hash;
							$this->log .= ' file created<br />';
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;temp file is: ' . $this->file_src_pathname . '<br />';
						} else {
							$this->log .= ' failed<br />';
							$this->uploaded = false;
							$this->error = $this->translate('temp_file');
						}
					}

					if ($this->uploaded) {
						$this->file_src_name = $file;
						$this->log .= '- local file OK<br />';
						preg_match('/\.([^\.]*$)/', $this->file_src_name, $extension);
						if (is_array($extension) && sizeof($extension) > 0) {
							$this->file_src_name_ext = strtolower($extension[1]);
							$this->file_src_name_body = substr($this->file_src_name, 0, ((strlen($this->file_src_name) - strlen($this->file_src_name_ext))) - 1);
						} else {
							$this->file_src_name_ext = '';
							$this->file_src_name_body = $this->file_src_name;
						}
						$this->file_src_size = (file_exists($this->file_src_pathname) ? filesize($this->file_src_pathname) : 0);
					}
					$this->file_src_error = 0;

				} else {
					$this->log .= '<b>source is a local file ' . $file . '</b><br />';
					$this->no_upload_check = TRUE;

					if ($this->uploaded && !file_exists($file)) {
						$this->uploaded = false;
						$this->error = $this->translate('local_file_missing');
					}

					if ($this->uploaded && !is_readable($file)) {
						$this->uploaded = false;
						$this->error = $this->translate('local_file_not_readable');
					}

					if ($this->uploaded) {
						$this->file_src_pathname = $file;
						$this->file_src_name = basename($file);
						$this->log .= '- local file OK<br />';
						preg_match('/\.([^\.]*$)/', $this->file_src_name, $extension);
						if (is_array($extension) && sizeof($extension) > 0) {
							$this->file_src_name_ext = strtolower($extension[1]);
							$this->file_src_name_body = substr($this->file_src_name, 0, ((strlen($this->file_src_name) - strlen($this->file_src_name_ext))) - 1);
						} else {
							$this->file_src_name_ext = '';
							$this->file_src_name_body = $this->file_src_name;
						}
						$this->file_src_size = (file_exists($this->file_src_pathname) ? filesize($this->file_src_pathname) : 0);
					}
					$this->file_src_error = 0;
				}
			}
		} else {
			$this->log .= '<b>source is an uploaded file</b><br />';
			if ($this->uploaded) {
				$this->file_src_error = trim($file['error']);

				switch ($this->file_src_error) {
				case UPLOAD_ERR_OK:
					// all is OK
					$this->log .= '- upload OK<br />';
					break;
				case UPLOAD_ERR_INI_SIZE:
					$this->uploaded = false;
					$this->error = $this->translate('uploaded_too_big_ini');
					break;
				case UPLOAD_ERR_FORM_SIZE:
					$this->uploaded = false;
					$this->error = $this->translate('uploaded_too_big_html');
					break;
				case UPLOAD_ERR_PARTIAL:
					$this->uploaded = false;
					$this->error = $this->translate('uploaded_partial');
					break;
				case UPLOAD_ERR_NO_FILE:
					$this->uploaded = false;
					$this->error = $this->translate('uploaded_missing');
					break;
				case @UPLOAD_ERR_NO_TMP_DIR:

					$this->uploaded = false;
					$this->error = $this->translate('uploaded_no_tmp_dir');
					break;
				case @UPLOAD_ERR_CANT_WRITE:
					$this->uploaded = false;
					$this->error = $this->translate('uploaded_cant_write');
					break;
				case @UPLOAD_ERR_EXTENSION:
					$this->uploaded = false;
					$this->error = $this->translate('uploaded_err_extension');
					break;
				default:
					$this->uploaded = false;
					$this->error = $this->translate('uploaded_unknown') . ' (' . $this->file_src_error . ')';
				}
			}

			if ($this->uploaded) {

				$this->file_src_pathname = $file['tmp_name'];
				$this->file_src_name = $file['name'];
				if ($this->file_src_name == '') {
					$this->uploaded = false;
					$this->error = $this->translate('try_again');
				}
			}

			if ($this->uploaded) {
				$this->log .= '- file name OK<br />';
				preg_match('/\.([^\.]*$)/', $this->file_src_name, $extension);
				if (is_array($extension) && sizeof($extension) > 0) {
					$this->file_src_name_ext = strtolower($extension[1]);
					$this->file_src_name_body = substr($this->file_src_name, 0, ((strlen($this->file_src_name) - strlen($this->file_src_name_ext))) - 1);
				} else {
					$this->file_src_name_ext = '';
					$this->file_src_name_body = $this->file_src_name;
				}
				$this->file_src_size = $file['size'];
				$mime_from_browser = $file['type'];
			}
		}

		if ($this->uploaded) {
			$this->log .= '<b>determining MIME type</b><br />';
			$this->file_src_mime = null;

			// checks MIME type with Fileinfo PECL extension
			if (!$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === FALSE) {
				if ($this->mime_fileinfo) {
					$this->log .= '- Checking MIME type with Fileinfo PECL extension<br />';
					if ($this->function_enabled('finfo_open')) {
						$path = null;
						if ($this->mime_fileinfo !== '') {
							if ($this->mime_fileinfo === true) {
								if (getenv('MAGIC') === FALSE) {
									if (substr(PHP_OS, 0, 3) == 'WIN') {
										$path = realpath(ini_get('extension_dir') . '/../') . '/extras/magic';
										$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MAGIC path defaults to ' . $path . '<br />';
									}
								} else {
									$path = getenv('MAGIC');
									$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MAGIC path is set to ' . $path . ' from MAGIC variable<br />';
								}
							} else {
								$path = $this->mime_fileinfo;
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MAGIC path is set to ' . $path . '<br />';
							}
						}
						if ($path) {
							$f = @finfo_open(FILEINFO_MIME, $path);
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MAGIC path will not be used<br />';
							$f = @finfo_open(FILEINFO_MIME);
						}
						if (is_resource($f)) {
							$mime = finfo_file($f, realpath($this->file_src_pathname));
							finfo_close($f);
							$this->file_src_mime = $mime;
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MIME type detected as ' . $this->file_src_mime . ' by Fileinfo PECL extension<br />';
							if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
								$this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
								$this->log .= '-&nbsp;MIME validated as ' . $this->file_src_mime . '<br />';
							} else {
								$this->file_src_mime = null;
							}
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;Fileinfo PECL extension failed (finfo_open)<br />';
						}
					} elseif (@class_exists('finfo', false)) {
						$f = new finfo(FILEINFO_MIME);
						if ($f) {
							$this->file_src_mime = $f->file(realpath($this->file_src_pathname));
							$this->log .= '- MIME type detected as ' . $this->file_src_mime . ' by Fileinfo PECL extension<br />';
							if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
								$this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
								$this->log .= '-&nbsp;MIME validated as ' . $this->file_src_mime . '<br />';
							} else {
								$this->file_src_mime = null;
							}
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;Fileinfo PECL extension failed (finfo)<br />';
						}
					} else {
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;Fileinfo PECL extension not available<br />';
					}
				} else {
					$this->log .= '- Fileinfo PECL extension deactivated<br />';
				}
			}

			// checks MIME type with shell if unix access is authorized
			if (!$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === FALSE) {
				if ($this->mime_file) {
					$this->log .= '- Checking MIME type with UNIX file() command<br />';
					if (substr(PHP_OS, 0, 3) != 'WIN') {
						if ($this->function_enabled('exec') && $this->function_enabled('escapeshellarg')) {
							if (strlen($mime = @exec("file -bi " . escapeshellarg($this->file_src_pathname))) != 0) {
								$this->file_src_mime = trim($mime);
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MIME type detected as ' . $this->file_src_mime . ' by UNIX file() command<br />';
								if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
									$this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
									$this->log .= '-&nbsp;MIME validated as ' . $this->file_src_mime . '<br />';
								} else {
									$this->file_src_mime = null;
								}
							} else {
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;UNIX file() command failed<br />';
							}
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;PHP exec() function is disabled<br />';
						}
					} else {
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;UNIX file() command not availabled<br />';
					}
				} else {
					$this->log .= '- UNIX file() command is deactivated<br />';
				}
			}

			// checks MIME type with mime_magic
			if (!$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === FALSE) {
				if ($this->mime_magic) {
					$this->log .= '- Checking MIME type with mime.magic file (mime_content_type())<br />';
					if ($this->function_enabled('mime_content_type')) {
						$this->file_src_mime = mime_content_type($this->file_src_pathname);
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MIME type detected as ' . $this->file_src_mime . ' by mime_content_type()<br />';
						if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
							$this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
							$this->log .= '-&nbsp;MIME validated as ' . $this->file_src_mime . '<br />';
						} else {
							$this->file_src_mime = null;
						}
					} else {
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;mime_content_type() is not available<br />';
					}
				} else {
					$this->log .= '- mime.magic file (mime_content_type()) is deactivated<br />';
				}
			}

			// checks MIME type with getimagesize()
			if (!$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === FALSE) {
				if ($this->mime_getimagesize) {
					$this->log .= '- Checking MIME type with getimagesize()<br />';
					$info = getimagesize($this->file_src_pathname);
					if (is_array($info) && array_key_exists('mime', $info)) {
						$this->file_src_mime = trim($info['mime']);
						if (empty($this->file_src_mime)) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MIME empty, guessing from type<br />';
							$mime = (is_array($info) && array_key_exists(2, $info) ? $info[2] : null); // 1 = GIF, 2 = JPG, 3 = PNG
							$this->file_src_mime = ($mime == IMAGETYPE_GIF ? 'image/gif' : ($mime == IMAGETYPE_JPEG ? 'image/jpeg' : ($mime == IMAGETYPE_PNG ? 'image/png' : ($mime == IMAGETYPE_BMP ? 'image/bmp' : null))));
						}
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;MIME type detected as ' . $this->file_src_mime . ' by PHP getimagesize() function<br />';
						if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
							$this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
							$this->log .= '-&nbsp;MIME validated as ' . $this->file_src_mime . '<br />';
						} else {
							$this->file_src_mime = null;
						}
					} else {
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;getimagesize() failed<br />';
					}
				} else {
					$this->log .= '- getimagesize() is deactivated<br />';
				}
			}

			// default to MIME from browser (or Flash)
			if (!empty($mime_from_browser) && !$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime)) {
				$this->file_src_mime = $mime_from_browser;
				$this->log .= '- MIME type detected as ' . $this->file_src_mime . ' by browser<br />';
				if (preg_match("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", $this->file_src_mime)) {
					$this->file_src_mime = preg_replace("/^([\.\w-]+)\/([\.\w-]+)(.*)$/i", '$1/$2', $this->file_src_mime);
					$this->log .= '-&nbsp;MIME validated as ' . $this->file_src_mime . '<br />';
				} else {
					$this->file_src_mime = null;
				}
			}

			// we need to work some magic if we upload via Flash
			if ($this->file_src_mime == 'application/octet-stream' || !$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === FALSE) {
				if ($this->file_src_mime == 'application/octet-stream') {
					$this->log .= '- Flash may be rewriting MIME as application/octet-stream<br />';
				}

				$this->log .= '- Try to guess MIME type from file extension (' . $this->file_src_name_ext . '): ';
				if (array_key_exists($this->file_src_name_ext, $this->mime_types)) {
					$this->file_src_mime = $this->mime_types[$this->file_src_name_ext];
				}

				if ($this->file_src_mime == 'application/octet-stream') {
					$this->log .= 'doesn\'t look like anything known<br />';
				} else {
					$this->log .= 'MIME type set to ' . $this->file_src_mime . '<br />';
				}
			}

			if (!$this->file_src_mime || !is_string($this->file_src_mime) || empty($this->file_src_mime) || strpos($this->file_src_mime, '/') === FALSE) {
				$this->log .= '- MIME type couldn\'t be detected! (' . (string) $this->file_src_mime . ')<br />';
			}

			// determine whether the file is an image
			if ($this->file_src_mime && is_string($this->file_src_mime) && !empty($this->file_src_mime) && array_key_exists($this->file_src_mime, $this->image_supported)) {
				$this->file_is_image = true;
				$this->image_src_type = $this->image_supported[$this->file_src_mime];
			}

			// if the file is an image, we gather some useful data
			if ($this->file_is_image) {
				if ($h = fopen($this->file_src_pathname, 'r')) {
					fclose($h);
					$info = getimagesize($this->file_src_pathname);
					if (is_array($info)) {
						$this->image_src_x = $info[0];
						$this->image_src_y = $info[1];
						$this->image_dst_x = $this->image_src_x;
						$this->image_dst_y = $this->image_src_y;
						$this->image_src_pixels = $this->image_src_x * $this->image_src_y;
						$this->image_src_bits = array_key_exists('bits', $info) ? $info['bits'] : null;
					} else {
						$this->file_is_image = false;
						$this->uploaded = false;
						$this->log .= '- can\'t retrieve image information, image may have been tampered with<br />';
						$this->error = $this->translate('source_invalid');
					}
				} else {
					$this->log .= '- can\'t read source file directly. open_basedir restriction in place?<br />';
				}
			}

			$this->log .= '<b>source variables</b><br />';
			$this->log .= '- You can use all these before calling process()<br />';
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_name         : ' . $this->file_src_name . '<br />';
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_name_body    : ' . $this->file_src_name_body . '<br />';
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_name_ext     : ' . $this->file_src_name_ext . '<br />';
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_pathname     : ' . $this->file_src_pathname . '<br />';
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_mime         : ' . $this->file_src_mime . '<br />';
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_size         : ' . $this->file_src_size . ' (max= ' . $this->file_max_size . ')<br />';
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_src_error        : ' . $this->file_src_error . '<br />';

			if ($this->file_is_image) {
				$this->log .= '- source file is an image<br />';
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_x           : ' . $this->image_src_x . '<br />';
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_y           : ' . $this->image_src_y . '<br />';
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_pixels      : ' . $this->image_src_pixels . '<br />';
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_type        : ' . $this->image_src_type . '<br />';
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_bits        : ' . $this->image_src_bits . '<br />';
			}
		}

	}

	public function isset_file()
	{
		return ($this->uploaded ? true : false);
	}

	public function validate_ext($extensions)
	{
		load_helper("validate");

		$status = exist_filter($this->file_src_name_ext,$extensions);

		return ($status->status == 1) ? false : true;

	}

	function function_enabled($func) {
		// cache the list of disabled functions
		static $disabled = null;
		if ($disabled === null) {
			$disabled = array_map('trim', array_map('strtolower', explode(',', ini_get('disable_functions'))));
		}

		// cache the list of functions blacklisted by suhosin
		static $blacklist = null;
		if ($blacklist === null) {
			$blacklist = extension_loaded('suhosin') ? array_map('trim', array_map('strtolower', explode(',', ini_get('  suhosin.executor.func.blacklist')))) : array();
		}

		// checks if the function is really enabled
		return (function_exists($func) && !in_array($func, $disabled) && !in_array($func, $blacklist));
	}

	/**
	 * Creates directories recursively
	 *
	 * @access private
	 * @param  string  $path Path to create
	 * @param  integer $mode Optional permissions
	 * @return boolean Success
	 */
	function rmkdir($path, $mode = 0777) {
		return is_dir($path) || ($this->rmkdir(dirname($path), $mode) && $this->_mkdir($path, $mode));
	}

	function _mkdir($path, $mode = 0777) {
		$old = umask(0);
		$res = @mkdir($path, $mode);
		umask($old);
		return $res;
	}

	function translate($str, $tokens = array()) {
		if (array_key_exists($str, $this->translation)) {
			$str = $this->translation[$str];

		}

		if (is_array($tokens) && sizeof($tokens) > 0) {
			$str = vsprintf($str, $tokens);

		}

		return $str;
	}


	function gdversion($full = false) {
		static $gd_version = null;
		static $gd_full_version = null;
		if ($gd_version === null) {
			if ($this->function_enabled('gd_info')) {
				$gd = gd_info();
				$gd = $gd["GD Version"];
				$regex = "/([\d\.]+)/i";
			} else {
				ob_start();
				phpinfo(8);
				$gd = ob_get_contents();
				ob_end_clean();
				$regex = "/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i";
			}
			if (preg_match($regex, $gd, $m)) {
				$gd_full_version = (string) $m[1];
				$gd_version = (float) $m[1];
			} else {
				$gd_full_version = 'none';
				$gd_version = 0;
			}
		}
		if ($full) {
			return $gd_full_version;
		} else {
			return $gd_version;
		}
	}


	function getsize($size) {
		if ($size === null) {
			return null;
		}

		$last = strtolower($size{strlen($size) - 1});
		$size = (int) $size;
		switch ($last) {
		case 'g':
			$size *= 1024;
		case 'm':
			$size *= 1024;
		case 'k':
			$size *= 1024;
		}
		return $size;
	}


	function temp_dir() {
		$dir = '';
		if ($this->function_enabled('sys_get_temp_dir')) {
			$dir = sys_get_temp_dir();
		}

		if (!$dir && $tmp = getenv('TMP')) {
			$dir = $tmp;
		}

		if (!$dir && $tmp = getenv('TEMP')) {
			$dir = $tmp;
		}

		if (!$dir && $tmp = getenv('TMPDIR')) {
			$dir = $tmp;
		}

		if (!$dir) {
			$tmp = tempnam(__FILE__, '');
			if (file_exists($tmp)) {
				unlink($tmp);
				$dir = dirname($tmp);
			}
		}
		if (!$dir) {
			return '';
		}

		$slash = (strtolower(substr(PHP_OS, 0, 3)) === 'win' ? '\\' : '/');
		if (substr($dir, -1) != $slash) {
			$dir = $dir . $slash;
		}

		return $dir;
	}


	function go($server_path = null) {
		$this->error = '';
		$this->processed = true;
		$return_mode = false;
		$return_content = null;

		// clean up dst variables
		$this->file_dst_path = '';
		$this->file_dst_pathname = '';
		$this->file_dst_name = '';
		$this->file_dst_name_body = '';
		$this->file_dst_name_ext = '';

		// clean up some parameters
		$this->file_max_size = $this->getsize($this->file_max_size);
		$this->jpeg_size = $this->getsize($this->jpeg_size);

		// copy some variables as we need to keep them clean
		$file_src_name = $this->file_src_name;
		$file_src_name_body = $this->file_src_name_body;
		$file_src_name_ext = $this->file_src_name_ext;

		if (!$this->uploaded) {
			$this->error = $this->translate('file_not_uploaded');
			$this->processed = false;
		}

		if ($this->processed) {
			if (empty($server_path) || is_null($server_path)) {
				$this->log .= '<b>process file and return the content</b><br />';
				$return_mode = true;
			} else {
				if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
					if (substr($server_path, -1, 1) != '\\') {
						$server_path = $server_path . '\\';
					}

				} else {
					if (substr($server_path, -1, 1) != '/') {
						$server_path = $server_path . '/';
					}

				}
				$this->log .= '<b>process file to ' . $server_path . '</b><br />';
			}
		}

		if ($this->processed) {
			// checks file max size
			if ($this->file_src_size > $this->file_max_size) {
				$this->processed = false;
				$this->error = $this->translate('file_too_big') . ' : ' . $this->file_src_size . ' > ' . $this->file_max_size;
			} else {
				$this->log .= '- file size OK<br />';
			}
		}

		if ($this->processed) {
			// if we have an image without extension, set it
			if ($this->file_force_extension && $this->file_is_image && !$this->file_src_name_ext) {
				$file_src_name_ext = $this->image_src_type;
			}

			// turn dangerous scripts into text files
			if ($this->no_script) {
				// if the file has no extension, we try to guess it from the MIME type
				if ($this->file_force_extension && empty($file_src_name_ext)) {
					if ($key = array_search($this->file_src_mime, $this->mime_types)) {
						$file_src_name_ext = $key;
						$file_src_name = $file_src_name_body . '.' . $file_src_name_ext;
						$this->log .= '- file renamed as ' . $file_src_name_body . '.' . $file_src_name_ext . '!<br />';
					}
				}
				// if the file is text based, or has a dangerous extension, we rename it as .txt
				if ((((substr($this->file_src_mime, 0, 5) == 'text/' && $this->file_src_mime != 'text/rtf') || strpos($this->file_src_mime, 'javascript') !== false) && (substr($file_src_name, -4) != '.txt'))
					|| preg_match('/\.(php|php5|php4|php3|phtml|pl|py|cgi|asp|js)$/i', $this->file_src_name)
					|| $this->file_force_extension && empty($file_src_name_ext)) {
					$this->file_src_mime = 'text/plain';
					if ($this->file_src_name_ext) {
						$file_src_name_body = $file_src_name_body . '.' . $this->file_src_name_ext;
					}

					$file_src_name_ext = 'txt';
					$file_src_name = $file_src_name_body . '.' . $file_src_name_ext;
					$this->log .= '- script renamed as ' . $file_src_name_body . '.' . $file_src_name_ext . '!<br />';
				}
			}

			if ($this->mime_check && empty($this->file_src_mime)) {
				$this->processed = false;
				$this->error = $this->translate('no_mime');
			} else if ($this->mime_check && !empty($this->file_src_mime) && strpos($this->file_src_mime, '/') !== false) {
				list($m1, $m2) = explode('/', $this->file_src_mime);
				$allowed = false;
				// check wether the mime type is allowed
				if (!is_array($this->allowed)) {
					$this->allowed = array($this->allowed);
				}

				foreach ($this->allowed as $k => $v) {
					list($v1, $v2) = explode('/', $v);
					if (($v1 == '*' && $v2 == '*') || ($v1 == $m1 && ($v2 == $m2 || $v2 == '*'))) {
						$allowed = true;
						break;
					}
				}
				// check wether the mime type is forbidden
				if (!is_array($this->forbidden)) {
					$this->forbidden = array($this->forbidden);
				}

				foreach ($this->forbidden as $k => $v) {
					list($v1, $v2) = explode('/', $v);
					if (($v1 == '*' && $v2 == '*') || ($v1 == $m1 && ($v2 == $m2 || $v2 == '*'))) {
						$allowed = false;
						break;
					}
				}
				if (!$allowed) {
					$this->processed = false;
					$this->error = $this->translate('incorrect_file');
				} else {
					$this->log .= '- file mime OK : ' . $this->file_src_mime . '<br />';
				}
			} else {
				$this->log .= '- file mime (not checked) : ' . $this->file_src_mime . '<br />';
			}


			if ($this->file_is_image) {
				if (is_numeric($this->image_src_x) && is_numeric($this->image_src_y)) {
					$ratio = $this->image_src_x / $this->image_src_y;
					if (!is_null($this->image_max_width) && $this->image_src_x > $this->image_max_width) {
						$this->processed = false;
						$this->error = $this->translate('image_too_wide');
					}
					if (!is_null($this->image_min_width) && $this->image_src_x < $this->image_min_width) {
						$this->processed = false;
						$this->error = $this->translate('image_too_narrow');
					}
					if (!is_null($this->image_max_height) && $this->image_src_y > $this->image_max_height) {
						$this->processed = false;
						$this->error = $this->translate('image_too_high');
					}
					if (!is_null($this->image_min_height) && $this->image_src_y < $this->image_min_height) {
						$this->processed = false;
						$this->error = $this->translate('image_too_short');
					}
					if (!is_null($this->image_max_ratio) && $ratio > $this->image_max_ratio) {
						$this->processed = false;
						$this->error = $this->translate('ratio_too_high');
					}
					if (!is_null($this->image_min_ratio) && $ratio < $this->image_min_ratio) {
						$this->processed = false;
						$this->error = $this->translate('ratio_too_low');
					}
					if (!is_null($this->image_max_pixels) && $this->image_src_pixels > $this->image_max_pixels) {
						$this->processed = false;
						$this->error = $this->translate('too_many_pixels');
					}
					if (!is_null($this->image_min_pixels) && $this->image_src_pixels < $this->image_min_pixels) {
						$this->processed = false;
						$this->error = $this->translate('not_enough_pixels');
					}
				} else {
					$this->log .= '- no image properties available, can\'t enforce dimension checks : ' . $this->file_src_mime . '<br />';
				}
			}
		}

		if ($this->processed) {
			$this->file_dst_path = $server_path;

			// repopulate dst variables from src
			$this->file_dst_name = $file_src_name;
			$this->file_dst_name_body = $file_src_name_body;
			$this->file_dst_name_ext = $file_src_name_ext;
			if ($this->file_overwrite) {
				$this->file_auto_rename = false;
			}

			if ($this->image_convert && $this->file_is_image) {
				// if we convert as an image
				if ($this->file_src_name_ext) {
					$this->file_dst_name_ext = $this->image_convert;
				}

				$this->log .= '- new file name ext : ' . $this->image_convert . '<br />';
			}
			if (!is_null($this->file_new_name_body)) {
				// rename file body
				$this->file_dst_name_body = $this->file_new_name_body;
				$this->log .= '- new file name body : ' . $this->file_new_name_body . '<br />';
			}
			if (!is_null($this->file_new_name_ext)) {
				// rename file ext
				$this->file_dst_name_ext = $this->file_new_name_ext;
				$this->log .= '- new file name ext : ' . $this->file_new_name_ext . '<br />';
			}
			if (!is_null($this->file_name_body_add)) {
				// append a string to the name
				$this->file_dst_name_body = $this->file_dst_name_body . $this->file_name_body_add;
				$this->log .= '- file name body append : ' . $this->file_name_body_add . '<br />';
			}
			if (!is_null($this->file_name_body_pre)) {
				// prepend a string to the name
				$this->file_dst_name_body = $this->file_name_body_pre . $this->file_dst_name_body;
				$this->log .= '- file name body prepend : ' . $this->file_name_body_pre . '<br />';
			}
			if ($this->file_safe_name) {
				// formats the name
				$this->file_dst_name_body = utf8_encode(strtr(utf8_decode($this->file_dst_name_body), utf8_decode('ŠŽšžŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïñòóôõöøùúûüýÿ'), 'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy'));
				$this->file_dst_name_body = strtr($this->file_dst_name_body, array('Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss', 'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u'));
				$this->file_dst_name_body = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $this->file_dst_name_body);
				$this->log .= '- file name safe format<br />';
			}

			$this->log .= '- destination variables<br />';
			if (empty($this->file_dst_path) || is_null($this->file_dst_path)) {
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_path         : n/a<br />';
			} else {
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_path         : ' . $this->file_dst_path . '<br />';
			}
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_name_body    : ' . $this->file_dst_name_body . '<br />';
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_name_ext     : ' . $this->file_dst_name_ext . '<br />';

			// set the destination file name
			$this->file_dst_name = $this->file_dst_name_body . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : '');

			if (!$return_mode) {
				if (!$this->file_auto_rename) {
					$this->log .= '- no auto_rename if same filename exists<br />';
					$this->file_dst_pathname = $this->file_dst_path . $this->file_dst_name;
				} else {
					$this->log .= '- checking for auto_rename<br />';
					$this->file_dst_pathname = $this->file_dst_path . $this->file_dst_name;
					$body = $this->file_dst_name_body;
					$ext = '';
					// if we have changed the extension, then we add our increment before
					if ($file_src_name_ext != $this->file_src_name_ext) {
						if (substr($this->file_dst_name_body, -1 - strlen($this->file_src_name_ext)) == '.' . $this->file_src_name_ext) {
							$body = substr($this->file_dst_name_body, 0, strlen($this->file_dst_name_body) - 1 - strlen($this->file_src_name_ext));
							$ext = '.' . $this->file_src_name_ext;
						}
					}
					$cpt = 1;
					while (@file_exists($this->file_dst_pathname)) {
						$this->file_dst_name_body = $body . '_' . $cpt . $ext;
						$this->file_dst_name = $this->file_dst_name_body . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : '');
						$cpt++;
						$this->file_dst_pathname = $this->file_dst_path . $this->file_dst_name;
					}
					if ($cpt > 1) {
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;auto_rename to ' . $this->file_dst_name . '<br />';
					}

				}

				$this->log .= '- destination file details<br />';
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_name         : ' . $this->file_dst_name . '<br />';
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_pathname     : ' . $this->file_dst_pathname . '<br />';

				if ($this->file_overwrite) {
					$this->log .= '- no overwrite checking<br />';
				} else {
					if (@file_exists($this->file_dst_pathname)) {
						$this->processed = false;
						$this->error = $this->translate('already_exists', array($this->file_dst_name));
					} else {
						$this->log .= '- ' . $this->file_dst_name . ' doesn\'t exist already<br />';
					}
				}
			}
		}

		if ($this->processed) {
			// if we have already moved the uploaded file, we use the temporary copy as source file, and check if it exists
			if (!empty($this->file_src_temp)) {
				$this->log .= '- use the temp file instead of the original file since it is a second process<br />';
				$this->file_src_pathname = $this->file_src_temp;
				if (!file_exists($this->file_src_pathname)) {
					$this->processed = false;
					$this->error = $this->translate('temp_file_missing');
				}
				// if we haven't a temp file, and that we do check on uploads, we use is_uploaded_file()
			} else if (!$this->no_upload_check) {
				if (!is_uploaded_file($this->file_src_pathname)) {
					$this->processed = false;
					$this->error = $this->translate('source_missing');
				}
				// otherwise, if we don't check on uploaded files (local file for instance), we use file_exists()
			} else {
				if (!file_exists($this->file_src_pathname)) {
					$this->processed = false;
					$this->error = $this->translate('source_missing');
				}
			}

			// checks if the destination directory exists, and attempt to create it
			if (!$return_mode) {
				if ($this->processed && !file_exists($this->file_dst_path)) {
					if ($this->dir_auto_create) {
						$this->log .= '- ' . $this->file_dst_path . ' doesn\'t exist. Attempting creation:';
						if (!$this->rmkdir($this->file_dst_path, $this->dir_chmod)) {
							$this->log .= ' failed<br />';
							$this->processed = false;
							$this->error = $this->translate('destination_dir');
						} else {
							$this->log .= ' success<br />';
						}
					} else {
						$this->error = $this->translate('destination_dir_missing');
					}
				}

				if ($this->processed && !is_dir($this->file_dst_path)) {
					$this->processed = false;
					$this->error = $this->translate('destination_path_not_dir');
				}

				// checks if the destination directory is writeable, and attempt to make it writeable
				$hash = md5($this->file_dst_name_body . rand(1, 1000));
				if ($this->processed && !($f = @fopen($this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''), 'a+'))) {
					if ($this->dir_auto_chmod) {
						$this->log .= '- ' . $this->file_dst_path . ' is not writeable. Attempting chmod:';
						if (!@chmod($this->file_dst_path, $this->dir_chmod)) {
							$this->log .= ' failed<br />';
							$this->processed = false;
							$this->error = $this->translate('destination_dir_write');
						} else {
							$this->log .= ' success<br />';
							if (!($f = @fopen($this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''), 'a+'))) {
								// we re-check
								$this->processed = false;
								$this->error = $this->translate('destination_dir_write');
							} else {
								@fclose($f);
							}
						}
					} else {
						$this->processed = false;
						$this->error = $this->translate('destination_path_write');
					}
				} else {
					if ($this->processed) {
						@fclose($f);
					}

					@unlink($this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''));
				}

				// if we have an uploaded file, and if it is the first process, and if we can't access the file directly (open_basedir restriction)
				// then we create a temp file that will be used as the source file in subsequent processes
				// the third condition is there to check if the file is not accessible *directly* (it already has positively gone through is_uploaded_file(), so it exists)
				if (!$this->no_upload_check && empty($this->file_src_temp) && !@file_exists($this->file_src_pathname)) {
					$this->log .= '- attempting to use a temp file:';
					$hash = md5($this->file_dst_name_body . rand(1, 1000));
					if (move_uploaded_file($this->file_src_pathname, $this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''))) {
						$this->file_src_pathname = $this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : '');
						$this->file_src_temp = $this->file_src_pathname;
						$this->log .= ' file created<br />';
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;temp file is: ' . $this->file_src_temp . '<br />';
					} else {
						$this->log .= ' failed<br />';
						$this->processed = false;
						$this->error = $this->translate('temp_file');
					}
				}
			}
		}

		if ($this->processed) {

			// check if we need to autorotate, to automatically pre-rotates the image according to EXIF data (JPEG only)
			$auto_flip = false;
			$auto_rotate = 0;
			if ($this->file_is_image && $this->image_auto_rotate && $this->image_src_type == 'jpg' && $this->function_enabled('exif_read_data')) {
				$exif = @exif_read_data($this->file_src_pathname);
				if (is_array($exif) && isset($exif['Orientation'])) {
					$orientation = $exif['Orientation'];
					switch ($orientation) {
					case 1:
						$this->log .= '- EXIF orientation = 1 : default<br />';
						break;
					case 2:
						$auto_flip = 'v';
						$this->log .= '- EXIF orientation = 2 : vertical flip<br />';
						break;
					case 3:
						$auto_rotate = 180;
						$this->log .= '- EXIF orientation = 3 : 180 rotate left<br />';
						break;
					case 4:
						$auto_flip = 'h';
						$this->log .= '- EXIF orientation = 4 : horizontal flip<br />';
						break;
					case 5:
						$auto_flip = 'h';
						$auto_rotate = 90;
						$this->log .= '- EXIF orientation = 5 : horizontal flip + 90 rotate right<br />';
						break;
					case 6:
						$auto_rotate = 90;
						$this->log .= '- EXIF orientation = 6 : 90 rotate right<br />';
						break;
					case 7:
						$auto_flip = 'v';
						$auto_rotate = 90;
						$this->log .= '- EXIF orientation = 7 : vertical flip + 90 rotate right<br />';
						break;
					case 8:
						$auto_rotate = 270;
						$this->log .= '- EXIF orientation = 8 : 90 rotate left<br />';
						break;
					default:
						$this->log .= '- EXIF orientation = ' . $orientation . ' : unknown<br />';
						break;
					}
				} else {
					$this->log .= '- EXIF data is invalid or missing<br />';
				}
			} else {
				if (!$this->image_auto_rotate) {
					$this->log .= '- auto-rotate deactivated<br />';
				} else if (!$this->image_src_type == 'jpg') {
					$this->log .= '- auto-rotate applies only to JPEG images<br />';
				} else if (!$this->function_enabled('exif_read_data')) {
					$this->log .= '- auto-rotate requires function exif_read_data to be enabled<br />';
				}
			}

			// do we do some image manipulation?
			$image_manipulation = ($this->file_is_image && (
				$this->image_resize
				|| $this->image_convert != ''
				|| is_numeric($this->image_brightness)
				|| is_numeric($this->image_contrast)
				|| is_numeric($this->image_opacity)
				|| is_numeric($this->image_threshold)
				|| !empty($this->image_tint_color)
				|| !empty($this->image_overlay_color)
				|| $this->image_pixelate
				|| $this->image_unsharp
				|| !empty($this->image_text)
				|| $this->image_greyscale
				|| $this->image_negative
				|| !empty($this->image_watermark)
				|| $auto_rotate || $auto_flip
				|| is_numeric($this->image_rotate)
				|| is_numeric($this->jpeg_size)
				|| !empty($this->image_flip)
				|| !empty($this->image_crop)
				|| !empty($this->image_precrop)
				|| !empty($this->image_border)
				|| !empty($this->image_border_transparent)
				|| $this->image_frame > 0
				|| $this->image_bevel > 0
				|| $this->image_reflection_height));

			// we do a quick check to ensure the file is really an image
			// we can do this only now, as it would have failed before in case of open_basedir
			if ($image_manipulation && !@getimagesize($this->file_src_pathname)) {
				$this->log .= '- the file is not an image!<br />';
				$image_manipulation = false;
			}

			if ($image_manipulation) {

				// make sure GD doesn't complain too much
				@ini_set("gd.jpeg_ignore_warning", 1);

				// checks if the source file is readable
				if ($this->processed && !($f = @fopen($this->file_src_pathname, 'r'))) {
					$this->processed = false;
					$this->error = $this->translate('source_not_readable');
				} else {
					@fclose($f);
				}

				// we now do all the image manipulations
				$this->log .= '- image resizing or conversion wanted<br />';
				if ($this->gdversion()) {
					switch ($this->image_src_type) {
					case 'jpg':
						if (!$this->function_enabled('imagecreatefromjpeg')) {
							$this->processed = false;
							$this->error = $this->translate('no_create_support', array('JPEG'));
						} else {
							$image_src = @imagecreatefromjpeg($this->file_src_pathname);
							if (!$image_src) {
								$this->processed = false;
								$this->error = $this->translate('create_error', array('JPEG'));
							} else {
								$this->log .= '- source image is JPEG<br />';
							}
						}
						break;
					case 'png':
						if (!$this->function_enabled('imagecreatefrompng')) {
							$this->processed = false;
							$this->error = $this->translate('no_create_support', array('PNG'));
						} else {
							$image_src = @imagecreatefrompng($this->file_src_pathname);
							if (!$image_src) {
								$this->processed = false;
								$this->error = $this->translate('create_error', array('PNG'));
							} else {
								$this->log .= '- source image is PNG<br />';
							}
						}
						break;
					case 'gif':
						if (!$this->function_enabled('imagecreatefromgif')) {
							$this->processed = false;
							$this->error = $this->translate('no_create_support', array('GIF'));
						} else {
							$image_src = @imagecreatefromgif($this->file_src_pathname);
							if (!$image_src) {
								$this->processed = false;
								$this->error = $this->translate('create_error', array('GIF'));
							} else {
								$this->log .= '- source image is GIF<br />';
							}
						}
						break;
					case 'bmp':
						if (!method_exists($this, 'imagecreatefrombmp')) {
							$this->processed = false;
							$this->error = $this->translate('no_create_support', array('BMP'));
						} else {
							$image_src = @$this->imagecreatefrombmp($this->file_src_pathname);
							if (!$image_src) {
								$this->processed = false;
								$this->error = $this->translate('create_error', array('BMP'));
							} else {
								$this->log .= '- source image is BMP<br />';
							}
						}
						break;
					default:
						$this->processed = false;
						$this->error = $this->translate('source_invalid');
					}
				} else {
					$this->processed = false;
					$this->error = $this->translate('gd_missing');
				}

				if ($this->processed && $image_src) {

					// we have to set image_convert if it is not already
					if (empty($this->image_convert)) {
						$this->log .= '- setting destination file type to ' . $this->image_src_type . '<br />';
						$this->image_convert = $this->image_src_type;
					}

					if (!in_array($this->image_convert, $this->image_supported)) {
						$this->image_convert = 'jpg';
					}

					// we set the default color to be the background color if we don't output in a transparent format
					if ($this->image_convert != 'png' && $this->image_convert != 'gif' && !empty($this->image_default_color) && empty($this->image_background_color)) {
						$this->image_background_color = $this->image_default_color;
					}

					if (!empty($this->image_background_color)) {
						$this->image_default_color = $this->image_background_color;
					}

					if (empty($this->image_default_color)) {
						$this->image_default_color = '#FFFFFF';
					}

					$this->image_src_x = imagesx($image_src);
					$this->image_src_y = imagesy($image_src);
					$gd_version = $this->gdversion();
					$ratio_crop = null;

					if (!imageistruecolor($image_src)) {
						// $this->image_src_type == 'gif'
						$this->log .= '- image is detected as having a palette<br />';
						$this->image_is_palette = true;
						$this->image_transparent_color = imagecolortransparent($image_src);
						if ($this->image_transparent_color >= 0 && imagecolorstotal($image_src) > $this->image_transparent_color) {
							$this->image_is_transparent = true;
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;palette image is detected as transparent<br />';
						}
						// if the image has a palette (GIF), we convert it to true color, preserving transparency
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;convert palette image to true color<br />';
						$true_color = imagecreatetruecolor($this->image_src_x, $this->image_src_y);
						imagealphablending($true_color, false);
						imagesavealpha($true_color, true);
						for ($x = 0; $x < $this->image_src_x; $x++) {
							for ($y = 0; $y < $this->image_src_y; $y++) {
								if ($this->image_transparent_color >= 0 && imagecolorat($image_src, $x, $y) == $this->image_transparent_color) {
									imagesetpixel($true_color, $x, $y, 127 << 24);
								} else {
									$rgb = imagecolorsforindex($image_src, imagecolorat($image_src, $x, $y));
									imagesetpixel($true_color, $x, $y, ($rgb['alpha'] << 24) | ($rgb['red'] << 16) | ($rgb['green'] << 8) | $rgb['blue']);
								}
							}
						}
						$image_src = $this->imagetransfer($true_color, $image_src);
						imagealphablending($image_src, false);
						imagesavealpha($image_src, true);
						$this->image_is_palette = false;
					}

					$image_dst = &$image_src;

					// auto-flip image, according to EXIF data (JPEG only)
					if ($gd_version >= 2 && !empty($auto_flip)) {
						$this->log .= '- auto-flip image : ' . ($auto_flip == 'v' ? 'vertical' : 'horizontal') . '<br />';
						$tmp = $this->imagecreatenew($this->image_src_x, $this->image_src_y);
						for ($x = 0; $x < $this->image_src_x; $x++) {
							for ($y = 0; $y < $this->image_src_y; $y++) {
								if (strpos($auto_flip, 'v') !== false) {
									imagecopy($tmp, $image_dst, $this->image_src_x - $x - 1, $y, $x, $y, 1, 1);
								} else {
									imagecopy($tmp, $image_dst, $x, $this->image_src_y - $y - 1, $x, $y, 1, 1);
								}
							}
						}
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// auto-rotate image, according to EXIF data (JPEG only)
					if ($gd_version >= 2 && is_numeric($auto_rotate)) {
						if (!in_array($auto_rotate, array(0, 90, 180, 270))) {
							$auto_rotate = 0;
						}

						if ($auto_rotate != 0) {
							if ($auto_rotate == 90 || $auto_rotate == 270) {
								$tmp = $this->imagecreatenew($this->image_src_y, $this->image_src_x);
							} else {
								$tmp = $this->imagecreatenew($this->image_src_x, $this->image_src_y);
							}
							$this->log .= '- auto-rotate image : ' . $auto_rotate . '<br />';
							for ($x = 0; $x < $this->image_src_x; $x++) {
								for ($y = 0; $y < $this->image_src_y; $y++) {
									if ($auto_rotate == 90) {
										imagecopy($tmp, $image_dst, $y, $x, $x, $this->image_src_y - $y - 1, 1, 1);
									} else if ($auto_rotate == 180) {
										imagecopy($tmp, $image_dst, $x, $y, $this->image_src_x - $x - 1, $this->image_src_y - $y - 1, 1, 1);
									} else if ($auto_rotate == 270) {
										imagecopy($tmp, $image_dst, $y, $x, $this->image_src_x - $x - 1, $y, 1, 1);
									} else {
										imagecopy($tmp, $image_dst, $x, $y, $x, $y, 1, 1);
									}
								}
							}
							if ($auto_rotate == 90 || $auto_rotate == 270) {
								$t = $this->image_src_y;
								$this->image_src_y = $this->image_src_x;
								$this->image_src_x = $t;
							}
							// we transfert tmp into image_dst
							$image_dst = $this->imagetransfer($tmp, $image_dst);
						}
					}

					// pre-crop image, before resizing
					if ((!empty($this->image_precrop))) {
						list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_precrop, $this->image_src_x, $this->image_src_y, true, true);
						$this->log .= '- pre-crop image : ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . ' <br />';
						$this->image_src_x = $this->image_src_x - $cl - $cr;
						$this->image_src_y = $this->image_src_y - $ct - $cb;
						if ($this->image_src_x < 1) {
							$this->image_src_x = 1;
						}

						if ($this->image_src_y < 1) {
							$this->image_src_y = 1;
						}

						$tmp = $this->imagecreatenew($this->image_src_x, $this->image_src_y);

						// we copy the image into the recieving image
						imagecopy($tmp, $image_dst, 0, 0, $cl, $ct, $this->image_src_x, $this->image_src_y);

						// if we crop with negative margins, we have to make sure the extra bits are the right color, or transparent
						if ($ct < 0 || $cr < 0 || $cb < 0 || $cl < 0) {
							// use the background color if present
							if (!empty($this->image_background_color)) {
								list($red, $green, $blue) = $this->getcolors($this->image_background_color);
								$fill = imagecolorallocate($tmp, $red, $green, $blue);
							} else {
								$fill = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
							}
							// fills eventual negative margins
							if ($ct < 0) {
								imagefilledrectangle($tmp, 0, 0, $this->image_src_x, -$ct, $fill);
							}

							if ($cr < 0) {
								imagefilledrectangle($tmp, $this->image_src_x + $cr, 0, $this->image_src_x, $this->image_src_y, $fill);
							}

							if ($cb < 0) {
								imagefilledrectangle($tmp, 0, $this->image_src_y + $cb, $this->image_src_x, $this->image_src_y, $fill);
							}

							if ($cl < 0) {
								imagefilledrectangle($tmp, 0, 0, -$cl, $this->image_src_y, $fill);
							}

						}

						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// resize image (and move image_src_x, image_src_y dimensions into image_dst_x, image_dst_y)
					if ($this->image_resize) {
						$this->log .= '- resizing...<br />';
						$this->image_dst_x = $this->image_x;
						$this->image_dst_y = $this->image_y;

						// backward compatibility for soon to be deprecated settings
						if ($this->image_ratio_no_zoom_in) {
							$this->image_ratio = true;
							$this->image_no_enlarging = true;
						} else if ($this->image_ratio_no_zoom_out) {
							$this->image_ratio = true;
							$this->image_no_shrinking = true;
						}

						// keeps aspect ratio with x calculated from y
						if ($this->image_ratio_x) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;calculate x size<br />';
							$this->image_dst_x = round(($this->image_src_x * $this->image_y) / $this->image_src_y);
							$this->image_dst_y = $this->image_y;

							// keeps aspect ratio with y calculated from x
						} else if ($this->image_ratio_y) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;calculate y size<br />';
							$this->image_dst_x = $this->image_x;
							$this->image_dst_y = round(($this->image_src_y * $this->image_x) / $this->image_src_x);

							// keeps aspect ratio, calculating x and y so that the image is approx the set number of pixels
						} else if (is_numeric($this->image_ratio_pixels)) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;calculate x/y size to match a number of pixels<br />';
							$pixels = $this->image_src_y * $this->image_src_x;
							$diff = sqrt($this->image_ratio_pixels / $pixels);
							$this->image_dst_x = round($this->image_src_x * $diff);
							$this->image_dst_y = round($this->image_src_y * $diff);

							// keeps aspect ratio with x and y dimensions, filling the space
						} else if ($this->image_ratio_crop) {
							if (!is_string($this->image_ratio_crop)) {
								$this->image_ratio_crop = '';
							}

							$this->image_ratio_crop = strtolower($this->image_ratio_crop);
							if (($this->image_src_x / $this->image_x) > ($this->image_src_y / $this->image_y)) {
								$this->image_dst_y = $this->image_y;
								$this->image_dst_x = intval($this->image_src_x * ($this->image_y / $this->image_src_y));
								$ratio_crop = array();
								$ratio_crop['x'] = $this->image_dst_x - $this->image_x;
								if (strpos($this->image_ratio_crop, 'l') !== false) {
									$ratio_crop['l'] = 0;
									$ratio_crop['r'] = $ratio_crop['x'];
								} else if (strpos($this->image_ratio_crop, 'r') !== false) {
									$ratio_crop['l'] = $ratio_crop['x'];
									$ratio_crop['r'] = 0;
								} else {
									$ratio_crop['l'] = round($ratio_crop['x'] / 2);
									$ratio_crop['r'] = $ratio_crop['x'] - $ratio_crop['l'];
								}
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_crop_x         : ' . $ratio_crop['x'] . ' (' . $ratio_crop['l'] . ';' . $ratio_crop['r'] . ')<br />';
								if (is_null($this->image_crop)) {
									$this->image_crop = array(0, 0, 0, 0);
								}

							} else {
								$this->image_dst_x = $this->image_x;
								$this->image_dst_y = intval($this->image_src_y * ($this->image_x / $this->image_src_x));
								$ratio_crop = array();
								$ratio_crop['y'] = $this->image_dst_y - $this->image_y;
								if (strpos($this->image_ratio_crop, 't') !== false) {
									$ratio_crop['t'] = 0;
									$ratio_crop['b'] = $ratio_crop['y'];
								} else if (strpos($this->image_ratio_crop, 'b') !== false) {
									$ratio_crop['t'] = $ratio_crop['y'];
									$ratio_crop['b'] = 0;
								} else {
									$ratio_crop['t'] = round($ratio_crop['y'] / 2);
									$ratio_crop['b'] = $ratio_crop['y'] - $ratio_crop['t'];
								}
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_crop_y         : ' . $ratio_crop['y'] . ' (' . $ratio_crop['t'] . ';' . $ratio_crop['b'] . ')<br />';
								if (is_null($this->image_crop)) {
									$this->image_crop = array(0, 0, 0, 0);
								}

							}

							// keeps aspect ratio with x and y dimensions, fitting the image in the space, and coloring the rest
						} else if ($this->image_ratio_fill) {
							if (!is_string($this->image_ratio_fill)) {
								$this->image_ratio_fill = '';
							}

							$this->image_ratio_fill = strtolower($this->image_ratio_fill);
							if (($this->image_src_x / $this->image_x) < ($this->image_src_y / $this->image_y)) {
								$this->image_dst_y = $this->image_y;
								$this->image_dst_x = intval($this->image_src_x * ($this->image_y / $this->image_src_y));
								$ratio_crop = array();
								$ratio_crop['x'] = $this->image_dst_x - $this->image_x;
								if (strpos($this->image_ratio_fill, 'l') !== false) {
									$ratio_crop['l'] = 0;
									$ratio_crop['r'] = $ratio_crop['x'];
								} else if (strpos($this->image_ratio_fill, 'r') !== false) {
									$ratio_crop['l'] = $ratio_crop['x'];
									$ratio_crop['r'] = 0;
								} else {
									$ratio_crop['l'] = round($ratio_crop['x'] / 2);
									$ratio_crop['r'] = $ratio_crop['x'] - $ratio_crop['l'];
								}
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_fill_x         : ' . $ratio_crop['x'] . ' (' . $ratio_crop['l'] . ';' . $ratio_crop['r'] . ')<br />';
								if (is_null($this->image_crop)) {
									$this->image_crop = array(0, 0, 0, 0);
								}

							} else {
								$this->image_dst_x = $this->image_x;
								$this->image_dst_y = intval($this->image_src_y * ($this->image_x / $this->image_src_x));
								$ratio_crop = array();
								$ratio_crop['y'] = $this->image_dst_y - $this->image_y;
								if (strpos($this->image_ratio_fill, 't') !== false) {
									$ratio_crop['t'] = 0;
									$ratio_crop['b'] = $ratio_crop['y'];
								} else if (strpos($this->image_ratio_fill, 'b') !== false) {
									$ratio_crop['t'] = $ratio_crop['y'];
									$ratio_crop['b'] = 0;
								} else {
									$ratio_crop['t'] = round($ratio_crop['y'] / 2);
									$ratio_crop['b'] = $ratio_crop['y'] - $ratio_crop['t'];
								}
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_fill_y         : ' . $ratio_crop['y'] . ' (' . $ratio_crop['t'] . ';' . $ratio_crop['b'] . ')<br />';
								if (is_null($this->image_crop)) {
									$this->image_crop = array(0, 0, 0, 0);
								}

							}

							// keeps aspect ratio with x and y dimensions
						} else if ($this->image_ratio) {
							if (($this->image_src_x / $this->image_x) > ($this->image_src_y / $this->image_y)) {
								$this->image_dst_x = $this->image_x;
								$this->image_dst_y = intval($this->image_src_y * ($this->image_x / $this->image_src_x));
							} else {
								$this->image_dst_y = $this->image_y;
								$this->image_dst_x = intval($this->image_src_x * ($this->image_y / $this->image_src_y));
							}

							// resize to provided exact dimensions
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;use plain sizes<br />';
							$this->image_dst_x = $this->image_x;
							$this->image_dst_y = $this->image_y;
						}

						if ($this->image_dst_x < 1) {
							$this->image_dst_x = 1;
						}

						if ($this->image_dst_y < 1) {
							$this->image_dst_y = 1;
						}

						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_x y        : ' . $this->image_src_x . ' x ' . $this->image_src_y . '<br />';
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_dst_x y        : ' . $this->image_dst_x . ' x ' . $this->image_dst_y . '<br />';

						// make sure we don't enlarge the image if we don't want to
						if ($this->image_no_enlarging && ($this->image_src_x < $this->image_dst_x || $this->image_src_y < $this->image_dst_y)) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;cancel resizing, as it would enlarge the image!<br />';
							$this->image_dst_x = $this->image_src_x;
							$this->image_dst_y = $this->image_src_y;
						}

						// make sure we don't shrink the image if we don't want to
						if ($this->image_no_shrinking && ($this->image_src_x > $this->image_dst_x || $this->image_src_y > $this->image_dst_y)) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;cancel resizing, as it would shrink the image!<br />';
							$this->image_dst_x = $this->image_src_x;
							$this->image_dst_y = $this->image_src_y;
						}

						// resize the image
						if ($this->image_dst_x != $this->image_src_x && $this->image_dst_y != $this->image_src_y) {
							$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);

							if ($gd_version >= 2) {
								$res = imagecopyresampled($tmp, $image_src, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, $this->image_src_x, $this->image_src_y);
							} else {
								$res = imagecopyresized($tmp, $image_src, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, $this->image_src_x, $this->image_src_y);
							}

							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;resized image object created<br />';
							// we transfert tmp into image_dst
							$image_dst = $this->imagetransfer($tmp, $image_dst);
						}

					} else {
						$this->image_dst_x = $this->image_src_x;
						$this->image_dst_y = $this->image_src_y;
					}

					// crop image (and also crops if image_ratio_crop is used)
					if ((!empty($this->image_crop) || !is_null($ratio_crop))) {
						list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_crop, $this->image_dst_x, $this->image_dst_y, true, true);
						// we adjust the cropping if we use image_ratio_crop
						if (!is_null($ratio_crop)) {
							if (array_key_exists('t', $ratio_crop)) {
								$ct += $ratio_crop['t'];
							}

							if (array_key_exists('r', $ratio_crop)) {
								$cr += $ratio_crop['r'];
							}

							if (array_key_exists('b', $ratio_crop)) {
								$cb += $ratio_crop['b'];
							}

							if (array_key_exists('l', $ratio_crop)) {
								$cl += $ratio_crop['l'];
							}

						}
						$this->log .= '- crop image : ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . ' <br />';
						$this->image_dst_x = $this->image_dst_x - $cl - $cr;
						$this->image_dst_y = $this->image_dst_y - $ct - $cb;
						if ($this->image_dst_x < 1) {
							$this->image_dst_x = 1;
						}

						if ($this->image_dst_y < 1) {
							$this->image_dst_y = 1;
						}

						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);

						// we copy the image into the recieving image
						imagecopy($tmp, $image_dst, 0, 0, $cl, $ct, $this->image_dst_x, $this->image_dst_y);

						// if we crop with negative margins, we have to make sure the extra bits are the right color, or transparent
						if ($ct < 0 || $cr < 0 || $cb < 0 || $cl < 0) {
							// use the background color if present
							if (!empty($this->image_background_color)) {
								list($red, $green, $blue) = $this->getcolors($this->image_background_color);
								$fill = imagecolorallocate($tmp, $red, $green, $blue);
							} else {
								$fill = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
							}
							// fills eventual negative margins
							if ($ct < 0) {
								imagefilledrectangle($tmp, 0, 0, $this->image_dst_x, -$ct - 1, $fill);
							}

							if ($cr < 0) {
								imagefilledrectangle($tmp, $this->image_dst_x + $cr, 0, $this->image_dst_x, $this->image_dst_y, $fill);
							}

							if ($cb < 0) {
								imagefilledrectangle($tmp, 0, $this->image_dst_y + $cb, $this->image_dst_x, $this->image_dst_y, $fill);
							}

							if ($cl < 0) {
								imagefilledrectangle($tmp, 0, 0, -$cl - 1, $this->image_dst_y, $fill);
							}

						}

						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// flip image
					if ($gd_version >= 2 && !empty($this->image_flip)) {
						$this->image_flip = strtolower($this->image_flip);
						$this->log .= '- flip image : ' . $this->image_flip . '<br />';
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						for ($x = 0; $x < $this->image_dst_x; $x++) {
							for ($y = 0; $y < $this->image_dst_y; $y++) {
								if (strpos($this->image_flip, 'v') !== false) {
									imagecopy($tmp, $image_dst, $this->image_dst_x - $x - 1, $y, $x, $y, 1, 1);
								} else {
									imagecopy($tmp, $image_dst, $x, $this->image_dst_y - $y - 1, $x, $y, 1, 1);
								}
							}
						}
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// rotate image
					if ($gd_version >= 2 && is_numeric($this->image_rotate)) {
						if (!in_array($this->image_rotate, array(0, 90, 180, 270))) {
							$this->image_rotate = 0;
						}

						if ($this->image_rotate != 0) {
							if ($this->image_rotate == 90 || $this->image_rotate == 270) {
								$tmp = $this->imagecreatenew($this->image_dst_y, $this->image_dst_x);
							} else {
								$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
							}
							$this->log .= '- rotate image : ' . $this->image_rotate . '<br />';
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								for ($y = 0; $y < $this->image_dst_y; $y++) {
									if ($this->image_rotate == 90) {
										imagecopy($tmp, $image_dst, $y, $x, $x, $this->image_dst_y - $y - 1, 1, 1);
									} else if ($this->image_rotate == 180) {
										imagecopy($tmp, $image_dst, $x, $y, $this->image_dst_x - $x - 1, $this->image_dst_y - $y - 1, 1, 1);
									} else if ($this->image_rotate == 270) {
										imagecopy($tmp, $image_dst, $y, $x, $this->image_dst_x - $x - 1, $y, 1, 1);
									} else {
										imagecopy($tmp, $image_dst, $x, $y, $x, $y, 1, 1);
									}
								}
							}
							if ($this->image_rotate == 90 || $this->image_rotate == 270) {
								$t = $this->image_dst_y;
								$this->image_dst_y = $this->image_dst_x;
								$this->image_dst_x = $t;
							}
							// we transfert tmp into image_dst
							$image_dst = $this->imagetransfer($tmp, $image_dst);
						}
					}

					// pixelate image
					if ((is_numeric($this->image_pixelate) && $this->image_pixelate > 0)) {
						$this->log .= '- pixelate image (' . $this->image_pixelate . 'px)<br />';
						$filter = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						if ($gd_version >= 2) {
							imagecopyresampled($filter, $image_dst, 0, 0, 0, 0, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate), $this->image_dst_x, $this->image_dst_y);
							imagecopyresampled($image_dst, $filter, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate));
						} else {
							imagecopyresized($filter, $image_dst, 0, 0, 0, 0, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate), $this->image_dst_x, $this->image_dst_y);
							imagecopyresized($image_dst, $filter, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate));
						}
						imagedestroy($filter);
					}

					// unsharp mask
					if ($gd_version >= 2 && $this->image_unsharp && is_numeric($this->image_unsharp_amount) && is_numeric($this->image_unsharp_radius) && is_numeric($this->image_unsharp_threshold)) {
						// Unsharp Mask for PHP - version 2.1.1
						// Unsharp mask algorithm by Torstein Hønsi 2003-07.
						// Used with permission
						// Modified to support alpha transparency
						if ($this->image_unsharp_amount > 500) {
							$this->image_unsharp_amount = 500;
						}

						$this->image_unsharp_amount = $this->image_unsharp_amount * 0.016;
						if ($this->image_unsharp_radius > 50) {
							$this->image_unsharp_radius = 50;
						}

						$this->image_unsharp_radius = $this->image_unsharp_radius * 2;
						if ($this->image_unsharp_threshold > 255) {
							$this->image_unsharp_threshold = 255;
						}

						$this->image_unsharp_radius = abs(round($this->image_unsharp_radius));
						if ($this->image_unsharp_radius != 0) {
							$this->image_dst_x = imagesx($image_dst);
							$this->image_dst_y = imagesy($image_dst);
							$canvas = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y, false, true);
							$blur = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y, false, true);
							if ($this->function_enabled('imageconvolution')) {
								// PHP >= 5.1
								$matrix = array(array(1, 2, 1), array(2, 4, 2), array(1, 2, 1));
								imagecopy($blur, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y);
								imageconvolution($blur, $matrix, 16, 0);
							} else {
								for ($i = 0; $i < $this->image_unsharp_radius; $i++) {
									imagecopy($blur, $image_dst, 0, 0, 1, 0, $this->image_dst_x - 1, $this->image_dst_y); // left
									$this->imagecopymergealpha($blur, $image_dst, 1, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, 50); // right
									$this->imagecopymergealpha($blur, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, 50); // center
									imagecopy($canvas, $blur, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y);
									$this->imagecopymergealpha($blur, $canvas, 0, 0, 0, 1, $this->image_dst_x, $this->image_dst_y - 1, 33.33333); // up
									$this->imagecopymergealpha($blur, $canvas, 0, 1, 0, 0, $this->image_dst_x, $this->image_dst_y, 25); // down
								}
							}
							$p_new = array();
							if ($this->image_unsharp_threshold > 0) {
								for ($x = 0; $x < $this->image_dst_x - 1; $x++) {
									for ($y = 0; $y < $this->image_dst_y; $y++) {
										$p_orig = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
										$p_blur = imagecolorsforindex($blur, imagecolorat($blur, $x, $y));
										$p_new['red'] = (abs($p_orig['red'] - $p_blur['red']) >= $this->image_unsharp_threshold) ? max(0, min(255, ($this->image_unsharp_amount * ($p_orig['red'] - $p_blur['red'])) + $p_orig['red'])) : $p_orig['red'];
										$p_new['green'] = (abs($p_orig['green'] - $p_blur['green']) >= $this->image_unsharp_threshold) ? max(0, min(255, ($this->image_unsharp_amount * ($p_orig['green'] - $p_blur['green'])) + $p_orig['green'])) : $p_orig['green'];
										$p_new['blue'] = (abs($p_orig['blue'] - $p_blur['blue']) >= $this->image_unsharp_threshold) ? max(0, min(255, ($this->image_unsharp_amount * ($p_orig['blue'] - $p_blur['blue'])) + $p_orig['blue'])) : $p_orig['blue'];
										if (($p_orig['red'] != $p_new['red']) || ($p_orig['green'] != $p_new['green']) || ($p_orig['blue'] != $p_new['blue'])) {
											$color = imagecolorallocatealpha($image_dst, $p_new['red'], $p_new['green'], $p_new['blue'], $p_orig['alpha']);
											imagesetpixel($image_dst, $x, $y, $color);
										}
									}
								}
							} else {
								for ($x = 0; $x < $this->image_dst_x; $x++) {
									for ($y = 0; $y < $this->image_dst_y; $y++) {
										$p_orig = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
										$p_blur = imagecolorsforindex($blur, imagecolorat($blur, $x, $y));
										$p_new['red'] = ($this->image_unsharp_amount * ($p_orig['red'] - $p_blur['red'])) + $p_orig['red'];
										if ($p_new['red'] > 255) {$p_new['red'] = 255;} elseif ($p_new['red'] < 0) {$p_new['red'] = 0;}
										$p_new['green'] = ($this->image_unsharp_amount * ($p_orig['green'] - $p_blur['green'])) + $p_orig['green'];
										if ($p_new['green'] > 255) {$p_new['green'] = 255;} elseif ($p_new['green'] < 0) {$p_new['green'] = 0;}
										$p_new['blue'] = ($this->image_unsharp_amount * ($p_orig['blue'] - $p_blur['blue'])) + $p_orig['blue'];
										if ($p_new['blue'] > 255) {$p_new['blue'] = 255;} elseif ($p_new['blue'] < 0) {$p_new['blue'] = 0;}
										$color = imagecolorallocatealpha($image_dst, $p_new['red'], $p_new['green'], $p_new['blue'], $p_orig['alpha']);
										imagesetpixel($image_dst, $x, $y, $color);
									}
								}
							}
							imagedestroy($canvas);
							imagedestroy($blur);
						}
					}

					// add color overlay
					if ($gd_version >= 2 && (is_numeric($this->image_overlay_opacity) && $this->image_overlay_opacity > 0 && !empty($this->image_overlay_color))) {
						$this->log .= '- apply color overlay<br />';
						list($red, $green, $blue) = $this->getcolors($this->image_overlay_color);
						$filter = imagecreatetruecolor($this->image_dst_x, $this->image_dst_y);
						$color = imagecolorallocate($filter, $red, $green, $blue);
						imagefilledrectangle($filter, 0, 0, $this->image_dst_x, $this->image_dst_y, $color);
						$this->imagecopymergealpha($image_dst, $filter, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, $this->image_overlay_opacity);
						imagedestroy($filter);
					}

					// add brightness, contrast and tint, turns to greyscale and inverts colors
					if ($gd_version >= 2 && ($this->image_negative || $this->image_greyscale || is_numeric($this->image_threshold) || is_numeric($this->image_brightness) || is_numeric($this->image_contrast) || !empty($this->image_tint_color))) {
						$this->log .= '- apply tint, light, contrast correction, negative, greyscale and threshold<br />';
						if (!empty($this->image_tint_color)) {
							list($tint_red, $tint_green, $tint_blue) = $this->getcolors($this->image_tint_color);
						}

						//imagealphablending($image_dst, true);
						for ($y = 0; $y < $this->image_dst_y; $y++) {
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								if ($this->image_greyscale) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$r = $g = $b = round((0.2125 * $pixel['red']) + (0.7154 * $pixel['green']) + (0.0721 * $pixel['blue']));
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
								if (is_numeric($this->image_threshold)) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$c = (round($pixel['red'] + $pixel['green'] + $pixel['blue']) / 3) - 127;
									$r = $g = $b = ($c > $this->image_threshold ? 255 : 0);
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
								if (is_numeric($this->image_brightness)) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$r = max(min(round($pixel['red'] + (($this->image_brightness * 2))), 255), 0);
									$g = max(min(round($pixel['green'] + (($this->image_brightness * 2))), 255), 0);
									$b = max(min(round($pixel['blue'] + (($this->image_brightness * 2))), 255), 0);
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
								if (is_numeric($this->image_contrast)) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$r = max(min(round(($this->image_contrast + 128) * $pixel['red'] / 128), 255), 0);
									$g = max(min(round(($this->image_contrast + 128) * $pixel['green'] / 128), 255), 0);
									$b = max(min(round(($this->image_contrast + 128) * $pixel['blue'] / 128), 255), 0);
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
								if (!empty($this->image_tint_color)) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$r = min(round($tint_red * $pixel['red'] / 169), 255);
									$g = min(round($tint_green * $pixel['green'] / 169), 255);
									$b = min(round($tint_blue * $pixel['blue'] / 169), 255);
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
								if (!empty($this->image_negative)) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$r = round(255 - $pixel['red']);
									$g = round(255 - $pixel['green']);
									$b = round(255 - $pixel['blue']);
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
							}
						}
					}

					// adds a border
					if ($gd_version >= 2 && !empty($this->image_border)) {
						list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_border, $this->image_dst_x, $this->image_dst_y, true, false);
						$this->log .= '- add border : ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . '<br />';
						$this->image_dst_x = $this->image_dst_x + $cl + $cr;
						$this->image_dst_y = $this->image_dst_y + $ct + $cb;
						if (!empty($this->image_border_color)) {
							list($red, $green, $blue) = $this->getcolors($this->image_border_color);
						}

						$opacity = (is_numeric($this->image_border_opacity) ? (int) (127 - $this->image_border_opacity / 100 * 127) : 0);
						// we now create an image, that we fill with the border color
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						$background = imagecolorallocatealpha($tmp, $red, $green, $blue, $opacity);
						imagefilledrectangle($tmp, 0, 0, $this->image_dst_x, $this->image_dst_y, $background);
						// we then copy the source image into the new image, without merging so that only the border is actually kept
						imagecopy($tmp, $image_dst, $cl, $ct, 0, 0, $this->image_dst_x - $cr - $cl, $this->image_dst_y - $cb - $ct);
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// adds a fading-to-transparent border
					if ($gd_version >= 2 && !empty($this->image_border_transparent)) {
						list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_border_transparent, $this->image_dst_x, $this->image_dst_y, true, false);
						$this->log .= '- add transparent border : ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . '<br />';
						// we now create an image, that we fill with the border color
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						// we then copy the source image into the new image, without the borders
						imagecopy($tmp, $image_dst, $cl, $ct, $cl, $ct, $this->image_dst_x - $cr - $cl, $this->image_dst_y - $cb - $ct);
						// we now add the top border
						$opacity = 100;
						for ($y = $ct - 1; $y >= 0; $y--) {
							$il = (int) ($ct > 0 ? ($cl * ($y / $ct)) : 0);
							$ir = (int) ($ct > 0 ? ($cr * ($y / $ct)) : 0);
							for ($x = $il; $x < $this->image_dst_x - $ir; $x++) {
								$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								$alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
								if ($alpha > 0) {
									if ($alpha > 1) {
										$alpha = 1;
									}

									$color = imagecolorallocatealpha($tmp, $pixel['red'], $pixel['green'], $pixel['blue'], round((1 - $alpha) * 127));
									imagesetpixel($tmp, $x, $y, $color);
								}
							}
							if ($opacity > 0) {
								$opacity = $opacity - (100 / $ct);
							}

						}
						// we now add the right border
						$opacity = 100;
						for ($x = $this->image_dst_x - $cr; $x < $this->image_dst_x; $x++) {
							$it = (int) ($cr > 0 ? ($ct * (($this->image_dst_x - $x - 1) / $cr)) : 0);
							$ib = (int) ($cr > 0 ? ($cb * (($this->image_dst_x - $x - 1) / $cr)) : 0);
							for ($y = $it; $y < $this->image_dst_y - $ib; $y++) {
								$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								$alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
								if ($alpha > 0) {
									if ($alpha > 1) {
										$alpha = 1;
									}

									$color = imagecolorallocatealpha($tmp, $pixel['red'], $pixel['green'], $pixel['blue'], round((1 - $alpha) * 127));
									imagesetpixel($tmp, $x, $y, $color);
								}
							}
							if ($opacity > 0) {
								$opacity = $opacity - (100 / $cr);
							}

						}
						// we now add the bottom border
						$opacity = 100;
						for ($y = $this->image_dst_y - $cb; $y < $this->image_dst_y; $y++) {
							$il = (int) ($cb > 0 ? ($cl * (($this->image_dst_y - $y - 1) / $cb)) : 0);
							$ir = (int) ($cb > 0 ? ($cr * (($this->image_dst_y - $y - 1) / $cb)) : 0);
							for ($x = $il; $x < $this->image_dst_x - $ir; $x++) {
								$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								$alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
								if ($alpha > 0) {
									if ($alpha > 1) {
										$alpha = 1;
									}

									$color = imagecolorallocatealpha($tmp, $pixel['red'], $pixel['green'], $pixel['blue'], round((1 - $alpha) * 127));
									imagesetpixel($tmp, $x, $y, $color);
								}
							}
							if ($opacity > 0) {
								$opacity = $opacity - (100 / $cb);
							}

						}
						// we now add the left border
						$opacity = 100;
						for ($x = $cl - 1; $x >= 0; $x--) {
							$it = (int) ($cl > 0 ? ($ct * ($x / $cl)) : 0);
							$ib = (int) ($cl > 0 ? ($cb * ($x / $cl)) : 0);
							for ($y = $it; $y < $this->image_dst_y - $ib; $y++) {
								$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								$alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
								if ($alpha > 0) {
									if ($alpha > 1) {
										$alpha = 1;
									}

									$color = imagecolorallocatealpha($tmp, $pixel['red'], $pixel['green'], $pixel['blue'], round((1 - $alpha) * 127));
									imagesetpixel($tmp, $x, $y, $color);
								}
							}
							if ($opacity > 0) {
								$opacity = $opacity - (100 / $cl);
							}

						}
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// add frame border
					if ($gd_version >= 2 && is_numeric($this->image_frame)) {
						if (is_array($this->image_frame_colors)) {
							$vars = $this->image_frame_colors;
							$this->log .= '- add frame : ' . implode(' ', $this->image_frame_colors) . '<br />';
						} else {
							$this->log .= '- add frame : ' . $this->image_frame_colors . '<br />';
							$vars = explode(' ', $this->image_frame_colors);
						}
						$nb = sizeof($vars);
						$this->image_dst_x = $this->image_dst_x + ($nb * 2);
						$this->image_dst_y = $this->image_dst_y + ($nb * 2);
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						imagecopy($tmp, $image_dst, $nb, $nb, 0, 0, $this->image_dst_x - ($nb * 2), $this->image_dst_y - ($nb * 2));
						$opacity = (is_numeric($this->image_frame_opacity) ? (int) (127 - $this->image_frame_opacity / 100 * 127) : 0);
						for ($i = 0; $i < $nb; $i++) {
							list($red, $green, $blue) = $this->getcolors($vars[$i]);
							$c = imagecolorallocatealpha($tmp, $red, $green, $blue, $opacity);
							if ($this->image_frame == 1) {
								imageline($tmp, $i, $i, $this->image_dst_x - $i - 1, $i, $c);
								imageline($tmp, $this->image_dst_x - $i - 1, $this->image_dst_y - $i - 1, $this->image_dst_x - $i - 1, $i, $c);
								imageline($tmp, $this->image_dst_x - $i - 1, $this->image_dst_y - $i - 1, $i, $this->image_dst_y - $i - 1, $c);
								imageline($tmp, $i, $i, $i, $this->image_dst_y - $i - 1, $c);
							} else {
								imageline($tmp, $i, $i, $this->image_dst_x - $i - 1, $i, $c);
								imageline($tmp, $this->image_dst_x - $nb + $i, $this->image_dst_y - $nb + $i, $this->image_dst_x - $nb + $i, $nb - $i, $c);
								imageline($tmp, $this->image_dst_x - $nb + $i, $this->image_dst_y - $nb + $i, $nb - $i, $this->image_dst_y - $nb + $i, $c);
								imageline($tmp, $i, $i, $i, $this->image_dst_y - $i - 1, $c);
							}
						}
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// add bevel border
					if ($gd_version >= 2 && $this->image_bevel > 0) {
						if (empty($this->image_bevel_color1)) {
							$this->image_bevel_color1 = '#FFFFFF';
						}

						if (empty($this->image_bevel_color2)) {
							$this->image_bevel_color2 = '#000000';
						}

						list($red1, $green1, $blue1) = $this->getcolors($this->image_bevel_color1);
						list($red2, $green2, $blue2) = $this->getcolors($this->image_bevel_color2);
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						imagecopy($tmp, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y);
						imagealphablending($tmp, true);
						for ($i = 0; $i < $this->image_bevel; $i++) {
							$alpha = round(($i / $this->image_bevel) * 127);
							$c1 = imagecolorallocatealpha($tmp, $red1, $green1, $blue1, $alpha);
							$c2 = imagecolorallocatealpha($tmp, $red2, $green2, $blue2, $alpha);
							imageline($tmp, $i, $i, $this->image_dst_x - $i - 1, $i, $c1);
							imageline($tmp, $this->image_dst_x - $i - 1, $this->image_dst_y - $i, $this->image_dst_x - $i - 1, $i, $c2);
							imageline($tmp, $this->image_dst_x - $i - 1, $this->image_dst_y - $i - 1, $i, $this->image_dst_y - $i - 1, $c2);
							imageline($tmp, $i, $i, $i, $this->image_dst_y - $i - 1, $c1);
						}
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// add watermark image
					if ($this->image_watermark != '' && file_exists($this->image_watermark)) {
						$this->log .= '- add watermark<br />';
						$this->image_watermark_position = strtolower($this->image_watermark_position);
						$watermark_info = getimagesize($this->image_watermark);
						$watermark_type = (array_key_exists(2, $watermark_info) ? $watermark_info[2] : null); // 1 = GIF, 2 = JPG, 3 = PNG
						$watermark_checked = false;
						if ($watermark_type == IMAGETYPE_GIF) {
							if (!$this->function_enabled('imagecreatefromgif')) {
								$this->error = $this->translate('watermark_no_create_support', array('GIF'));
							} else {
								$filter = @imagecreatefromgif($this->image_watermark);
								if (!$filter) {
									$this->error = $this->translate('watermark_create_error', array('GIF'));
								} else {
									$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;watermark source image is GIF<br />';
									$watermark_checked = true;
								}
							}
						} else if ($watermark_type == IMAGETYPE_JPEG) {
							if (!$this->function_enabled('imagecreatefromjpeg')) {
								$this->error = $this->translate('watermark_no_create_support', array('JPEG'));
							} else {
								$filter = @imagecreatefromjpeg($this->image_watermark);
								if (!$filter) {
									$this->error = $this->translate('watermark_create_error', array('JPEG'));
								} else {
									$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;watermark source image is JPEG<br />';
									$watermark_checked = true;
								}
							}
						} else if ($watermark_type == IMAGETYPE_PNG) {
							if (!$this->function_enabled('imagecreatefrompng')) {
								$this->error = $this->translate('watermark_no_create_support', array('PNG'));
							} else {
								$filter = @imagecreatefrompng($this->image_watermark);
								if (!$filter) {
									$this->error = $this->translate('watermark_create_error', array('PNG'));
								} else {
									$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;watermark source image is PNG<br />';
									$watermark_checked = true;
								}
							}
						} else if ($watermark_type == IMAGETYPE_BMP) {
							if (!method_exists($this, 'imagecreatefrombmp')) {
								$this->error = $this->translate('watermark_no_create_support', array('BMP'));
							} else {
								$filter = @$this->imagecreatefrombmp($this->image_watermark);
								if (!$filter) {
									$this->error = $this->translate('watermark_create_error', array('BMP'));
								} else {
									$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;watermark source image is BMP<br />';
									$watermark_checked = true;
								}
							}
						} else {
							$this->error = $this->translate('watermark_invalid');
						}
						if ($watermark_checked) {
							$watermark_dst_width = $watermark_src_width = imagesx($filter);
							$watermark_dst_height = $watermark_src_height = imagesy($filter);

							// if watermark is too large/tall, resize it first
							if ((!$this->image_watermark_no_zoom_out && ($watermark_dst_width > $this->image_dst_x || $watermark_dst_height > $this->image_dst_y))
								|| (!$this->image_watermark_no_zoom_in && $watermark_dst_width < $this->image_dst_x && $watermark_dst_height < $this->image_dst_y)) {
								$canvas_width = $this->image_dst_x - abs($this->image_watermark_x);
								$canvas_height = $this->image_dst_y - abs($this->image_watermark_y);
								if (($watermark_src_width / $canvas_width) > ($watermark_src_height / $canvas_height)) {
									$watermark_dst_width = $canvas_width;
									$watermark_dst_height = intval($watermark_src_height * ($canvas_width / $watermark_src_width));
								} else {
									$watermark_dst_height = $canvas_height;
									$watermark_dst_width = intval($watermark_src_width * ($canvas_height / $watermark_src_height));
								}
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;watermark resized from ' . $watermark_src_width . 'x' . $watermark_src_height . ' to ' . $watermark_dst_width . 'x' . $watermark_dst_height . '<br />';

							}
							// determine watermark position
							$watermark_x = 0;
							$watermark_y = 0;
							if (is_numeric($this->image_watermark_x)) {
								if ($this->image_watermark_x < 0) {
									$watermark_x = $this->image_dst_x - $watermark_dst_width + $this->image_watermark_x;
								} else {
									$watermark_x = $this->image_watermark_x;
								}
							} else {
								if (strpos($this->image_watermark_position, 'r') !== false) {
									$watermark_x = $this->image_dst_x - $watermark_dst_width;
								} else if (strpos($this->image_watermark_position, 'l') !== false) {
									$watermark_x = 0;
								} else {
									$watermark_x = ($this->image_dst_x - $watermark_dst_width) / 2;
								}
							}
							if (is_numeric($this->image_watermark_y)) {
								if ($this->image_watermark_y < 0) {
									$watermark_y = $this->image_dst_y - $watermark_dst_height + $this->image_watermark_y;
								} else {
									$watermark_y = $this->image_watermark_y;
								}
							} else {
								if (strpos($this->image_watermark_position, 'b') !== false) {
									$watermark_y = $this->image_dst_y - $watermark_dst_height;
								} else if (strpos($this->image_watermark_position, 't') !== false) {
									$watermark_y = 0;
								} else {
									$watermark_y = ($this->image_dst_y - $watermark_dst_height) / 2;
								}
							}
							imagealphablending($image_dst, true);
							imagecopyresampled($image_dst, $filter, $watermark_x, $watermark_y, 0, 0, $watermark_dst_width, $watermark_dst_height, $watermark_src_width, $watermark_src_height);
						} else {
							$this->error = $this->translate('watermark_invalid');
						}
					}

					// add text
					if (!empty($this->image_text)) {
						$this->log .= '- add text<br />';

						// calculate sizes in human readable format
						$src_size = $this->file_src_size / 1024;
						$src_size_mb = number_format($src_size / 1024, 1, ".", " ");
						$src_size_kb = number_format($src_size, 1, ".", " ");
						$src_size_human = ($src_size > 1024 ? $src_size_mb . " MB" : $src_size_kb . " kb");

						$this->image_text = str_replace(
							array('[src_name]',
								'[src_name_body]',
								'[src_name_ext]',
								'[src_pathname]',
								'[src_mime]',
								'[src_size]',
								'[src_size_kb]',
								'[src_size_mb]',
								'[src_size_human]',
								'[src_x]',
								'[src_y]',
								'[src_pixels]',
								'[src_type]',
								'[src_bits]',
								'[dst_path]',
								'[dst_name_body]',
								'[dst_name_ext]',
								'[dst_name]',
								'[dst_pathname]',
								'[dst_x]',
								'[dst_y]',
								'[date]',
								'[time]',
								'[host]',
								'[server]',
								'[ip]',
								'[gd_version]'),
							array($this->file_src_name,
								$this->file_src_name_body,
								$this->file_src_name_ext,
								$this->file_src_pathname,
								$this->file_src_mime,
								$this->file_src_size,
								$src_size_kb,
								$src_size_mb,
								$src_size_human,
								$this->image_src_x,
								$this->image_src_y,
								$this->image_src_pixels,
								$this->image_src_type,
								$this->image_src_bits,
								$this->file_dst_path,
								$this->file_dst_name_body,
								$this->file_dst_name_ext,
								$this->file_dst_name,
								$this->file_dst_pathname,
								$this->image_dst_x,
								$this->image_dst_y,
								date('Y-m-d'),
								date('H:i:s'),
								(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'n/a'),
								(isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'n/a'),
								(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'n/a'),
								$this->gdversion(true)),
							$this->image_text);

						if (!is_numeric($this->image_text_padding)) {
							$this->image_text_padding = 0;
						}

						if (!is_numeric($this->image_text_line_spacing)) {
							$this->image_text_line_spacing = 0;
						}

						if (!is_numeric($this->image_text_padding_x)) {
							$this->image_text_padding_x = $this->image_text_padding;
						}

						if (!is_numeric($this->image_text_padding_y)) {
							$this->image_text_padding_y = $this->image_text_padding;
						}

						$this->image_text_position = strtolower($this->image_text_position);
						$this->image_text_direction = strtolower($this->image_text_direction);
						$this->image_text_alignment = strtolower($this->image_text_alignment);

						$font_type = 'gd';

						// if the font is a string with a GDF font path, we assume that we might want to load a font
						if (!is_numeric($this->image_text_font) && strlen($this->image_text_font) > 4 && substr(strtolower($this->image_text_font), -4) == '.gdf') {
							if (strpos($this->image_text_font, '/') === false) {
								$this->image_text_font = "./" . $this->image_text_font;
							}

							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;try to load font ' . $this->image_text_font . '... ';
							if ($this->image_text_font = @imageloadfont($this->image_text_font)) {
								$this->log .= 'success<br />';
							} else {
								$this->log .= 'error<br />';
								$this->image_text_font = 5;
							}
						}

						// if the font is a string with a TTF font path, we check if we can access the font file
						if (!is_numeric($this->image_text_font) && strlen($this->image_text_font) > 4 && substr(strtolower($this->image_text_font), -4) == '.ttf') {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;try to load font ' . $this->image_text_font . '... ';
							if (strpos($this->image_text_font, '/') === false) {
								$this->image_text_font = "./" . $this->image_text_font;
							}

							if (file_exists($this->image_text_font) && is_readable($this->image_text_font)) {
								$this->log .= 'success<br />';
								$font_type = 'tt';
							} else {
								$this->log .= 'error<br />';
								$this->image_text_font = 5;
							}
						}

						// get the text bounding box (GD fonts)
						if ($font_type == 'gd') {
							$text = explode("\n", $this->image_text);
							$char_width = imagefontwidth($this->image_text_font);
							$char_height = imagefontheight($this->image_text_font);
							$text_height = 0;
							$text_width = 0;
							$line_height = 0;
							$line_width = 0;
							foreach ($text as $k => $v) {
								if ($this->image_text_direction == 'v') {
									$h = ($char_width * strlen($v));
									if ($h > $text_height) {
										$text_height = $h;
									}

									$line_width = $char_height;
									$text_width += $line_width + ($k < (sizeof($text) - 1) ? $this->image_text_line_spacing : 0);
								} else {
									$w = ($char_width * strlen($v));
									if ($w > $text_width) {
										$text_width = $w;
									}

									$line_height = $char_height;
									$text_height += $line_height + ($k < (sizeof($text) - 1) ? $this->image_text_line_spacing : 0);
								}
							}
							$text_width += (2 * $this->image_text_padding_x);
							$text_height += (2 * $this->image_text_padding_y);

							// get the text bounding box (TrueType fonts)
						} else if ($font_type == 'tt') {
							$text = $this->image_text;
							if (!$this->image_text_angle) {
								$this->image_text_angle = $this->image_text_direction == 'v' ? 90 : 0;
							}

							$text_height = 0;
							$text_width = 0;
							$text_offset_x = 0;
							$text_offset_y = 0;
							$rect = imagettfbbox($this->image_text_size, $this->image_text_angle, $this->image_text_font, $text);
							if ($rect) {
								$minX = min(array($rect[0], $rect[2], $rect[4], $rect[6]));
								$maxX = max(array($rect[0], $rect[2], $rect[4], $rect[6]));
								$minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
								$maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));
								$text_offset_x = abs($minX) - 1;
								$text_offset_y = abs($minY) - 1;
								$text_width = $maxX - $minX + (2 * $this->image_text_padding_x);
								$text_height = $maxY - $minY + (2 * $this->image_text_padding_y);
							}
						}

						// position the text block
						$text_x = 0;
						$text_y = 0;
						if (is_numeric($this->image_text_x)) {
							if ($this->image_text_x < 0) {
								$text_x = $this->image_dst_x - $text_width + $this->image_text_x;
							} else {
								$text_x = $this->image_text_x;
							}
						} else {
							if (strpos($this->image_text_position, 'r') !== false) {
								$text_x = $this->image_dst_x - $text_width;
							} else if (strpos($this->image_text_position, 'l') !== false) {
								$text_x = 0;
							} else {
								$text_x = ($this->image_dst_x - $text_width) / 2;
							}
						}
						if (is_numeric($this->image_text_y)) {
							if ($this->image_text_y < 0) {
								$text_y = $this->image_dst_y - $text_height + $this->image_text_y;
							} else {
								$text_y = $this->image_text_y;
							}
						} else {
							if (strpos($this->image_text_position, 'b') !== false) {
								$text_y = $this->image_dst_y - $text_height;
							} else if (strpos($this->image_text_position, 't') !== false) {
								$text_y = 0;
							} else {
								$text_y = ($this->image_dst_y - $text_height) / 2;
							}
						}

						// add a background, maybe transparent
						if (!empty($this->image_text_background)) {
							list($red, $green, $blue) = $this->getcolors($this->image_text_background);
							if ($gd_version >= 2 && (is_numeric($this->image_text_background_opacity)) && $this->image_text_background_opacity >= 0 && $this->image_text_background_opacity <= 100) {
								$filter = imagecreatetruecolor($text_width, $text_height);
								$background_color = imagecolorallocate($filter, $red, $green, $blue);
								imagefilledrectangle($filter, 0, 0, $text_width, $text_height, $background_color);
								$this->imagecopymergealpha($image_dst, $filter, $text_x, $text_y, 0, 0, $text_width, $text_height, $this->image_text_background_opacity);
								imagedestroy($filter);
							} else {
								$background_color = imagecolorallocate($image_dst, $red, $green, $blue);
								imagefilledrectangle($image_dst, $text_x, $text_y, $text_x + $text_width, $text_y + $text_height, $background_color);
							}
						}

						$text_x += $this->image_text_padding_x;
						$text_y += $this->image_text_padding_y;
						$t_width = $text_width - (2 * $this->image_text_padding_x);
						$t_height = $text_height - (2 * $this->image_text_padding_y);
						list($red, $green, $blue) = $this->getcolors($this->image_text_color);

						// add the text, maybe transparent
						if ($gd_version >= 2 && (is_numeric($this->image_text_opacity)) && $this->image_text_opacity >= 0 && $this->image_text_opacity <= 100) {
							if ($t_width < 0) {
								$t_width = 0;
							}

							if ($t_height < 0) {
								$t_height = 0;
							}

							$filter = $this->imagecreatenew($t_width, $t_height, false, true);
							$text_color = imagecolorallocate($filter, $red, $green, $blue);

							if ($font_type == 'gd') {
								foreach ($text as $k => $v) {
									if ($this->image_text_direction == 'v') {
										imagestringup($filter,
											$this->image_text_font,
											$k * ($line_width + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0)),
											$text_height - (2 * $this->image_text_padding_y) - ($this->image_text_alignment == 'l' ? 0 : (($t_height - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
											$v,
											$text_color);
									} else {
										imagestring($filter,
											$this->image_text_font,
											($this->image_text_alignment == 'l' ? 0 : (($t_width - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
											$k * ($line_height + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0)),
											$v,
											$text_color);
									}
								}
							} else if ($font_type == 'tt') {
								imagettftext($filter,
									$this->image_text_size,
									$this->image_text_angle,
									$text_offset_x,
									$text_offset_y,
									$text_color,
									$this->image_text_font,
									$text);
							}
							$this->imagecopymergealpha($image_dst, $filter, $text_x, $text_y, 0, 0, $t_width, $t_height, $this->image_text_opacity);
							imagedestroy($filter);

						} else {
							$text_color = imagecolorallocate($image_dst, $red, $green, $blue);
							if ($font_type == 'gd') {
								foreach ($text as $k => $v) {
									if ($this->image_text_direction == 'v') {
										imagestringup($image_dst,
											$this->image_text_font,
											$text_x + $k * ($line_width + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0)),
											$text_y + $text_height - (2 * $this->image_text_padding_y) - ($this->image_text_alignment == 'l' ? 0 : (($t_height - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
											$v,
											$text_color);
									} else {
										imagestring($image_dst,
											$this->image_text_font,
											$text_x + ($this->image_text_alignment == 'l' ? 0 : (($t_width - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
											$text_y + $k * ($line_height + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0)),
											$v,
											$text_color);
									}
								}
							} else if ($font_type == 'tt') {
								imagettftext($image_dst,
									$this->image_text_size,
									$this->image_text_angle,
									$text_offset_x + ($this->image_dst_x / 2) - ($text_width / 2) + $this->image_text_padding_x,
									$text_offset_y + ($this->image_dst_y / 2) - ($text_height / 2) + $this->image_text_padding_y,
									$text_color,
									$this->image_text_font,
									$text);
							}
						}
					}

					// add a reflection
					if ($this->image_reflection_height) {
						$this->log .= '- add reflection : ' . $this->image_reflection_height . '<br />';
						// we decode image_reflection_height, which can be a integer, a string in pixels or percentage
						$image_reflection_height = $this->image_reflection_height;
						if (strpos($image_reflection_height, '%') > 0) {
							$image_reflection_height = $this->image_dst_y * (str_replace('%', '', $image_reflection_height / 100));
						}

						if (strpos($image_reflection_height, 'px') > 0) {
							$image_reflection_height = str_replace('px', '', $image_reflection_height);
						}

						$image_reflection_height = (int) $image_reflection_height;
						if ($image_reflection_height > $this->image_dst_y) {
							$image_reflection_height = $this->image_dst_y;
						}

						if (empty($this->image_reflection_opacity)) {
							$this->image_reflection_opacity = 60;
						}

						// create the new destination image
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y + $image_reflection_height + $this->image_reflection_space, true);
						$transparency = $this->image_reflection_opacity;

						// copy the original image
						imagecopy($tmp, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y + ($this->image_reflection_space < 0 ? $this->image_reflection_space : 0));

						// we have to make sure the extra bit is the right color, or transparent
						if ($image_reflection_height + $this->image_reflection_space > 0) {
							// use the background color if present
							if (!empty($this->image_background_color)) {
								list($red, $green, $blue) = $this->getcolors($this->image_background_color);
								$fill = imagecolorallocate($tmp, $red, $green, $blue);
							} else {
								$fill = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
							}
							// fill in from the edge of the extra bit
							imagefill($tmp, round($this->image_dst_x / 2), $this->image_dst_y + $image_reflection_height + $this->image_reflection_space - 1, $fill);
						}

						// copy the reflection
						for ($y = 0; $y < $image_reflection_height; $y++) {
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								$pixel_b = imagecolorsforindex($tmp, imagecolorat($tmp, $x, $y + $this->image_dst_y + $this->image_reflection_space));
								$pixel_o = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $this->image_dst_y - $y - 1 + ($this->image_reflection_space < 0 ? $this->image_reflection_space : 0)));
								$alpha_o = 1 - ($pixel_o['alpha'] / 127);
								$alpha_b = 1 - ($pixel_b['alpha'] / 127);
								$opacity = $alpha_o * $transparency / 100;
								if ($opacity > 0) {
									$red = round((($pixel_o['red'] * $opacity) + ($pixel_b['red']) * $alpha_b) / ($alpha_b + $opacity));
									$green = round((($pixel_o['green'] * $opacity) + ($pixel_b['green']) * $alpha_b) / ($alpha_b + $opacity));
									$blue = round((($pixel_o['blue'] * $opacity) + ($pixel_b['blue']) * $alpha_b) / ($alpha_b + $opacity));
									$alpha = ($opacity + $alpha_b);
									if ($alpha > 1) {
										$alpha = 1;
									}

									$alpha = round((1 - $alpha) * 127);
									$color = imagecolorallocatealpha($tmp, $red, $green, $blue, $alpha);
									imagesetpixel($tmp, $x, $y + $this->image_dst_y + $this->image_reflection_space, $color);
								}
							}
							if ($transparency > 0) {
								$transparency = $transparency - ($this->image_reflection_opacity / $image_reflection_height);
							}

						}

						// copy the resulting image into the destination image
						$this->image_dst_y = $this->image_dst_y + $image_reflection_height + $this->image_reflection_space;
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// change opacity
					if ($gd_version >= 2 && is_numeric($this->image_opacity) && $this->image_opacity < 100) {
						$this->log .= '- change opacity<br />';
						// create the new destination image
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y, true);
						for ($y = 0; $y < $this->image_dst_y; $y++) {
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								$alpha = $pixel['alpha'] + round((127 - $pixel['alpha']) * (100 - $this->image_opacity) / 100);
								if ($alpha > 127) {
									$alpha = 127;
								}

								if ($alpha > 0) {
									$color = imagecolorallocatealpha($tmp, $pixel['red'], $pixel['green'], $pixel['blue'], $alpha);
									imagesetpixel($tmp, $x, $y, $color);
								}
							}
						}
						// copy the resulting image into the destination image
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// reduce the JPEG image to a set desired size
					if (is_numeric($this->jpeg_size) && $this->jpeg_size > 0 && ($this->image_convert == 'jpeg' || $this->image_convert == 'jpg')) {
						// inspired by: JPEGReducer class version 1, 25 November 2004, Author: Huda M ElMatsani, justhuda at netscape dot net
						$this->log .= '- JPEG desired file size : ' . $this->jpeg_size . '<br />';
						// calculate size of each image. 75%, 50%, and 25% quality
						ob_start();
						imagejpeg($image_dst, null, 75);
						$buffer = ob_get_contents();
						ob_end_clean();
						$size75 = strlen($buffer);
						ob_start();
						imagejpeg($image_dst, null, 50);
						$buffer = ob_get_contents();
						ob_end_clean();
						$size50 = strlen($buffer);
						ob_start();
						imagejpeg($image_dst, null, 25);
						$buffer = ob_get_contents();
						ob_end_clean();
						$size25 = strlen($buffer);

						// make sure we won't divide by 0
						if ($size50 == $size25) {
							$size50++;
						}

						if ($size75 == $size50 || $size75 == $size25) {
							$size75++;
						}

						// calculate gradient of size reduction by quality
						$mgrad1 = 25 / ($size50 - $size25);
						$mgrad2 = 25 / ($size75 - $size50);
						$mgrad3 = 50 / ($size75 - $size25);
						$mgrad = ($mgrad1 + $mgrad2 + $mgrad3) / 3;
						// result of approx. quality factor for expected size
						$q_factor = round($mgrad * ($this->jpeg_size - $size50) + 50);

						if ($q_factor < 1) {
							$this->jpeg_quality = 1;
						} elseif ($q_factor > 100) {
							$this->jpeg_quality = 100;
						} else {
							$this->jpeg_quality = $q_factor;
						}
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;JPEG quality factor set to ' . $this->jpeg_quality . '<br />';
					}

					// converts image from true color, and fix transparency if needed
					$this->log .= '- converting...<br />';
					$this->image_dst_type = $this->image_convert;
					switch ($this->image_convert) {
					case 'gif':
						// if the image is true color, we convert it to a palette
						if (imageistruecolor($image_dst)) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;true color to palette<br />';
							// creates a black and white mask
							$mask = array(array());
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								for ($y = 0; $y < $this->image_dst_y; $y++) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$mask[$x][$y] = $pixel['alpha'];
								}
							}
							list($red, $green, $blue) = $this->getcolors($this->image_default_color);
							// first, we merge the image with the background color, so we know which colors we will have
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								for ($y = 0; $y < $this->image_dst_y; $y++) {
									if ($mask[$x][$y] > 0) {
										// we have some transparency. we combine the color with the default color
										$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
										$alpha = ($mask[$x][$y] / 127);
										$pixel['red'] = round(($pixel['red'] * (1 - $alpha) + $red * ($alpha)));
										$pixel['green'] = round(($pixel['green'] * (1 - $alpha) + $green * ($alpha)));
										$pixel['blue'] = round(($pixel['blue'] * (1 - $alpha) + $blue * ($alpha)));
										$color = imagecolorallocate($image_dst, $pixel['red'], $pixel['green'], $pixel['blue']);
										imagesetpixel($image_dst, $x, $y, $color);
									}
								}
							}
							// transforms the true color image into palette, with its merged default color
							if (empty($this->image_background_color)) {
								imagetruecolortopalette($image_dst, true, 255);
								$transparency = imagecolorallocate($image_dst, 254, 1, 253);
								imagecolortransparent($image_dst, $transparency);
								// make the transparent areas transparent
								for ($x = 0; $x < $this->image_dst_x; $x++) {
									for ($y = 0; $y < $this->image_dst_y; $y++) {
										// we test wether we have enough opacity to justify keeping the color
										if ($mask[$x][$y] > 120) {
											imagesetpixel($image_dst, $x, $y, $transparency);
										}

									}
								}
							}
							unset($mask);
						}
						break;
					case 'jpg':
					case 'bmp':

						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;fills in transparency with default color<br />';
						list($red, $green, $blue) = $this->getcolors($this->image_default_color);
						$transparency = imagecolorallocate($image_dst, $red, $green, $blue);

						for ($x = 0; $x < $this->image_dst_x; $x++) {
							for ($y = 0; $y < $this->image_dst_y; $y++) {

								if (imageistruecolor($image_dst)) {
									$rgba = imagecolorat($image_dst, $x, $y);
									$pixel = array('red' => ($rgba >> 16) & 0xFF,
										'green' => ($rgba >> 8) & 0xFF,
										'blue' => $rgba & 0xFF,
										'alpha' => ($rgba & 0x7F000000) >> 24);
								} else {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								}
								if ($pixel['alpha'] == 127) {
									// we have full transparency. we make the pixel transparent
									imagesetpixel($image_dst, $x, $y, $transparency);
								} else if ($pixel['alpha'] > 0) {
									// we have some transparency. we combine the color with the default color
									$alpha = ($pixel['alpha'] / 127);
									$pixel['red'] = round(($pixel['red'] * (1 - $alpha) + $red * ($alpha)));
									$pixel['green'] = round(($pixel['green'] * (1 - $alpha) + $green * ($alpha)));
									$pixel['blue'] = round(($pixel['blue'] * (1 - $alpha) + $blue * ($alpha)));
									$color = imagecolorclosest($image_dst, $pixel['red'], $pixel['green'], $pixel['blue']);
									imagesetpixel($image_dst, $x, $y, $color);
								}
							}
						}

						break;
					default:
						break;
					}

					// interlace options
					if ($this->image_interlace) {
						imageinterlace($image_dst, true);
					}

					// outputs image
					$this->log .= '- saving image...<br />';
					switch ($this->image_convert) {
					case 'jpeg':
					case 'jpg':
						if (!$return_mode) {
							$result = @imagejpeg($image_dst, $this->file_dst_pathname, $this->jpeg_quality);
						} else {
							ob_start();
							$result = @imagejpeg($image_dst, null, $this->jpeg_quality);
							$return_content = ob_get_contents();
							ob_end_clean();
						}
						if (!$result) {
							$this->processed = false;
							$this->error = $this->translate('file_create', array('JPEG'));
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;JPEG image created<br />';
						}
						break;
					case 'png':
						imagealphablending($image_dst, false);
						imagesavealpha($image_dst, true);
						if (!$return_mode) {
							if (is_numeric($this->png_compression) && version_compare(PHP_VERSION, '5.1.2') >= 0) {
								$result = @imagepng($image_dst, $this->file_dst_pathname, $this->png_compression);
							} else {
								$result = @imagepng($image_dst, $this->file_dst_pathname);
							}
						} else {
							ob_start();
							if (is_numeric($this->png_compression) && version_compare(PHP_VERSION, '5.1.2') >= 0) {
								$result = @imagepng($image_dst, null, $this->png_compression);
							} else {
								$result = @imagepng($image_dst);
							}
							$return_content = ob_get_contents();
							ob_end_clean();
						}
						if (!$result) {
							$this->processed = false;
							$this->error = $this->translate('file_create', array('PNG'));
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;PNG image created<br />';
						}
						break;
					case 'gif':
						if (!$return_mode) {
							$result = @imagegif($image_dst, $this->file_dst_pathname);
						} else {
							ob_start();
							$result = @imagegif($image_dst);
							$return_content = ob_get_contents();
							ob_end_clean();
						}
						if (!$result) {
							$this->processed = false;
							$this->error = $this->translate('file_create', array('GIF'));
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;GIF image created<br />';
						}
						break;
					case 'bmp':
						if (!$return_mode) {
							$result = $this->imagebmp($image_dst, $this->file_dst_pathname);
						} else {
							ob_start();
							$result = $this->imagebmp($image_dst);
							$return_content = ob_get_contents();
							ob_end_clean();
						}
						if (!$result) {
							$this->processed = false;
							$this->error = $this->translate('file_create', array('BMP'));
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;BMP image created<br />';
						}
						break;

					default:
						$this->processed = false;
						$this->error = $this->translate('no_conversion_type');
					}
					if ($this->processed) {
						if (is_resource($image_src)) {
							imagedestroy($image_src);
						}

						if (is_resource($image_dst)) {
							imagedestroy($image_dst);
						}

						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image objects destroyed<br />';
					}
				}

			} else {
				$this->log .= '- no image processing wanted<br />';

				if (!$return_mode) {

					if (!copy($this->file_src_pathname, $this->file_dst_pathname)) {
						$this->processed = false;
						$this->error = $this->translate('copy_failed');
					}
				} else {
					$return_content = @file_get_contents($this->file_src_pathname);
					if ($return_content === FALSE) {
						$this->processed = false;
						$this->error = $this->translate('reading_failed');
					}
				}
			}
		}

		if ($this->processed) {
			$this->log .= '- <b>process OK</b><br />';
		} else {
			$this->log .= '- <b>error</b>: ' . $this->error . '<br />';
		}

		$this->init();

		if ($return_mode) {
			return $return_content;
		}

	}

	function process($server_path = null) {
		$this->error = '';
		$this->processed = true;
		$return_mode = false;
		$return_content = null;

		// clean up dst variables
		$this->file_dst_path = '';
		$this->file_dst_pathname = '';
		$this->file_dst_name = '';
		$this->file_dst_name_body = '';
		$this->file_dst_name_ext = '';

		// clean up some parameters
		$this->file_max_size = $this->getsize($this->file_max_size);
		$this->jpeg_size = $this->getsize($this->jpeg_size);

		// copy some variables as we need to keep them clean
		$file_src_name = $this->file_src_name;
		$file_src_name_body = $this->file_src_name_body;
		$file_src_name_ext = $this->file_src_name_ext;

		if (!$this->uploaded) {
			$this->error = $this->translate('file_not_uploaded');
			$this->processed = false;
		}

		if ($this->processed) {
			if (empty($server_path) || is_null($server_path)) {
				$this->log .= '<b>process file and return the content</b><br />';
				$return_mode = true;
			} else {
				if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
					if (substr($server_path, -1, 1) != '\\') {
						$server_path = $server_path . '\\';
					}

				} else {
					if (substr($server_path, -1, 1) != '/') {
						$server_path = $server_path . '/';
					}

				}
				$this->log .= '<b>process file to ' . $server_path . '</b><br />';
			}
		}

		if ($this->processed) {
			// checks file max size
			if ($this->file_src_size > $this->file_max_size) {
				$this->processed = false;
				$this->error = $this->translate('file_too_big') . ' : ' . $this->file_src_size . ' > ' . $this->file_max_size;
			} else {
				$this->log .= '- file size OK<br />';
			}
		}

		if ($this->processed) {
			// if we have an image without extension, set it
			if ($this->file_force_extension && $this->file_is_image && !$this->file_src_name_ext) {
				$file_src_name_ext = $this->image_src_type;
			}

			// turn dangerous scripts into text files
			if ($this->no_script) {
				// if the file has no extension, we try to guess it from the MIME type
				if ($this->file_force_extension && empty($file_src_name_ext)) {
					if ($key = array_search($this->file_src_mime, $this->mime_types)) {
						$file_src_name_ext = $key;
						$file_src_name = $file_src_name_body . '.' . $file_src_name_ext;
						$this->log .= '- file renamed as ' . $file_src_name_body . '.' . $file_src_name_ext . '!<br />';
					}
				}
				// if the file is text based, or has a dangerous extension, we rename it as .txt
				if ((((substr($this->file_src_mime, 0, 5) == 'text/' && $this->file_src_mime != 'text/rtf') || strpos($this->file_src_mime, 'javascript') !== false) && (substr($file_src_name, -4) != '.txt'))
					|| preg_match('/\.(php|php5|php4|php3|phtml|pl|py|cgi|asp|js)$/i', $this->file_src_name)
					|| $this->file_force_extension && empty($file_src_name_ext)) {
					$this->file_src_mime = 'text/plain';
					if ($this->file_src_name_ext) {
						$file_src_name_body = $file_src_name_body . '.' . $this->file_src_name_ext;
					}

					$file_src_name_ext = 'txt';
					$file_src_name = $file_src_name_body . '.' . $file_src_name_ext;
					$this->log .= '- script renamed as ' . $file_src_name_body . '.' . $file_src_name_ext . '!<br />';
				}
			}

			if ($this->mime_check && empty($this->file_src_mime)) {
				$this->processed = false;
				$this->error = $this->translate('no_mime');
			} else if ($this->mime_check && !empty($this->file_src_mime) && strpos($this->file_src_mime, '/') !== false) {
				list($m1, $m2) = explode('/', $this->file_src_mime);
				$allowed = false;
				// check wether the mime type is allowed
				if (!is_array($this->allowed)) {
					$this->allowed = array($this->allowed);
				}

				foreach ($this->allowed as $k => $v) {
					list($v1, $v2) = explode('/', $v);
					if (($v1 == '*' && $v2 == '*') || ($v1 == $m1 && ($v2 == $m2 || $v2 == '*'))) {
						$allowed = true;
						break;
					}
				}
				// check wether the mime type is forbidden
				if (!is_array($this->forbidden)) {
					$this->forbidden = array($this->forbidden);
				}

				foreach ($this->forbidden as $k => $v) {
					list($v1, $v2) = explode('/', $v);
					if (($v1 == '*' && $v2 == '*') || ($v1 == $m1 && ($v2 == $m2 || $v2 == '*'))) {
						$allowed = false;
						break;
					}
				}
				if (!$allowed) {
					$this->processed = false;
					$this->error = $this->translate('incorrect_file');
				} else {
					$this->log .= '- file mime OK : ' . $this->file_src_mime . '<br />';
				}
			} else {
				$this->log .= '- file mime (not checked) : ' . $this->file_src_mime . '<br />';
			}

			// if the file is an image, we can check on its dimensions
			// these checks are not available if open_basedir restrictions are in place
			if ($this->file_is_image) {
				if (is_numeric($this->image_src_x) && is_numeric($this->image_src_y)) {
					$ratio = $this->image_src_x / $this->image_src_y;
					if (!is_null($this->image_max_width) && $this->image_src_x > $this->image_max_width) {
						$this->processed = false;
						$this->error = $this->translate('image_too_wide');
					}
					if (!is_null($this->image_min_width) && $this->image_src_x < $this->image_min_width) {
						$this->processed = false;
						$this->error = $this->translate('image_too_narrow');
					}
					if (!is_null($this->image_max_height) && $this->image_src_y > $this->image_max_height) {
						$this->processed = false;
						$this->error = $this->translate('image_too_high');
					}
					if (!is_null($this->image_min_height) && $this->image_src_y < $this->image_min_height) {
						$this->processed = false;
						$this->error = $this->translate('image_too_short');
					}
					if (!is_null($this->image_max_ratio) && $ratio > $this->image_max_ratio) {
						$this->processed = false;
						$this->error = $this->translate('ratio_too_high');
					}
					if (!is_null($this->image_min_ratio) && $ratio < $this->image_min_ratio) {
						$this->processed = false;
						$this->error = $this->translate('ratio_too_low');
					}
					if (!is_null($this->image_max_pixels) && $this->image_src_pixels > $this->image_max_pixels) {
						$this->processed = false;
						$this->error = $this->translate('too_many_pixels');
					}
					if (!is_null($this->image_min_pixels) && $this->image_src_pixels < $this->image_min_pixels) {
						$this->processed = false;
						$this->error = $this->translate('not_enough_pixels');
					}
				} else {
					$this->log .= '- no image properties available, can\'t enforce dimension checks : ' . $this->file_src_mime . '<br />';
				}
			}
		}

		if ($this->processed) {
			$this->file_dst_path = $server_path;

			// repopulate dst variables from src
			$this->file_dst_name = $file_src_name;
			$this->file_dst_name_body = $file_src_name_body;
			$this->file_dst_name_ext = $file_src_name_ext;
			if ($this->file_overwrite) {
				$this->file_auto_rename = false;
			}

			if ($this->image_convert && $this->file_is_image) {
				// if we convert as an image
				if ($this->file_src_name_ext) {
					$this->file_dst_name_ext = $this->image_convert;
				}

				$this->log .= '- new file name ext : ' . $this->image_convert . '<br />';
			}
			if (!is_null($this->file_new_name_body)) {
				// rename file body
				$this->file_dst_name_body = $this->file_new_name_body;
				$this->log .= '- new file name body : ' . $this->file_new_name_body . '<br />';
			}
			if (!is_null($this->file_new_name_ext)) {
				// rename file ext
				$this->file_dst_name_ext = $this->file_new_name_ext;
				$this->log .= '- new file name ext : ' . $this->file_new_name_ext . '<br />';
			}
			if (!is_null($this->file_name_body_add)) {
				// append a string to the name
				$this->file_dst_name_body = $this->file_dst_name_body . $this->file_name_body_add;
				$this->log .= '- file name body append : ' . $this->file_name_body_add . '<br />';
			}
			if (!is_null($this->file_name_body_pre)) {
				// prepend a string to the name
				$this->file_dst_name_body = $this->file_name_body_pre . $this->file_dst_name_body;
				$this->log .= '- file name body prepend : ' . $this->file_name_body_pre . '<br />';
			}
			if ($this->file_safe_name) {
				// formats the name
				$this->file_dst_name_body = utf8_encode(strtr(utf8_decode($this->file_dst_name_body), utf8_decode('ŠŽšžŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïñòóôõöøùúûüýÿ'), 'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy'));
				$this->file_dst_name_body = strtr($this->file_dst_name_body, array('Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss', 'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u'));
				$this->file_dst_name_body = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $this->file_dst_name_body);
				$this->log .= '- file name safe format<br />';
			}

			$this->log .= '- destination variables<br />';
			if (empty($this->file_dst_path) || is_null($this->file_dst_path)) {
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_path         : n/a<br />';
			} else {
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_path         : ' . $this->file_dst_path . '<br />';
			}
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_name_body    : ' . $this->file_dst_name_body . '<br />';
			$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_name_ext     : ' . $this->file_dst_name_ext . '<br />';

			// set the destination file name
			$this->file_dst_name = $this->file_dst_name_body . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : '');

			if (!$return_mode) {
				if (!$this->file_auto_rename) {
					$this->log .= '- no auto_rename if same filename exists<br />';
					$this->file_dst_pathname = $this->file_dst_path . $this->file_dst_name;
				} else {
					$this->log .= '- checking for auto_rename<br />';
					$this->file_dst_pathname = $this->file_dst_path . $this->file_dst_name;
					$body = $this->file_dst_name_body;
					$ext = '';
					// if we have changed the extension, then we add our increment before
					if ($file_src_name_ext != $this->file_src_name_ext) {
						if (substr($this->file_dst_name_body, -1 - strlen($this->file_src_name_ext)) == '.' . $this->file_src_name_ext) {
							$body = substr($this->file_dst_name_body, 0, strlen($this->file_dst_name_body) - 1 - strlen($this->file_src_name_ext));
							$ext = '.' . $this->file_src_name_ext;
						}
					}
					$cpt = 1;
					while (@file_exists($this->file_dst_pathname)) {
						$this->file_dst_name_body = $body . '_' . $cpt . $ext;
						$this->file_dst_name = $this->file_dst_name_body . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : '');
						$cpt++;
						$this->file_dst_pathname = $this->file_dst_path . $this->file_dst_name;
					}
					if ($cpt > 1) {
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;auto_rename to ' . $this->file_dst_name . '<br />';
					}

				}

				$this->log .= '- destination file details<br />';
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_name         : ' . $this->file_dst_name . '<br />';
				$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;file_dst_pathname     : ' . $this->file_dst_pathname . '<br />';

				if ($this->file_overwrite) {
					$this->log .= '- no overwrite checking<br />';
				} else {
					if (@file_exists($this->file_dst_pathname)) {
						$this->processed = false;
						$this->error = $this->translate('already_exists', array($this->file_dst_name));
					} else {
						$this->log .= '- ' . $this->file_dst_name . ' doesn\'t exist already<br />';
					}
				}
			}
		}

		if ($this->processed) {
			// if we have already moved the uploaded file, we use the temporary copy as source file, and check if it exists
			if (!empty($this->file_src_temp)) {
				$this->log .= '- use the temp file instead of the original file since it is a second process<br />';
				$this->file_src_pathname = $this->file_src_temp;
				if (!file_exists($this->file_src_pathname)) {
					$this->processed = false;
					$this->error = $this->translate('temp_file_missing');
				}
				// if we haven't a temp file, and that we do check on uploads, we use is_uploaded_file()
			} else if (!$this->no_upload_check) {
				if (!is_uploaded_file($this->file_src_pathname)) {
					$this->processed = false;
					$this->error = $this->translate('source_missing');
				}
				// otherwise, if we don't check on uploaded files (local file for instance), we use file_exists()
			} else {
				if (!file_exists($this->file_src_pathname)) {
					$this->processed = false;
					$this->error = $this->translate('source_missing');
				}
			}

			// checks if the destination directory exists, and attempt to create it
			if (!$return_mode) {
				if ($this->processed && !file_exists($this->file_dst_path)) {
					if ($this->dir_auto_create) {
						$this->log .= '- ' . $this->file_dst_path . ' doesn\'t exist. Attempting creation:';
						if (!$this->rmkdir($this->file_dst_path, $this->dir_chmod)) {
							$this->log .= ' failed<br />';
							$this->processed = false;
							$this->error = $this->translate('destination_dir');
						} else {
							$this->log .= ' success<br />';
						}
					} else {
						$this->error = $this->translate('destination_dir_missing');
					}
				}

				if ($this->processed && !is_dir($this->file_dst_path)) {
					$this->processed = false;
					$this->error = $this->translate('destination_path_not_dir');
				}

				// checks if the destination directory is writeable, and attempt to make it writeable
				$hash = md5($this->file_dst_name_body . rand(1, 1000));
				if ($this->processed && !($f = @fopen($this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''), 'a+'))) {
					if ($this->dir_auto_chmod) {
						$this->log .= '- ' . $this->file_dst_path . ' is not writeable. Attempting chmod:';
						if (!@chmod($this->file_dst_path, $this->dir_chmod)) {
							$this->log .= ' failed<br />';
							$this->processed = false;
							$this->error = $this->translate('destination_dir_write');
						} else {
							$this->log .= ' success<br />';
							if (!($f = @fopen($this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''), 'a+'))) {
								// we re-check
								$this->processed = false;
								$this->error = $this->translate('destination_dir_write');
							} else {
								@fclose($f);
							}
						}
					} else {
						$this->processed = false;
						$this->error = $this->translate('destination_path_write');
					}
				} else {
					if ($this->processed) {
						@fclose($f);
					}

					@unlink($this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''));
				}

				// if we have an uploaded file, and if it is the first process, and if we can't access the file directly (open_basedir restriction)
				// then we create a temp file that will be used as the source file in subsequent processes
				// the third condition is there to check if the file is not accessible *directly* (it already has positively gone through is_uploaded_file(), so it exists)
				if (!$this->no_upload_check && empty($this->file_src_temp) && !@file_exists($this->file_src_pathname)) {
					$this->log .= '- attempting to use a temp file:';
					$hash = md5($this->file_dst_name_body . rand(1, 1000));
					if (move_uploaded_file($this->file_src_pathname, $this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : ''))) {
						$this->file_src_pathname = $this->file_dst_path . $hash . (!empty($this->file_dst_name_ext) ? '.' . $this->file_dst_name_ext : '');
						$this->file_src_temp = $this->file_src_pathname;
						$this->log .= ' file created<br />';
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;temp file is: ' . $this->file_src_temp . '<br />';
					} else {
						$this->log .= ' failed<br />';
						$this->processed = false;
						$this->error = $this->translate('temp_file');
					}
				}
			}
		}

		if ($this->processed) {

			// check if we need to autorotate, to automatically pre-rotates the image according to EXIF data (JPEG only)
			$auto_flip = false;
			$auto_rotate = 0;
			if ($this->file_is_image && $this->image_auto_rotate && $this->image_src_type == 'jpg' && $this->function_enabled('exif_read_data')) {
				$exif = @exif_read_data($this->file_src_pathname);
				if (is_array($exif) && isset($exif['Orientation'])) {
					$orientation = $exif['Orientation'];
					switch ($orientation) {
					case 1:
						$this->log .= '- EXIF orientation = 1 : default<br />';
						break;
					case 2:
						$auto_flip = 'v';
						$this->log .= '- EXIF orientation = 2 : vertical flip<br />';
						break;
					case 3:
						$auto_rotate = 180;
						$this->log .= '- EXIF orientation = 3 : 180 rotate left<br />';
						break;
					case 4:
						$auto_flip = 'h';
						$this->log .= '- EXIF orientation = 4 : horizontal flip<br />';
						break;
					case 5:
						$auto_flip = 'h';
						$auto_rotate = 90;
						$this->log .= '- EXIF orientation = 5 : horizontal flip + 90 rotate right<br />';
						break;
					case 6:
						$auto_rotate = 90;
						$this->log .= '- EXIF orientation = 6 : 90 rotate right<br />';
						break;
					case 7:
						$auto_flip = 'v';
						$auto_rotate = 90;
						$this->log .= '- EXIF orientation = 7 : vertical flip + 90 rotate right<br />';
						break;
					case 8:
						$auto_rotate = 270;
						$this->log .= '- EXIF orientation = 8 : 90 rotate left<br />';
						break;
					default:
						$this->log .= '- EXIF orientation = ' . $orientation . ' : unknown<br />';
						break;
					}
				} else {
					$this->log .= '- EXIF data is invalid or missing<br />';
				}
			} else {
				if (!$this->image_auto_rotate) {
					$this->log .= '- auto-rotate deactivated<br />';
				} else if (!$this->image_src_type == 'jpg') {
					$this->log .= '- auto-rotate applies only to JPEG images<br />';
				} else if (!$this->function_enabled('exif_read_data')) {
					$this->log .= '- auto-rotate requires function exif_read_data to be enabled<br />';
				}
			}

			// do we do some image manipulation?
			$image_manipulation = ($this->file_is_image && (
				$this->image_resize
				|| $this->image_convert != ''
				|| is_numeric($this->image_brightness)
				|| is_numeric($this->image_contrast)
				|| is_numeric($this->image_opacity)
				|| is_numeric($this->image_threshold)
				|| !empty($this->image_tint_color)
				|| !empty($this->image_overlay_color)
				|| $this->image_pixelate
				|| $this->image_unsharp
				|| !empty($this->image_text)
				|| $this->image_greyscale
				|| $this->image_negative
				|| !empty($this->image_watermark)
				|| $auto_rotate || $auto_flip
				|| is_numeric($this->image_rotate)
				|| is_numeric($this->jpeg_size)
				|| !empty($this->image_flip)
				|| !empty($this->image_crop)
				|| !empty($this->image_precrop)
				|| !empty($this->image_border)
				|| !empty($this->image_border_transparent)
				|| $this->image_frame > 0
				|| $this->image_bevel > 0
				|| $this->image_reflection_height));

			// we do a quick check to ensure the file is really an image
			// we can do this only now, as it would have failed before in case of open_basedir
			if ($image_manipulation && !@getimagesize($this->file_src_pathname)) {
				$this->log .= '- the file is not an image!<br />';
				$image_manipulation = false;
			}

			if ($image_manipulation) {

				// make sure GD doesn't complain too much
				@ini_set("gd.jpeg_ignore_warning", 1);

				// checks if the source file is readable
				if ($this->processed && !($f = @fopen($this->file_src_pathname, 'r'))) {
					$this->processed = false;
					$this->error = $this->translate('source_not_readable');
				} else {
					@fclose($f);
				}

				// we now do all the image manipulations
				$this->log .= '- image resizing or conversion wanted<br />';
				if ($this->gdversion()) {
					switch ($this->image_src_type) {
					case 'jpg':
						if (!$this->function_enabled('imagecreatefromjpeg')) {
							$this->processed = false;
							$this->error = $this->translate('no_create_support', array('JPEG'));
						} else {
							$image_src = @imagecreatefromjpeg($this->file_src_pathname);
							if (!$image_src) {
								$this->processed = false;
								$this->error = $this->translate('create_error', array('JPEG'));
							} else {
								$this->log .= '- source image is JPEG<br />';
							}
						}
						break;
					case 'png':
						if (!$this->function_enabled('imagecreatefrompng')) {
							$this->processed = false;
							$this->error = $this->translate('no_create_support', array('PNG'));
						} else {
							$image_src = @imagecreatefrompng($this->file_src_pathname);
							if (!$image_src) {
								$this->processed = false;
								$this->error = $this->translate('create_error', array('PNG'));
							} else {
								$this->log .= '- source image is PNG<br />';
							}
						}
						break;
					case 'gif':
						if (!$this->function_enabled('imagecreatefromgif')) {
							$this->processed = false;
							$this->error = $this->translate('no_create_support', array('GIF'));
						} else {
							$image_src = @imagecreatefromgif($this->file_src_pathname);
							if (!$image_src) {
								$this->processed = false;
								$this->error = $this->translate('create_error', array('GIF'));
							} else {
								$this->log .= '- source image is GIF<br />';
							}
						}
						break;
					case 'bmp':
						if (!method_exists($this, 'imagecreatefrombmp')) {
							$this->processed = false;
							$this->error = $this->translate('no_create_support', array('BMP'));
						} else {
							$image_src = @$this->imagecreatefrombmp($this->file_src_pathname);
							if (!$image_src) {
								$this->processed = false;
								$this->error = $this->translate('create_error', array('BMP'));
							} else {
								$this->log .= '- source image is BMP<br />';
							}
						}
						break;
					default:
						$this->processed = false;
						$this->error = $this->translate('source_invalid');
					}
				} else {
					$this->processed = false;
					$this->error = $this->translate('gd_missing');
				}

				if ($this->processed && $image_src) {

					// we have to set image_convert if it is not already
					if (empty($this->image_convert)) {
						$this->log .= '- setting destination file type to ' . $this->image_src_type . '<br />';
						$this->image_convert = $this->image_src_type;
					}

					if (!in_array($this->image_convert, $this->image_supported)) {
						$this->image_convert = 'jpg';
					}

					// we set the default color to be the background color if we don't output in a transparent format
					if ($this->image_convert != 'png' && $this->image_convert != 'gif' && !empty($this->image_default_color) && empty($this->image_background_color)) {
						$this->image_background_color = $this->image_default_color;
					}

					if (!empty($this->image_background_color)) {
						$this->image_default_color = $this->image_background_color;
					}

					if (empty($this->image_default_color)) {
						$this->image_default_color = '#FFFFFF';
					}

					$this->image_src_x = imagesx($image_src);
					$this->image_src_y = imagesy($image_src);
					$gd_version = $this->gdversion();
					$ratio_crop = null;

					if (!imageistruecolor($image_src)) {
						// $this->image_src_type == 'gif'
						$this->log .= '- image is detected as having a palette<br />';
						$this->image_is_palette = true;
						$this->image_transparent_color = imagecolortransparent($image_src);
						if ($this->image_transparent_color >= 0 && imagecolorstotal($image_src) > $this->image_transparent_color) {
							$this->image_is_transparent = true;
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;palette image is detected as transparent<br />';
						}
						// if the image has a palette (GIF), we convert it to true color, preserving transparency
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;convert palette image to true color<br />';
						$true_color = imagecreatetruecolor($this->image_src_x, $this->image_src_y);
						imagealphablending($true_color, false);
						imagesavealpha($true_color, true);
						for ($x = 0; $x < $this->image_src_x; $x++) {
							for ($y = 0; $y < $this->image_src_y; $y++) {
								if ($this->image_transparent_color >= 0 && imagecolorat($image_src, $x, $y) == $this->image_transparent_color) {
									imagesetpixel($true_color, $x, $y, 127 << 24);
								} else {
									$rgb = imagecolorsforindex($image_src, imagecolorat($image_src, $x, $y));
									imagesetpixel($true_color, $x, $y, ($rgb['alpha'] << 24) | ($rgb['red'] << 16) | ($rgb['green'] << 8) | $rgb['blue']);
								}
							}
						}
						$image_src = $this->imagetransfer($true_color, $image_src);
						imagealphablending($image_src, false);
						imagesavealpha($image_src, true);
						$this->image_is_palette = false;
					}

					$image_dst = &$image_src;

					// auto-flip image, according to EXIF data (JPEG only)
					if ($gd_version >= 2 && !empty($auto_flip)) {
						$this->log .= '- auto-flip image : ' . ($auto_flip == 'v' ? 'vertical' : 'horizontal') . '<br />';
						$tmp = $this->imagecreatenew($this->image_src_x, $this->image_src_y);
						for ($x = 0; $x < $this->image_src_x; $x++) {
							for ($y = 0; $y < $this->image_src_y; $y++) {
								if (strpos($auto_flip, 'v') !== false) {
									imagecopy($tmp, $image_dst, $this->image_src_x - $x - 1, $y, $x, $y, 1, 1);
								} else {
									imagecopy($tmp, $image_dst, $x, $this->image_src_y - $y - 1, $x, $y, 1, 1);
								}
							}
						}
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// auto-rotate image, according to EXIF data (JPEG only)
					if ($gd_version >= 2 && is_numeric($auto_rotate)) {
						if (!in_array($auto_rotate, array(0, 90, 180, 270))) {
							$auto_rotate = 0;
						}

						if ($auto_rotate != 0) {
							if ($auto_rotate == 90 || $auto_rotate == 270) {
								$tmp = $this->imagecreatenew($this->image_src_y, $this->image_src_x);
							} else {
								$tmp = $this->imagecreatenew($this->image_src_x, $this->image_src_y);
							}
							$this->log .= '- auto-rotate image : ' . $auto_rotate . '<br />';
							for ($x = 0; $x < $this->image_src_x; $x++) {
								for ($y = 0; $y < $this->image_src_y; $y++) {
									if ($auto_rotate == 90) {
										imagecopy($tmp, $image_dst, $y, $x, $x, $this->image_src_y - $y - 1, 1, 1);
									} else if ($auto_rotate == 180) {
										imagecopy($tmp, $image_dst, $x, $y, $this->image_src_x - $x - 1, $this->image_src_y - $y - 1, 1, 1);
									} else if ($auto_rotate == 270) {
										imagecopy($tmp, $image_dst, $y, $x, $this->image_src_x - $x - 1, $y, 1, 1);
									} else {
										imagecopy($tmp, $image_dst, $x, $y, $x, $y, 1, 1);
									}
								}
							}
							if ($auto_rotate == 90 || $auto_rotate == 270) {
								$t = $this->image_src_y;
								$this->image_src_y = $this->image_src_x;
								$this->image_src_x = $t;
							}
							// we transfert tmp into image_dst
							$image_dst = $this->imagetransfer($tmp, $image_dst);
						}
					}

					// pre-crop image, before resizing
					if ((!empty($this->image_precrop))) {
						list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_precrop, $this->image_src_x, $this->image_src_y, true, true);
						$this->log .= '- pre-crop image : ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . ' <br />';
						$this->image_src_x = $this->image_src_x - $cl - $cr;
						$this->image_src_y = $this->image_src_y - $ct - $cb;
						if ($this->image_src_x < 1) {
							$this->image_src_x = 1;
						}

						if ($this->image_src_y < 1) {
							$this->image_src_y = 1;
						}

						$tmp = $this->imagecreatenew($this->image_src_x, $this->image_src_y);

						// we copy the image into the recieving image
						imagecopy($tmp, $image_dst, 0, 0, $cl, $ct, $this->image_src_x, $this->image_src_y);

						// if we crop with negative margins, we have to make sure the extra bits are the right color, or transparent
						if ($ct < 0 || $cr < 0 || $cb < 0 || $cl < 0) {
							// use the background color if present
							if (!empty($this->image_background_color)) {
								list($red, $green, $blue) = $this->getcolors($this->image_background_color);
								$fill = imagecolorallocate($tmp, $red, $green, $blue);
							} else {
								$fill = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
							}
							// fills eventual negative margins
							if ($ct < 0) {
								imagefilledrectangle($tmp, 0, 0, $this->image_src_x, -$ct, $fill);
							}

							if ($cr < 0) {
								imagefilledrectangle($tmp, $this->image_src_x + $cr, 0, $this->image_src_x, $this->image_src_y, $fill);
							}

							if ($cb < 0) {
								imagefilledrectangle($tmp, 0, $this->image_src_y + $cb, $this->image_src_x, $this->image_src_y, $fill);
							}

							if ($cl < 0) {
								imagefilledrectangle($tmp, 0, 0, -$cl, $this->image_src_y, $fill);
							}

						}

						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// resize image (and move image_src_x, image_src_y dimensions into image_dst_x, image_dst_y)
					if ($this->image_resize) {
						$this->log .= '- resizing...<br />';
						$this->image_dst_x = $this->image_x;
						$this->image_dst_y = $this->image_y;

						// backward compatibility for soon to be deprecated settings
						if ($this->image_ratio_no_zoom_in) {
							$this->image_ratio = true;
							$this->image_no_enlarging = true;
						} else if ($this->image_ratio_no_zoom_out) {
							$this->image_ratio = true;
							$this->image_no_shrinking = true;
						}

						// keeps aspect ratio with x calculated from y
						if ($this->image_ratio_x) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;calculate x size<br />';
							$this->image_dst_x = round(($this->image_src_x * $this->image_y) / $this->image_src_y);
							$this->image_dst_y = $this->image_y;

							// keeps aspect ratio with y calculated from x
						} else if ($this->image_ratio_y) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;calculate y size<br />';
							$this->image_dst_x = $this->image_x;
							$this->image_dst_y = round(($this->image_src_y * $this->image_x) / $this->image_src_x);

							// keeps aspect ratio, calculating x and y so that the image is approx the set number of pixels
						} else if (is_numeric($this->image_ratio_pixels)) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;calculate x/y size to match a number of pixels<br />';
							$pixels = $this->image_src_y * $this->image_src_x;
							$diff = sqrt($this->image_ratio_pixels / $pixels);
							$this->image_dst_x = round($this->image_src_x * $diff);
							$this->image_dst_y = round($this->image_src_y * $diff);

							// keeps aspect ratio with x and y dimensions, filling the space
						} else if ($this->image_ratio_crop) {
							if (!is_string($this->image_ratio_crop)) {
								$this->image_ratio_crop = '';
							}

							$this->image_ratio_crop = strtolower($this->image_ratio_crop);
							if (($this->image_src_x / $this->image_x) > ($this->image_src_y / $this->image_y)) {
								$this->image_dst_y = $this->image_y;
								$this->image_dst_x = intval($this->image_src_x * ($this->image_y / $this->image_src_y));
								$ratio_crop = array();
								$ratio_crop['x'] = $this->image_dst_x - $this->image_x;
								if (strpos($this->image_ratio_crop, 'l') !== false) {
									$ratio_crop['l'] = 0;
									$ratio_crop['r'] = $ratio_crop['x'];
								} else if (strpos($this->image_ratio_crop, 'r') !== false) {
									$ratio_crop['l'] = $ratio_crop['x'];
									$ratio_crop['r'] = 0;
								} else {
									$ratio_crop['l'] = round($ratio_crop['x'] / 2);
									$ratio_crop['r'] = $ratio_crop['x'] - $ratio_crop['l'];
								}
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_crop_x         : ' . $ratio_crop['x'] . ' (' . $ratio_crop['l'] . ';' . $ratio_crop['r'] . ')<br />';
								if (is_null($this->image_crop)) {
									$this->image_crop = array(0, 0, 0, 0);
								}

							} else {
								$this->image_dst_x = $this->image_x;
								$this->image_dst_y = intval($this->image_src_y * ($this->image_x / $this->image_src_x));
								$ratio_crop = array();
								$ratio_crop['y'] = $this->image_dst_y - $this->image_y;
								if (strpos($this->image_ratio_crop, 't') !== false) {
									$ratio_crop['t'] = 0;
									$ratio_crop['b'] = $ratio_crop['y'];
								} else if (strpos($this->image_ratio_crop, 'b') !== false) {
									$ratio_crop['t'] = $ratio_crop['y'];
									$ratio_crop['b'] = 0;
								} else {
									$ratio_crop['t'] = round($ratio_crop['y'] / 2);
									$ratio_crop['b'] = $ratio_crop['y'] - $ratio_crop['t'];
								}
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_crop_y         : ' . $ratio_crop['y'] . ' (' . $ratio_crop['t'] . ';' . $ratio_crop['b'] . ')<br />';
								if (is_null($this->image_crop)) {
									$this->image_crop = array(0, 0, 0, 0);
								}

							}

							// keeps aspect ratio with x and y dimensions, fitting the image in the space, and coloring the rest
						} else if ($this->image_ratio_fill) {
							if (!is_string($this->image_ratio_fill)) {
								$this->image_ratio_fill = '';
							}

							$this->image_ratio_fill = strtolower($this->image_ratio_fill);
							if (($this->image_src_x / $this->image_x) < ($this->image_src_y / $this->image_y)) {
								$this->image_dst_y = $this->image_y;
								$this->image_dst_x = intval($this->image_src_x * ($this->image_y / $this->image_src_y));
								$ratio_crop = array();
								$ratio_crop['x'] = $this->image_dst_x - $this->image_x;
								if (strpos($this->image_ratio_fill, 'l') !== false) {
									$ratio_crop['l'] = 0;
									$ratio_crop['r'] = $ratio_crop['x'];
								} else if (strpos($this->image_ratio_fill, 'r') !== false) {
									$ratio_crop['l'] = $ratio_crop['x'];
									$ratio_crop['r'] = 0;
								} else {
									$ratio_crop['l'] = round($ratio_crop['x'] / 2);
									$ratio_crop['r'] = $ratio_crop['x'] - $ratio_crop['l'];
								}
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_fill_x         : ' . $ratio_crop['x'] . ' (' . $ratio_crop['l'] . ';' . $ratio_crop['r'] . ')<br />';
								if (is_null($this->image_crop)) {
									$this->image_crop = array(0, 0, 0, 0);
								}

							} else {
								$this->image_dst_x = $this->image_x;
								$this->image_dst_y = intval($this->image_src_y * ($this->image_x / $this->image_src_x));
								$ratio_crop = array();
								$ratio_crop['y'] = $this->image_dst_y - $this->image_y;
								if (strpos($this->image_ratio_fill, 't') !== false) {
									$ratio_crop['t'] = 0;
									$ratio_crop['b'] = $ratio_crop['y'];
								} else if (strpos($this->image_ratio_fill, 'b') !== false) {
									$ratio_crop['t'] = $ratio_crop['y'];
									$ratio_crop['b'] = 0;
								} else {
									$ratio_crop['t'] = round($ratio_crop['y'] / 2);
									$ratio_crop['b'] = $ratio_crop['y'] - $ratio_crop['t'];
								}
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;ratio_fill_y         : ' . $ratio_crop['y'] . ' (' . $ratio_crop['t'] . ';' . $ratio_crop['b'] . ')<br />';
								if (is_null($this->image_crop)) {
									$this->image_crop = array(0, 0, 0, 0);
								}

							}

							// keeps aspect ratio with x and y dimensions
						} else if ($this->image_ratio) {
							if (($this->image_src_x / $this->image_x) > ($this->image_src_y / $this->image_y)) {
								$this->image_dst_x = $this->image_x;
								$this->image_dst_y = intval($this->image_src_y * ($this->image_x / $this->image_src_x));
							} else {
								$this->image_dst_y = $this->image_y;
								$this->image_dst_x = intval($this->image_src_x * ($this->image_y / $this->image_src_y));
							}

							// resize to provided exact dimensions
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;use plain sizes<br />';
							$this->image_dst_x = $this->image_x;
							$this->image_dst_y = $this->image_y;
						}

						if ($this->image_dst_x < 1) {
							$this->image_dst_x = 1;
						}

						if ($this->image_dst_y < 1) {
							$this->image_dst_y = 1;
						}

						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_src_x y        : ' . $this->image_src_x . ' x ' . $this->image_src_y . '<br />';
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image_dst_x y        : ' . $this->image_dst_x . ' x ' . $this->image_dst_y . '<br />';

						// make sure we don't enlarge the image if we don't want to
						if ($this->image_no_enlarging && ($this->image_src_x < $this->image_dst_x || $this->image_src_y < $this->image_dst_y)) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;cancel resizing, as it would enlarge the image!<br />';
							$this->image_dst_x = $this->image_src_x;
							$this->image_dst_y = $this->image_src_y;
						}

						// make sure we don't shrink the image if we don't want to
						if ($this->image_no_shrinking && ($this->image_src_x > $this->image_dst_x || $this->image_src_y > $this->image_dst_y)) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;cancel resizing, as it would shrink the image!<br />';
							$this->image_dst_x = $this->image_src_x;
							$this->image_dst_y = $this->image_src_y;
						}

						// resize the image
						if ($this->image_dst_x != $this->image_src_x && $this->image_dst_y != $this->image_src_y) {
							$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);

							if ($gd_version >= 2) {
								$res = imagecopyresampled($tmp, $image_src, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, $this->image_src_x, $this->image_src_y);
							} else {
								$res = imagecopyresized($tmp, $image_src, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, $this->image_src_x, $this->image_src_y);
							}

							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;resized image object created<br />';
							// we transfert tmp into image_dst
							$image_dst = $this->imagetransfer($tmp, $image_dst);
						}

					} else {
						$this->image_dst_x = $this->image_src_x;
						$this->image_dst_y = $this->image_src_y;
					}

					// crop image (and also crops if image_ratio_crop is used)
					if ((!empty($this->image_crop) || !is_null($ratio_crop))) {
						list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_crop, $this->image_dst_x, $this->image_dst_y, true, true);
						// we adjust the cropping if we use image_ratio_crop
						if (!is_null($ratio_crop)) {
							if (array_key_exists('t', $ratio_crop)) {
								$ct += $ratio_crop['t'];
							}

							if (array_key_exists('r', $ratio_crop)) {
								$cr += $ratio_crop['r'];
							}

							if (array_key_exists('b', $ratio_crop)) {
								$cb += $ratio_crop['b'];
							}

							if (array_key_exists('l', $ratio_crop)) {
								$cl += $ratio_crop['l'];
							}

						}
						$this->log .= '- crop image : ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . ' <br />';
						$this->image_dst_x = $this->image_dst_x - $cl - $cr;
						$this->image_dst_y = $this->image_dst_y - $ct - $cb;
						if ($this->image_dst_x < 1) {
							$this->image_dst_x = 1;
						}

						if ($this->image_dst_y < 1) {
							$this->image_dst_y = 1;
						}

						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);

						// we copy the image into the recieving image
						imagecopy($tmp, $image_dst, 0, 0, $cl, $ct, $this->image_dst_x, $this->image_dst_y);

						// if we crop with negative margins, we have to make sure the extra bits are the right color, or transparent
						if ($ct < 0 || $cr < 0 || $cb < 0 || $cl < 0) {
							// use the background color if present
							if (!empty($this->image_background_color)) {
								list($red, $green, $blue) = $this->getcolors($this->image_background_color);
								$fill = imagecolorallocate($tmp, $red, $green, $blue);
							} else {
								$fill = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
							}
							// fills eventual negative margins
							if ($ct < 0) {
								imagefilledrectangle($tmp, 0, 0, $this->image_dst_x, -$ct - 1, $fill);
							}

							if ($cr < 0) {
								imagefilledrectangle($tmp, $this->image_dst_x + $cr, 0, $this->image_dst_x, $this->image_dst_y, $fill);
							}

							if ($cb < 0) {
								imagefilledrectangle($tmp, 0, $this->image_dst_y + $cb, $this->image_dst_x, $this->image_dst_y, $fill);
							}

							if ($cl < 0) {
								imagefilledrectangle($tmp, 0, 0, -$cl - 1, $this->image_dst_y, $fill);
							}

						}

						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// flip image
					if ($gd_version >= 2 && !empty($this->image_flip)) {
						$this->image_flip = strtolower($this->image_flip);
						$this->log .= '- flip image : ' . $this->image_flip . '<br />';
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						for ($x = 0; $x < $this->image_dst_x; $x++) {
							for ($y = 0; $y < $this->image_dst_y; $y++) {
								if (strpos($this->image_flip, 'v') !== false) {
									imagecopy($tmp, $image_dst, $this->image_dst_x - $x - 1, $y, $x, $y, 1, 1);
								} else {
									imagecopy($tmp, $image_dst, $x, $this->image_dst_y - $y - 1, $x, $y, 1, 1);
								}
							}
						}
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// rotate image
					if ($gd_version >= 2 && is_numeric($this->image_rotate)) {
						if (!in_array($this->image_rotate, array(0, 90, 180, 270))) {
							$this->image_rotate = 0;
						}

						if ($this->image_rotate != 0) {
							if ($this->image_rotate == 90 || $this->image_rotate == 270) {
								$tmp = $this->imagecreatenew($this->image_dst_y, $this->image_dst_x);
							} else {
								$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
							}
							$this->log .= '- rotate image : ' . $this->image_rotate . '<br />';
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								for ($y = 0; $y < $this->image_dst_y; $y++) {
									if ($this->image_rotate == 90) {
										imagecopy($tmp, $image_dst, $y, $x, $x, $this->image_dst_y - $y - 1, 1, 1);
									} else if ($this->image_rotate == 180) {
										imagecopy($tmp, $image_dst, $x, $y, $this->image_dst_x - $x - 1, $this->image_dst_y - $y - 1, 1, 1);
									} else if ($this->image_rotate == 270) {
										imagecopy($tmp, $image_dst, $y, $x, $this->image_dst_x - $x - 1, $y, 1, 1);
									} else {
										imagecopy($tmp, $image_dst, $x, $y, $x, $y, 1, 1);
									}
								}
							}
							if ($this->image_rotate == 90 || $this->image_rotate == 270) {
								$t = $this->image_dst_y;
								$this->image_dst_y = $this->image_dst_x;
								$this->image_dst_x = $t;
							}
							// we transfert tmp into image_dst
							$image_dst = $this->imagetransfer($tmp, $image_dst);
						}
					}

					// pixelate image
					if ((is_numeric($this->image_pixelate) && $this->image_pixelate > 0)) {
						$this->log .= '- pixelate image (' . $this->image_pixelate . 'px)<br />';
						$filter = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						if ($gd_version >= 2) {
							imagecopyresampled($filter, $image_dst, 0, 0, 0, 0, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate), $this->image_dst_x, $this->image_dst_y);
							imagecopyresampled($image_dst, $filter, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate));
						} else {
							imagecopyresized($filter, $image_dst, 0, 0, 0, 0, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate), $this->image_dst_x, $this->image_dst_y);
							imagecopyresized($image_dst, $filter, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, round($this->image_dst_x / $this->image_pixelate), round($this->image_dst_y / $this->image_pixelate));
						}
						imagedestroy($filter);
					}

					// unsharp mask
					if ($gd_version >= 2 && $this->image_unsharp && is_numeric($this->image_unsharp_amount) && is_numeric($this->image_unsharp_radius) && is_numeric($this->image_unsharp_threshold)) {
						// Unsharp Mask for PHP - version 2.1.1
						// Unsharp mask algorithm by Torstein Hønsi 2003-07.
						// Used with permission
						// Modified to support alpha transparency
						if ($this->image_unsharp_amount > 500) {
							$this->image_unsharp_amount = 500;
						}

						$this->image_unsharp_amount = $this->image_unsharp_amount * 0.016;
						if ($this->image_unsharp_radius > 50) {
							$this->image_unsharp_radius = 50;
						}

						$this->image_unsharp_radius = $this->image_unsharp_radius * 2;
						if ($this->image_unsharp_threshold > 255) {
							$this->image_unsharp_threshold = 255;
						}

						$this->image_unsharp_radius = abs(round($this->image_unsharp_radius));
						if ($this->image_unsharp_radius != 0) {
							$this->image_dst_x = imagesx($image_dst);
							$this->image_dst_y = imagesy($image_dst);
							$canvas = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y, false, true);
							$blur = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y, false, true);
							if ($this->function_enabled('imageconvolution')) {
								// PHP >= 5.1
								$matrix = array(array(1, 2, 1), array(2, 4, 2), array(1, 2, 1));
								imagecopy($blur, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y);
								imageconvolution($blur, $matrix, 16, 0);
							} else {
								for ($i = 0; $i < $this->image_unsharp_radius; $i++) {
									imagecopy($blur, $image_dst, 0, 0, 1, 0, $this->image_dst_x - 1, $this->image_dst_y); // left
									$this->imagecopymergealpha($blur, $image_dst, 1, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, 50); // right
									$this->imagecopymergealpha($blur, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, 50); // center
									imagecopy($canvas, $blur, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y);
									$this->imagecopymergealpha($blur, $canvas, 0, 0, 0, 1, $this->image_dst_x, $this->image_dst_y - 1, 33.33333); // up
									$this->imagecopymergealpha($blur, $canvas, 0, 1, 0, 0, $this->image_dst_x, $this->image_dst_y, 25); // down
								}
							}
							$p_new = array();
							if ($this->image_unsharp_threshold > 0) {
								for ($x = 0; $x < $this->image_dst_x - 1; $x++) {
									for ($y = 0; $y < $this->image_dst_y; $y++) {
										$p_orig = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
										$p_blur = imagecolorsforindex($blur, imagecolorat($blur, $x, $y));
										$p_new['red'] = (abs($p_orig['red'] - $p_blur['red']) >= $this->image_unsharp_threshold) ? max(0, min(255, ($this->image_unsharp_amount * ($p_orig['red'] - $p_blur['red'])) + $p_orig['red'])) : $p_orig['red'];
										$p_new['green'] = (abs($p_orig['green'] - $p_blur['green']) >= $this->image_unsharp_threshold) ? max(0, min(255, ($this->image_unsharp_amount * ($p_orig['green'] - $p_blur['green'])) + $p_orig['green'])) : $p_orig['green'];
										$p_new['blue'] = (abs($p_orig['blue'] - $p_blur['blue']) >= $this->image_unsharp_threshold) ? max(0, min(255, ($this->image_unsharp_amount * ($p_orig['blue'] - $p_blur['blue'])) + $p_orig['blue'])) : $p_orig['blue'];
										if (($p_orig['red'] != $p_new['red']) || ($p_orig['green'] != $p_new['green']) || ($p_orig['blue'] != $p_new['blue'])) {
											$color = imagecolorallocatealpha($image_dst, $p_new['red'], $p_new['green'], $p_new['blue'], $p_orig['alpha']);
											imagesetpixel($image_dst, $x, $y, $color);
										}
									}
								}
							} else {
								for ($x = 0; $x < $this->image_dst_x; $x++) {
									for ($y = 0; $y < $this->image_dst_y; $y++) {
										$p_orig = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
										$p_blur = imagecolorsforindex($blur, imagecolorat($blur, $x, $y));
										$p_new['red'] = ($this->image_unsharp_amount * ($p_orig['red'] - $p_blur['red'])) + $p_orig['red'];
										if ($p_new['red'] > 255) {$p_new['red'] = 255;} elseif ($p_new['red'] < 0) {$p_new['red'] = 0;}
										$p_new['green'] = ($this->image_unsharp_amount * ($p_orig['green'] - $p_blur['green'])) + $p_orig['green'];
										if ($p_new['green'] > 255) {$p_new['green'] = 255;} elseif ($p_new['green'] < 0) {$p_new['green'] = 0;}
										$p_new['blue'] = ($this->image_unsharp_amount * ($p_orig['blue'] - $p_blur['blue'])) + $p_orig['blue'];
										if ($p_new['blue'] > 255) {$p_new['blue'] = 255;} elseif ($p_new['blue'] < 0) {$p_new['blue'] = 0;}
										$color = imagecolorallocatealpha($image_dst, $p_new['red'], $p_new['green'], $p_new['blue'], $p_orig['alpha']);
										imagesetpixel($image_dst, $x, $y, $color);
									}
								}
							}
							imagedestroy($canvas);
							imagedestroy($blur);
						}
					}

					// add color overlay
					if ($gd_version >= 2 && (is_numeric($this->image_overlay_opacity) && $this->image_overlay_opacity > 0 && !empty($this->image_overlay_color))) {
						$this->log .= '- apply color overlay<br />';
						list($red, $green, $blue) = $this->getcolors($this->image_overlay_color);
						$filter = imagecreatetruecolor($this->image_dst_x, $this->image_dst_y);
						$color = imagecolorallocate($filter, $red, $green, $blue);
						imagefilledrectangle($filter, 0, 0, $this->image_dst_x, $this->image_dst_y, $color);
						$this->imagecopymergealpha($image_dst, $filter, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y, $this->image_overlay_opacity);
						imagedestroy($filter);
					}

					// add brightness, contrast and tint, turns to greyscale and inverts colors
					if ($gd_version >= 2 && ($this->image_negative || $this->image_greyscale || is_numeric($this->image_threshold) || is_numeric($this->image_brightness) || is_numeric($this->image_contrast) || !empty($this->image_tint_color))) {
						$this->log .= '- apply tint, light, contrast correction, negative, greyscale and threshold<br />';
						if (!empty($this->image_tint_color)) {
							list($tint_red, $tint_green, $tint_blue) = $this->getcolors($this->image_tint_color);
						}

						//imagealphablending($image_dst, true);
						for ($y = 0; $y < $this->image_dst_y; $y++) {
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								if ($this->image_greyscale) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$r = $g = $b = round((0.2125 * $pixel['red']) + (0.7154 * $pixel['green']) + (0.0721 * $pixel['blue']));
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
								if (is_numeric($this->image_threshold)) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$c = (round($pixel['red'] + $pixel['green'] + $pixel['blue']) / 3) - 127;
									$r = $g = $b = ($c > $this->image_threshold ? 255 : 0);
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
								if (is_numeric($this->image_brightness)) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$r = max(min(round($pixel['red'] + (($this->image_brightness * 2))), 255), 0);
									$g = max(min(round($pixel['green'] + (($this->image_brightness * 2))), 255), 0);
									$b = max(min(round($pixel['blue'] + (($this->image_brightness * 2))), 255), 0);
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
								if (is_numeric($this->image_contrast)) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$r = max(min(round(($this->image_contrast + 128) * $pixel['red'] / 128), 255), 0);
									$g = max(min(round(($this->image_contrast + 128) * $pixel['green'] / 128), 255), 0);
									$b = max(min(round(($this->image_contrast + 128) * $pixel['blue'] / 128), 255), 0);
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
								if (!empty($this->image_tint_color)) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$r = min(round($tint_red * $pixel['red'] / 169), 255);
									$g = min(round($tint_green * $pixel['green'] / 169), 255);
									$b = min(round($tint_blue * $pixel['blue'] / 169), 255);
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
								if (!empty($this->image_negative)) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$r = round(255 - $pixel['red']);
									$g = round(255 - $pixel['green']);
									$b = round(255 - $pixel['blue']);
									$color = imagecolorallocatealpha($image_dst, $r, $g, $b, $pixel['alpha']);
									imagesetpixel($image_dst, $x, $y, $color);
									unset($color);unset($pixel);
								}
							}
						}
					}

					// adds a border
					if ($gd_version >= 2 && !empty($this->image_border)) {
						list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_border, $this->image_dst_x, $this->image_dst_y, true, false);
						$this->log .= '- add border : ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . '<br />';
						$this->image_dst_x = $this->image_dst_x + $cl + $cr;
						$this->image_dst_y = $this->image_dst_y + $ct + $cb;
						if (!empty($this->image_border_color)) {
							list($red, $green, $blue) = $this->getcolors($this->image_border_color);
						}

						$opacity = (is_numeric($this->image_border_opacity) ? (int) (127 - $this->image_border_opacity / 100 * 127) : 0);
						// we now create an image, that we fill with the border color
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						$background = imagecolorallocatealpha($tmp, $red, $green, $blue, $opacity);
						imagefilledrectangle($tmp, 0, 0, $this->image_dst_x, $this->image_dst_y, $background);
						// we then copy the source image into the new image, without merging so that only the border is actually kept
						imagecopy($tmp, $image_dst, $cl, $ct, 0, 0, $this->image_dst_x - $cr - $cl, $this->image_dst_y - $cb - $ct);
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// adds a fading-to-transparent border
					if ($gd_version >= 2 && !empty($this->image_border_transparent)) {
						list($ct, $cr, $cb, $cl) = $this->getoffsets($this->image_border_transparent, $this->image_dst_x, $this->image_dst_y, true, false);
						$this->log .= '- add transparent border : ' . $ct . ' ' . $cr . ' ' . $cb . ' ' . $cl . '<br />';
						// we now create an image, that we fill with the border color
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						// we then copy the source image into the new image, without the borders
						imagecopy($tmp, $image_dst, $cl, $ct, $cl, $ct, $this->image_dst_x - $cr - $cl, $this->image_dst_y - $cb - $ct);
						// we now add the top border
						$opacity = 100;
						for ($y = $ct - 1; $y >= 0; $y--) {
							$il = (int) ($ct > 0 ? ($cl * ($y / $ct)) : 0);
							$ir = (int) ($ct > 0 ? ($cr * ($y / $ct)) : 0);
							for ($x = $il; $x < $this->image_dst_x - $ir; $x++) {
								$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								$alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
								if ($alpha > 0) {
									if ($alpha > 1) {
										$alpha = 1;
									}

									$color = imagecolorallocatealpha($tmp, $pixel['red'], $pixel['green'], $pixel['blue'], round((1 - $alpha) * 127));
									imagesetpixel($tmp, $x, $y, $color);
								}
							}
							if ($opacity > 0) {
								$opacity = $opacity - (100 / $ct);
							}

						}
						// we now add the right border
						$opacity = 100;
						for ($x = $this->image_dst_x - $cr; $x < $this->image_dst_x; $x++) {
							$it = (int) ($cr > 0 ? ($ct * (($this->image_dst_x - $x - 1) / $cr)) : 0);
							$ib = (int) ($cr > 0 ? ($cb * (($this->image_dst_x - $x - 1) / $cr)) : 0);
							for ($y = $it; $y < $this->image_dst_y - $ib; $y++) {
								$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								$alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
								if ($alpha > 0) {
									if ($alpha > 1) {
										$alpha = 1;
									}

									$color = imagecolorallocatealpha($tmp, $pixel['red'], $pixel['green'], $pixel['blue'], round((1 - $alpha) * 127));
									imagesetpixel($tmp, $x, $y, $color);
								}
							}
							if ($opacity > 0) {
								$opacity = $opacity - (100 / $cr);
							}

						}
						// we now add the bottom border
						$opacity = 100;
						for ($y = $this->image_dst_y - $cb; $y < $this->image_dst_y; $y++) {
							$il = (int) ($cb > 0 ? ($cl * (($this->image_dst_y - $y - 1) / $cb)) : 0);
							$ir = (int) ($cb > 0 ? ($cr * (($this->image_dst_y - $y - 1) / $cb)) : 0);
							for ($x = $il; $x < $this->image_dst_x - $ir; $x++) {
								$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								$alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
								if ($alpha > 0) {
									if ($alpha > 1) {
										$alpha = 1;
									}

									$color = imagecolorallocatealpha($tmp, $pixel['red'], $pixel['green'], $pixel['blue'], round((1 - $alpha) * 127));
									imagesetpixel($tmp, $x, $y, $color);
								}
							}
							if ($opacity > 0) {
								$opacity = $opacity - (100 / $cb);
							}

						}
						// we now add the left border
						$opacity = 100;
						for ($x = $cl - 1; $x >= 0; $x--) {
							$it = (int) ($cl > 0 ? ($ct * ($x / $cl)) : 0);
							$ib = (int) ($cl > 0 ? ($cb * ($x / $cl)) : 0);
							for ($y = $it; $y < $this->image_dst_y - $ib; $y++) {
								$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								$alpha = (1 - ($pixel['alpha'] / 127)) * $opacity / 100;
								if ($alpha > 0) {
									if ($alpha > 1) {
										$alpha = 1;
									}

									$color = imagecolorallocatealpha($tmp, $pixel['red'], $pixel['green'], $pixel['blue'], round((1 - $alpha) * 127));
									imagesetpixel($tmp, $x, $y, $color);
								}
							}
							if ($opacity > 0) {
								$opacity = $opacity - (100 / $cl);
							}

						}
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// add frame border
					if ($gd_version >= 2 && is_numeric($this->image_frame)) {
						if (is_array($this->image_frame_colors)) {
							$vars = $this->image_frame_colors;
							$this->log .= '- add frame : ' . implode(' ', $this->image_frame_colors) . '<br />';
						} else {
							$this->log .= '- add frame : ' . $this->image_frame_colors . '<br />';
							$vars = explode(' ', $this->image_frame_colors);
						}
						$nb = sizeof($vars);
						$this->image_dst_x = $this->image_dst_x + ($nb * 2);
						$this->image_dst_y = $this->image_dst_y + ($nb * 2);
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						imagecopy($tmp, $image_dst, $nb, $nb, 0, 0, $this->image_dst_x - ($nb * 2), $this->image_dst_y - ($nb * 2));
						$opacity = (is_numeric($this->image_frame_opacity) ? (int) (127 - $this->image_frame_opacity / 100 * 127) : 0);
						for ($i = 0; $i < $nb; $i++) {
							list($red, $green, $blue) = $this->getcolors($vars[$i]);
							$c = imagecolorallocatealpha($tmp, $red, $green, $blue, $opacity);
							if ($this->image_frame == 1) {
								imageline($tmp, $i, $i, $this->image_dst_x - $i - 1, $i, $c);
								imageline($tmp, $this->image_dst_x - $i - 1, $this->image_dst_y - $i - 1, $this->image_dst_x - $i - 1, $i, $c);
								imageline($tmp, $this->image_dst_x - $i - 1, $this->image_dst_y - $i - 1, $i, $this->image_dst_y - $i - 1, $c);
								imageline($tmp, $i, $i, $i, $this->image_dst_y - $i - 1, $c);
							} else {
								imageline($tmp, $i, $i, $this->image_dst_x - $i - 1, $i, $c);
								imageline($tmp, $this->image_dst_x - $nb + $i, $this->image_dst_y - $nb + $i, $this->image_dst_x - $nb + $i, $nb - $i, $c);
								imageline($tmp, $this->image_dst_x - $nb + $i, $this->image_dst_y - $nb + $i, $nb - $i, $this->image_dst_y - $nb + $i, $c);
								imageline($tmp, $i, $i, $i, $this->image_dst_y - $i - 1, $c);
							}
						}
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// add bevel border
					if ($gd_version >= 2 && $this->image_bevel > 0) {
						if (empty($this->image_bevel_color1)) {
							$this->image_bevel_color1 = '#FFFFFF';
						}

						if (empty($this->image_bevel_color2)) {
							$this->image_bevel_color2 = '#000000';
						}

						list($red1, $green1, $blue1) = $this->getcolors($this->image_bevel_color1);
						list($red2, $green2, $blue2) = $this->getcolors($this->image_bevel_color2);
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y);
						imagecopy($tmp, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y);
						imagealphablending($tmp, true);
						for ($i = 0; $i < $this->image_bevel; $i++) {
							$alpha = round(($i / $this->image_bevel) * 127);
							$c1 = imagecolorallocatealpha($tmp, $red1, $green1, $blue1, $alpha);
							$c2 = imagecolorallocatealpha($tmp, $red2, $green2, $blue2, $alpha);
							imageline($tmp, $i, $i, $this->image_dst_x - $i - 1, $i, $c1);
							imageline($tmp, $this->image_dst_x - $i - 1, $this->image_dst_y - $i, $this->image_dst_x - $i - 1, $i, $c2);
							imageline($tmp, $this->image_dst_x - $i - 1, $this->image_dst_y - $i - 1, $i, $this->image_dst_y - $i - 1, $c2);
							imageline($tmp, $i, $i, $i, $this->image_dst_y - $i - 1, $c1);
						}
						// we transfert tmp into image_dst
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// add watermark image
					if ($this->image_watermark != '' && file_exists($this->image_watermark)) {
						$this->log .= '- add watermark<br />';
						$this->image_watermark_position = strtolower($this->image_watermark_position);
						$watermark_info = getimagesize($this->image_watermark);
						$watermark_type = (array_key_exists(2, $watermark_info) ? $watermark_info[2] : null); // 1 = GIF, 2 = JPG, 3 = PNG
						$watermark_checked = false;
						if ($watermark_type == IMAGETYPE_GIF) {
							if (!$this->function_enabled('imagecreatefromgif')) {
								$this->error = $this->translate('watermark_no_create_support', array('GIF'));
							} else {
								$filter = @imagecreatefromgif($this->image_watermark);
								if (!$filter) {
									$this->error = $this->translate('watermark_create_error', array('GIF'));
								} else {
									$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;watermark source image is GIF<br />';
									$watermark_checked = true;
								}
							}
						} else if ($watermark_type == IMAGETYPE_JPEG) {
							if (!$this->function_enabled('imagecreatefromjpeg')) {
								$this->error = $this->translate('watermark_no_create_support', array('JPEG'));
							} else {
								$filter = @imagecreatefromjpeg($this->image_watermark);
								if (!$filter) {
									$this->error = $this->translate('watermark_create_error', array('JPEG'));
								} else {
									$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;watermark source image is JPEG<br />';
									$watermark_checked = true;
								}
							}
						} else if ($watermark_type == IMAGETYPE_PNG) {
							if (!$this->function_enabled('imagecreatefrompng')) {
								$this->error = $this->translate('watermark_no_create_support', array('PNG'));
							} else {
								$filter = @imagecreatefrompng($this->image_watermark);
								if (!$filter) {
									$this->error = $this->translate('watermark_create_error', array('PNG'));
								} else {
									$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;watermark source image is PNG<br />';
									$watermark_checked = true;
								}
							}
						} else if ($watermark_type == IMAGETYPE_BMP) {
							if (!method_exists($this, 'imagecreatefrombmp')) {
								$this->error = $this->translate('watermark_no_create_support', array('BMP'));
							} else {
								$filter = @$this->imagecreatefrombmp($this->image_watermark);
								if (!$filter) {
									$this->error = $this->translate('watermark_create_error', array('BMP'));
								} else {
									$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;watermark source image is BMP<br />';
									$watermark_checked = true;
								}
							}
						} else {
							$this->error = $this->translate('watermark_invalid');
						}
						if ($watermark_checked) {
							$watermark_dst_width = $watermark_src_width = imagesx($filter);
							$watermark_dst_height = $watermark_src_height = imagesy($filter);

							// if watermark is too large/tall, resize it first
							if ((!$this->image_watermark_no_zoom_out && ($watermark_dst_width > $this->image_dst_x || $watermark_dst_height > $this->image_dst_y))
								|| (!$this->image_watermark_no_zoom_in && $watermark_dst_width < $this->image_dst_x && $watermark_dst_height < $this->image_dst_y)) {
								$canvas_width = $this->image_dst_x - abs($this->image_watermark_x);
								$canvas_height = $this->image_dst_y - abs($this->image_watermark_y);
								if (($watermark_src_width / $canvas_width) > ($watermark_src_height / $canvas_height)) {
									$watermark_dst_width = $canvas_width;
									$watermark_dst_height = intval($watermark_src_height * ($canvas_width / $watermark_src_width));
								} else {
									$watermark_dst_height = $canvas_height;
									$watermark_dst_width = intval($watermark_src_width * ($canvas_height / $watermark_src_height));
								}
								$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;watermark resized from ' . $watermark_src_width . 'x' . $watermark_src_height . ' to ' . $watermark_dst_width . 'x' . $watermark_dst_height . '<br />';

							}
							// determine watermark position
							$watermark_x = 0;
							$watermark_y = 0;
							if (is_numeric($this->image_watermark_x)) {
								if ($this->image_watermark_x < 0) {
									$watermark_x = $this->image_dst_x - $watermark_dst_width + $this->image_watermark_x;
								} else {
									$watermark_x = $this->image_watermark_x;
								}
							} else {
								if (strpos($this->image_watermark_position, 'r') !== false) {
									$watermark_x = $this->image_dst_x - $watermark_dst_width;
								} else if (strpos($this->image_watermark_position, 'l') !== false) {
									$watermark_x = 0;
								} else {
									$watermark_x = ($this->image_dst_x - $watermark_dst_width) / 2;
								}
							}
							if (is_numeric($this->image_watermark_y)) {
								if ($this->image_watermark_y < 0) {
									$watermark_y = $this->image_dst_y - $watermark_dst_height + $this->image_watermark_y;
								} else {
									$watermark_y = $this->image_watermark_y;
								}
							} else {
								if (strpos($this->image_watermark_position, 'b') !== false) {
									$watermark_y = $this->image_dst_y - $watermark_dst_height;
								} else if (strpos($this->image_watermark_position, 't') !== false) {
									$watermark_y = 0;
								} else {
									$watermark_y = ($this->image_dst_y - $watermark_dst_height) / 2;
								}
							}
							imagealphablending($image_dst, true);
							imagecopyresampled($image_dst, $filter, $watermark_x, $watermark_y, 0, 0, $watermark_dst_width, $watermark_dst_height, $watermark_src_width, $watermark_src_height);
						} else {
							$this->error = $this->translate('watermark_invalid');
						}
					}

					// add text
					if (!empty($this->image_text)) {
						$this->log .= '- add text<br />';

						// calculate sizes in human readable format
						$src_size = $this->file_src_size / 1024;
						$src_size_mb = number_format($src_size / 1024, 1, ".", " ");
						$src_size_kb = number_format($src_size, 1, ".", " ");
						$src_size_human = ($src_size > 1024 ? $src_size_mb . " MB" : $src_size_kb . " kb");

						$this->image_text = str_replace(
							array('[src_name]',
								'[src_name_body]',
								'[src_name_ext]',
								'[src_pathname]',
								'[src_mime]',
								'[src_size]',
								'[src_size_kb]',
								'[src_size_mb]',
								'[src_size_human]',
								'[src_x]',
								'[src_y]',
								'[src_pixels]',
								'[src_type]',
								'[src_bits]',
								'[dst_path]',
								'[dst_name_body]',
								'[dst_name_ext]',
								'[dst_name]',
								'[dst_pathname]',
								'[dst_x]',
								'[dst_y]',
								'[date]',
								'[time]',
								'[host]',
								'[server]',
								'[ip]',
								'[gd_version]'),
							array($this->file_src_name,
								$this->file_src_name_body,
								$this->file_src_name_ext,
								$this->file_src_pathname,
								$this->file_src_mime,
								$this->file_src_size,
								$src_size_kb,
								$src_size_mb,
								$src_size_human,
								$this->image_src_x,
								$this->image_src_y,
								$this->image_src_pixels,
								$this->image_src_type,
								$this->image_src_bits,
								$this->file_dst_path,
								$this->file_dst_name_body,
								$this->file_dst_name_ext,
								$this->file_dst_name,
								$this->file_dst_pathname,
								$this->image_dst_x,
								$this->image_dst_y,
								date('Y-m-d'),
								date('H:i:s'),
								(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'n/a'),
								(isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'n/a'),
								(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'n/a'),
								$this->gdversion(true)),
							$this->image_text);

						if (!is_numeric($this->image_text_padding)) {
							$this->image_text_padding = 0;
						}

						if (!is_numeric($this->image_text_line_spacing)) {
							$this->image_text_line_spacing = 0;
						}

						if (!is_numeric($this->image_text_padding_x)) {
							$this->image_text_padding_x = $this->image_text_padding;
						}

						if (!is_numeric($this->image_text_padding_y)) {
							$this->image_text_padding_y = $this->image_text_padding;
						}

						$this->image_text_position = strtolower($this->image_text_position);
						$this->image_text_direction = strtolower($this->image_text_direction);
						$this->image_text_alignment = strtolower($this->image_text_alignment);

						$font_type = 'gd';

						// if the font is a string with a GDF font path, we assume that we might want to load a font
						if (!is_numeric($this->image_text_font) && strlen($this->image_text_font) > 4 && substr(strtolower($this->image_text_font), -4) == '.gdf') {
							if (strpos($this->image_text_font, '/') === false) {
								$this->image_text_font = "./" . $this->image_text_font;
							}

							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;try to load font ' . $this->image_text_font . '... ';
							if ($this->image_text_font = @imageloadfont($this->image_text_font)) {
								$this->log .= 'success<br />';
							} else {
								$this->log .= 'error<br />';
								$this->image_text_font = 5;
							}
						}

						// if the font is a string with a TTF font path, we check if we can access the font file
						if (!is_numeric($this->image_text_font) && strlen($this->image_text_font) > 4 && substr(strtolower($this->image_text_font), -4) == '.ttf') {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;try to load font ' . $this->image_text_font . '... ';
							if (strpos($this->image_text_font, '/') === false) {
								$this->image_text_font = "./" . $this->image_text_font;
							}

							if (file_exists($this->image_text_font) && is_readable($this->image_text_font)) {
								$this->log .= 'success<br />';
								$font_type = 'tt';
							} else {
								$this->log .= 'error<br />';
								$this->image_text_font = 5;
							}
						}

						// get the text bounding box (GD fonts)
						if ($font_type == 'gd') {
							$text = explode("\n", $this->image_text);
							$char_width = imagefontwidth($this->image_text_font);
							$char_height = imagefontheight($this->image_text_font);
							$text_height = 0;
							$text_width = 0;
							$line_height = 0;
							$line_width = 0;
							foreach ($text as $k => $v) {
								if ($this->image_text_direction == 'v') {
									$h = ($char_width * strlen($v));
									if ($h > $text_height) {
										$text_height = $h;
									}

									$line_width = $char_height;
									$text_width += $line_width + ($k < (sizeof($text) - 1) ? $this->image_text_line_spacing : 0);
								} else {
									$w = ($char_width * strlen($v));
									if ($w > $text_width) {
										$text_width = $w;
									}

									$line_height = $char_height;
									$text_height += $line_height + ($k < (sizeof($text) - 1) ? $this->image_text_line_spacing : 0);
								}
							}
							$text_width += (2 * $this->image_text_padding_x);
							$text_height += (2 * $this->image_text_padding_y);

							// get the text bounding box (TrueType fonts)
						} else if ($font_type == 'tt') {
							$text = $this->image_text;
							if (!$this->image_text_angle) {
								$this->image_text_angle = $this->image_text_direction == 'v' ? 90 : 0;
							}

							$text_height = 0;
							$text_width = 0;
							$text_offset_x = 0;
							$text_offset_y = 0;
							$rect = imagettfbbox($this->image_text_size, $this->image_text_angle, $this->image_text_font, $text);
							if ($rect) {
								$minX = min(array($rect[0], $rect[2], $rect[4], $rect[6]));
								$maxX = max(array($rect[0], $rect[2], $rect[4], $rect[6]));
								$minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
								$maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));
								$text_offset_x = abs($minX) - 1;
								$text_offset_y = abs($minY) - 1;
								$text_width = $maxX - $minX + (2 * $this->image_text_padding_x);
								$text_height = $maxY - $minY + (2 * $this->image_text_padding_y);
							}
						}

						// position the text block
						$text_x = 0;
						$text_y = 0;
						if (is_numeric($this->image_text_x)) {
							if ($this->image_text_x < 0) {
								$text_x = $this->image_dst_x - $text_width + $this->image_text_x;
							} else {
								$text_x = $this->image_text_x;
							}
						} else {
							if (strpos($this->image_text_position, 'r') !== false) {
								$text_x = $this->image_dst_x - $text_width;
							} else if (strpos($this->image_text_position, 'l') !== false) {
								$text_x = 0;
							} else {
								$text_x = ($this->image_dst_x - $text_width) / 2;
							}
						}
						if (is_numeric($this->image_text_y)) {
							if ($this->image_text_y < 0) {
								$text_y = $this->image_dst_y - $text_height + $this->image_text_y;
							} else {
								$text_y = $this->image_text_y;
							}
						} else {
							if (strpos($this->image_text_position, 'b') !== false) {
								$text_y = $this->image_dst_y - $text_height;
							} else if (strpos($this->image_text_position, 't') !== false) {
								$text_y = 0;
							} else {
								$text_y = ($this->image_dst_y - $text_height) / 2;
							}
						}

						// add a background, maybe transparent
						if (!empty($this->image_text_background)) {
							list($red, $green, $blue) = $this->getcolors($this->image_text_background);
							if ($gd_version >= 2 && (is_numeric($this->image_text_background_opacity)) && $this->image_text_background_opacity >= 0 && $this->image_text_background_opacity <= 100) {
								$filter = imagecreatetruecolor($text_width, $text_height);
								$background_color = imagecolorallocate($filter, $red, $green, $blue);
								imagefilledrectangle($filter, 0, 0, $text_width, $text_height, $background_color);
								$this->imagecopymergealpha($image_dst, $filter, $text_x, $text_y, 0, 0, $text_width, $text_height, $this->image_text_background_opacity);
								imagedestroy($filter);
							} else {
								$background_color = imagecolorallocate($image_dst, $red, $green, $blue);
								imagefilledrectangle($image_dst, $text_x, $text_y, $text_x + $text_width, $text_y + $text_height, $background_color);
							}
						}

						$text_x += $this->image_text_padding_x;
						$text_y += $this->image_text_padding_y;
						$t_width = $text_width - (2 * $this->image_text_padding_x);
						$t_height = $text_height - (2 * $this->image_text_padding_y);
						list($red, $green, $blue) = $this->getcolors($this->image_text_color);

						// add the text, maybe transparent
						if ($gd_version >= 2 && (is_numeric($this->image_text_opacity)) && $this->image_text_opacity >= 0 && $this->image_text_opacity <= 100) {
							if ($t_width < 0) {
								$t_width = 0;
							}

							if ($t_height < 0) {
								$t_height = 0;
							}

							$filter = $this->imagecreatenew($t_width, $t_height, false, true);
							$text_color = imagecolorallocate($filter, $red, $green, $blue);

							if ($font_type == 'gd') {
								foreach ($text as $k => $v) {
									if ($this->image_text_direction == 'v') {
										imagestringup($filter,
											$this->image_text_font,
											$k * ($line_width + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0)),
											$text_height - (2 * $this->image_text_padding_y) - ($this->image_text_alignment == 'l' ? 0 : (($t_height - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
											$v,
											$text_color);
									} else {
										imagestring($filter,
											$this->image_text_font,
											($this->image_text_alignment == 'l' ? 0 : (($t_width - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
											$k * ($line_height + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0)),
											$v,
											$text_color);
									}
								}
							} else if ($font_type == 'tt') {
								imagettftext($filter,
									$this->image_text_size,
									$this->image_text_angle,
									$text_offset_x,
									$text_offset_y,
									$text_color,
									$this->image_text_font,
									$text);
							}
							$this->imagecopymergealpha($image_dst, $filter, $text_x, $text_y, 0, 0, $t_width, $t_height, $this->image_text_opacity);
							imagedestroy($filter);

						} else {
							$text_color = imagecolorallocate($image_dst, $red, $green, $blue);
							if ($font_type == 'gd') {
								foreach ($text as $k => $v) {
									if ($this->image_text_direction == 'v') {
										imagestringup($image_dst,
											$this->image_text_font,
											$text_x + $k * ($line_width + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0)),
											$text_y + $text_height - (2 * $this->image_text_padding_y) - ($this->image_text_alignment == 'l' ? 0 : (($t_height - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
											$v,
											$text_color);
									} else {
										imagestring($image_dst,
											$this->image_text_font,
											$text_x + ($this->image_text_alignment == 'l' ? 0 : (($t_width - strlen($v) * $char_width) / ($this->image_text_alignment == 'r' ? 1 : 2))),
											$text_y + $k * ($line_height + ($k > 0 && $k < (sizeof($text)) ? $this->image_text_line_spacing : 0)),
											$v,
											$text_color);
									}
								}
							} else if ($font_type == 'tt') {
								imagettftext($image_dst,
									$this->image_text_size,
									$this->image_text_angle,
									$text_offset_x + ($this->image_dst_x / 2) - ($text_width / 2) + $this->image_text_padding_x,
									$text_offset_y + ($this->image_dst_y / 2) - ($text_height / 2) + $this->image_text_padding_y,
									$text_color,
									$this->image_text_font,
									$text);
							}
						}
					}

					// add a reflection
					if ($this->image_reflection_height) {
						$this->log .= '- add reflection : ' . $this->image_reflection_height . '<br />';
						// we decode image_reflection_height, which can be a integer, a string in pixels or percentage
						$image_reflection_height = $this->image_reflection_height;
						if (strpos($image_reflection_height, '%') > 0) {
							$image_reflection_height = $this->image_dst_y * (str_replace('%', '', $image_reflection_height / 100));
						}

						if (strpos($image_reflection_height, 'px') > 0) {
							$image_reflection_height = str_replace('px', '', $image_reflection_height);
						}

						$image_reflection_height = (int) $image_reflection_height;
						if ($image_reflection_height > $this->image_dst_y) {
							$image_reflection_height = $this->image_dst_y;
						}

						if (empty($this->image_reflection_opacity)) {
							$this->image_reflection_opacity = 60;
						}

						// create the new destination image
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y + $image_reflection_height + $this->image_reflection_space, true);
						$transparency = $this->image_reflection_opacity;

						// copy the original image
						imagecopy($tmp, $image_dst, 0, 0, 0, 0, $this->image_dst_x, $this->image_dst_y + ($this->image_reflection_space < 0 ? $this->image_reflection_space : 0));

						// we have to make sure the extra bit is the right color, or transparent
						if ($image_reflection_height + $this->image_reflection_space > 0) {
							// use the background color if present
							if (!empty($this->image_background_color)) {
								list($red, $green, $blue) = $this->getcolors($this->image_background_color);
								$fill = imagecolorallocate($tmp, $red, $green, $blue);
							} else {
								$fill = imagecolorallocatealpha($tmp, 0, 0, 0, 127);
							}
							// fill in from the edge of the extra bit
							imagefill($tmp, round($this->image_dst_x / 2), $this->image_dst_y + $image_reflection_height + $this->image_reflection_space - 1, $fill);
						}

						// copy the reflection
						for ($y = 0; $y < $image_reflection_height; $y++) {
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								$pixel_b = imagecolorsforindex($tmp, imagecolorat($tmp, $x, $y + $this->image_dst_y + $this->image_reflection_space));
								$pixel_o = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $this->image_dst_y - $y - 1 + ($this->image_reflection_space < 0 ? $this->image_reflection_space : 0)));
								$alpha_o = 1 - ($pixel_o['alpha'] / 127);
								$alpha_b = 1 - ($pixel_b['alpha'] / 127);
								$opacity = $alpha_o * $transparency / 100;
								if ($opacity > 0) {
									$red = round((($pixel_o['red'] * $opacity) + ($pixel_b['red']) * $alpha_b) / ($alpha_b + $opacity));
									$green = round((($pixel_o['green'] * $opacity) + ($pixel_b['green']) * $alpha_b) / ($alpha_b + $opacity));
									$blue = round((($pixel_o['blue'] * $opacity) + ($pixel_b['blue']) * $alpha_b) / ($alpha_b + $opacity));
									$alpha = ($opacity + $alpha_b);
									if ($alpha > 1) {
										$alpha = 1;
									}

									$alpha = round((1 - $alpha) * 127);
									$color = imagecolorallocatealpha($tmp, $red, $green, $blue, $alpha);
									imagesetpixel($tmp, $x, $y + $this->image_dst_y + $this->image_reflection_space, $color);
								}
							}
							if ($transparency > 0) {
								$transparency = $transparency - ($this->image_reflection_opacity / $image_reflection_height);
							}

						}

						// copy the resulting image into the destination image
						$this->image_dst_y = $this->image_dst_y + $image_reflection_height + $this->image_reflection_space;
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// change opacity
					if ($gd_version >= 2 && is_numeric($this->image_opacity) && $this->image_opacity < 100) {
						$this->log .= '- change opacity<br />';
						// create the new destination image
						$tmp = $this->imagecreatenew($this->image_dst_x, $this->image_dst_y, true);
						for ($y = 0; $y < $this->image_dst_y; $y++) {
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								$alpha = $pixel['alpha'] + round((127 - $pixel['alpha']) * (100 - $this->image_opacity) / 100);
								if ($alpha > 127) {
									$alpha = 127;
								}

								if ($alpha > 0) {
									$color = imagecolorallocatealpha($tmp, $pixel['red'], $pixel['green'], $pixel['blue'], $alpha);
									imagesetpixel($tmp, $x, $y, $color);
								}
							}
						}
						// copy the resulting image into the destination image
						$image_dst = $this->imagetransfer($tmp, $image_dst);
					}

					// reduce the JPEG image to a set desired size
					if (is_numeric($this->jpeg_size) && $this->jpeg_size > 0 && ($this->image_convert == 'jpeg' || $this->image_convert == 'jpg')) {
						// inspired by: JPEGReducer class version 1, 25 November 2004, Author: Huda M ElMatsani, justhuda at netscape dot net
						$this->log .= '- JPEG desired file size : ' . $this->jpeg_size . '<br />';
						// calculate size of each image. 75%, 50%, and 25% quality
						ob_start();
						imagejpeg($image_dst, null, 75);
						$buffer = ob_get_contents();
						ob_end_clean();
						$size75 = strlen($buffer);
						ob_start();
						imagejpeg($image_dst, null, 50);
						$buffer = ob_get_contents();
						ob_end_clean();
						$size50 = strlen($buffer);
						ob_start();
						imagejpeg($image_dst, null, 25);
						$buffer = ob_get_contents();
						ob_end_clean();
						$size25 = strlen($buffer);

						// make sure we won't divide by 0
						if ($size50 == $size25) {
							$size50++;
						}

						if ($size75 == $size50 || $size75 == $size25) {
							$size75++;
						}

						// calculate gradient of size reduction by quality
						$mgrad1 = 25 / ($size50 - $size25);
						$mgrad2 = 25 / ($size75 - $size50);
						$mgrad3 = 50 / ($size75 - $size25);
						$mgrad = ($mgrad1 + $mgrad2 + $mgrad3) / 3;
						// result of approx. quality factor for expected size
						$q_factor = round($mgrad * ($this->jpeg_size - $size50) + 50);

						if ($q_factor < 1) {
							$this->jpeg_quality = 1;
						} elseif ($q_factor > 100) {
							$this->jpeg_quality = 100;
						} else {
							$this->jpeg_quality = $q_factor;
						}
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;JPEG quality factor set to ' . $this->jpeg_quality . '<br />';
					}

					// converts image from true color, and fix transparency if needed
					$this->log .= '- converting...<br />';
					$this->image_dst_type = $this->image_convert;
					switch ($this->image_convert) {
					case 'gif':
						// if the image is true color, we convert it to a palette
						if (imageistruecolor($image_dst)) {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;true color to palette<br />';
							// creates a black and white mask
							$mask = array(array());
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								for ($y = 0; $y < $this->image_dst_y; $y++) {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
									$mask[$x][$y] = $pixel['alpha'];
								}
							}
							list($red, $green, $blue) = $this->getcolors($this->image_default_color);
							// first, we merge the image with the background color, so we know which colors we will have
							for ($x = 0; $x < $this->image_dst_x; $x++) {
								for ($y = 0; $y < $this->image_dst_y; $y++) {
									if ($mask[$x][$y] > 0) {
										// we have some transparency. we combine the color with the default color
										$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
										$alpha = ($mask[$x][$y] / 127);
										$pixel['red'] = round(($pixel['red'] * (1 - $alpha) + $red * ($alpha)));
										$pixel['green'] = round(($pixel['green'] * (1 - $alpha) + $green * ($alpha)));
										$pixel['blue'] = round(($pixel['blue'] * (1 - $alpha) + $blue * ($alpha)));
										$color = imagecolorallocate($image_dst, $pixel['red'], $pixel['green'], $pixel['blue']);
										imagesetpixel($image_dst, $x, $y, $color);
									}
								}
							}
							// transforms the true color image into palette, with its merged default color
							if (empty($this->image_background_color)) {
								imagetruecolortopalette($image_dst, true, 255);
								$transparency = imagecolorallocate($image_dst, 254, 1, 253);
								imagecolortransparent($image_dst, $transparency);
								// make the transparent areas transparent
								for ($x = 0; $x < $this->image_dst_x; $x++) {
									for ($y = 0; $y < $this->image_dst_y; $y++) {
										// we test wether we have enough opacity to justify keeping the color
										if ($mask[$x][$y] > 120) {
											imagesetpixel($image_dst, $x, $y, $transparency);
										}

									}
								}
							}
							unset($mask);
						}
						break;
					case 'jpg':
					case 'bmp':
						// if the image doesn't support any transparency, then we merge it with the default color
						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;fills in transparency with default color<br />';
						list($red, $green, $blue) = $this->getcolors($this->image_default_color);
						$transparency = imagecolorallocate($image_dst, $red, $green, $blue);
						// make the transaparent areas transparent
						for ($x = 0; $x < $this->image_dst_x; $x++) {
							for ($y = 0; $y < $this->image_dst_y; $y++) {
								// we test wether we have some transparency, in which case we will merge the colors
								if (imageistruecolor($image_dst)) {
									$rgba = imagecolorat($image_dst, $x, $y);
									$pixel = array('red' => ($rgba >> 16) & 0xFF,
										'green' => ($rgba >> 8) & 0xFF,
										'blue' => $rgba & 0xFF,
										'alpha' => ($rgba & 0x7F000000) >> 24);
								} else {
									$pixel = imagecolorsforindex($image_dst, imagecolorat($image_dst, $x, $y));
								}
								if ($pixel['alpha'] == 127) {
									// we have full transparency. we make the pixel transparent
									imagesetpixel($image_dst, $x, $y, $transparency);
								} else if ($pixel['alpha'] > 0) {
									// we have some transparency. we combine the color with the default color
									$alpha = ($pixel['alpha'] / 127);
									$pixel['red'] = round(($pixel['red'] * (1 - $alpha) + $red * ($alpha)));
									$pixel['green'] = round(($pixel['green'] * (1 - $alpha) + $green * ($alpha)));
									$pixel['blue'] = round(($pixel['blue'] * (1 - $alpha) + $blue * ($alpha)));
									$color = imagecolorclosest($image_dst, $pixel['red'], $pixel['green'], $pixel['blue']);
									imagesetpixel($image_dst, $x, $y, $color);
								}
							}
						}

						break;
					default:
						break;
					}

					// interlace options
					if ($this->image_interlace) {
						imageinterlace($image_dst, true);
					}

					// outputs image
					$this->log .= '- saving image...<br />';
					switch ($this->image_convert) {
					case 'jpeg':
					case 'jpg':
						if (!$return_mode) {
							$result = @imagejpeg($image_dst, $this->file_dst_pathname, $this->jpeg_quality);
						} else {
							ob_start();
							$result = @imagejpeg($image_dst, null, $this->jpeg_quality);
							$return_content = ob_get_contents();
							ob_end_clean();
						}
						if (!$result) {
							$this->processed = false;
							$this->error = $this->translate('file_create', array('JPEG'));
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;JPEG image created<br />';
						}
						break;
					case 'png':
						imagealphablending($image_dst, false);
						imagesavealpha($image_dst, true);
						if (!$return_mode) {
							if (is_numeric($this->png_compression) && version_compare(PHP_VERSION, '5.1.2') >= 0) {
								$result = @imagepng($image_dst, $this->file_dst_pathname, $this->png_compression);
							} else {
								$result = @imagepng($image_dst, $this->file_dst_pathname);
							}
						} else {
							ob_start();
							if (is_numeric($this->png_compression) && version_compare(PHP_VERSION, '5.1.2') >= 0) {
								$result = @imagepng($image_dst, null, $this->png_compression);
							} else {
								$result = @imagepng($image_dst);
							}
							$return_content = ob_get_contents();
							ob_end_clean();
						}
						if (!$result) {
							$this->processed = false;
							$this->error = $this->translate('file_create', array('PNG'));
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;PNG image created<br />';
						}
						break;
					case 'gif':
						if (!$return_mode) {
							$result = @imagegif($image_dst, $this->file_dst_pathname);
						} else {
							ob_start();
							$result = @imagegif($image_dst);
							$return_content = ob_get_contents();
							ob_end_clean();
						}
						if (!$result) {
							$this->processed = false;
							$this->error = $this->translate('file_create', array('GIF'));
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;GIF image created<br />';
						}
						break;
					case 'bmp':
						if (!$return_mode) {
							$result = $this->imagebmp($image_dst, $this->file_dst_pathname);
						} else {
							ob_start();
							$result = $this->imagebmp($image_dst);
							$return_content = ob_get_contents();
							ob_end_clean();
						}
						if (!$result) {
							$this->processed = false;
							$this->error = $this->translate('file_create', array('BMP'));
						} else {
							$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;BMP image created<br />';
						}
						break;

					default:
						$this->processed = false;
						$this->error = $this->translate('no_conversion_type');
					}
					if ($this->processed) {
						if (is_resource($image_src)) {
							imagedestroy($image_src);
						}

						if (is_resource($image_dst)) {
							imagedestroy($image_dst);
						}

						$this->log .= '&nbsp;&nbsp;&nbsp;&nbsp;image objects destroyed<br />';
					}
				}

			} else {
				$this->log .= '- no image processing wanted<br />';

				if (!$return_mode) {
					// copy the file to its final destination. we don't use move_uploaded_file here
					// if we happen to have open_basedir restrictions, it is a temp file that we copy, not the original uploaded file
					if (!copy($this->file_src_pathname, $this->file_dst_pathname)) {
						$this->processed = false;
						$this->error = $this->translate('copy_failed');
					}
				} else {
					// returns the file, so that its content can be received by the caller
					$return_content = @file_get_contents($this->file_src_pathname);
					if ($return_content === FALSE) {
						$this->processed = false;
						$this->error = $this->translate('reading_failed');
					}
				}
			}
		}

		if ($this->processed) {
			$this->log .= '- <b>process OK</b><br />';
		} else {
			$this->log .= '- <b>error</b>: ' . $this->error . '<br />';
		}

		// we reinit all the vars
		$this->init();

		// we may return the image content
		if ($return_mode) {
			return $return_content;
		}

	}
	

	function clean() {
		$this->log .= '<b>cleanup</b><br />';
		$this->log .= '- delete temp file ' . $this->file_src_pathname . '<br />';
		@unlink($this->file_src_pathname);
	}



	function imagecreatefrombmp($filename) {
		if (!$f1 = fopen($filename, "rb")) {
			return false;
		}

		$file = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1, 14));
		if ($file['file_type'] != 19778) {
			return false;
		}

		$bmp = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel' .
			'/Vcompression/Vsize_bitmap/Vhoriz_resolution' .
			'/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1, 40));
		$bmp['colors'] = pow(2, $bmp['bits_per_pixel']);
		if ($bmp['size_bitmap'] == 0) {
			$bmp['size_bitmap'] = $file['file_size'] - $file['bitmap_offset'];
		}

		$bmp['bytes_per_pixel'] = $bmp['bits_per_pixel'] / 8;
		$bmp['bytes_per_pixel2'] = ceil($bmp['bytes_per_pixel']);
		$bmp['decal'] = ($bmp['width'] * $bmp['bytes_per_pixel'] / 4);
		$bmp['decal'] -= floor($bmp['width'] * $bmp['bytes_per_pixel'] / 4);
		$bmp['decal'] = 4 - (4 * $bmp['decal']);
		if ($bmp['decal'] == 4) {
			$bmp['decal'] = 0;
		}

		$palette = array();
		if ($bmp['colors'] < 16777216) {
			$palette = unpack('V' . $bmp['colors'], fread($f1, $bmp['colors'] * 4));
		}

		$im = fread($f1, $bmp['size_bitmap']);
		$vide = chr(0);

		$res = imagecreatetruecolor($bmp['width'], $bmp['height']);
		$P = 0;
		$Y = $bmp['height'] - 1;
		while ($Y >= 0) {
			$X = 0;
			while ($X < $bmp['width']) {
				if ($bmp['bits_per_pixel'] == 24) {
					$color = unpack("V", substr($im, $P, 3) . $vide);
				} elseif ($bmp['bits_per_pixel'] == 16) {
					$color = unpack("n", substr($im, $P, 2));
					$color[1] = $palette[$color[1] + 1];
				} elseif ($bmp['bits_per_pixel'] == 8) {
					$color = unpack("n", $vide . substr($im, $P, 1));
					$color[1] = $palette[$color[1] + 1];
				} elseif ($bmp['bits_per_pixel'] == 4) {
					$color = unpack("n", $vide . substr($im, floor($P), 1));
					if (($P * 2) % 2 == 0) {
						$color[1] = ($color[1] >> 4);
					} else {
						$color[1] = ($color[1] & 0x0F);
					}

					$color[1] = $palette[$color[1] + 1];
				} elseif ($bmp['bits_per_pixel'] == 1) {
					$color = unpack("n", $vide . substr($im, floor($P), 1));
					if (($P * 8) % 8 == 0) {
						$color[1] = $color[1] >> 7;
					} elseif (($P * 8) % 8 == 1) {
						$color[1] = ($color[1] & 0x40) >> 6;
					} elseif (($P * 8) % 8 == 2) {
						$color[1] = ($color[1] & 0x20) >> 5;
					} elseif (($P * 8) % 8 == 3) {
						$color[1] = ($color[1] & 0x10) >> 4;
					} elseif (($P * 8) % 8 == 4) {
						$color[1] = ($color[1] & 0x8) >> 3;
					} elseif (($P * 8) % 8 == 5) {
						$color[1] = ($color[1] & 0x4) >> 2;
					} elseif (($P * 8) % 8 == 6) {
						$color[1] = ($color[1] & 0x2) >> 1;
					} elseif (($P * 8) % 8 == 7) {
						$color[1] = ($color[1] & 0x1);
					}

					$color[1] = $palette[$color[1] + 1];
				} else {
					return FALSE;
				}

				imagesetpixel($res, $X, $Y, $color[1]);
				$X++;
				$P += $bmp['bytes_per_pixel'];
			}
			$Y--;
			$P += $bmp['decal'];
		}
		fclose($f1);
		return $res;
	}


	function imagebmp(&$im, $filename = "") {

		if (!$im) {
			return false;
		}

		$w = imagesx($im);
		$h = imagesy($im);
		$result = '';

		if (!imageistruecolor($im)) {
			$tmp = imagecreatetruecolor($w, $h);
			imagecopy($tmp, $im, 0, 0, 0, 0, $w, $h);
			imagedestroy($im);
			$im = &$tmp;
		}

		$biBPLine = $w * 3;
		$biStride = ($biBPLine + 3) & ~3;
		$biSizeImage = $biStride * $h;
		$bfOffBits = 54;
		$bfSize = $bfOffBits + $biSizeImage;

		$result .= substr('BM', 0, 2);
		$result .= pack('VvvV', $bfSize, 0, 0, $bfOffBits);
		$result .= pack('VVVvvVVVVVV', 40, $w, $h, 1, 24, 0, $biSizeImage, 0, 0, 0, 0);

		$numpad = $biStride - $biBPLine;
		for ($y = $h - 1; $y >= 0; --$y) {
			for ($x = 0; $x < $w; ++$x) {
				$col = imagecolorat($im, $x, $y);
				$result .= substr(pack('V', $col), 0, 3);
			}
			for ($i = 0; $i < $numpad; ++$i) {
				$result .= pack('C', 0);
			}

		}

		if ($filename == "") {
			echo $result;
		} else {
			$file = fopen($filename, "wb");
			fwrite($file, $result);
			fclose($file);
		}
		return true;
	}








}

 ?>