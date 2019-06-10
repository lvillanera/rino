<?php

	error_reporting(E_ALL ^ E_NOTICE);
	setlocale(LC_ALL, "es_PE");
	date_default_timezone_set('America/Lima');
		
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