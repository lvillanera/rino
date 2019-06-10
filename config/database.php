<?php 

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| 
 */



$config["default"] = array(
		'host'      => 'localhost',
	    'driver'    => 'mysql',
	    'database'  => 'store_app',
	    'port'  => '443',
	    'username'  => 'root',
	    'password'  => '',
	    'charset'   => 'utf8',
	    'collation' => 'utf8_general_ci',
	    'prefix'     => '',
	    'path'     => APP_SYSTEM . DS."Storage/Database/Database.log",
	    'log_query'=>false
	    );


$config["db_temp"] = array(
		'host'      => 'host',
	    'driver'    => 'mysql',
	    'database'  => 'databasetemp',
	    'port'  => 'port',
	    'username'  => 'root',
	    'password'  => 'password',
	    'charset'   => 'utf8',
	    'collation' => 'utf8_general_ci',
	    'prefix'     => '',
	    'path'     => APP_SYSTEM . DS."Storage/Database/Database.log",
	    'log_query'=>false
);