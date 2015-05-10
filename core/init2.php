<?php
//starts session storage
session_start();

$GLOBALS['config'] array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db' => 'massplashdb'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800    // seconds
	),
	'session' => array(
		'session_name' => 'user'
	)

);

// (spl: standard php library) allows a class to be pulled on the fly when it is required.
spl_autoload_register(function($class){
	require_once 'classes/' . $class . '.php';
});

required_once 'functions/sanitize.php';

?>