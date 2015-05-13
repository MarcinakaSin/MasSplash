<?php
//starts session storage
session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'db' => 'massplashdb'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

// (spl: standard php library) allows a class to be pulled on the fly when it is required.
spl_autoload_register(function($class){
	require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';

//  Uses to initiate the user object for the main user //
$user = new User();
//  Uses to initiate the user object for the main user //

//  Defined $errors as a array variable to be used on all pages //
$errors = array();
//  Defined $errors as a array variable to be used on all pages //

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

	if($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}