<?php

namespace Rino\Rain\Errors;

class Not_Found {

	public function render() {
		$view = new \Rino\Rain\View();
		echo $view->see(dirname(__FILE__) . DIRECTORY_SEPARATOR . "tpl" . DIRECTORY_SEPARATOR . "not_found.html");
	}
}

?>