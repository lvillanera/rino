<?php
	setlocale(LC_ALL, "es_PE");
	date_default_timezone_set('America/Lima');
	ini_set('display_errors', '0');
	ini_set('display_startup_errors', '0');
	error_reporting(E_ALL);
	include_once __DIR__ . '/vendor/autoload.php';

	use Phroute\Phroute\Runner;
	
	$config = new Rino\Core\Config();

    $package = $config->get();
	
	if((bool)$package->load_session)
	{
		$session = new Rino\Core\Session();
		$session->start();
	}

	$route = new Runner();

	$route->home(array('home'=>$package->defaultmodule))->run();



?>