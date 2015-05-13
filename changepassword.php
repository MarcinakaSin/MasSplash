<?php 
include 'core/OOP_init.php';

if(!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

$errors = array();
if(Input::exists()) {
	if(Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'current_password' => array(
				'rename' => 'Current Password',
				'required' => true,
				'min' => 6
			),
			'password' => array(
				'rename' => 'New Password',
				'required' => true,
				'min' => 6
			),
			'validate_password' => array(
				'rename' => 'Confirm New Password',
				'required' => true,
				'min' => 6,
				'match' => 'password'
			)
		));

		if($validation->passed()) {
			if(Hash::make(Input::get('current_password'), $user->data()->salt) !== $user->data()->password) {

				array_push($errors, "The Current Password you have entered is incorrect.");
			} else {

				$salt = Hash::salt(32);
				$user->update(array(
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt
				));

				Session::flash('home', 'Your password has been changed');
				Redirect::to('index.php');
			}
		} else {
			$errors = $validation->errors();
		}
	}
}

include 'includes/overall/header.php'; 
?>
	
<div class="row">
	<div class="page-header">
		<h3>Change Password</h3>
	</div>
</div>

<?php if($errors) { ?>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>
			<?php 	echo Validate::output_errors($errors);	/*output errors*/  ?>
		</strong>
	</div>
</div>

<?php } ?>

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
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
				<input type="submit" name="Change Password" value="Change Password" class="btn btn-default" />
			</div>
		</form>
	</div>
</div>	

<?php include 'includes/overall/footer.php'; ?>