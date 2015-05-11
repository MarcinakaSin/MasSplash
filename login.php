<?php
include 'core/OOP_init.php';
// prevents and redirects logged in users from accessing this page.
//logged_in_redirect();

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true
			),
			'password' => array(
				'required' => true
			)
		));

		if($validation->passed()) {
			$user = new User();

			$remember = (Input::get('remember') === 'on') ? true : false;
			$login = $user->login(Input::get('username'), Input::get('password'), $remember);

			if($login) {
				Redirect::to('index.php');
			} else {
				echo '<br /><br /><br />Sorry, logging in failed';
			}
		} else {
			foreach($validation->errors() as $error) {
				echo $error, '<br />';
			}
		}
	}
}

/*if(!isset($_GET['new']) && empty($_GET['new'])){
	if (empty($_POST) === false) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		if(empty($username) === true || empty($password) === true) {
			$errors[] = 'You need to enter a Username and Password.';
		} else if (user_exists($dbcon, $username) === false) {
			$errors[] = 'We can\'t find that Username. Have you registered?';
		} else if (user_active($dbcon, $username) === false) {
			$errors[] = 'You haven\'t activated your account!';
		} else {

			$login = login($dbcon, $username, $password);
			
			if ($login === false) {
				$errors[] = 'That Username/Password combination is incorrect.';
			
			} else {
				// set the user session
				//die($login);
				$_SESSION['user_id'] = $login;

				// redirect user to home
				header('Location: index.php');
				
				echo $login;
				exit();
			}
		}

		//print_r($errors); 
	} else {
		$errors[] = 'No data received.';
	}
}*/
include 'includes/overall/header.php';
?>
<div class="row">
	<div class="page-header">
		<h3>Login!</h3>
	</div>
</div>
<?php
if(empty($errors) === false){
?>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>We tried to log you in, but...</strong>
		<?php 	//echo output_errors($errors); ?>
	</div>
</div>
<?php } ?>
<div class="row">
	<div class="col-sm-4 col-sm-offset-4">
		<?php include 'includes/widgets/plogin_form.php'; ?> 
	</div>
</div>

<?php include 'includes/overall/footer.php'; ?> 