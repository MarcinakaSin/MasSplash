<?php
function change_profile_image($dbcon, $session_user_id, $file_temp, $file_extn){
	$file_path = 'images/profile/' . substr(md5(time()), 0, 10) . '.' . $file_extn;
	move_uploaded_file($file_temp, $file_path);

	$update = $dbcon->prepare("UPDATE `users` SET `profile` = ? WHERE `user_id` = ?");
	$update->bind_param('si', $file_path, $session_user_id);
	$update->execute();
	$update->close();
}


function mail_users($dbcon, $subject, $body){

	//$query = mysql_query("SELECT 'email', 'first_name' FROM 'users' WHERE 'allow_email' = 1");
	$sql = "SELECT email, first_name FROM users WHERE allow_email = 1";
	$result = $dbcon->query($sql);
	$user_query = $result->fetch_assoc();
	while(($row = $user_query) !== false) {
		email($row['email'], $subject, "Hello" . $row['first_name'] . ",\n\n" . $body);
	}
}

function has_access($dbcon, $user_id, $type){
	$user_id 	= (int)$user_id;
	$type		= (int)$type;
	$count = $dbcon->prepare("SELECT COUNT(user_id) FROM users WHERE user_id = ? AND type = ? LIMIT 1");
	$count->bind_param('ii', $user_id, $type);
	$count->execute();
	$count->bind_result($user_count);
	$count->fetch();
	$count->close();

	return $user_count === 1;

	/*if(($user_count == 1) ? true : false) {
		return true;
	} else {
		return false;
	}*/

}


function recover($dbcon, $mode, $email){
	$mode 	= sanitize($mode);
	$email 	= sanitize($email);

	$user_data = user_data($dbcon, user_id_from_email($dbcon, $email), 'first_name', 'username');

	if($mode == 'username'){
		//recover username
		email($email, 'Your username', "Hello " . $user_data['first_name'] . ", \n\nYour username is: " . $user_data['username'] . "\n\n -MasSplash");
	} else if($mode == 'password') {
		//recover password
		$generated_password = substr(md5(rand(999, 999999)), 0, 8);
		//die($generated_password);
		change_password($dbcon, $user_data['user_id'], $generated_password);

		update_user($dbcon, $user_data['user_id'], array('password_recover' => '1'));


		email($email, 'Your password reovery', "Hello " . $user_data['first_name'] . ", \n\nYour new password is: " . $generated_password . "\n\n -MasSplash");

	}
}


function update_user($dbcon, $user_id, $update_data) {
	// Sanitizes each value in the array
	$update = array();
	array_walk($update_data, 'array_sanitize');

	foreach ($update_data as $field => $data) {
		$update[] = '`' . $field . '` = \'' . $data . '\'';
	}
	//print_r($update);
	//die();
	
	$sql = "UPDATE `users` SET " . implode(', ', $update) . " WHERE user_id = $user_id";
	$result = $dbcon->query($sql);

}

function activate($dbcon, $email, $email_code){
	//$email 		= mysql_real_escape_string($email);
	//$email_code	= mysql_real_escape_string($email_code);

	$count = $dbcon->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = ? AND `email_code` = ? AND `active` = 0 LIMIT 1");
	$count->bind_param('ss', $email, $email_code);
	$count->execute();
	$count->bind_result($user_count);
	$count->fetch();
	$count->close();  // required for second sql statement to work
	
	if(($user_count == 1) ? true : false) {
		$user_status = 1;
		$update = $dbcon->prepare("UPDATE `users` SET `active` = ? WHERE `email` = ?");
		$update->bind_param('is', $user_status, $email);
		$update->execute();

		return true;
	} else {
		return false;
	}

}

function change_password($dbcon, $user_id, $password){
	$user_id = (int)$user_id;
	$password = md5($password);
	$password_recover = 0;
	$update = $dbcon->prepare("UPDATE `users` SET `password` = ?, `password_recover` = ? WHERE `user_id` = ?");
	$update->bind_param('sii', $password, $password_recover, $user_id);
	$update->execute();
	$update->close();
}

// Inserts registration data into the database
function register_user($dbcon, $register_data) {
	// Sanitizes each value in the array
	array_walk($register_data, 'array_sanitize');
	// Encrypts password
	$register_data['password'] = md5($register_data['password']);
	// Converts Array into a string, array keys display the keys(indexs) of the array.
	$fields = implode(', ', array_keys($register_data));
	$data = '\'' . implode('\', \'', $register_data) . '\'';
	$sql = "INSERT INTO users($fields) VALUES ($data)";
	$result = $dbcon->query($sql);

	//$count = $dbcon->prepare("INSERT INTO users(?) VALUES (?)");
	//$count->bind_param('ss', $fields, $data);
	//$count->execute();
	//$count->close();

	// Used to activate account.
	email($register_data['email'], 'Activate Your Account', 
		"Hello " . $register_data['first_name'] . ",\n\nYou need to activate your account.  
		Please use the link below:\n\nhttp://www.massplash.com/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . "\n\n- massplash");
	}

function user_count($dbcon) {

	$user_status = 1;
	$count = $dbcon->prepare("SELECT COUNT(user_id) FROM users WHERE active = ? LIMIT 1");
	$count->bind_param('i', $user_status);
	$count->execute();
	$count->bind_result($user_count);
	$count->fetch();
	$count->close();

	return $user_count;
}

function user_data($dbcon, $user_id) {
	$data = array();
	// Create an integer from value to prevent varchar 
	$user_id = (int)$user_id;
	$func_num_args = func_num_args();
	//echo $func_num_args;
	$func_get_args = func_get_args();
	//print_r($func_get_args);

	// Removes the first and second argument for user_data function
	unset($func_get_args[0], $func_get_args[1]);
	// Sanitizes each value in the array
	array_walk($func_get_args, 'array_sanitize');

	if ($func_num_args > 1){
		$fields = implode(', ', $func_get_args);
		$sql = "SELECT $fields FROM users WHERE user_id = $user_id LIMIT 1";
		$result = $dbcon->query($sql);
		$data = $result->fetch_assoc();
		//print_r($data);
		return $data;
	}
}


function logged_in() {
	return (isset($_SESSION['user_id'])) ? true : false;
}

function user_exists($dbcon, $username) {

	// Set up mySQL statement
	$count = $dbcon->prepare("SELECT COUNT(user_id) FROM users WHERE username = ? LIMIT 1");
	// Sanitizes input values for mySQL statement
	$count->bind_param('s', $username);
	// Executes mySQL statement
	$count->execute();
	// Declares variable names for results
	$count->bind_result($user_count);
	// Fetches results
	$count->fetch();
	// Closes db connection
	$count->close();
	// Returns value from function
	return ($user_count == 1) ? true : false;

}

function email_exists($dbcon, $email){
	//$email = sanitize($email);
	// Set up mySQL statement
	$count = $dbcon->prepare("SELECT COUNT(user_id) FROM users WHERE email = ? LIMIT 1");
	// Bind input values for mySQL statement
	$count->bind_param('s', $email);
	// Executes mySQL statement
	$count->execute();
	// Declares variable names for results
	$count->bind_result($email_count);
	// Fetches results
	$count->fetch();
	// Closes db connection
	$count->close();
	// Returns value from function
	return ($email_count == 1) ? true : false;

}

function user_active($dbcon, $username) {

	$user_status = 1;
	$count = $dbcon->prepare("SELECT COUNT(user_id) FROM users WHERE username = ? AND active = ? LIMIT 1");
	$count->bind_param('si', $username, $user_status);
	$count->execute();
	$count->bind_result($user_count);
	$count->fetch();
	$count->close();

	return ($user_count == 1) ? true : false;
}

function user_id_from_username($dbcon, $username) {

	$count = $dbcon->prepare("SELECT user_id FROM users WHERE username = ? LIMIT 1");
	$count->bind_param('s', $username);
	$count->execute();
	$count->bind_result($user_id);
	$count->fetch();
	$count->close();

	return $user_id;
}

function user_id_from_email($dbcon, $email) {
	$email = sanitize($email);
	$count = $dbcon->prepare("SELECT user_id FROM users WHERE username = ? LIMIT 1");
	$count->bind_param('s', $email);
	$count->execute();
	$count->bind_result($user_id);
	$count->fetch();
	$count->close();

	return $user_id;
}

function login($dbcon, $username, $password) {

	$user_id = user_id_from_username($dbcon, $username);
	$password = md5($password);

	$count = $dbcon->prepare("SELECT COUNT(user_id) FROM users WHERE username = ? AND password = ? LIMIT 1");
	$count->bind_param('ss', $username, $password);
	$count->execute();
	$count->bind_result($user_count);
	$count->fetch();
	$count->close();

	return ($user_count == 1) ? $user_id : false;
}
?>