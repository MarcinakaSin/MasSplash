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
	
<div class="row">
	<div class="page-header">
		<h3>Change Password</h3>
	</div>
</div>

<?php
if(isset($_GET['success']) && empty($_GET['success'])) {
	echo 'Your password has been changed.';

} else {
	if(isset($_GET['force']) && empty($_GET['force'])) {
	?>
	<p> You must change your password. </p>
	<?php
	}
		// If data is posted and there's no errors.
	if(empty($_POST) === false && empty($errors) === true){
		change_password($dbcon, $session_user_id, $_POST['password']);
		header('Location: changepassword.php?success');
	} else if(empty($errors) === false){ ?>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>
			<?php 	echo output_errors($errors);	/*output errors*/  ?>
		</strong>
	</div>
</div>

<?php
	}
?>

<div class="row">
	<div class="col-sm-4">
		<form action="" method="post">
			<div class="form-group">
		    	<label for="current_password">Current Password*</label>
				<input type="password" id="current_password" name="current_password" placeholder="Current Password" class="form-control" required />
			</div>
			<div class="form-group">
		    	<label for="password">New Password*</label>
				<input type="password" id="password" name="password" placeholder="New Password" class="form-control" required />
			</div>
			<div class="form-group">
		    	<label for="validate_password">Confirm New Password*</label>
				<input type="password" id="validate_password" name="validate_password" placeholder="Confirm New Password" class="form-control" required />
			</div>
			<div class="form-group">
				<input type="submit" name="Change Password" value="Change Password" class="btn btn-default" />
			</div>
		</form>
	</div>
</div>	

<?php 
}
include 'includes/overall/footer.php'; ?>