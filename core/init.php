<?php
//starts session storage
session_start();
// 0 eliminates errors from displaying.
//error_reporting(0);

require 'database/connect.php';
require 'functions/general.php';
require 'functions/users.php';

// Identifies correct file path in server, explodes path in array
$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
// Takes last item in array.
$current_file = end($current_file);

// Checks to see if user is logged in.
if (logged_in() === true){  
	// Grabs user_id from php session variable.
	$session_user_id = $_SESSION['user_id'];
	// Stores user information that can be accessed throughout the site.
	$user_data = user_data($dbcon, $session_user_id, 'user_id', 'username', 'password', 'first_name', 'last_name', 'email', 'password_recover', 'type', 'allow_email');
	//echo $user_data['username'];
	if (user_active($dbcon, $user_data['username']) === false) {
		session_destroy();
		header('Location: index.php');
		exit();
	}
	if($current_file !== 'changepassword.php' && $current_file !== 'logout.php' && $user_data['password_recover'] == 1){
		header('Location: changepassword.php?force');
		exit();
	}
}

$errors = array();
//mysqli_close($dbcon);
?>
