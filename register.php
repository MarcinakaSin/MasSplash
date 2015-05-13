<?php
include 'core/OOP_init.php';
// prevents and redirects logged in users from accessing this page.
//logged_in_redirect();
include 'includes/overall/header.php'; 

$errors = array();
if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true,
				'nospace' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'users'
			),
			'password' => array(
				'required' => true,
				'min' => 6
			),
			'validate_password' => array(
				'required' => true,
				'matches' => 'password'
			),
			'first_name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'email' => array(
				'required' => true,
				'format' => 'email'//,
				//'unique' => 'users'
			)
		));

		if($validation->passed()) {
			$user = new User();

			$salt = Hash::salt(32);

			try {

				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					//'email' => Input::get('email'),
					'name' => Input::get('first_name'),
					//'name_firt' => Input::get('name_first'),
					//'name_last' => Input::get('name_last'),
					'joined' => date('Y-m-d H:i:s'),
					'group' => 1
				));

			} catch(Exception $e) {
				die($e->getMessage());
			}


			Session::flash('success', 'You registered successfully!');
			Redirect::to(404);
			//header('Location: index.php');
		} else {
			$errors = $validation->errors();
		}
	}
} 
?>
		
<div class="row">
	<div class="page-header">
		<h3>Register</h3>
	</div>
</div>

<?php if($errors != null) { ?>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>
			<?php 	echo Validate::output_errors($errors);	/*output errors*/  ?>
		</strong>
	</div>
</div>
<?php }	?>
<div class="row">
	<div class="col-sm-4">
	<form action="" method="post">
		<div class="form-group">
	    	<label for="username">Username*</label>
			<input type="text" id="username" name="username" placeholder="Username" class="form-control" value="<?php echo escape(Input::get('username')); ?>" required />
		</div>
		<div class="form-group">
	    	<label for="password">Password*</label>
			<input type="password" id="password" name="password" placeholder="Password" class="form-control" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>" required />
		</div>
		<div class="form-group">
	    	<label for="validate_password">Confirm Password*</label>
			<input type="password" id="validate_password" name="validate_password" placeholder="Confirm Password" class="form-control" required />
		</div>
		<div class="form-group">
	    	<label for="first_name">First Name*</label>
			<input type="text" id="first_name" name="first_name" placeholder="First Name" class="form-control" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>" required />
		</div>
		<div class="form-group">
	    	<label for="last_name">Last Name*</label>
			<input type="text" id="last_name" name="last_name" placeholder="Last Name" class="form-control" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>" required />
		</div>
		<div class="form-group">
	    	<label for="email">E-mail*</label>
			<input type="text" id="email" name="email" placeholder="E-mail" class="form-control" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required />
		</div>
		<div class="form-group">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<input type="submit" class="btn btn-default" value="Register" />
		</div>
	</form>
	</div>
</div>
<?php include 'includes/overall/footer.php'; ?>