<?php 
include 'core/init.php';
protect_page();

if(empty($_POST) === false){
	$required_fields = array('current_password', 'password', 'validate_password');
	foreach ($_POST as $key => $value) {
		if(empty($value) && in_array($key, $required_fields) === true){
			$errors[] = 'Fields marked with an asterisk are required.';
			break 1;
		}
	}

	if(md5($_POST['current_password']) === $user_data['password']){

		// Compares password with confirm password.
		if(trim($_POST['password']) !== trim($_POST['validate_password'])) {
			$errors[] = 'Your new passwords do not match.';
		// Checks to see if password is at least 6 charaters.
		} else if(strlen(trim($_POST['password'])) < 6) {
			$errors[] = 'Your password must be at least 6 characters.';
		} else if (trim($_POST['current_password']) === trim($_POST['password'])){
			$errors[] = 'Your new password is the same as your old password.';
		}

	} else {
		$errors[] = "Your current password is incorrect.";
	}

	//print_r($errors);
}

include 'includes/overall/header.php'; 
?>
			
<h1>Change Password</h1>

<?php
if(isset($_GET['success']) && empty($_GET['success'])) {
	echo 'Your password has been changed.';

} else {

		// If data is posted and there's no errors.
	if(empty($_POST) === false && empty($errors) === true){
		change_password($dbcon, $session_user_id, $_POST['password']);
		header('Location: changepassword.php?success');
	} else if(empty($errors) === false){
		echo output_errors($errors);
	}
	?>

	<form action="" method="post">
	<ul>
		<li>
			Current Password*:<br />
			<input type="password" name="current_password">
		</li>
		<li>
			New Password*:<br />
			<input type="password" name="password">
		</li>
		<li>
			Confirm New Password*:<br />
			<input type="password" name="validate_password">
		</li>
		<li>
			<input type="submit" name="Change Password">
		</li>
	</ul>
	</form>

		
<?php 
}
include 'includes/overall/footer.php'; ?>