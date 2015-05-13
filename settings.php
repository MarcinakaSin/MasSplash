<?php 
include 'core/init.php';

if(!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

include 'includes/overall/header.php'; 

$errors = array();
if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'first_name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50

			)
		));

		if($validation->passed()) {

			try {
				$user->update(array(
					'name' => Input::get('first_name')
				));

				Session::flash('home', 'Your details have been updated.');
				Redirect::to('index.php');

			} catch(Exception $e) {
				die($e->getMessage());
			}

		} else {
			$errors = $validation->errors();
		}
	}
}

/*if (empty($_POST) === false){
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
} */

?>

<div class="row">
	<div class="page-header">
		<h3>Settings</h3>
	</div>
</div>

<?php
/*if(isset($_GET['success']) && empty($_GET['success'])){ 
?>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-success">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>
			Your details have been updated.
		</strong>
	</div>
</div>

<?php
} else {
	if(empty($_POST) === false && empty($errors) === true){
		//echo $_POST['allow_email'];
		$allow_email = ($_POST['allow_email'] == 'on') ? 1 : 0;
		$update_data = array(
			'first_name' 	=> $_POST['first_name'],
			'last_name' 	=> $_POST['last_name'],
			'email' 		=> $_POST['email'],
			'allow_email'	=> $allow_email
			);
	//print_r($update_data);

	update_user($dbcon, $session_user_id, $update_data);
	//echo $allow_email;
	header('Location: settings.php?success' );
	exit();

	} else if (empty($errors) === false) { */ 

	if($errors != null) {	?>


<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>
			<?php 	echo Validate::output_errors($errors);	/*output errors*/  ?>
		</strong>
	</div>
</div>

<?php	
	}
?>

	<?php /*
	if(isset($_FILES['profile']) === true) {
		if(empty($_FILES['profile']['name']) === true){
		echo "Please choose a file!";
		} else {
			$allowed = array('jpg', 'jpeg', 'gif', 'png');

			$file_name = $_FILES['profile']['name'];
			$file_extn = strtolower(end(explode('.', $file_name)));
			$file_temp = $_FILES['profile']['tmp_name'];

			if(in_array($file_extn, $allowed) === true){
				change_profile_image($dbcon, $session_user_id, $file_temp, $file_extn);

				header('Location: ' . $current_file);
				exit();
			} else {
				echo 'Incorrect file type. Allowed:';
				echo implode(', ', $allowed);
			}
		}
	}	*/?>

<div class="row">
	<div class="col-sm-4">
		<fieldset>
			<legend> Profile Image</legend>
<?php	/*if(empty($user_data['profile']) === false) { 
		echo '<img src="', $user_data['profile'], '" class="img-thumbnail" alt="', $user_data['first_name'], '\'s Profile Image">';
	} */
	?>

			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<input type="file" id="profile" name="profile" />
				</div>
				<div class="form-group">
					<input type="submit" value="Upload Image" class="btn btn-default" />
				</div>
			</form>
		</fieldset>
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<form action="" method="post">
			<div class="form-group">
		    	<label for="first_name">First Name*</label>
				<input type="text" id="first_name" name="first_name" placeholder="First Name" class="form-control" value="<?php echo escape($user->data()->name); ?>" required />
			</div>
			<div class="form-group">
		    	<label for="last_name">Last Name*</label>
				<input type="text" id="last_name" name="last_name" placeholder="Last Name" class="form-control" value="<?php //echo $user_data['last_name']; ?>" required />
			</div>
			<div class="form-group">
		    	<label for="email">E-mail*</label>
				<input type="text" id="email" name="email" placeholder="E-mail" class="form-control" value="<?php //echo $user_data['email']; ?>" required />
			</div>
			<div class="form-group">
			    <div class="checkbox">
			      	<label>
						<input type="checkbox" id="allow_email" name="allow_email" <?php //if($user_data['allow_email'] == 1){ echo 'checked="checked"'; } ?> /> Would you like to receive email from us?
					</label>
				</div>
			</div>
			<div class="form-group">
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
				<input type="submit" value="Update" class="btn btn-default" />
			</div>
		</form>
	</div>
</div>
<?php
//}
include 'includes/overall/footer.php'; 
?>