<?php

function email ($to, $subject, $body){
	mail($to, $subject, $body, 'From: email_power@MasSplash.com');

}

function logged_in_redirect(){
	if(logged_in() === true){
		header('Location: index.php');
		exit();
	}
}


function protect_page(){
	if(logged_in() === false){
		header('Location: restricted.php');
		exit();
	}
}

function admin_protect(){
	global $dbcon;
	global $user_data;
	if(has_access($dbcon, $user_data['user_id'], 1) === false){
		header('Location: index.php');
		exit();
	}
}

  // filters for html and mysql injections
function array_sanitize($item) {
	$item = htmlentities(strip_tags(mysql_real_escape_string($item)));
}

  // filters for html and mysql injections
function sanitize($data) {
	return htmlentities(strip_tags(mysql_real_escape_string($data)));
}

function output_errors($errors) {

	// Implode converts arrays into strings, appends first argument if multiple.
	//return '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
		return implode('<br />', $errors);
}
?>