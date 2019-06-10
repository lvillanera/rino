<?php

if (!function_exists('head')) {

	function head($data = '', $h = '1', $attributes = '') {
		return '<h' . $h . _stringify_attributes($attributes) . '>' . $data . '</h' . $h . '>';
	}
}

// ------------------------------------------------------------------------

if (!function_exists('ul')) {

	function ul($list, $attributes = '') {
		return _list('ul', $list, $attributes);
	}
}

// ------------------------------------------------------------------------

if (!function_exists('ol')) {

	function ol($list, $attributes = '') {
		return _list('ol', $list, $attributes);
	}
}

// ------------------------------------------------------------------------

if (!function_exists('_list')) {

	function _list($type = 'ul', $list = array(), $attributes = '', $depth = 0) {

		if (!is_array($list)) {
			return $list;
		}

		$out = str_repeat(' ', $depth)
		 . '<' . $type . _stringify_attributes($attributes) . ">\n";

		static $_last_list_item = '';
		foreach ($list as $key => $val) {
			$_last_list_item = $key;

			$out .= str_repeat(' ', $depth + 2) . '<li>';

			if (!is_array($val)) {
				$out .= $val;
			} else {
				$out .= $_last_list_item . "\n" . _list($type, $val, '', $depth + 4) . str_repeat(' ', $depth + 2);
			}

			$out .= "</li>\n";
		}

		return $out . str_repeat(' ', $depth) . '</' . $type . ">\n";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_stringify_attributes'))
{
	function _stringify_attributes($attributes, $js = FALSE)
	{
		$atts = NULL;

		if (empty($attributes))
		{
			return $atts;
		}

		if (is_string($attributes))
		{
			return ' '.$attributes;
		}

		$attributes = (array) $attributes;

		foreach ($attributes as $key => $val)
		{
			$atts .= ($js) ? $key.'='.$val.',' : ' '.$key.'="'.$val.'"';
		}

		return rtrim($atts, ',');
	}
}



// ------------------------------------------------------------------------

if (!function_exists('img')) {

	function img($src = '', $index_page = FALSE, $attributes = '') {
		if (!is_array($src)) {
			$src = array('src' => $src);
		}

		if (!isset($src['alt'])) {
			$src['alt'] = '';
		}

		$img = '<img';

		foreach ($src as $k => $v) {
			if ($k === 'src' && !preg_match('#^([a-z]+:)?//#i', $v)) {
				if ($index_page === TRUE) {
					$img .= ' src="' . base_url($v) . '"';
				} else {
					$img .= ' src="' . base_url() . $v . '"';
				}
			} else {
				$img .= ' ' . $k . '="' . $v . '"';
			}
		}
		
		return $img . _stringify_attributes($attributes) . ' />';
	}
}


// ------------------------------------------------------------------------

if (!function_exists('link_tag')) {

	function link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '', $index_page = FALSE) {
		$link = '<link ';

		if (is_array($href)) {
			foreach ($href as $k => $v) {
				if ($k === 'href' && !preg_match('#^([a-z]+:)?//#i', $v)) {
					if ($index_page === TRUE) {
						$link .= 'href="' . base_url($href) . '" ';
					} else {
						$link .= 'href="' . base_url() . $v . '" ';
					}
				} else {
					$link .= $k . '="' . $v . '" ';
				}
			}
		} else {
			if (preg_match('#^([a-z]+:)?//#i', $href)) {
				$link .= 'href="' . $href . '" ';
			} elseif ($index_page === TRUE) {
				$link .= 'href="' . base_url($href) . '" ';
			} else {
				$link .= 'href="' . base_url() . $href . '" ';
			}

			$link .= 'rel="' . $rel . '" type="' . $type . '" ';

			if ($media !== '') {
				$link .= 'media="' . $media . '" ';
			}

			if ($title !== '') {
				$link .= 'title="' . $title . '" ';
			}
		}

		return $link . "/>\n";
	}
}

// ------------------------------------------------------------------------

if (!function_exists('meta')) {

	function meta($name = '', $content = '', $type = 'name', $newline = "\n") {

		if (!is_array($name)) {
			$name = array(array('name' => $name, 'content' => $content, 'type' => $type, 'newline' => $newline));
		} elseif (isset($name['name'])) {
			$name = array($name);
		}

		$str = '';
		foreach ($name as $meta) {
			$type = (isset($meta['type']) && $meta['type'] !== 'name') ? 'http-equiv' : 'name';
			$name = isset($meta['name']) ? $meta['name'] : '';
			$content = isset($meta['content']) ? $meta['content'] : '';
			$newline = isset($meta['newline']) ? $meta['newline'] : "\n";

			$str .= '<meta ' . $type . '="' . $name . '" content="' . $content . '" />' . $newline;
		}

		return $str;
	}
}

// ------------------------------------------------------------------------

if (!function_exists('br')) {

	function br($count = 1) {
		return str_repeat('<br />', $count);
	}
}

// ------------------------------------------------------------------------

if (!function_exists('nbs')) {

	function nbs($num = 1) {
		return str_repeat('&nbsp;', $num);
	}
}



if(!function_exists('input'))
{
	function input($type='text',$propierties = array(
			'name'=>'textOne',
			'value'=>'',
			'class'=>'',
			'placeholder'=>'',
			'autocomplete'=>'off',
			'autofocus'=>'off',
			'checked'=>'checked',
			'disabled'=>'',
			'readonly'=>'',
			'required'=>'',
			'size'=>'',
			'src'=>'',
			'width'=>'100',
			'height'=>'100'
		))
	{

		$getPropierties = '';
		foreach ($propierties as $key => $value) {
			if(!empty($value))
				$getPropierties.= $key.'="'.$value.'" ';
		}

		$someHtml = '<input type="'.$type.'" '.$getPropierties.' >';
		return $someHtml;
	}
}
