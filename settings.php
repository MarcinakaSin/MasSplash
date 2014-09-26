<?php 
include 'core/init.php';
protect_page();

include 'includes/overall/header.php'; 

if (empty($_POST) === false){
	$required_fields = array('first_name', 'email');
	// Loops through each field and assigns value
	foreach($_POST as $key=>$value){
		// if value is empty and if the value is in the reqired array
		if(empty($value) && in_array($key, $required_fields) === true){
			$errors[] = 'Fields marked with an asterisk are required.';
			// breaks out of the loop once one required value is missing
			break 1;
		}
	}

	if(empty($errors) === true){
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false){
			$errors[] = 'A valid email address is required.';
		} else if(email_exists($dbcon, $_POST['email']) === true && $user_data['email'] !== $_POST['email']){
			$errors[] = 'Sorry, the e-mail \'' . htmlentities($_POST['email']) . '\' is already in use.';
		}
	}
	//print_r($errors);
}

?>
<h1>Settings</h1>

<?php
if(isset($_GET['success']) && empty($_GET['success'])){
	echo 'Your details have been updated.';
} else {
	if(empty($_POST) === false && empty($errors) === true){

		$update_data = array(
			'first_name' 	=> $_POST['first_name'],
			'last_name' 	=> $_POST['last_name'],
			'email' 		=> $_POST['email']
			);
	//print_r($update_data);

	update_user($dbcon, $update_data, $session_user_id);
	header('Location: settings.php?success' );
	exit();

	} else if (empty($errors) === false) {
		echo output_errors($errors);
	}
?>

<form action="" method="post">
	<ul>
		<li>First name*:<br>
			<input type="text" name="first_name" value="<?php echo $user_data['first_name']; ?>">
		</li>
		<li>Last name:<br>
			<input type="text" name="last_name" value="<?php echo $user_data['last_name']; ?>">
		</li>
		<li>E-mail*:<br>
			<input type="text" name="email" value="<?php echo $user_data['email']; ?>">
		</li>
		<li>
			<input type="submit" value="Update">
		</li>
	</ul>
</form>
<?php
}
include 'includes/overall/footer.php'; 
?>