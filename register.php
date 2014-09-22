<?php
include 'core/init.php';
// prevents and redirects logged in users from accessing this page.
logged_in_redirect();
include 'includes/overall/header.php'; 

if(empty($_POST) === false){
	$required_fields = array('username', 'password', 'validate_password', 'first_name', 'email');
	// Loops through each field and assigns value
	foreach($_POST as $key=>$value){
		// if value is empty and if the value is in the reqired array
		if(empty($value) && in_array($key, $required_fields) === true){
			$errors[] = 'Fields marked with an asterisk are required.';
			// breaks out of the loop once one required value is missing
			break 1;
		}
	}

	if(empty($errors) === true) {
		// Checks to see if user exists
		if(user_exists($dbcon, $_POST['username']) === true){
			// Error message with a check to make sure the output of username does not contain html entities.
			$errors[] = 'Sorry, the username \'' . htmlentities($_POST['username']) . '\' is already taken.';
		}
		// Checks to see if username contains spaces with a regular expression preg_match.
		if(preg_match("/\\s/", $_POST['username']) == true){
			//$regular_expression = preg_match("/\\s/", $_POST['username']);
			//var_dump($regular_expression);
			$errors = 'Your username must not contain any spaces.';
		}
		// Checks to see if password is at least 6 charaters.
		if(strlen($_POST['password']) < 6){
			$errors[] = 'Your password must be at least 6 characters.';
		}
		// Compares password with confirm password.
		if($_POST['password'] !== $_POST['validate_password']) {
			$errors[] = 'Your passwords do not match.';
		}
		// Checks to see if the email provided is formated correctly.
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false){
			$errors[] = 'A valid email address is required.';
		}
		// Checks to see if the email provided exists in database.
		if(email_exists($dbcon, $_POST['email']) === true){
			$errors[] = 'Sorry, the e-mail \'' . htmlentities($_POST['email']) . '\' is already in use.';
		}
	}

	//echo '<pre>', print_r($_POST, true), '</pre>';
}
// prints out errors array for testing
//print_r($errors);

?>
		

<h1>Register</h1>

<?php
if(isset($_GET['success']) && empty($_GET['success'])){
	echo 'You\'ve been registered successfully! Please check your e-mail to activate your account.';
} else {

	// if form is not empty and there are no errors
	if(empty($_POST) === false && empty($errors) === true){
		// register user
		$register_data = array(
			'username' 		=> $_POST['username'],
			'password' 		=> $_POST['password'],
			'first_name' 	=> $_POST['first_name'],
			'last_name' 	=> $_POST['last_name'],
			'email' 		=> $_POST['email'],
			'email_code'	=> md5($_POST['username'] + microtime())
			);

		register_user($dbcon, $register_data);
		// redirect
		header('Location: register.php?success');
		// exit
		exit();
		//print_r($register_data);
	} else if (empty($errors) === false){
		// output errors
		echo output_errors($errors);
	}

?>

	<form action="" method="post">
		<ul>
			<li>
				Username*:<br/>
				<input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" required>
			</li>
			<li>
				Password*:<br />
				<input type="password" name="password" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>" required>
			</li>
			<li>
				Confirm Password*:<br />
				<input type="password" name="validate_password" required>
			</li>
			<li>
				First Name*:<br />
				<input type="text" name="first_name" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>" required>
			</li>
			<li>
				Last Name:<br />
				<input type="text" name="last_name" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>">
			</li>
			<li>
				Email*:<br/>
				<input	type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required>
			</li>
			<li>
				<input type="submit" value="Register">
			</li>
		</ul>
	</form>
			
<?php
}
 include 'includes/overall/footer.php'; ?>